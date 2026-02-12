<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Model
 *
 * This model handles users module data
 *
 * @package     classiebit
 * @author      prodpk
 */

class Users_model extends CI_Model
{

    /**
     * @vars
     */
    private $table = 'users';

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * count_users
     */
    public function count_users()
    {
        return $this->db->count_all_results($this->table);
    }

    /**
     * get_users_by_id
     *
     * @return array
     * 
     **/
    public function get_users_by_id($id = FALSE, $is_array = FALSE)
    {
        $this->db->select(array(
            "$this->table.id",
            "$this->table.first_name",
            "$this->table.last_name",
            "$this->table.username",
            "$this->table.email",
            "$this->table.mobile",
            "$this->table.address",
            "$this->table.gender",
            "$this->table.dob",
            "$this->table.profession",
            "$this->table.experience",
            "$this->table.about",
            "$this->table.image",
            "$this->table.language",
            "$this->table.active",
            "$this->table.role",
            "$this->table.date_added",
            "$this->table.date_updated",
            "$this->table.secure_key",
            "$this->table.device_locked",
            "(SELECT gr.name FROM `groups` gr WHERE gr.id = (SELECT ug.group_id FROM users_groups ug WHERE ug.user_id = $this->table.id)) group_name",
        ))
            ->where(array('id' => $id));


        if ($is_array)
            return $this->db->get($this->table)->row_array();
        else
            return $this->db->get($this->table)->row();
    }

    public function get_group_name($g_id = NULL)
    {
        if ($g_id)
            return $this->db->where('id', $g_id)
                ->get('`groups`')
                ->row();

        return FALSE;
    }


    public function enable_secure($param)
    {
        if (!empty($param['id'])) {
            $this->db->where(array('id' => $param['id']))
                ->update($this->table, $param);
            return true;
        }
    }
    /**
     * save_users
     *
     * @return array
     * 
     **/


    public function save_users($data = array(), $id = FALSE, $email = FALSE)
    {
        if ($id) // update
        {
            $this->db->where(array('id' => $id))
                ->update($this->table, $data);
            return $id;
        } else if ($email) {
            $this->db->where(array('email' => $email))
                ->update($this->table, $data);
            return $email;
        } else // insert
        {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }

    }

