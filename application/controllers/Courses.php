<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Courses Controller
 *
 * This class handles courses listings module functionality
 *
 * @package     classiebit
 * @author      prodpk
 */

class Courses extends Public_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'admin/courses_model',
            'admin/categories_model',
            'course_model',
            'users_model',
        ));
    }


    function user_input_json()
    {

        header("Content-type:application/json");

        $limit = 5;

        if (null !== $_GET['limit']) {

            $limit = $_GET['limit'];
        }



        $row = $this->db->where('lock', '0')->limit($limit)->get('user_data')->result_array();



        if (!empty($row)) {


            $names = array_column($row, 'id');
            $this->db->where_in('id', $names);
            $this->db->update('user_data', array('lock' => '1'));


            echo json_encode($row);
        } else {
            echo json_encode(array('user_data' => 'empty'));
        }


        // $data  = file_get_contents('/home/edwinpok/public_html/zeyobron.com/upload/jsondata/'.rand(1,53).'.json');



        // echo $data;



        die;
    }

    function stream_sample()
    {
        for ($i = 1; $i <= 10; $i++):
            sleep(1);
            echo "$i\n";
            ob_flush();
            flush();
        endfor;

    }

    function sample_json()
    {

        header("Content-type:application/json");

        $limit = 5;

        if (null !== $_GET['limit']) {

            $limit = $_GET['limit'];
        }





        $data = file_get_contents('/home/edwinpok/public_html/zeyobron.com/upload/jsondata/' . rand(1, 53) . '.json');



        echo $data;



        die;
    }



    function user_input()
    {


        if (null !== $this->input->post('user_data')) {

            $data = array(

                'name' => $this->input->post('user_data')

            );

            $this->db->insert('user_data', $data);

        }



        $this->load->view('user_input', array('sample' => 'yes'));
    }

    private function get_courses_by_category($category = NULL)
    {
        $categories = array();
        if ($category) {
            $category_id = $this->course_model->get_course_categories_id($category);

            if (empty($category_id))
                show_404();

            $categories = $this->categories_model->get_course_categories_levels_status_update($category_id->id);
            // insert top-level category id at first
            array_unshift($categories, array('id' => $category_id->id));

            foreach ($categories as $key => $val)
                $categories[$key] = $val['id'];
        }

        $data['courses'] = $this->course_model->get_courses($categories);

        // get user ids by group tutor = 2
        $tutor_ids = array();
        foreach ($this->ion_auth->get_users_by_group(2)->result() as $val)
            $tutor_ids[] = $val->user_id;

        $data['tutors'] = $this->course_model->get_tutors($tutor_ids);

        foreach ($data['courses'] as $key => $val)
            if ($val->users_id)
                foreach ($data['tutors'] as $v)
                    if ($v->id === $val->users_id)
                        $val->tutor = $v;


        return $data;
    }


    /**
     * index
     */
    function index($category = NULL)
    {
        /* Initialize assets and title */
        $this
            ->add_plugin_theme(array(
                'vmenu-module/vmenuModule.js',
                'easy-autocomplete/easy-autocomplete.min.css',
                'easy-autocomplete/easy-autocomplete.themes.min.css',
                'easy-autocomplete/jquery.easy-autocomplete.min.js',
            ), 'default')
            ->add_js_theme("pages/courses_listings/index_i18n.js", TRUE);

        // setup page header data
        $this->set_title(lang('menu_courses'));

        $data = $this->includes;

        $category = $category ? str_replace('+', ' ', urldecode($category)) : NULL;
        $courses = $this->get_courses_by_category($category);

        // set content data
        $content_data['category'] = $category;
        $content_data['courses'] = $courses['courses'];
        $content_data['tutors'] = $courses['tutors'];
        $content_data['p_courses'] = $this->course_model->top_courses_list();

        // load views
        $data['content'] = $this->load->view('courses_listings', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    private function get_featured_c_e()
    {
        $data['f_courses'] = $this->course_model->get_f_courses();
        $data['f_events'] = array();
        $tutor_ids = array();
        foreach ($this->ion_auth->get_users_by_group(2)->result() as $val)
            $tutor_ids[] = $val->user_id;

        $data['tutors'] = $this->course_model->get_tutors($tutor_ids);

        foreach ($data['f_courses'] as $key => $val)
            if ($val->users_id)
                foreach ($data['tutors'] as $v)
                    if ($v->id === $val->users_id)
                        $val->tutor = $v;

        return $data;
    }
    function my_courses($category = NULL)
    {


        $this
            ->add_plugin_theme(array(
                "owl-carousel/owl.carousel.css",
                "owl-carousel/owl.carousel.min.js",
                "theme-lib/counter.js",
                "theme-lib/isotope.pkgd.min.js",
                "theme-lib/jquery.mb.YTPlayer.min.js",
                // "theme-lib/jquery.stellar.min.js",
                'easy-autocomplete/easy-autocomplete.min.css',
                'easy-autocomplete/easy-autocomplete.themes.min.css',
                'easy-autocomplete/jquery.easy-autocomplete.min.js',
            ), 'default')
            ->add_js_theme("pages/welcome/index_i18n.js", TRUE);

        // setup page header data
        $this->set_title(sprintf(lang('welcome title'), $this->settings->site_name));

        $data = $this->includes;

        $c_e_data = $this->get_featured_c_e();


        $my_courses_list = array();
        if (isset($_SESSION['user_id'])) {

            $user_id = $_SESSION['user_id'];
            $my_courses_list = $this->course_model->get_my_courses_details($user_id);

            foreach ($my_courses_list as $course) {
                $course->progress = $this->course_model->get_course_progress($user_id, $course->id);
            }
        }

        // set content data
        $content_data = array(
            'f_courses' => $c_e_data['f_courses'],
            'f_events' => $c_e_data['f_events'],
            'tutors' => $c_e_data['tutors'],
            'my_courses' => $my_courses_list
        );

        // load views
        $data['content'] = $this->load->view('my_course_new', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function my_courses_old($category = NULL)
    {


        /* Initialize assets and title */
        $this
            ->add_plugin_theme(array(
                'vmenu-module/vmenuModule.js',
                'easy-autocomplete/easy-autocomplete.min.css',
                'easy-autocomplete/easy-autocomplete.themes.min.css',
                'easy-autocomplete/jquery.easy-autocomplete.min.js',
            ), 'default')
            ->add_js_theme("pages/courses_listings/index_i18n.js", TRUE);

        // setup page header data
        $this->set_title(lang('menu_courses'));

        $data = $this->includes;
        $user_id = $_SESSION['logged_in']['id'];
        $category = $category ? str_replace('+', ' ', urldecode($category)) : NULL;
        $get_course_ids = $this->course_model->get_my_courses_ids($user_id);
        $get_course_ids = array_column($get_course_ids, 'cs_course_id');
        $data['courses'] = $this->course_model->get_my_courses($get_course_ids);
        if (empty($data['courses'])) {
            redirect('/', 'refresh');
        }

        // get user ids by group tutor = 2
        $tutor_ids = array();
        foreach ($this->ion_auth->get_users_by_group(2)->result() as $val)
            $tutor_ids[] = $val->user_id;

        $data['tutors'] = $this->course_model->get_tutors($tutor_ids);






        // set content data
        // $content_data['category']   = $category;
        // $content_data['courses']    = $courses['courses'];
        // $content_data['tutors']     = $courses['tutors'];
        // echo "<pre>"; print_r($content_data);die;
        //$content_data['p_courses']  = $this->course_model->top_courses_list();

        // load views
        $data['content'] = $this->load->view('courses_listings', $data, TRUE);
        $this->load->view($this->template, $data);
    }
    /**
     * detail
     */
    public function content_course()
    {
        //$post_data      = file_get_contents('php://input');
        $id = $this->input->post('id');
        //$lecture_id     = $this->input->post('content_id');
        $finger_id = $this->input->post('finger');
        $user_id = $_SESSION['logged_in']['id'];
        $lecture = $this->course_model->get_course_lecture_by_id($id);

        $response = array();
        $response['error'] = false;
        $response['message'] = 'Course Content Not available';

        //echo "<pre>";print_r($lecture);die;
        if (!empty($lecture)) {
            $response = array();
            $response['error'] = false;
            $response['message'] = 'Course Content haveing issue';
            $response['message'] = 'Course Content getting success';


            $response['data'] = '<iframe  id="myframe" src="https://drive.google.com/file/d/' . $lecture['cl_file_name'] . '/preview" frameborder="0" frameborder="0" scrolling="no" seamless="" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe><div style="width: 80px; height: 80px; position: absolute; opacity: 0; right: 0px; top: 0px;"> </div>';

            if ($lecture['cl_type'] == 3) {
                $content_data['data'] = $lecture;
                $response['data'] = $this->load->view('plyr', $content_data, TRUE);


            }



            echo $response['data'];
        }

        die;
    }

    function course_board($id)
    {
        $user_id = (!empty($_SESSION['logged_in']['id'])) ? $_SESSION['logged_in']['id'] : false;
        if (!$user_id) {
            redirect('/', 'refresh');
        }
        /* Initialize assets and title */
        $this
            ->add_plugin_theme(array(
                "owl-carousel/owl.carousel.css",
                "owl-carousel/owl.carousel.min.js",
            ), 'default')
            ->add_js_theme("pages/courses_listings/detail.js");

        // setup page header data
        $this->set_title(lang('menu_course'));
        $data = $this->includes;
        $data['hide_header'] = false;

        // set content data
        $content_data['course_detail'] = $this->course_model->get_course_by_id(array('id' => $id));

        if (empty($content_data['course_detail']))
            show_404();
        $content_data['course_lectue'] = $this->course_model->get_course_lecture($id);


        if ($content_data['course_detail']->meta_title)
            $this->meta_title = $content_data['course_detail']->meta_title;
        if ($content_data['course_detail']->meta_tags)
            $this->meta_tags = $content_data['course_detail']->meta_tags;
        if ($content_data['course_detail']->meta_description)
            $this->meta_description = $content_data['course_detail']->meta_description;
        if ($content_data['course_detail']->images)
            $this->meta_image = base_url('upload/courses/images/') . json_decode($content_data['course_detail']->images)[0];
        if ($content_data['course_detail']->title)
            $this->meta_url = site_url('courses/detail/') . str_replace(' ', '+', $content_data['course_detail']->title);

        // related courses
        // render top-level category
        $categories_levels = $this->courses_model->get_courses_levels($content_data['course_detail']->course_categories_id);
        $count_level = count($categories_levels);
        $top_level_category = $categories_levels[$count_level - 1]; // the last category will be top category


        // load views

        $data['content'] = $this->load->view('course_board', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    function lecture($course_id = null, $id = null)
    {

        try {


            $user_id = (!empty($_SESSION['logged_in']['id'])) ? $_SESSION['logged_in']['id'] : null;

            if ($user_id == null) {
                throw new Exception("you are not authorized to access Video Content... Please Login To Get Access");
            }

            if ($course_id == null) {
                throw new Exception("Course Not Found !...");
            }



            $lecture = $this->course_model->get_course_lecture_by_id($id);

            if (empty($lecture)) {

                $lecture = $this->course_model->get_course_lecture_random_id(($course_id));
                if (empty($lecture)) {
                    throw new Exception("Video Content Not Found !...");
                }

            }

            $Is_subscription = $this->db->get_where('course_subscription', array('cs_user_id' => $user_id, 'cs_course_id' => $lecture['cl_course_id']))->num_rows();

            if ($Is_subscription > 0) {

                $this->add_plugin_theme(array(
                    "owl-carousel/owl.carousel.css",
                    "owl-carousel/owl.carousel.min.js",
                ), 'default')
                    ->add_js_theme("pages/courses_listings/detail.js");

                // setup page header data
                $this->set_title(lang('menu_course'));
                $data = $this->includes;

                $all_lecture = $this->course_model->get_course_lecture($lecture['cl_course_id']);
                if (!empty($lecture)) {
                    $type = $lecture['cl_type'];

                    if ($type == 1) {
                        $this->load_video_content();

                    }
                    $completed_lectures = $this->course_model->get_user_completed_lectures($user_id, $lecture['cl_course_id']);
                    $content_data['lecture'] = $lecture;
                    $content_data['all_leture'] = $all_lecture;
                    $content_data['completed_lectures'] = $completed_lectures;
                }
                $this->hide_footer_and_header = true;

                $this->active_lecture = $lecture['id'];


                $this->load->view('lecture_detials', $content_data);
                // $this->load->view($this->template, $data);        
            } else {
                throw new Exception("you are not authorized to access Video Content !...");
            }

        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            die;
        }

    }

    function lecture_offline($course_id = null, $id = null)
    {

        try {


            $user_id = (!empty($_SESSION['logged_in']['id'])) ? $_SESSION['logged_in']['id'] : null;

            if ($user_id == null) {
                throw new Exception("you are not authorized to access Video Content... Please Login To Get Access");
            }

            if ($course_id == null) {
                throw new Exception("Course Not Found !...");
            }



            $lecture = $this->course_model->get_course_lecture_by_id($id);

            if (empty($lecture)) {

                $lecture = $this->course_model->get_course_lecture_random_id(($course_id));
                if (empty($lecture)) {
                    throw new Exception("Video Content Not Found !...");
                }

            }

            $Is_subscription = $this->db->get_where('course_subscription', array('cs_user_id' => $user_id, 'cs_course_id' => $lecture['cl_course_id']))->num_rows();

            if ($Is_subscription > 0) {

                $this->add_plugin_theme(array(
                    "owl-carousel/owl.carousel.css",
                    "owl-carousel/owl.carousel.min.js",
                ), 'default')
                    ->add_js_theme("pages/courses_listings/detail.js");

                // setup page header data
                $this->set_title(lang('menu_course'));
                $data = $this->includes;

                $all_lecture = $this->course_model->get_course_lecture($lecture['cl_course_id']);
                if (!empty($lecture)) {
                    $type = $lecture['cl_type'];

                    if ($type == 1) {
                        $this->load_video_content();

                    }
                    $content_data['lecture'] = $lecture;
                    $content_data['all_leture'] = $all_lecture;
                }
                $this->hide_footer_and_header = true;

                $this->active_lecture = $lecture['id'];


                $this->load->view('lecture_detials_offline', $content_data);
                // $this->load->view($this->template, $data);        
            } else {
                throw new Exception("you are not authorized to access Video Content !...");
            }

        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            die;
        }

    }
    function lecture_old($course_id = null, $id = null)
    {

        try {


            $user_id = (!empty($_SESSION['logged_in']['id'])) ? $_SESSION['logged_in']['id'] : null;

            if ($user_id == null) {
                throw new Exception("you are not authorized to access Video Content... Please Login To Get Access");
            }

            if ($course_id == null) {
                throw new Exception("Course Not Found !...");
            }



            $lecture = $this->course_model->get_course_lecture_by_id($id);

            if (empty($lecture)) {

                $lecture = $this->course_model->get_course_lecture_random_id(($course_id));
                if (empty($lecture)) {
                    throw new Exception("Video Content Not Found !...");
                }

            }

            $Is_subscription = $this->db->get_where('course_subscription', array('cs_user_id' => $user_id, 'cs_course_id' => $lecture['cl_course_id']))->num_rows();

            if ($Is_subscription > 0) {

                $this->add_plugin_theme(array(
                    "owl-carousel/owl.carousel.css",
                    "owl-carousel/owl.carousel.min.js",
                ), 'default')
                    ->add_js_theme("pages/courses_listings/detail.js");

                // setup page header data
                $this->set_title(lang('menu_course'));
                $data = $this->includes;

                $all_lecture = $this->course_model->get_course_lecture($lecture['cl_course_id']);
                if (!empty($lecture)) {
                    $type = $lecture['cl_type'];

                    if ($type == 1) {
                        $this->load_video_content();

                    }
                    $content_data['lecture'] = $lecture;
                    $content_data['all_leture'] = $all_lecture;
                }
                $this->hide_footer_and_header = true;

                $this->active_lecture = $lecture['id'];


                // load views
                $data['content'] = $this->load->view('lecture_detials', $content_data, TRUE);
                $this->load->view($this->template, $data);
            } else {
                throw new Exception("you are not authorized to access Video Content !...");
            }

        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            die;
        }

    }
    function load_video_content()
    {

    }
    function detail($course_title = NULL)
    {
        /* Initialize assets and title */
        $this
            ->add_plugin_theme(array(
                "owl-carousel/owl.carousel.css",
                "owl-carousel/owl.carousel.min.js",
            ), 'default')
            ->add_js_theme("pages/courses_listings/detail.js");

        // setup page header data
        $this->set_title(lang('menu_course'));
        $data = $this->includes;

        $course_title = $course_title ? str_replace('+', ' ', urldecode($course_title)) : NULL;

        if (!$course_title)
            show_404();


        $course_access_list = array();
        if (isset($_SESSION['user_id'])) {

            $user_id = $_SESSION['user_id'];
            $course_access_list = $this->course_model->get_my_courses_ids($user_id);

            if (!empty($course_access_list)) {
                $course_access_list = array_column($course_access_list, 'cs_course_id');
            }
        }

        // set content data
        $content_data['course_detail'] = $this->course_model->get_course_detail($course_title);

        $content_data['course_lectue'] = $this->course_model->get_course_lecture($content_data['course_detail']->id);
        if (empty($content_data['course_detail']))
            show_404();

        if ($content_data['course_detail']->meta_title)
            $this->meta_title = $content_data['course_detail']->meta_title;
        if ($content_data['course_detail']->meta_tags)
            $this->meta_tags = $content_data['course_detail']->meta_tags;
        if ($content_data['course_detail']->meta_description)
            $this->meta_description = $content_data['course_detail']->meta_description;
        if ($content_data['course_detail']->images)
            $this->meta_image = base_url('upload/courses/images/') . json_decode($content_data['course_detail']->images)[0];
        if ($content_data['course_detail']->title)
            $this->meta_url = site_url('courses/detail/') . str_replace(' ', '+', $content_data['course_detail']->title);

        // related courses
        // render top-level category
        $categories_levels = $this->courses_model->get_courses_levels($content_data['course_detail']->course_categories_id);
        $count_level = count($categories_levels);
        $top_level_category = $categories_levels[$count_level - 1]; // the last category will be top category
        $content_data['related_courses'] = $this->get_courses_by_category($top_level_category['title'])['courses'];
        $content_data['has_entrolled'] = (in_array($content_data['course_detail']->id, $course_access_list)) ? true : false;

        $completed_lectures = array();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $completed_lectures = $this->course_model->get_user_completed_lectures($user_id, $content_data['course_detail']->id);
        }
        $content_data['completed_lectures'] = $completed_lectures;

        if ($content_data['course_detail']->total_tutors)
            $content_data['course_tutors'] = $this->course_model->get_courses_tutors($content_data['course_detail']->id);
        // echo "<pre>";print_r($content_data);die;
        // load views
        $data['content'] = $this->load->view('courses_detail', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    public function mark_complete()
    {
        if (!$this->session->userdata('logged_in')) {
            echo json_encode(array('status' => false, 'message' => 'Please login first'));
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $lecture_id = $this->input->post('lecture_id');
        $course_id = $this->input->post('course_id');

        if ($lecture_id && $course_id) {
            $this->course_model->mark_lecture_complete($user_id, $lecture_id, $course_id);
            echo json_encode(array('status' => true, 'message' => 'Progress updated'));
        } else {
            echo json_encode(array('status' => false, 'message' => 'Invalid data'));
        }
    }

    /**
     * search_categories
     */
    function search_categories()
    {
        $this->form_validation->set_rules('phrase', lang('action_search'), 'trim|required|alpha_dash_spaces');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array());
            exit;
        }

        $search = $this->input->post('phrase');

        $categories = $this->course_model->get_categories($search);

        if (empty($categories)) {
            echo json_encode(array());
            exit;
        }

        $output = array();
        foreach ($categories as $key => $val) {
            $output[$key]['text'] = $val->title;
            $output[$key]['link'] = site_url('courses') . '/' . str_replace(' ', '+', $val->title);
        }

        echo json_encode($output);
        exit;
    }

}

/* Courses controller ends */
