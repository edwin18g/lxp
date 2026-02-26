<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Enrolled Users Controller
 *
 * This class handles enrolled users module functionality
 */
class Enrolled_users extends Admin_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->load->model('users_model');
        //$this->lang->load('auth');

        // Page Title
        $this->set_title('Enrolled Users');
    }

    /**
     * index
     */
    function index()
    {
        /* Initialize assets */
        $this->include_index_plugins();
        $this->add_plugin_theme(array(
            "sweetalert/sweetalert.css",
            "sweetalert/sweetalert.min.js",
        ), 'core');
        $data = $this->includes;

        // Table Header
        $data['t_headers'] = array(
            '<input type="checkbox" id="chk_all" class="filled-in chk-col-blue"><label for="chk_all"></label>',
            '#',
            'Image',
            lang('users_first_name'),
            lang('users_last_name'),
            lang('users_email'),
            'Enrolled Courses',
            lang('common_status'),
            'Lock',
            'Remove',
            'Details',
        );

        // Stats
        $data['total_enrolled'] = $this->db->query("SELECT COUNT(DISTINCT cs_user_id) as count FROM course_subscription WHERE cs_status = 1")->row()->count;

        // Locked Learning Count - distinct users enrolled with device_locked = 1
        $data['total_locked_learning'] = $this->db->query("
            SELECT COUNT(DISTINCT users.id) as count 
            FROM users 
            JOIN course_subscription ON course_subscription.cs_user_id = users.id 
            WHERE course_subscription.cs_status = 1 AND users.device_locked = 1
        ")->row()->count;

        // load views
        $content['content'] = $this->load->view('admin/lms/enrolled_users/index', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * ajax_list
     */
    public function ajax_list()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];
        $order_post = $this->input->post('order');

        $orders = array();
        $columns_map = array(
            2 => 'users.first_name',
            3 => 'users.last_name',
            4 => 'users.email',
            5 => 'course_count',
            6 => 'users.active',
        );

        if ($order_post) {
            foreach ($order_post as $o) {
                if (isset($columns_map[$o['column']])) {
                    $orders[$columns_map[$o['column']]] = $o['dir'];
                }
            }
        }

        $list = $this->users_model->get_enrolled_users_dt($length, $start, $orders, $search);

        $data = array();
        $no = $start;

        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" id="u_chk_' . $val->id . '" class="filled-in chk-col-blue user-chk" value="' . $val->id . '"><label for="u_chk_' . $val->id . '"></label>';
            $row[] = $no;

            // Image
            if ($val->image) {
                $img_url = base_url('upload/users/images/' . $val->image);
                $row[] = '<img src="' . $img_url . '" class="img-circle" width="28" height="28" alt="User">';
            } else {
                $initial = mb_substr($val->first_name, 0, 1) . mb_substr($val->last_name, 0, 1);
                $row[] = '<div class="btn-circle bg-blue waves-effect waves-circle waves-float" style="width:28px;height:28px;line-height:28px;text-align:center;color:#fff;font-weight:bold;font-size:10px;">' . strtoupper($initial) . '</div>';
            }

            $row[] = $val->first_name;
            $row[] = $val->last_name;
            $row[] = $val->email;

            // Courses
            $courses_html = '<span class="badge bg-cyan">' . $val->course_count . ' Courses</span>';

            $row[] = $courses_html;

            $row[] = status_switch($val->active, $val->id);

            // Locked Learning Toggle
            $lock_icon = $val->device_locked ? 'lock' : 'lock_open';
            $lock_class = $val->device_locked ? 'color-danger' : 'color-success';
            $lock_title = $val->device_locked ? 'Unlock Learning' : 'Lock Learning';

            $row[] = '<button class="btn btn-default btn-circle-sm waves-effect btn-lock-toggle ' . $lock_class . '" onclick="toggleLearningLock(' . $val->id . ', ' . ($val->device_locked ? 0 : 1) . ')" title="' . $lock_title . '">
                        <i class="material-icons" style="font-size:16px;">' . $lock_icon . '</i>
                      </button>';

            // Remove Enrollment Action
            $row[] = '<button class="btn btn-default btn-circle-sm waves-effect text-danger" onclick="removeAllUserEnrollments(' . $val->id . ')" title="Remove All Enrollments">
                        <i class="material-icons" style="font-size:16px;">delete_forever</i>
                      </button>';

            // Details Action
            $row[] = '<button class="btn btn-default btn-circle-sm waves-effect" onclick="openCourseSidebar(' . $val->id . ')" title="View Details"><i class="material-icons" style="font-size:16px;">visibility</i></button>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->users_model->count_all_enrolled_users(),
            "recordsFiltered" => $this->users_model->count_filtered_enrolled_users($search),
            "data" => $data,
        );

        echo json_encode($output);
    }

    /**
     * ajax_get_courses
     */
    public function ajax_get_courses()
    {
        $user_id = $this->input->post('user_id');
        if (!$user_id) {
            echo '<p class="text-center text-muted">Invalid User</p>';
            return;
        }

        $user = $this->users_model->get_users_by_id($user_id);
        $courses = $this->users_model->get_user_course_details($user_id);

        if (!$user) {
            echo '<p class="text-center text-muted">User not found</p>';
            return;
        }

        // Sidebar Header with User Info
        echo '<div class="offcanvas-user-profile animate-up">';
        echo '<div class="profile-main">';

        $image = is_object($user) ? $user->image : $user['image'];
        $first_name = is_object($user) ? $user->first_name : $user['first_name'];
        $last_name = is_object($user) ? $user->last_name : $user['last_name'];
        $email = is_object($user) ? $user->email : $user['email'];

        if ($image) {
            echo '<img src="' . base_url('upload/users/images/' . $image) . '" class="profile-avatar shadow-lg" alt="User">';
        } else {
            $initial = mb_substr($first_name, 0, 1) . mb_substr($last_name, 0, 1);
            echo '<div class="profile-avatar-initial bg-indigo-soft color-indigo shadow-lg">' . strtoupper($initial) . '</div>';
        }
        echo '<div class="profile-details">';
        echo '<h3>' . $first_name . ' ' . $last_name . '</h3>';
        echo '<p><i class="material-icons">email</i> ' . $email . '</p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="profile-stats">';
        echo '<div class="stat-pill"><span class="label">Total Courses</span><span class="value">' . count($courses) . '</span></div>';
        echo '<div class="stat-pill"><span class="label">Status</span><span class="value active">' . ($user->active ? 'Active' : 'Inactive') . '</span></div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="offcanvas-content-wrapper p-30 animate-up" style="animation-delay: 0.1s;">';
        echo '<h4 class="section-title">Enrolled Courses</h4>';

        if ($courses) {
            echo '<div class="course-grid-modern">';
            foreach ($courses as $course) {
                echo '<div class="course-card-premium">';
                echo '<div class="course-badge">' . date('M Y', strtotime($course->cs_start_date)) . '</div>';
                echo '<div class="course-image-wrapper">';
                if ($course->images) {
                    echo '<img src="' . base_url('upload/courses/images/' . $course->images) . '" alt="Course">';
                } else {
                    echo '<img src="' . base_url('themes/admin/images/book-cover.jpg') . '" alt="Course">';
                }
                echo '</div>';
                echo '<div class="course-body">';
                echo '<h5>' . $course->title . '</h5>';
                echo '<div class="course-meta">';
                echo '<span><i class="material-icons">event</i> ' . date('d M, Y', strtotime($course->cs_start_date)) . '</span>';
                echo '</div>';
                echo '<div class="course-actions">';
                echo '<a href="' . site_url('admin/course/preview/' . $course->id) . '" class="btn-card-action">PREVIEW <i class="material-icons" style="font-size:14px;">arrow_forward</i></a>';
                echo '<button onclick="removeEnrollment(' . $course->cs_id . ', ' . $user_id . ')" class="btn-card-action color-danger ml-5" style="border:none; background:transparent; cursor:pointer; font-size:12px; font-weight:800; padding:0; display:flex; align-items:center; gap:4px;">REMOVE <i class="material-icons" style="font-size:14px;">delete_outline</i></button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="empty-state-sidebar">';
            echo '<i class="material-icons">info_outline</i>';
            echo '<p>This user has no active enrollments.</p>';
            echo '</div>';
        }
        echo '</div>';
    }

    /**
     * get_active_courses_ajax
     */
    public function get_active_courses_ajax()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        $this->load->model('admin/courses_model');
        $courses = $this->db->select('id, title')
            ->where('status', 1)
            ->order_by('title', 'ASC')
            ->get('courses')
            ->result();

        echo json_encode($courses);
        exit;
    }

    /**
     * get_users_for_enrollment_ajax
     */
    public function get_users_for_enrollment_ajax()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        $course_id = $this->input->post('course_id');
        $this->load->model('admin/courses_model');

        $param = array(
            'course_id' => $course_id,
            'select' => 'users.id, users.first_name, users.last_name, users.username, users.email'
        );
        $users = $this->courses_model->get_user_dropdown($param);

        echo json_encode($users);
        exit;
    }

    /**
     * toggle_lock_ajax
     */
    public function toggle_lock_ajax()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');

        if (empty($user_id)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Invalid request.'));
            exit;
        }

        $data = array(
            'id' => $user_id,
            'device_locked' => $status
        );

        if ($this->users_model->enable_secure($data)) {
            // Clear all sessions if unlocking
            if (!$status) {
                // CI3 session data is serialized. We look for the user_id in the data blob.
                // Format: user_id|s:len:"value";
                $this->db->like('data', 'user_id|s:' . strlen($user_id) . ':"' . $user_id . '";');
                $this->db->delete('ce_sessn');

                // Also clear last_session_id in users table to be thorough
                $this->db->where('id', $user_id)->update('users', array('last_session_id' => NULL));
            }

            $msg = $status ? 'Learning locked successfully.' : 'Learning unlocked successfully.';

            // Get new count
            $new_count = $this->db->query("
                SELECT COUNT(DISTINCT users.id) as count 
                FROM users 
                JOIN course_subscription ON course_subscription.cs_user_id = users.id 
                WHERE course_subscription.cs_status = 1 AND users.device_locked = 1
            ")->row()->count;

            echo json_encode(array('flag' => 1, 'msg' => $msg, 'new_count' => $new_count));
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Failed to update lock status.'));
        }
        exit;
    }

    /**
     * save_enrollment_ajax
     */
    public function save_enrollment_ajax()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        $course_id = $this->input->post('course_id');
        $user_ids = $this->input->post('user_ids');

        if (empty($course_id) || empty($user_ids)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Please select course and users.'));
            exit;
        }

        $this->load->model('admin/courses_model');
        $success_count = 0;

        foreach ($user_ids as $user_id) {
            $data = array(
                'cs_user_id' => $user_id,
                'cs_course_id' => $course_id,
                'cs_start_date' => date('Y-m-d'),
                'cs_status' => 1
            );
            if ($this->courses_model->save_suscription($data)) {
                $success_count++;
            }
        }

        if ($success_count > 0) {
            echo json_encode(array('flag' => 1, 'msg' => $success_count . ' users enrolled successfully!'));
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Failed to enroll users.'));
        }
        exit;
    }

    /**
     * remove_enrollment_ajax
     */
    public function remove_enrollment_ajax()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        $cs_id = $this->input->post('cs_id');

        if (empty($cs_id)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Invalid request.'));
            exit;
        }

        if ($this->users_model->remove_enrollment($cs_id)) {
            echo json_encode(array('flag' => 1, 'msg' => 'Enrollment removed successfully.'));
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Failed to remove enrollment.'));
        }
        exit;
    }

    /**
     * remove_all_user_enrollments_ajax
     */
    public function remove_all_user_enrollments_ajax()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        $user_id = $this->input->post('user_id');

        if (empty($user_id)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Invalid request.'));
            exit;
        }

        if ($this->users_model->remove_all_user_enrollments($user_id)) {
            // Get new total enrolled count for global stats
            $total_enrolled = $this->db->query("SELECT COUNT(DISTINCT cs_user_id) as count FROM course_subscription WHERE cs_status = 1")->row()->count;
            echo json_encode(array('flag' => 1, 'msg' => 'All enrollments removed for this user.', 'total_enrolled' => $total_enrolled));
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Failed to remove enrollments.'));
        }
        exit;
    }

    /**
     * bulk_remove_enrollment_ajax
     */
    public function bulk_remove_enrollment_ajax()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        $user_ids = $this->input->post('user_ids');

        if (empty($user_ids) || !is_array($user_ids)) {
            echo json_encode(array('flag' => 0, 'msg' => 'No users selected.'));
            exit;
        }

        if ($this->users_model->bulk_remove_user_enrollments($user_ids)) {
            // Get new total enrolled count for global stats
            $total_enrolled = $this->db->query("SELECT COUNT(DISTINCT cs_user_id) as count FROM course_subscription WHERE cs_status = 1")->row()->count;
            echo json_encode(array('flag' => 1, 'msg' => count($user_ids) . ' user enrollments removed.', 'total_enrolled' => $total_enrolled));
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Failed to remove enrollments.'));
        }
        exit;
    }
}
