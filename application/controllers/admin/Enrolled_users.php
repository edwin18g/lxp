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
        $this->lang->load('auth');

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
        $data = $this->includes;

        // Table Header
        $data['t_headers'] = array(
            '#',
            'Image',
            lang('users_first_name'),
            lang('users_last_name'),
            lang('users_email'),
            'Enrolled Courses',
            lang('common_status'),
        );

        // load views
        $content['content'] = $this->load->view('admin/enrolled_users/index', $data, TRUE);
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
            $row[] = $no;

            // Image
            if ($val->image) {
                $img_url = base_url('upload/users/images/' . $val->image);
                $row[] = '<img src="' . $img_url . '" class="img-circle" width="40" height="40" alt="User">';
            } else {
                $initial = mb_substr($val->first_name, 0, 1) . mb_substr($val->last_name, 0, 1);
                $row[] = '<div class="btn-circle bg-blue waves-effect waves-circle waves-float" style="width:40px;height:40px;line-height:40px;text-align:center;color:#fff;font-weight:bold;">' . strtoupper($initial) . '</div>';
            }

            $row[] = $val->first_name;
            $row[] = $val->last_name;
            $row[] = $val->email;

            // Courses
            $courses_html = '<span class="badge bg-cyan">' . $val->course_count . ' Courses</span><br>';
            $courses_html .= '<button class="btn btn-info btn-xs waves-effect" onclick="openCourseSidebar(' . $val->id . ')">View Courses</button>';
            $row[] = $courses_html;

            $row[] = status_switch($val->active, $val->id);

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

        $courses = $this->users_model->get_user_course_details($user_id);

        if ($courses) {
            echo '<ul class="list-group">';
            foreach ($courses as $course) {
                echo '<li class="list-group-item">';
                echo '<div class="media">';
                echo '<div class="media-left">';
                if ($course->images) {
                    echo '<img class="media-object" src="' . base_url('upload/courses/images/' . $course->images) . '" width="64" height="64">';
                } else {
                    echo '<img class="media-object" src="' . base_url('themes/admin/images/book-cover.jpg') . '" width="64" height="64">';
                }
                echo '</div>';
                echo '<div class="media-body">';
                echo '<h4 class="media-heading">' . $course->title . '</h4>';
                echo '<p><span class="label label-info">Enrolled: ' . date('d M Y', strtotime($course->cs_start_date)) . '</span></p>';
                echo '</div>';
                echo '</div>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p class="text-center text-muted">No active courses found.</p>';
        }
    }
}
