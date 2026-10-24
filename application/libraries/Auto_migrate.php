<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auto_migrate
 *
 * Applies pending SQL migrations from application/database/migrations/*.sql automatically,
 * once each, in filename order. Applied files are recorded in the `schema_migrations` table.
 *
 * - Fast path: a marker file in application/cache/ lists the applied files, so normal requests
 *   only read one small file (no DB query) when nothing is pending.
 * - Only one request can migrate at a time (MySQL GET_LOCK); others skip and carry on.
 * - A failing migration is logged, is NOT marked as applied, and is retried after a cool-down.
 *   It never breaks the page that triggered it.
 *
 * Migration files: plain SQL, one statement per line-ending ";" (comments with "--" are ignored).
 * Write them so they are safe to re-run (check information_schema before ALTERs).
 *
 * @package classiebit
 */
class Auto_migrate
{
    protected $CI;
    protected $dir;
    protected $marker;
    protected $table = 'schema_migrations';
    protected $lock_name = 'zeyobron_auto_migrate';
    protected $retry_after = 600; // seconds before retrying a failed migration

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->dir = APPPATH . 'database/migrations/';
        $this->marker = APPPATH . 'cache/schema_migrations.json';
    }

    /**
     * Run pending migrations (cheap no-op when everything is applied).
     *
     * @return array list of migration files applied during this call
     */
    public function run()
    {
        $files = $this->migration_files();
        if (empty($files)) {
            return array();
        }

        $state = $this->read_marker();
        $pending = array_values(array_diff($files, $state['applied']));
        if (empty($pending)) {
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

        $applied_now = array();
        try {
            $this->ensure_table();
            $done = array_column($db->select('migration')->get($this->table)->result_array(), 'migration');

            foreach ($files as $file) {
                if (in_array($file, $done, TRUE)) {
                    continue;
                }

                $error = $this->apply_file($file);
                if ($error !== NULL) {
                    log_message('error', 'Auto_migrate: ' . $file . ' failed: ' . $error);
                    $this->write_marker($done, time());
                    return $applied_now;
                }

                $db->insert($this->table, array('migration' => $file, 'applied_at' => date('Y-m-d H:i:s')));
                $done[] = $file;
                $applied_now[] = $file;
                log_message('info', 'Auto_migrate: applied ' . $file);
            }

            $this->write_marker($done, 0);
        } catch (Throwable $e) {
            log_message('error', 'Auto_migrate: ' . $e->getMessage());
        } finally {
            $db->query('SELECT RELEASE_LOCK(' . $db->escape($this->lock_name) . ')');
        }

        return $applied_now;
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
        $state = array('applied' => array(), 'failed_at' => 0);
        if (is_file($this->marker)) {
            $data = json_decode((string) @file_get_contents($this->marker), TRUE);
            if (is_array($data)) {
                $state['applied'] = isset($data['applied']) && is_array($data['applied']) ? $data['applied'] : array();
                $state['failed_at'] = isset($data['failed_at']) ? (int) $data['failed_at'] : 0;
            }
        }
        return $state;
    }

    protected function write_marker(array $applied, $failed_at)
    {
        @file_put_contents($this->marker, json_encode(array(
            'applied' => array_values($applied),
            'failed_at' => (int) $failed_at,
            'updated' => date('c'),
        )), LOCK_EX);
    }
}
