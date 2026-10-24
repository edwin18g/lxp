<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auto_migrate
 *
 * Keeps the database schema up to date automatically (triggered from Admin_Controller):
 *
 * 1. Auto-install: every table defined in application/database/schema.sql that does not exist in the
 *    database is created. Only CREATE TABLE statements are used (as CREATE TABLE IF NOT EXISTS);
 *    DROP / other statements in schema.sql are never executed, so existing tables and data are untouched.
 * 2. Migrations: pending application/database/migrations/*.sql files are applied once each, in filename
 *    order, and recorded in the `schema_migrations` table.
 *
 * - Fast path: a marker file in application/cache/ records the applied migrations and the schema.sql
 *   signature, so normal requests only read one small file (no DB query) when nothing changed.
 * - Only one request can run this at a time (MySQL GET_LOCK); others skip and carry on.
 * - Failures are logged, not marked as done, and retried after a cool-down. They never break the page.
 *
 * Migration files: plain SQL statements separated by ";" ("--" / "#" comments are ignored).
 * Write them so they are safe to re-run (check information_schema before ALTERs).
 *
 * @package classiebit
 */
class Auto_migrate
{
    protected $CI;
    protected $dir;
    protected $schema_file;
    protected $marker;
    protected $table = 'schema_migrations';
    protected $lock_name = 'zeyobron_auto_migrate';
    protected $retry_after = 600; // seconds before retrying after a failure

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->dir = APPPATH . 'database/migrations/';
        $this->schema_file = APPPATH . 'database/schema.sql';
        $this->marker = APPPATH . 'cache/schema_migrations.json';
    }

    /**
     * Install missing tables and run pending migrations (cheap no-op when nothing changed).
     *
     * @return array tables created ("table:<name>") and migration files applied during this call
     */
    public function run()
    {
        $files = $this->migration_files();
        $state = $this->read_marker();
        $schema_sig = $this->schema_signature();

        $schema_changed = ($schema_sig !== '' && $schema_sig !== $state['schema_sig']);
        $pending = array_values(array_diff($files, $state['applied']));
        if (!$schema_changed && empty($pending)) {
            return array();
        }

        // Back off after a recent failure
        if (!empty($state['failed_at']) && (time() - $state['failed_at']) < $this->retry_after) {
            return array();
        }

        $db = $this->CI->db;

        // Only one request migrates at a time; others skip without waiting
        $lock = $db->query('SELECT GET_LOCK(' . $db->escape($this->lock_name) . ', 0) AS l')->row();
        if (!$lock || (int) $lock->l !== 1) {
            return array();
        }

        $done_now = array();
        $done = $state['applied'];
        try {
            // 1. Create tables from schema.sql that don't exist yet
            if ($schema_changed) {
                $error = NULL;
                foreach ($this->install_missing_tables($error) as $created) {
                    $done_now[] = 'table:' . $created;
                }
                if ($error !== NULL) {
                    log_message('error', 'Auto_migrate: schema install failed: ' . $error);
                    $this->write_marker($done, time(), $state['schema_sig']);
                    return $done_now;
                }
            }

            // 2. Pending migrations
            $this->ensure_table();
            $done = array_column($db->select('migration')->get($this->table)->result_array(), 'migration');

            foreach ($files as $file) {
                if (in_array($file, $done, TRUE)) {
                    continue;
                }

                $error = $this->apply_file($file);
                if ($error !== NULL) {
                    log_message('error', 'Auto_migrate: ' . $file . ' failed: ' . $error);
                    $this->write_marker($done, time(), $schema_sig);
                    return $done_now;
                }

                $db->insert($this->table, array('migration' => $file, 'applied_at' => date('Y-m-d H:i:s')));
                $done[] = $file;
                $done_now[] = $file;
                log_message('info', 'Auto_migrate: applied ' . $file);
            }

            $this->write_marker($done, 0, $schema_sig);
        } catch (Throwable $e) {
            log_message('error', 'Auto_migrate: ' . $e->getMessage());
            $this->write_marker($done, time(), $state['schema_sig']);
        } finally {
            $db->query('SELECT RELEASE_LOCK(' . $db->escape($this->lock_name) . ')');
        }

        return $done_now;
    }

    /**
     * Create every table defined in schema.sql that is missing from the database.
     * Never drops or alters anything.
     *
     * @param string|null $error set to an error message if a table could not be created
     * @return array names of the tables created
     */
    protected function install_missing_tables(&$error)
    {
        $error = NULL;
        $sql = @file_get_contents($this->schema_file);
        if ($sql === FALSE || $sql === '') {
            return array();
        }

        $db = $this->CI->db;
        $existing = array_map('strtolower', $db->list_tables(FALSE));
        $created = array();

        foreach ($this->split_statements($sql) as $statement) {
            if (!preg_match('/^CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`?(\w+)`?/i', $statement, $m)) {
                continue; // only CREATE TABLE statements are ever used
            }
            $name = $m[1];
            if (in_array(strtolower($name), $existing, TRUE)) {
                continue;
            }

            $create = preg_replace('/^CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?/i', 'CREATE TABLE IF NOT EXISTS ', $statement);
            $result = $this->exec($create);
            if ($result !== NULL && stripos($result, 'collation') !== FALSE) {
                // Older MySQL / MariaDB don't know MySQL 8 collations (utf8mb4_0900_ai_ci): retry with the server default
                $result = $this->exec(preg_replace('/\s+COLLATE\s*=?\s*\w+/i', '', $create));
            }
            if ($result !== NULL) {
                $error = $name . ': ' . $result;
                return $created;
            }

            $created[] = $name;
            $existing[] = strtolower($name);
            log_message('info', 'Auto_migrate: created missing table ' . $name);
        }

        return $created;
    }

    /**
     * Run one statement without CI's error page; return NULL on success or the error message.
     */
    protected function exec($statement)
    {
        $db = $this->CI->db;
        $old_debug = $db->db_debug;
        $db->db_debug = FALSE;
        $error = NULL;
        try {
            if ($db->query($statement) === FALSE) {
                $err = $db->error();
                $error = '[' . $err['code'] . '] ' . $err['message'];
            }
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
        $db->db_debug = $old_debug;
        return $error;
    }

    /**
     * Changes whenever schema.sql is edited/deployed (cheap: no file read).
     */
    protected function schema_signature()
    {
        if (!is_file($this->schema_file)) {
            return '';
        }
        clearstatcache(TRUE, $this->schema_file);
        return filemtime($this->schema_file) . '-' . filesize($this->schema_file);
    }

    /**
     * Execute one migration file statement by statement on the current connection
     * (session variables / PREPARE persist between statements).
     *
     * @return string|null error message, or NULL on success
     */
    protected function apply_file($file)
    {
        $db = $this->CI->db;
        $sql = file_get_contents($this->dir . $file);
        if ($sql === FALSE) {
            return 'cannot read file';
        }

        $old_debug = $db->db_debug;
        $db->db_debug = FALSE; // report errors instead of showing CI's error page
        $error = NULL;
        foreach ($this->split_statements($sql) as $statement) {
            try {
                // mysqli throws on PHP 8.1+ even with db_debug off, so handle both styles
                $ok = $db->query($statement);
            } catch (Throwable $e) {
                $ok = FALSE;
                $error = $e->getMessage();
            }
            if ($ok === FALSE) {
                if ($error === NULL) {
                    $err = $db->error();
                    $error = '[' . $err['code'] . '] ' . $err['message'];
                }
                $error .= ' in: ' . substr(preg_replace('/\s+/', ' ', $statement), 0, 160);
                break;
            }
        }
        $db->db_debug = $old_debug;

        return $error;
    }

    /**
     * Split SQL into statements on ";" outside quotes, ignoring "--" and "#" line comments.
     *
     * @param string $sql
     * @return array
     */
    protected function split_statements($sql)
    {
        $statements = array();
        $buf = '';
        $quote = NULL;
        $len = strlen($sql);

        for ($i = 0; $i < $len; $i++) {
            $ch = $sql[$i];

            if ($quote !== NULL) {
                $buf .= $ch;
                if ($ch === '\\' && $i + 1 < $len) { // backslash escape
                    $buf .= $sql[++$i];
                } elseif ($ch === $quote) {
                    if ($i + 1 < $len && $sql[$i + 1] === $quote) { // doubled quote escape ('')
                        $buf .= $sql[++$i];
                    } else {
                        $quote = NULL;
                    }
                }
                continue;
            }

            if ($ch === "'" || $ch === '"' || $ch === '`') {
                $quote = $ch;
                $buf .= $ch;
            } elseif (($ch === '-' && substr($sql, $i, 2) === '--' && ($i + 2 >= $len || ctype_space($sql[$i + 2]))) || $ch === '#') {
                $nl = strpos($sql, "\n", $i);
                $i = ($nl === FALSE) ? $len : $nl - 1; // skip to end of line
            } elseif ($ch === ';') {
                if (trim($buf) !== '') {
                    $statements[] = trim($buf);
                }
                $buf = '';
            } else {
                $buf .= $ch;
            }
        }
        if (trim($buf) !== '') {
            $statements[] = trim($buf);
        }

        return $statements;
    }

    protected function ensure_table()
    {
        $this->CI->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `migration` varchar(191) NOT NULL,
            `applied_at` datetime NOT NULL,
            PRIMARY KEY (`migration`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    protected function migration_files()
    {
        $files = glob($this->dir . '*.sql');
        if (empty($files)) {
            return array();
        }
        $files = array_map('basename', $files);
        sort($files, SORT_STRING);
        return $files;
    }

    protected function read_marker()
    {
        $state = array('applied' => array(), 'failed_at' => 0, 'schema_sig' => '');
        if (is_file($this->marker)) {
            $data = json_decode((string) @file_get_contents($this->marker), TRUE);
            if (is_array($data)) {
                $state['applied'] = isset($data['applied']) && is_array($data['applied']) ? $data['applied'] : array();
                $state['failed_at'] = isset($data['failed_at']) ? (int) $data['failed_at'] : 0;
                $state['schema_sig'] = isset($data['schema_sig']) ? (string) $data['schema_sig'] : '';
            }
        }
        return $state;
    }

    protected function write_marker(array $applied, $failed_at, $schema_sig = '')
    {
        @file_put_contents($this->marker, json_encode(array(
            'applied' => array_values($applied),
            'failed_at' => (int) $failed_at,
            'schema_sig' => (string) $schema_sig,
            'updated' => date('c'),
        )), LOCK_EX);
    }
}
