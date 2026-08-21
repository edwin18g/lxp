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

        $this->db->insert($this->table, $data);

        if ($this->db->insert_id()) {
            return $this->db->insert_id();
        }

        return FALSE;
    }

    /**
     * Deactivate a session on logout
     *
     * @param string $session_id
     * @return bool
     */
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

    /**
     * Deactivate all sessions for a user (force logout everywhere)
     *
     * @param int $user_id
     * @return bool
     */
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

    /**
     * Get all active sessions for a user
     *
     * @param int $user_id
     * @return array
     */
    public function get_active($user_id)
    {
        $this->db->where('user_id', $user_id)
                  ->where('is_active', 1)
                  ->order_by('last_activity', 'DESC');

        $query = $this->db->get($this->table);
        return $query->result_array();
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

                // Get macOS version
                if ($os === 'macOS' && preg_match('/Mac OS X ([\d_]+)/i', $ua, $m)) {
                    $os = 'macOS ' . str_replace('_', '.', $m[1]);
                }

                // Get Android version
                if ($os === 'Android' && preg_match('/Android ([\d.]+)/i', $ua, $m)) {
                    $os = 'Android ' . $m[1];
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
}
