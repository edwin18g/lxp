<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Sessions Model
 *
 * Tracks user login sessions with device information
 *
 * @package     classiebit
 */

class User_sessions_model extends CI_Model
{

    private $table = 'user_sessions';

    function __construct()
    {
        parent::__construct();
        $this->_ensure_table_exists();
    }

    /**
     * Ensure the user_sessions table exists in DB (Auto-migration for prod)
     */
    private function _ensure_table_exists()
    {
        if (!$this->db->table_exists($this->table)) {
            $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
              `id` int unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int unsigned NOT NULL,
              `session_id` varchar(128) NOT NULL,
              `ip_address` varchar(45) NOT NULL,
              `user_agent` varchar(512) NOT NULL,
              `device_type` varchar(32) DEFAULT NULL,
              `browser` varchar(128) DEFAULT NULL,
              `os` varchar(128) DEFAULT NULL,
              `is_active` tinyint(1) NOT NULL DEFAULT '1',
              `last_activity` int unsigned NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `idx_user_sessions_user_id` (`user_id`),
              KEY `idx_user_sessions_session_id` (`session_id`),
              KEY `idx_user_sessions_active` (`user_id`,`is_active`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $this->db->query($sql);
        }
    }

    /**
     * Create a new session record on login
     *
     * @param int $user_id
     * @return int|false inserted row id or false
     */
    public function create($user_id)
    {
        $user_agent = $this->input->server('HTTP_USER_AGENT');
        $ip_address = $this->input->ip_address();
        $session_id = session_id();

        $ua_info = $this->parse_user_agent($user_agent);

        $data = array(
            'user_id'       => $user_id,
            'session_id'    => $session_id,
            'ip_address'    => $ip_address,
            'user_agent'    => $user_agent,
            'device_type'   => $ua_info['device_type'],
            'browser'       => $ua_info['browser'],
            'os'            => $ua_info['os'],
            'is_active'     => 1,
            'last_activity' => time(),
        );

        // Check if active record for session_id already exists to prevent duplicates
        $existing = $this->db->get_where($this->table, array('session_id' => $session_id, 'is_active' => 1))->row();
        if ($existing) {
            $this->db->where('id', $existing->id)->update($this->table, $data);
            return $existing->id;
        }

        $this->db->insert($this->table, $data);

        if ($this->db->insert_id()) {
            return $this->db->insert_id();
        }

        return FALSE;
    }

    public function get_active($user_id)
    {
        if (!$user_id) {
            return array();
        }

        // Subquery to get max session record ID per session_id
        $subquery = $this->db->select('MAX(id) as max_id')
                             ->from($this->table)
                             ->where('user_id', $user_id)
                             ->where('is_active', 1)
                             ->group_by('session_id')
                             ->get_compiled_select();

        // Main query to get full rows for distinct sessions
        $this->db->select('*')
                 ->from($this->table)
                 ->where("id IN ($subquery)", NULL, FALSE)
                 ->order_by('last_activity', 'DESC');

        return $this->db->get()->result_array();
    }

    public function deactivate($session_id)
    {
        if (!$session_id) {
            return FALSE;
        }

        $this->db->where('session_id', $session_id)
                  ->where('is_active', 1)
                  ->update($this->table, array('is_active' => 0));

        return TRUE;
    }

    public function deactivate_all($user_id)
    {
        if (!$user_id) {
            return FALSE;
        }

        $this->db->where('user_id', $user_id)
                  ->where('is_active', 1)
                  ->update($this->table, array('is_active' => 0));

        return TRUE;
    }

    public function deactivate_all_except($user_id, $current_session_id)
    {
        if (!$user_id) {
            return FALSE;
        }

        $this->db->where('user_id', $user_id)
                 ->where('is_active', 1);

        if ($current_session_id) {
            $this->db->where('session_id !=', $current_session_id);
        }

        $this->db->update($this->table, array('is_active' => 0));
        return TRUE;
    }

    /**
     * Update last_activity timestamp for a session
     *
     * @param string $session_id
     * @return bool
     */
    public function update_activity($session_id)
    {
        if (!$session_id) {
            return FALSE;
        }

        $this->db->where('session_id', $session_id)
                  ->where('is_active', 1)
                  ->update($this->table, array('last_activity' => time()));

        return TRUE;
    }

    /**
     * Deactivate a specific session by id (for user terminating another session)
     *
     * @param int $id session record id
     * @param int $user_id owner of the session
     * @return bool
     */
    public function terminate($id, $user_id)
    {
        $this->db->where('id', $id)
                  ->where('user_id', $user_id)
                  ->where('is_active', 1)
                  ->update($this->table, array('is_active' => 0));

        return $this->db->affected_rows() > 0;
    }

    /**
     * Parse User-Agent string to extract browser, OS, and device type
     *
     * @param string $ua User-Agent string
     * @return array [browser, os, device_type]
     */
    public function parse_user_agent($ua)
    {
        $browser = 'Unknown';
        $os = 'Unknown';
        $device_type = 'desktop';

        // Device type detection
        if (preg_match('/tablet|ipad/i', $ua)) {
            $device_type = 'tablet';
        } elseif (preg_match('/mobile|android|iphone|ipod|blackberry|opera mini|iemobile/i', $ua)) {
            $device_type = 'mobile';
        }

        // Browser detection (order matters - check specific before generic)
        $browsers = array(
            'Edge'      => '/Edg[e\/]([\d\w.]+)/i',
            'Opera'     => '/(?:OPR|Opera)[\/\s]([\d.]+)/i',
            'Chrome'    => '/Chrome\/([\d.]+)/i',
            'Firefox'   => '/Firefox\/([\d.]+)/i',
            'Safari'    => '/Version\/([\d.]+).*Safari/i',
            'IE 11'     => '/Trident\/.*rv:([\d.]+)/i',
            'IE'        => '/MSIE ([\d.]+)/i',
        );

        foreach ($browsers as $name => $pattern) {
            if (preg_match($pattern, $ua, $matches)) {
                $browser = $name;
                if ($name === 'Edge') {
                    $browser = 'Edge';
                }
                break;
            }
        }

        // OS detection
        $oses = array(
            'Windows 11'    => '/Windows NT 10\.0/i',
            'Windows 10'    => '/Windows NT 10\.0/i',
            'Windows 8.1'   => '/Windows NT 6\.3/i',
            'Windows 8'     => '/Windows NT 6\.2/i',
            'Windows 7'     => '/Windows NT 6\.1/i',
            'Windows Vista' => '/Windows NT 6\.0/i',
            'Windows XP'    => '/Windows NT 5\.[12]/i',
            'Windows'       => '/Windows/i',
            'macOS'         => '/Mac OS X/i',
            'Linux'         => '/Linux/i',
            'Android'       => '/Android/i',
            'iOS'           => '/(?:iPhone|iPad|iPod)/i',
            'Chrome OS'     => '/CrOS/i',
            'BlackBerry'    => '/BlackBerry/i',
        );

        foreach ($oses as $name => $pattern) {
            if (preg_match($pattern, $ua)) {
                $os = $name;

                // Refine Windows version
                if ($os === 'Windows') {
                    if (preg_match('/Windows NT 10\.0/i', $ua)) {
                        if (preg_match('/Windows NT 10\.0.*(?:Windows 11|Build 22000|Build 22[0-9]{3})/i', $ua)) {
                            $os = 'Windows 11';
                        } else {
                            $os = 'Windows 10';
                        }
                    }
                }

                // Get iOS version
                if ($os === 'iOS' && preg_match('/OS ([\d_]+)/i', $ua, $m)) {
                    $os = 'iOS ' . str_replace('_', '.', $m[1]);
                }

                break;
            }
        }

        return array(
            'browser'     => $browser,
            'os'          => $os,
            'device_type' => $device_type,
        );
    }

    /**
     * DataTables query helper for sessions GROUPED BY USER with Filter Support
     */
    private function _get_user_grouped_sessions_query($search = '', $status_filter = 'all', $role_filter = 'all')
    {
        $this->db->select('
            users.id as user_id,
            users.first_name,
            users.last_name,
            users.email,
            users.image,
            users.device_locked,
            users.role,
            COUNT(DISTINCT CASE WHEN user_sessions.is_active = 1 THEN user_sessions.session_id END) as active_count,
            COUNT(user_sessions.id) as total_count,
            MAX(user_sessions.last_activity) as max_last_activity
        ');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = user_sessions.user_id', 'inner');

        if (!empty($role_filter) && $role_filter !== 'all') {
            $this->db->where('users.role', $role_filter);
        }

        if (!empty($status_filter) && $status_filter === 'locked') {
            $this->db->where('users.device_locked', 1);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.first_name', $search);
            $this->db->or_like('users.last_name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('user_sessions.ip_address', $search);
            $this->db->group_end();
        }

        $this->db->group_by('users.id');

        if (!empty($status_filter)) {
            if ($status_filter === 'active') {
                $this->db->having('active_count >', 0);
            } elseif ($status_filter === 'multidevice') {
                $this->db->having('active_count >', 1);
            } elseif ($status_filter === 'inactive') {
                $this->db->having('active_count', 0);
            }
        }
    }

    public function get_user_grouped_sessions_dt($limit = 10, $offset = 0, $orders = array(), $search = '', $status_filter = 'all', $role_filter = 'all')
    {
        $this->_get_user_grouped_sessions_query($search, $status_filter, $role_filter);

        if (!empty($orders)) {
            foreach ($orders as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else {
            $this->db->order_by('active_count', 'DESC');
            $this->db->order_by('max_last_activity', 'DESC');
        }

        if ($limit != -1) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    public function count_all_grouped_users()
    {
        $res = $this->db->query("SELECT COUNT(DISTINCT user_id) as total FROM user_sessions")->row();
        return $res ? $res->total : 0;
    }

    public function count_filtered_grouped_users($search = '', $status_filter = 'all', $role_filter = 'all')
    {
        $this->_get_user_grouped_sessions_query($search, $status_filter, $role_filter);
        return $this->db->get()->num_rows();
    }

    public function count_multidevice_users()
    {
        $res = $this->db->query("SELECT COUNT(*) as total FROM (SELECT user_id FROM user_sessions WHERE is_active = 1 GROUP BY user_id HAVING COUNT(DISTINCT session_id) > 1) as tmp")->row();
        return $res ? $res->total : 0;
    }

    public function count_locked_users()
    {
        return $this->db->where('device_locked', 1)->count_all_results('users');
    }

    /**
     * Get all session records for a specific user (for modal details)
     */
    public function get_all_sessions_by_user($user_id)
    {
        if (!$user_id) {
            return array();
        }

        $subquery = $this->db->select('MAX(id) as max_id')
                             ->from($this->table)
                             ->where('user_id', $user_id)
                             ->group_by('session_id')
                             ->get_compiled_select();

        $this->db->select('*')
                 ->from($this->table)
                 ->where("id IN ($subquery)", NULL, FALSE)
                 ->order_by('is_active', 'DESC')
                 ->order_by('last_activity', 'DESC');

        return $this->db->get()->result_array();
    }

    /**
     * DataTables query helper for all sessions
     */
    private function _get_sessions_query($search = '')
    {
        $this->db->select('user_sessions.*, users.first_name, users.last_name, users.email, users.image');
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = user_sessions.user_id', 'left');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.first_name', $search);
            $this->db->or_like('users.last_name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('user_sessions.ip_address', $search);
            $this->db->or_like('user_sessions.browser', $search);
            $this->db->or_like('user_sessions.os', $search);
            $this->db->group_end();
        }
    }

    public function get_sessions_dt($limit = 10, $offset = 0, $orders = array(), $search = '')
    {
        $this->_get_sessions_query($search);

        if (!empty($orders)) {
            foreach ($orders as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else {
            $this->db->order_by('user_sessions.last_activity', 'DESC');
        }

        if ($limit != -1) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    public function count_all_sessions()
    {
        return $this->db->count_all($this->table);
    }

    public function count_filtered_sessions($search = '')
    {
        $this->_get_sessions_query($search);
        return $this->db->get()->num_rows();
    }
}

