<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'admin/batches_model',
            'admin/events_model',
            'users_model',
            'course_model',
            'event_model',
        ));

    }


    /**
     * Dashboard
     */
    function index()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        // setup page header data
        $this
            ->add_plugin_theme(array(
                // Jquery CountTo
                'jquery-countto/jquery.countTo.js',
            ), 'admin')
            ->set_title(lang('menu_dashboard'));

        $data = $this->includes;

        // Breadcrumb
        $data['breadcrumb'][0] = array('icon' => 'dashboard', 'route_name' => lang('menu_dashboard'), 'route_path' => site_url('admin'));

        $data['total_users'] = $this->users_model->count_users();
        $data['total_courses'] = $this->course_model->count_courses();
        $data['total_batches'] = $this->course_model->count_batches();

        $data['todays_b_e'] = $this->course_model->todays_batches_list() + $this->event_model->todays_events_list();
        $data['top_events'] = $this->events_model->top_events_list();
        $data['recent_users'] = $this->users_model->get_recent_users(5);

        // Chart Data
        $user_counts = $this->users_model->count_users_by_month();
        $monthly_data = array_fill(0, 12, 0); // Initialize all 12 months with 0
        foreach ($user_counts as $row) {
            $monthly_data[$row['month'] - 1] = (int) $row['count'];
        }
        $data['user_growth_data'] = json_encode($monthly_data);

        // load views
        $content['content'] = $this->load->view('admin/system/dashboard', $data, TRUE);
        $this->load->view($this->template, $content);
    }

}