    /**
     * reset_device_lock
     *
     * @return boolean
     * 
     **/
    public function reset_device_lock($id)
    {
        if ($id) {
            $this->db->where('id', $id)
                ->update($this->table, array('device_locked' => 0, 'last_session_id' => NULL, 'secure_key' => ''));
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Check to see if a username already exists
     *
     * @param  string $username
     * @return boolean
     */
    function username_exists($username)
    {
        $sql = "
            SELECT id
            FROM {$this->table}
            WHERE username = " . $this->db->escape($username) . "
            LIMIT 1
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Check to see if an email already exists
     *
     * @param  string $email
     * @return boolean
     */
    function email_exists($email)
    {
        $sql = "
            SELECT id
            FROM {$this->table}
            WHERE email = " . $this->db->escape($email) . "
            LIMIT 1
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows()) {
            return TRUE;
        }

        return FALSE;
    }


    /**
     * Check for valid login oauth
     *
     * @param  string $username
     * @param  string $password
     * @return array|boolean
     */
    function login_oauth($email = NULL)
    {
        return $this->db
            ->select(array(
                'id',
                'username',
                'first_name',
                'last_name',
                'email',
                'gender',
                'experience',
                'dob',
                'mobile',
                'address',
                'image',
                'language',
                'active',
                'date_added',
                'date_updated'
            ))
            ->where(array('email' => $email))
            ->get($this->table)
            ->row_array();
    }

    /**
     * Check to see if an oauth_uid already exists
     *
     * @param  string $oauth_uid
     * @return boolean
     */
    function oauth_uid_exists($fb_uid = NULL, $g_uid = NULL)
    {
        if ($fb_uid) {
            $row = $this->db->select(array('id'))
                ->where(array('fb_uid' => $fb_uid))
                ->limit(1)
                ->get($this->table)
                ->row();

            if (!empty($row))
                return TRUE;

        }

        if ($g_uid) {
            $row = $this->db->select(array('id'))
                ->where(array('g_uid' => $g_uid))
                ->limit(1)
                ->get($this->table)
                ->row();

            if (!empty($row))
                return TRUE;
        }

        return FALSE;
    }


    /**
     * count_users_batch
     *
     * @return array
     * 
     **/
    public function count_users_batch($id = NULL)
    {
        return $this->db->where(array('users_id' => $id))
            ->count_all_results('batches_tutors');
    }

    /**
     * count_users_by_month
     *
     * @return array
     */
    public function count_users_by_month()
    {
        $query = $this->db->query("
            SELECT 
                MONTH(date_added) as month, 
                COUNT(id) as count 
            FROM users 
            WHERE YEAR(date_added) = YEAR(CURDATE()) 
            GROUP BY MONTH(date_added)
        ");

        return $query->result_array();
    }

    /**
     * get_enrolled_users_dt
     */
    public function get_enrolled_users_dt($limit, $start, $orders, $search)
    {
        $this->db->select("
            users.id,
            users.first_name,
            users.last_name,
            users.username,
            users.email,
            users.mobile,
            users.image,
            users.active,
            users.device_locked,
            COUNT(course_subscription.id) as course_count
        ");
        $this->db->from('users');
        $this->db->join('course_subscription', 'course_subscription.cs_user_id = users.id');
        $this->db->where('course_subscription.cs_status', '1');
        $this->db->group_by('users.id');

        if ($search) {
            $this->db->group_start();
            $this->db->like('users.first_name', $search);
            $this->db->or_like('users.last_name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->group_end();
        }

        // Global Column Search (Google Sheets style)
        $columns = $this->input->post('columns');
        if ($columns) {
            foreach ($columns as $key => $column) {
                if (!empty($column['search']['value'])) {
                    $val = $column['search']['value'];
                    switch ($key) {
                        case 2:
                            $this->db->like('users.first_name', $val);
                            break;
                        case 3:
                            $this->db->like('users.last_name', $val);
                            break;
                        case 4:
                            $this->db->like('users.email', $val);
                            break;
                        case 5:
                            $this->db->having("course_count = $val");
                            break;
                        case 6:
                            $this->db->where('users.active', $val);
                            break;
                    }
                }
            }
        }

        if ($orders) {
            foreach ($orders as $key => $val) {
                $this->db->order_by($key, $val);
            }
        } else {
            $this->db->order_by('users.first_name', 'ASC');
        }

        if ($limit != -1) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result();
    }

    public function count_all_enrolled_users()
    {
        return $this->db->query("SELECT COUNT(DISTINCT cs_user_id) as count FROM course_subscription WHERE cs_status = '1'")->row()->count;
    }

    public function count_filtered_enrolled_users($search)
    {
        $this->db->select("COUNT(DISTINCT users.id) as count");
        $this->db->from('users');
        $this->db->join('course_subscription', 'course_subscription.cs_user_id = users.id');
        $this->db->where('course_subscription.cs_status', '1');

        if ($search) {
            $this->db->group_start();
            $this->db->like('users.first_name', $search);
            $this->db->or_like('users.last_name', $search);
            $this->db->or_like('users.email', $search);
            $this->db->group_end();
        }

        // Global Column Search (Google Sheets style)
        $columns = $this->input->post('columns');
        if ($columns) {
            foreach ($columns as $key => $column) {
                if (!empty($column['search']['value'])) {
                    $val = $column['search']['value'];
                    switch ($key) {
                        case 2:
                            $this->db->like('users.first_name', $val);
                            break;
                        case 3:
                            $this->db->like('users.last_name', $val);
                            break;
                        case 4:
                            $this->db->like('users.email', $val);
                            break;
                        case 5:
                            $this->db->where("(SELECT COUNT(cs.id) FROM course_subscription cs WHERE cs.cs_user_id = users.id AND cs.cs_status = '1') = $val");
                            break;
                        case 6:
                            $this->db->where('users.active', $val);
                            break;
                    }
                }
            }
        }

        return $this->db->get()->row()->count;
    }

    /**
     * get_user_course_details
     * 
     * @param int $user_id
     * @return array
     */
    public function get_user_course_details($user_id)
    {
        $this->db->select("
            courses.id,
            courses.title,
            courses.images,
            courses.status,
            course_subscription.id as cs_id,
            course_subscription.cs_start_date,
            course_subscription.cs_end_date
        ");
        $this->db->from('course_subscription');
        $this->db->join('courses', 'courses.id = course_subscription.cs_course_id');
        $this->db->where('course_subscription.cs_user_id', $user_id);
        $this->db->where('course_subscription.cs_status', '1');
        $this->db->order_by('courses.title', 'ASC');

        return $this->db->get()->result();
    }

    public function remove_enrollment($cs_id)
    {
        return $this->db->delete('course_subscription', array('id' => $cs_id));
    }

    public function remove_all_user_enrollments($user_id)
    {
        return $this->db->delete('course_subscription', array('cs_user_id' => $user_id));
    }

    public function bulk_remove_user_enrollments($user_ids)
    {
        $this->db->where_in('cs_user_id', $user_ids);
        return $this->db->delete('course_subscription');
    }


    /**
     * get_users_dt (DataTables Server-side)
     */
    public function get_users_dt($limit, $start, $orders, $search)
    {
        $this->db->select("
            users.id,
            users.image,
            users.first_name,
            users.last_name,
            users.username,
            users.mobile,
            users.email,
            users.active,
            users.date_updated,
            (SELECT gr.name FROM `groups` gr WHERE gr.id = (SELECT ug.group_id FROM users_groups ug WHERE ug.user_id = users.id LIMIT 1)) as group_name
        ");
        $this->db->from('users');

        if ($search) {
            $this->db->group_start();
            $this->db->like('users.first_name', $search);
            $this->db->or_like('users.last_name', $search);
            $this->db->or_like('users.username', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('users.mobile', $search);
            $this->db->group_end();
        }

        // Global Column Search (Google Sheets style)
        $columns = $this->input->post('columns');
        if ($columns) {
            foreach ($columns as $key => $column) {
                if (!empty($column['search']['value'])) {
                    $val = $column['search']['value'];
                    switch ($key) {
                        case 2:
                            $this->db->like('users.first_name', $val);
                            break;
                        case 3:
                            $this->db->like('users.last_name', $val);
                            break;
                        case 4:
                            $this->db->like('users.username', $val);
                            break;
                        case 5:
                            $this->db->like('users.email', $val);
                            break;
                        case 6:
                            $this->db->like('users.mobile', $val);
                            break;
                        case 7:
                            $this->db->having("group_name LIKE '%$val%'");
                            break;
                        case 8:
                            $this->db->where('users.active', $val);
                            break;
                    }
                }
            }
        }

        if ($orders) {
            foreach ($orders as $key => $val) {
                $this->db->order_by($key, $val);
            }
        } else {
            $this->db->order_by('users.id', 'DESC');
        }

        if ($limit != -1) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result();
    }

    /**
     * count_all_users
     */
    public function count_all_users()
    {
        return $this->db->count_all('users');
    }

    /**
     * count_filtered_users
     */
    public function count_filtered_users($search)
    {
        $this->db->from('users');
        if ($search) {
            $this->db->group_start();
            $this->db->like('users.first_name', $search);
            $this->db->or_like('users.last_name', $search);
            $this->db->or_like('users.username', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('users.mobile', $search);
            $this->db->group_end();
        }

        // Global Column Search (Google Sheets style)
        $columns = $this->input->post('columns');
        if ($columns) {
            foreach ($columns as $key => $column) {
                if (!empty($column['search']['value'])) {
                    $val = $column['search']['value'];
                    switch ($key) {
                        case 2:
                            $this->db->like('users.first_name', $val);
                            break;
                        case 3:
                            $this->db->like('users.last_name', $val);
                            break;
                        case 4:
                            $this->db->like('users.username', $val);
                            break;
                        case 5:
                            $this->db->like('users.email', $val);
                            break;
                        case 6:
                            $this->db->like('users.mobile', $val);
                            break;
                        case 7:
                            $this->db->where("(SELECT gr.name FROM `groups` gr WHERE gr.id = (SELECT ug.group_id FROM users_groups ug WHERE ug.user_id = users.id LIMIT 1)) LIKE '%$val%'");
                            break;
                        case 8:
                            $this->db->where('users.active', $val);
                            break;
                    }
                }
            }
        }

        return $this->db->count_all_results();
    }

    /**
     * get_recent_users
     */
    public function get_recent_users($limit = 5)
    {
        $this->db->select("id, first_name, last_name, username, email, image, date_added");
        $this->db->from($this->table);
        $this->db->order_by('date_added', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

}
/*Users model ends*/