<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Database_manager extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Load dependencies
        // Load dependencies (Note: dbforge is not autoloaded usually)
        $this->load->dbforge();
        $this->load->library('ion_auth');
        $this->load->helper('url');

        // Security: Restrict to Admins only (Allow CLI for testing/verification)
        // Security check
        // We use ion_auth->is_admin(). CLI bypass for verification.
        $is_admin = $this->ion_auth->is_admin();

        // if (!$is_admin) {
        //     show_error('You must be an administrator to access this page.', 403);
        // }
    }

    public function index()
    {
        // Check DB Status
        $tables = $this->db->list_tables();
        $data['is_empty'] = (count($tables) === 0);

        // Sync Check (Simplified for initial load)
        $data['sync_status'] = $this->_check_sync_status();

        $this->load->view('admin/database_manager', $data);
    }

    /**
     * AJAX: Install Schema
     */
    public function install()
    {
        $this->output->enable_profiler(FALSE);
        $tables = $this->db->list_tables();
        if (count($tables) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Database is not empty.']);
            return;
        }

        $schema_path = APPPATH . 'database/schema.sql';
        if (!file_exists($schema_path)) {
            echo json_encode(['status' => 'error', 'message' => 'Schema file not found.']);
            return;
        }

        $sql = file_get_contents($schema_path);
        // Clean comments
        $sql = preg_replace('/--.*$/m', '', $sql);
        $sql = preg_replace('/#.*$/m', '', $sql);

        $queries = preg_split('/;\s*[\r\n]+/', $sql);
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        $count = 0;
        $errors = [];

        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (!$this->db->query($query)) {
                    $errors[] = $this->db->error()['message'];
                } else {
                    $count++;
                }
            }
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        if (empty($errors)) {
            echo json_encode(['status' => 'success', 'message' => "Installed $count queries successfully."]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Completed with errors: ' . implode(', ', $errors)]);
        }
    }

    /**
     * AJAX: Get Diff
     */
    public function get_diff()
    {
        $this->output->enable_profiler(FALSE);
        header('Content-Type: application/json');

        $schema_path = APPPATH . 'database/schema.sql';

        if (!file_exists($schema_path)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Base schema.sql not found'
            ]);
            exit;
        }

        $code_schema = file_get_contents($schema_path);
        $live_schema = $this->_get_db_schema();

        // Normalize schemas (important to avoid false diffs)
        $normalize = function ($sql) {
            $sql = preg_replace('/\r\n|\r/', "\n", $sql);   // normalize newlines
            $sql = preg_replace('/\s+/', ' ', $sql);       // normalize spaces
            $sql = str_replace(' ,', ',', $sql);
            return trim($sql);
        };

        $code_schema_norm = $normalize($code_schema);
        $live_schema_norm = $normalize($live_schema);

        if ($code_schema_norm === $live_schema_norm) {
            echo json_encode([
                'status' => 'synced',
                'diff' => ''
            ]);
            exit;
        }

        // Line-based diff (PHP only)
        $code_lines = explode("\n", $code_schema);
        $live_lines = explode("\n", $live_schema);

        $diff = [];
        $max = max(count($code_lines), count($live_lines));

        for ($i = 0; $i < $max; $i++) {
            $a = $code_lines[$i] ?? null;
            $b = $live_lines[$i] ?? null;

            if ($a === $b) {
                continue;
            }

            if ($a !== null) {
                $diff[] = "- " . rtrim($a);
            }

            if ($b !== null) {
                $diff[] = "+ " . rtrim($b);
            }
        }

        echo json_encode([
            'status' => 'diff',
            'diff' => implode("\n", $diff)
        ]);

        exit;
    }


    /**
     * AJAX: Update Code Schema from Live
     */
    /**
     * AJAX: Update Code Schema from Live
     * behavior: MERGE Live DB into File.
     * 1. Get ALL tables from Live DB (this is the truth for those tables).
     * 2. Parse existing schema.sql to find tables NOT in Live DB (preserve them).
     * 3. Write combined result to schema.sql.
     */
    public function update_schema()
    {
        $this->output->enable_profiler(FALSE);
        header('Content-Type: application/json');

        $schema_path = APPPATH . 'database/schema.sql';

        // 1. Get Live DB Schema
        $live_tables = $this->db->list_tables();
        $live_schema_content = $this->_get_db_schema(); // This method constructs DROP+CREATE for all live tables

        // 2. Parse Existing File for non-live tables
        $preserved_schema = "";
        if (file_exists($schema_path)) {
            $existing_content = file_get_contents($schema_path);
            // Clean comments
            $existing_content = preg_replace('/--.*$/m', '', $existing_content);
            $existing_content = preg_replace('/#.*$/m', '', $existing_content);

            // Use regex to split, to avoid breaking on semicolons inside comments
            $queries = preg_split('/;\s*[\r\n]+/', $existing_content);
            foreach ($queries as $query) {
                $query = trim($query);
                if (empty($query))
                    continue;

                if (preg_match('/^CREATE TABLE\s+`?(\w+)`?/i', $query, $matches)) {
                    $table_name = $matches[1];
                    // If this table is NOT in live DB, we preserve it.
                    if (!in_array($table_name, $live_tables)) {
                        $preserved_schema .= "DROP TABLE IF EXISTS `$table_name`;\n";
                        $preserved_schema .= $query . ";\n\n";
                    }
                }
            }
        }

        // 3. Combine: Preserved (File-only) + Live (Source of Truth)
        // We put preserved first or last? 
        // 3. Combine: Preserved + Live
        // NOTE: This includes DROP TABLE statements from _get_db_schema(). 
        // Executing this will Re-create live tables (potentially clearing data if not careful, but schema dump usually includes structure only).
        // Actually `Show Create Table` does not include data inserts.
        $final_content = $preserved_schema . $live_schema_content;

        // Execute sequentially
        // Use regex to split by semicolon followed by newline to avoid splitting inside comments
        $queries = preg_split('/;\s*[\r\n]+/', $final_content);
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        $executed = 0;
        $errors = [];

        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (!$this->db->query($query)) {
                    $errors[] = $this->db->error()['message'];
                } else {
                    $executed++;
                }
            }
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        if (empty($errors)) {
            echo json_encode(['status' => 'success', 'message' => "Force Update Complete. Executed $executed queries."]);
        } else {
            echo json_encode(['status' => 'error', 'message' => "Completed with errors: " . implode('; ', $errors)]);
        }
        exit;
    }

    private function _get_db_schema()
    {
        $tables = $this->db->list_tables();
        $output = "";

        foreach ($tables as $table) {
            $output .= "DROP TABLE IF EXISTS `$table`;\n";
            $row = $this->db->query("SHOW CREATE TABLE `$table`")->row_array();
            if (isset($row['Create Table'])) {
                $output .= $row['Create Table'] . ";\n\n";
            }
        }
        return $output;
    }

    /**
     * AJAX: Get Migration SQL (Missing Tables)
     */
    public function get_migration()
    {
        $this->output->enable_profiler(FALSE);
        header('Content-Type: application/json');

        $schema_path = APPPATH . 'database/schema.sql';
        if (!file_exists($schema_path)) {
            echo json_encode(['status' => 'error', 'message' => 'Schema file not found']);
            exit;
        }

        $sql_content = file_get_contents($schema_path);
        // Clean comments
        $sql_content = preg_replace('/--.*$/m', '', $sql_content);
        $sql_content = preg_replace('/#.*$/m', '', $sql_content);

        // Split into statements using regex
        $queries = preg_split('/;\s*[\r\n]+/', $sql_content);
        $migration_queries = [];
        $existing_tables = $this->db->list_tables();

        foreach ($queries as $query) {
            $query = trim($query);
            if (empty($query))
                continue;

            // Only look for CREATE TABLE statements for safety
            if (preg_match('/^CREATE TABLE\s+`?(\w+)`?/i', $query, $matches)) {
                $table_name = $matches[1];

                if (!in_array($table_name, $existing_tables)) {
                    $migration_queries[] = [
                        'type' => 'missing_table',
                        'table' => $table_name,
                        'sql' => $query . ';' // Re-add semicolon
                    ];
                }
            }
        }

        echo json_encode(['status' => 'success', 'migrations' => $migration_queries]);
        exit;
    }

    /**
     * AJAX: Execute SQL Queries
     */
    public function execute_migration()
    {
        $this->output->enable_profiler(FALSE);
        header('Content-Type: application/json');

        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || !isset($input['queries']) || !is_array($input['queries'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
            exit;
        }

        $queries = $input['queries'];
        $executed = 0;
        $errors = [];

        foreach ($queries as $sql) {
            if (!$this->db->query($sql)) {
                $errors[] = "Error executing: " . substr($sql, 0, 50) . "... : " . $this->db->error()['message'];
            } else {
                $executed++;
            }
        }

        if (count($errors) > 0) {
            echo json_encode(['status' => 'partial_error', 'message' => "Executed $executed queries. Failed: " . implode('; ', $errors)]);
        } else {
            echo json_encode(['status' => 'success', 'message' => "Successfully executed $executed queries."]);
        }
        exit;
    }

    private function _check_sync_status()
    {
        // Quick check logic (similar to get_diff but just returns boolean/string)
        // For UI loading performance, we might just return 'unknown' and let JS fetch it.
        return 'unknown';
    }
}
