<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Courses Controller
 *
 * This class handles courses module functionality
 *
 * @package     classiebit
 * @author      prodpk
 */

class Courses extends Admin_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->load->model('admin/courses_model');

        /* Page Title */
        $this->set_title(lang('menu_courses'));
    }

    /**
     * index
     */


    function sample_json()
    {

        echo "Sd";
        die;
    }



    function index()
    {
        /* Initialize assets */
        $this->include_index_plugins();
        $data = $this->includes;

        // Course Stats
        $data['total_courses'] = $this->courses_model->count_all_courses();
        $data['active_courses'] = $this->courses_model->count_active_courses();
        $data['featured_courses'] = $this->courses_model->count_featured_courses();

        // Table Header
        // Categories for filter
        $data['categories'] = $this->courses_model->get_course_categories_dropdown();

        // Table Header
        $data['t_headers'] = array(
            '#',
            'Image',
            lang('common_title'),
            lang('courses_category'),
            lang('common_updated'),
            lang('common_featured'),
            lang('common_status'),
            lang('action_action'),
        );

        // load views
        $content['content'] = $this->load->view('admin/courses/index', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * ajax_list
     */
    public function ajax_list()
    {
        $this->load->library('datatables');

        $table = 'courses';
        $columns = array(
            "$table.id",
            "$table.title",
            "$table.images",
            "$table.course_categories_id",
            "$table.featured",
            "$table.status",
            "$table.date_updated",
            "(SELECT cc.title FROM course_categories cc WHERE cc.id = $table.course_categories_id) category_name",
        );
        $columns_order = array(
            "$table.id",
            "",
            "$table.title",
            "$table.course_categories_id",
            "$table.date_updated",
            "$table.featured",
            "$table.status",
        );
        $columns_search = array(
            'title',
        );
        $order = array('date_updated' => 'DESC');

        // Filtering
        $where = array();
        if ($this->input->post('category_id')) {
            $where["$table.course_categories_id"] = $this->input->post('category_id');
        }
        if ($this->input->post('status') !== '' && $this->input->post('status') !== NULL) {
            $where["$table.status"] = $this->input->post('status');
        }

        $result = $this->datatables->get_datatables($table, $columns, $columns_order, $columns_search, $order, $where);
        $data = array();
        $no = $_POST['start'];

        foreach ($result as $val) {
            $no++;
            $row = array();
            $row[] = $no;

            // Image
            $images = ($val->images) ? json_decode($val->images) : null;
            $img_src = base_url('assets/img/defaults/course_default.png'); // Placeholder/Default
            if (!empty($images) && is_array($images) && !empty($images[0])) {
                // Assuming images are stored in assets/uploads/courses/
                $img_src = base_url('assets/uploads/courses/' . $images[0]);
            }
            $row[] = '<img src="' . $img_src . '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">';

            $row[] = mb_substr($val->title, 0, 30, 'utf-8');
            $row[] = '<a href="' . site_url('admin/categories/view/') . $val->course_categories_id . '" target="_blank">' . $val->category_name . '</a>';
            $row[] = date('g:iA d/m/y', strtotime($val->date_updated));
            $row[] = featured_switch($val->featured, $val->id);
            $row[] = status_switch($val->status, $val->id);
            $row[] = action_buttons('courses', $val->id, mb_substr($val->title, 0, 20, 'utf-8'), lang('menu_course'));
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatables->count_all(),
            "recordsFiltered" => $this->datatables->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
        exit;
    }

    /**
     * ajax_list
     */

    public function ajax_users_list()
    {
        $course_id = $this->input->post('id');
        if (!$course_id) {
            echo json_encode(array(
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => array(),
            ));
            exit;
        }

        $this->load->library('datatables');

        $table = 'course_subscription';
        $columns = array(
            "$table.id",
            "$table.cs_user_id",
            "$table.cs_course_id",
            "$table.cs_start_date",
            "$table.cs_end_date",
            "$table.cs_status"

        );
        $columns_order = array(
            "$table.id",
            "$table.cs_user_id",
            "$table.cs_course_id",
            // "$table.cl_file_name",
            "$table.cs_status",
            // "$table.cl_status",
        );
        $columns_search = array(
            'cs_user_id',
        );
        $order = array('cs_user_id' => 'DESC');
        $where = array('cs_course_id' => $course_id);

        $result = $this->datatables->get_datatables($table, $columns, $columns_order, $columns_search, $order, $where);

        $data = array();
        $no = $_POST['start'];

        foreach ($result as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = user_detials($val->cs_user_id);
            //  $row[]          = lecture_type($val->cl_type);
            // $row[]          = $val->cl_file_name;
            // $row[]          = $val->cl_secure;
            $row[] = status_switch_lecture($val->cs_status, $val->id);

            $menu = '<div class="btn-group"><button type="button" class="btn bg-' . $this->settings->admin_theme . ' btn-xs waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="material-icons">more_vert</i></button>
                            <ul class="dropdown-menu pull-right">';
            $menu .= '<li><a href="' . site_url("admin/courses/user_form/" . $_POST['id']) . '" class="waves-effect waves-block"><i class="material-icons">edit</i>' . lang('action_edit') . '</a></li>';
            $menu .= '<li role="separator" class="divider"></li>
                        <li><a role="button" class="waves-effect waves-block" onclick="ajaxDeleteUser(`' . $val->id . '`)"><i class="material-icons">delete_forever</i>' . lang('action_delete') . '</a></li>';

            $menu .= '</ul>
                        </div>';
            $row[] = $menu;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatables->count_all(),
            "recordsFiltered" => $this->datatables->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
        exit;
    }
    public function sort_lecture()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $lectures = $this->input->post('lectures');
        $section_id = $this->input->post('section_id');
        $this->courses_model->update_lecture_order($lectures, $section_id);
        echo json_encode(['flag' => 1, 'msg' => 'Order updated successfully']);
    }

    public function sort_section()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $sections = $this->input->post('sections');
        $this->courses_model->update_section_order($sections);
        echo json_encode(['flag' => 1, 'msg' => 'Section order updated successfully']);
    }

    public function render_curriculum($course_id)
    {
        $data['curriculum'] = $this->courses_model->get_curriculum($course_id);
        $this->load->view('admin/courses/curriculum_list', $data);
    }
    protected function _json(int $status, string $message, array $errors = [], array $data = [])
    {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => $status < 300,
                'status' => $status,
                'message' => $message,
                'errors' => $errors,
                'data' => $data
            ], JSON_UNESCAPED_UNICODE))
            ->_display();

        exit;
    }
    public function save_section()
    {
        // API → no redirect / no view
        if (!$this->input->is_ajax_request()) {
            $this->_json(403, 'Forbidden');
            return;
        }

        $payload = json_decode($this->input->raw_input_stream, true) ?: $_POST;
        $errors = [];

        // Extract & normalize
        $course_id = isset($payload['course_id']) ? (int) $payload['course_id'] : 0;
        $title = isset($payload['title']) ? trim($payload['title']) : '';
        $id = isset($payload['id']) ? (int) $payload['id'] : null;

        /* -------------------------
         | Required & type checks
         * -------------------------*/
        if ($course_id <= 0) {
            $errors['course_id'] = 'Invalid course_id';
        }

        if ($title === '') {
            $errors['title'] = 'Section title is required';
        }

        /* -------------------------
         | Length & charset checks
         * -------------------------*/
        if ($title !== '') {
            if (mb_strlen($title) < 3) {
                $errors['title'] = 'Title must be at least 3 characters';
            } elseif (mb_strlen($title) > 150) {
                $errors['title'] = 'Title cannot exceed 150 characters';
            }
        }

        if ($title !== '' && !preg_match('/^[\p{L}\p{N}\s\-\(\)\.,]+$/u', $title)) {
            $errors['title'] = 'Title contains invalid characters';
        }

        /* -------------------------
         | Business validation
         * -------------------------*/
        if ($course_id > 0 && !$this->courses_model->course_exists($course_id)) {
            $errors['course_id'] = 'Course not found';
        }

        if ($course_id > 0 && $title !== '') {
            if ($this->courses_model->section_exists($course_id, $title, $id)) {
                $errors['title'] = 'Section already exists for this course';
            }
        }

        /* -------------------------
         | Validation failed
         * -------------------------*/
        if (!empty($errors)) {
            $this->_json(422, 'Validation failed', $errors);
            return;
        }

        /* -------------------------
         | Persist
         * -------------------------*/
        try {
            $data = [
                'course_id' => $course_id,
                'title' => $title,
            ];

            $section_id = $this->courses_model->save_section($data, $id);

            $this->_json(200, 'Section saved', [
                'id' => $section_id
            ]);
        } catch (Throwable $e) {
            log_message('error', 'API Save Section: ' . $e->getMessage());
            $this->_json(500, 'Internal server error');
        }
    }



    public function delete_section()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');
        $id = $this->input->post('id');
        if ($this->courses_model->delete_section($id)) {
            echo json_encode(['flag' => 1, 'msg' => 'Section deleted successfully']);
        } else {
            echo json_encode(['flag' => 0, 'msg' => 'Error deleting section']);
        }
    }


    /**
     * lectures
     */
    public function lectures($id = NULL)
    {
        $id = (int) $id;
        $this->include_index_plugins();
        $data = $this->includes;

        // Table Header
        $data['t_headers'] = array(
            '#',
            'Lecture Name',
            'content Type',
            'Secure content',
            // lang('common_featured'),
            // lang('common_status'),
            lang('action_action'),
        );
        // if($id)
        // {
        //     $result                 = $this->courses_model->get_leture_by_course_id($id);
        //     if(empty($result))
        //     {
        //         $this->session->set_flashdata('error', sprintf(lang('alert_not_found') ,lang('menu_course')));
        //         redirect($this->uri->segment(1).'/'.$this->uri->segment(2));
        //     }

        // }                          

        // load views
        $content['content'] = $this->load->view('admin/lecture/index', $data, TRUE);
        $this->load->view($this->template, $content);






    }
    public function users($id = NULL)
    {

        $id = (int) $id;
        $this->include_index_plugins();
        $data = $this->includes;

        // Table Header
        $data['t_headers'] = array(
            '#',
            'Name',

            'Secure status',
            // lang('common_featured'),
            // lang('common_status'),
            lang('action_action'),
        );
        // if($id)
        // {
        //     $result                 = $this->courses_model->get_leture_by_course_id($id);

        //     if(empty($result))
        //     {
        //         //$this->session->set_flashdata('error', sprintf(lang('alert_not_found') ,lang('menu_course')));
        //         redirect($this->uri->segment(1).'/'.$this->uri->segment(2).'/users_form/'.$id);
        //     }

        // }                          

        // load views
        $content['content'] = $this->load->view('admin/courses/users', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * form
     */
    public function form($id = NULL)
    {
        /* Initialize assets */
        $this->add_plugin_theme(array(
            "tinymce/tinymce.js",
            "jquery-datatable/datatables.min.css",
            "jquery-datatable/datatables.min.js",
        ), 'admin')
            ->add_plugin_theme(array(
                "sweetalert/sweetalert.css",
                "sweetalert/sweetalert.min.js",
            ), 'core')
            ->add_js_theme("pages/courses/form_i18n.js", TRUE);

        // Set full width template for immersive editing
        $this->set_template('template_fullwidth.php');

        $data = $this->includes;

        // in case of edit
        $id = (int) $id;
        if ($id) {
            $result = $this->courses_model->get_courses_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), lang('menu_course')));
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
            }

            // hidden field in case of update
            $data['id'] = $result->id;

            // current images
            $data['c_images'] = ($result->images) ? json_decode($result->images) : null;

            // render category levels for current category in case of edit
            $categories_levels = $this->courses_model->get_courses_levels($result->course_categories_id);
            $count_level = count($categories_levels);
            $top_level_category = $categories_levels[$count_level - 1]; // the last category will be top category

            // populate subcategory dropdown
            $data['category_l'] = array();
            if (count($categories_levels) > 0) {
                for ($i = (count($categories_levels) - 2); $i >= 0; $i--) {
                    $data['category_l'][$i] = array(
                        'name' => 'category[]',
                        'options' => array($categories_levels[$i]['id'] => $categories_levels[$i]['title']),
                        'class' => 'form-control parent',
                        'selected' => $this->form_validation->set_value('category[]', $categories_levels[$i]['id']),
                    );
                }
            }
        }

        // render category dropdown
        $categories = $this->courses_model->get_course_categories_dropdown();
        $data['categories']['0'] = '-- ' . lang('courses_category') . ' --';

        foreach ($categories as $category)
            $data['categories'][$category->id] = $category->title;

        $data['category'] = array(
            'name' => 'category[]',
            'options' => $data['categories'],
            'id' => 'category',
            'class' => 'category form-control show-tick parent',
            'data-live-search' => "true",
            'selected' => $this->form_validation->set_value('category[]', !empty($top_level_category['id']) ? $top_level_category['id'] : ''),
        );
        $data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('title', !empty($result->title) ? $result->title : ''),
        );
        $data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'textarea',
            'class' => 'tinymce form-control',
            'value' => $this->form_validation->set_value('description', !empty($result->description) ? $result->description : ''),
        );
        $data['images'] = array(
            'name' => 'images[]',
            'id' => 'images',
            'type' => 'file',
            'multiple' => 'multiple',
            'class' => 'form-control',
            'accept' => 'image/*',
        );
        $data['meta_title'] = array(
            'name' => 'meta_title',
            'id' => 'meta_title',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('meta_title', !empty($result->meta_title) ? $result->meta_title : ''),
        );
        $data['meta_tags'] = array(
            'name' => 'meta_tags',
            'id' => 'meta_tags',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('meta_tags', !empty($result->meta_tags) ? $result->meta_tags : ''),
        );
        $data['meta_description'] = array(
            'name' => 'meta_description',
            'id' => 'meta_description',
            'type' => 'textarea',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('meta_description', !empty($result->meta_description) ? $result->meta_description : ''),
        );
        $data['featured'] = array(
            'name' => 'featured',
            'id' => 'featured',
            'class' => 'form-control',
            'options' => array('1' => lang('common_featured_enabled'), '0' => lang('common_featured_disabled')),
            'selected' => $this->form_validation->set_value('featured', !empty($result->featured) ? $result->featured : 0),
        );
        $data['status'] = array(
            'name' => 'status',
            'id' => 'status',
            'class' => 'form-control',
            'options' => array('1' => lang('common_status_active'), '0' => lang('common_status_inactive')),
            'selected' => $this->form_validation->set_value('status', !empty($result->status) ? $result->status : 0),
        );

        /* Load Template */
        $content['content'] = $this->load->view('admin/courses/form', $data, TRUE);
        $this->load->view($this->template, $content);
    }
    public function users_form($id = NULL, $ajax_call = false)
    {
        // in case of edit
        $course_id = (int) $this->uri->segment(4);
        $id = (int) $this->uri->segment(5);
        if ($ajax_call) {
            $param = array();
            $param['course_id'] = $course_id;
            $param['count'] = true;

            $param['keyword'] = $this->input->post('keyword');
            $users_count = $this->courses_model->get_user_dropdown($param);
            unset($param['count']);
            if ($this->input->post('offset') == 1) {

                $param['offset'] = 0;
            } else {
                $offset = (int) $this->input->post('offset') - 1;

                $param['offset'] = $offset * (int) $this->input->post('limit');
            }

            $param['limit'] = $this->input->post('limit');



            $users = $this->courses_model->get_user_dropdown($param);

            echo json_encode(array('users' => $users, 'total_users' => $users_count));
            die;
        } else {
            /* Initialize assets */
            $this->add_plugin_theme(array(
                "tinymce/tinymce.js",
            ), 'admin')
                ->add_js_theme("pages/courses/users_form_i18n.js", TRUE);
            $data = $this->includes;

            if ($id) {
                $result = $this->courses_model->get_courses_by_id($id);

                if (empty($result)) {
                    $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), lang('menu_course')));
                    redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
                }

                // hidden field in case of update
                $data['id'] = $result->id;

                // current images
                $data['c_images'] = json_decode($result->images);

                // render category levels for current category in case of edit
                $categories_levels = $this->courses_model->get_courses_levels($result->course_categories_id);
                $count_level = count($categories_levels);
                $top_level_category = $categories_levels[$count_level - 1]; // the last category will be top category

            }

            // render category dropdown
            $param = array();
            $param['course_id'] = $course_id;
            //$param['where_not']            = 
// $users                     = $this->courses_model->get_user_dropdown($param);
// echo "<pre>"; print_r($users);die;

            $data['users'] = array('empt' => 'dd');
            $data['course_id'] = $course_id;

            /* Load Template */
            $content['content'] = $this->load->view('admin/courses/user_form_beta', $data, TRUE);
            $this->load->view($this->template, $content);
        }


    }
    public function users_form_old($id = NULL)
    {
        /* Initialize assets */
        $this->add_plugin_theme(array(
            "tinymce/tinymce.js",
        ), 'admin')
            ->add_js_theme("pages/courses/users_form_i18n.js", TRUE);
        $data = $this->includes;
        // in case of edit
        $course_id = (int) $this->uri->segment(4);
        $id = (int) $this->uri->segment(5);
        if ($id) {
            $result = $this->courses_model->get_courses_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), lang('menu_course')));
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
            }

            // hidden field in case of update
            $data['id'] = $result->id;

            // current images
            $data['c_images'] = json_decode($result->images);

            // render category levels for current category in case of edit
            $categories_levels = $this->courses_model->get_courses_levels($result->course_categories_id);
            $count_level = count($categories_levels);
            $top_level_category = $categories_levels[$count_level - 1]; // the last category will be top category

        }

        // render category dropdown
        $param = array();
        $param['course_id'] = $course_id;
        //$param['where_not']            = 
        $users = $this->courses_model->get_user_dropdown($param);

        $data['users']['0'] = '-- Select user --';

        foreach ($users as $user)
            $data['users'][$user['id']] = $user['username'];


        //echo "<pre>";print_r($data['users']);die;
        $data['user_input'] = array(
            'name' => 'user',
            'options' => $data['users'],
            'id' => 'course-user',
            'class' => 'cu-user form-control show-tick parent',
            'data-live-search' => "true",
            'selected' => $this->form_validation->set_value('user', !empty($top_level_category['id']) ? $top_level_category['id'] : ''),
        );
        $data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('title', !empty($result->title) ? $result->title : ''),
        );
        $data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'textarea',
            'class' => 'tinymce form-control',
            'value' => $this->form_validation->set_value('description', !empty($result->description) ? $result->description : ''),
        );
        $data['images'] = array(
            'name' => 'images[]',
            'id' => 'images',
            'type' => 'file',
            'multiple' => 'multiple',
            'class' => 'form-control',
            'accept' => 'image/*',
        );
        $data['meta_title'] = array(
            'name' => 'meta_title',
            'id' => 'meta_title',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('meta_title', !empty($result->meta_title) ? $result->meta_title : ''),
        );
        $data['meta_tags'] = array(
            'name' => 'meta_tags',
            'id' => 'meta_tags',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('meta_tags', !empty($result->meta_tags) ? $result->meta_tags : ''),
        );
        $data['meta_description'] = array(
            'name' => 'meta_description',
            'id' => 'meta_description',
            'type' => 'textarea',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('meta_description', !empty($result->meta_description) ? $result->meta_description : ''),
        );
        $data['featured'] = array(
            'name' => 'featured',
            'id' => 'featured',
            'class' => 'form-control',
            'options' => array('1' => lang('common_featured_enabled'), '0' => lang('common_featured_disabled')),
            'selected' => $this->form_validation->set_value('featured', !empty($result->featured) ? $result->featured : 0),
        );
        $data['status'] = array(
            'name' => 'status',
            'id' => 'status',
            'class' => 'form-control',
            'options' => array('1' => lang('common_status_active'), '0' => lang('common_status_inactive')),
            'selected' => $this->form_validation->set_value('status', !empty($result->status) ? $result->status : 0),
        );

        /* Load Template */
        $content['content'] = $this->load->view('admin/courses/user_form', $data, TRUE);
        $this->load->view($this->template, $content);
    }
    public function lecture_form($id = NULL)
    {
        /* Initialize assets */
        $id = $this->uri->segment(5);
        $this->add_plugin_theme(array(
            "tinymce/tinymce.js",
        ), 'admin')
            ->add_js_theme("pages/lecture/form_i18n.js", TRUE);
        $data = $this->includes;

        // in case of edit
        $id = ($id) ? (int) $id : false;
        if ($id) {
            $result = $this->courses_model->get_lecture_courses_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), lang('menu_course')));
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
            }

            // hidden field in case of update
            $data['id'] = $result->id;
        }

        // render category dropdown
        //$categories                     = $this->courses_model->get_course_categories_dropdown();
        $data['categories']['0'] = '-- Content Type --';
        $data['categories']['1'] = 'Google drive';
        $data['categories']['2'] = 'Pdf Document';
        $data['categories']['3'] = 'youtube OR vimeo';


        $data['category'] = array(
            'name' => 'category',
            'options' => $data['categories'],
            'id' => 'category',
            'class' => 'category form-control show-tick parent',
            'data-live-search' => "true",
            'selected' => $this->form_validation->set_value('category[]', !empty($result->cl_type) ? $result->cl_type : ''),
        );
        $data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('title', !empty($result->cl_name) ? $result->cl_name : ''),
        );
        $data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'textarea',
            'class' => 'tinymce form-control',
            'value' => $this->form_validation->set_value('description', !empty($result->cl_decsription) ? $result->cl_decsription : ''),
        );

        $data['meta_title'] = array(
            'name' => 'meta_title',
            'id' => 'meta_title',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('meta_title', !empty($result->cl_file_name) ? $result->cl_file_name : ''),
        );
        $data['featured'] = array(
            'name' => 'featured',
            'id' => 'featured',
            'class' => 'form-control',
            'options' => array('1' => lang('common_featured_enabled'), '0' => lang('common_featured_disabled')),
            'selected' => $this->form_validation->set_value('featured', !empty($result->cl_secure) ? $result->cl_secure : 1),
        );
        $data['status'] = array(
            'name' => 'status',
            'id' => 'status',
            'class' => 'form-control',
            'options' => array('1' => lang('common_status_active'), '0' => lang('common_status_inactive')),
            'selected' => $this->form_validation->set_value('status', !empty($result->cl_status) ? $result->cl_status : 1),
        );

        /* Load Template */
        $data['type'] = (!empty($result->cl_type)) ? $result->cl_type : false;
        $data['video_file'] = (!empty($result->cl_file_name)) ? $result->cl_file_name : false;
        $content['content'] = $this->load->view('admin/lecture/form', $data, TRUE);
        $this->load->view($this->template, $content);
    }
    /**
     * save
     */
    public function lecture_save()
    {
        $id = NULL;

        if (!empty($_POST['id'])) {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_edit')) {
                echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')) . '</p>';
                exit;
            }

            $id = (int) $this->input->post('id');
            $result = $this->courses_model->get_lecture_courses_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), lang('menu_course')));
                echo json_encode(array(
                    'flag' => 0,
                    'msg' => $this->session->flashdata('message'),
                    'type' => 'fail',
                ));
                exit;
            }
        } else {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_add')) {
                echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_add')) . '</p>';
                exit;
            }
        }

        /* Validate form input */
        $this->form_validation
            ->set_rules('title', 'Lecture Name empty not allowed ', 'trim|required|alpha_dash_spaces|max_length[256]')
            ->set_rules('description', lang('common_description'), 'trim')
            ->set_rules('featured', lang('common_featured'), 'required|in_list[0,1]')
            ->set_rules('status', lang('common_status'), 'required|in_list[0,1]')
            ->set_rules('meta_title', 'Enter google file id', 'required|trim|max_length[128]')


            ->set_rules('category', 'Please select content type', 'required|is_natural_no_zero', array('is_natural_no_zero' => lang('courses_select_category')));



        if ($this->form_validation->run() === FALSE) {
            // for fetching specific fields errors in order to view errors on each field seperately
            $error_fields = array();
            foreach ($_POST as $key => $val)
                if (form_error($key))
                    $error_fields[] = $key;

            echo json_encode(array('flag' => 0, 'msg' => validation_errors(), 'error_fields' => json_encode($error_fields)));
            exit;
        }



        // data to insert in db table
        $data = array();
        $data['cl_name'] = strtolower($this->input->post('title'));
        $data['cl_decsription'] = $this->input->post('description');
        $data['cl_file_name'] = $this->input->post('meta_title');
        $data['cl_status'] = $this->input->post('featured');
        $data['cl_secure'] = $this->input->post('status');
        $data['cl_course_id'] = $this->input->post('course_id');
        $data['cl_type'] = $this->input->post('category');
        if ($data['cl_type'] == 3) {
            $data['cl_file_name'] = $this->generate_youtube_url($this->input->post('meta_title'));
        }


        $flag = $this->courses_model->save_lecture($data, $id);

        if ($flag) {
            if ($id)
                $this->session->set_flashdata('message', 'Lecture updated successfully');
            else
                $this->session->set_flashdata('message', 'lecture added successfully');

            echo json_encode(array(
                'flag' => 1,
                'msg' => $this->session->flashdata('message'),
                'type' => 'success',
            ));
            exit;
        }

        if ($id)
            $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), lang('menu_course')));
        else
            $this->session->set_flashdata('error', sprintf(lang('alert_insert_fail'), lang('menu_course')));

        echo json_encode(array(
            'flag' => 0,
            'msg' => $this->session->flashdata('message'),
            'type' => 'fail',
        ));
        exit;
    }


    private function generate_youtube_url($url = false)
    {
        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
        $result = preg_match($pattern, $url, $matches);
        if ($result) {
            //return $matches[1];
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return false;
    }

    public function user_save_beta()
    {

        if (!empty($_POST['course_id'])) {

            if (!empty($_POST['user_id'])) {
                $user_ids = explode(',', $_POST['user_id']);

                foreach ($user_ids as $key => $user_id) {
                    // data to insert in db table
                    $data = array();
                    $data['cs_user_id'] = strtolower($user_id);
                    $data['cs_course_id'] = $this->input->post('course_id');
                    $flag = $this->courses_model->save_suscription($data, $user_id);
                }
            }
        }

        if ($flag) {
            if (!empty($id))
                $this->session->set_flashdata('message', 'user  to course updated successfully');
            else
                $this->session->set_flashdata('message', 'user  to course updated successfully');

            echo json_encode(array(
                'flag' => 1,
                'msg' => $this->session->flashdata('message'),
                'type' => 'success',
            ));
            exit;
        }

        if (!empty($id))
            $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), lang('menu_course')));
        else
            $this->session->set_flashdata('error', sprintf(lang('alert_insert_fail'), lang('menu_course')));

        echo json_encode(array(
            'flag' => 0,
            'msg' => $this->session->flashdata('message'),
            'type' => 'fail',
        ));
        exit;

    }

    public function user_save()
    {
        $id = NULL;

        if (!empty($_POST['id'])) {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_edit')) {
                echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')) . '</p>';
                exit;
            }

            $id = (int) $this->input->post('id');

            // if(empty($result))
            // {
            //     $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), lang('menu_course')));
            //     echo json_encode(array(
            //                             'flag'  => 0, 
            //                             'msg'   => $this->session->flashdata('message'),
            //                             'type'  => 'fail',
            //                         ));exit;
            // }
        } else {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_add')) {
                echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_add')) . '</p>';
                exit;
            }
        }

        /* Validate form input */
        $this->form_validation
            ->set_rules('user', 'user Name empty not allowed ', 'trim|required|alpha_dash_spaces|max_length[256]');







        if ($this->form_validation->run() === FALSE) {
            // for fetching specific fields errors in order to view errors on each field seperately
            $error_fields = array();
            foreach ($_POST as $key => $val)
                if (form_error($key))
                    $error_fields[] = $key;

            echo json_encode(array('flag' => 0, 'msg' => validation_errors(), 'error_fields' => json_encode($error_fields)));
            exit;
        }

        // data to insert in db table
        $data = array();
        $data['cs_user_id'] = strtolower($this->input->post('user'));
        $data['cs_course_id'] = $this->input->post('course_id');


        $flag = $this->courses_model->save_suscription($data, $id);

        if ($flag) {
            if ($id)
                $this->session->set_flashdata('message', 'user  to course updated successfully');
            else
                $this->session->set_flashdata('message', 'user  to course updated successfully');

            echo json_encode(array(
                'flag' => 1,
                'msg' => $this->session->flashdata('message'),
                'type' => 'success',
            ));
            exit;
        }

        if ($id)
            $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), lang('menu_course')));
        else
            $this->session->set_flashdata('error', sprintf(lang('alert_insert_fail'), lang('menu_course')));

        echo json_encode(array(
            'flag' => 0,
            'msg' => $this->session->flashdata('message'),
            'type' => 'fail',
        ));
        exit;
    }
    public function save()
    {
        $id = NULL;

        if (!empty($_POST['id'])) {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_edit')) {
                echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')) . '</p>';
                exit;
            }

            $id = (int) $this->input->post('id');
            $result = $this->courses_model->get_courses_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), lang('menu_course')));
                echo json_encode(array(
                    'flag' => 0,
                    'msg' => $this->session->flashdata('message'),
                    'type' => 'fail',
                ));
                exit;
            }
        } else {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_add')) {
                echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_add')) . '</p>';
                exit;
            }
        }

        /* Validate form input */
        $this->form_validation
            ->set_rules('title', lang('common_title'), 'trim|required|alpha_dash_spaces|max_length[256]')
            ->set_rules('description', lang('common_description'), 'trim')
            ->set_rules('featured', lang('common_featured'), 'required|in_list[0,1]')
            ->set_rules('status', lang('common_status'), 'required|in_list[0,1]')
            ->set_rules('meta_title', lang('common_meta_title'), 'trim|max_length[128]')
            ->set_rules('meta_tags', lang('common_meta_tags'), 'trim|max_length[256]')
            ->set_rules('meta_description', lang('common_meta_description'), 'trim')
            ->set_rules('category[]', lang('courses_category'), 'required|is_natural_no_zero', array('is_natural_no_zero' => lang('courses_select_category')));

        // update courses image
        if (!empty($_FILES['images']['name'][0])) // if image 
        {
            $files = array('folder' => 'courses/images', 'input_file' => 'images');

            // Remove old image
            if ($id)
                if (!empty($result->images))
                    $this->file_uploads->remove_files('./upload/' . $files['folder'] . '/', json_decode($result->images));

            // update courses image            
            $filenames = $this->file_uploads->upload_files($files);
            // through image upload error
            if (!empty($filenames['error']))
                $this->form_validation->set_rules('image_error', lang('common_images'), 'required', array('required' => $filenames['error']));
        }

        if ($this->form_validation->run() === FALSE) {
            // for fetching specific fields errors in order to view errors on each field seperately
            $error_fields = array();
            foreach ($_POST as $key => $val)
                if (form_error($key))
                    $error_fields[] = $key;

            echo json_encode(array('flag' => 0, 'msg' => validation_errors(), 'error_fields' => json_encode($error_fields)));
            exit;
        }

        // data to insert in db table
        $data = array();
        $data['title'] = strtolower($this->input->post('title'));
        $data['description'] = $this->input->post('description');
        $data['meta_title'] = $this->input->post('meta_title');
        $data['meta_tags'] = strtolower($this->input->post('meta_title'));
        $data['meta_description'] = $this->input->post('meta_description');
        $data['featured'] = $this->input->post('featured');
        $data['status'] = $this->input->post('status');

        // pick the last selected category
        $data['course_categories_id'] = count($this->input->post('category')) - 1;
        $data['course_categories_id'] = $this->input->post('category')[$data['course_categories_id']];

        if (!empty($filenames) && !isset($filenames['error']))
            $data['images'] = json_encode($filenames);

        $flag = $this->courses_model->save_courses($data, $id);

        if ($flag) {
            if ($id)
                $this->session->set_flashdata('message', sprintf(lang('alert_update_success'), lang('menu_course')));
            else
                $this->session->set_flashdata('message', sprintf(lang('alert_insert_success'), lang('menu_course')));

            echo json_encode(array(
                'flag' => 1,
                'msg' => $this->session->flashdata('message'),
                'type' => 'success',
            ));
            exit;
        }

        if ($id)
            $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), lang('menu_course')));
        else
            $this->session->set_flashdata('error', sprintf(lang('alert_insert_fail'), lang('menu_course')));

        echo json_encode(array(
            'flag' => 0,
            'msg' => $this->session->flashdata('message'),
            'type' => 'fail',
        ));
        exit;
    }

    /**
     * view
     */
    public function view($id)
    {
        /* Initialize Assets */
        $data = $this->includes;

        /* Get Data */
        $id = (int) $id;
        $result = $this->courses_model->get_courses_by_id($id);

        if (empty($result)) {
            $this->session->set_flashdata('error', lang('courses_not_found'));
            /* Redirect */
            redirect('admin/courses');
        }

        // render category levels for current category
        $categories_levels = $this->courses_model->get_courses_levels($result->course_categories_id);

        $data['category'] = '';
        for ($i = (count($categories_levels) - 1); $i >= 0; $i--) {
            $data['category'] .= '<a href="' . site_url('admin/categories/view/') . $categories_levels[$i]['id'] . '" target="_blank">' . $categories_levels[$i]['title'] . '</a>';
            if ($i != 0)
                $data['category'] .= ' -> ';
        }

        $data['courses'] = $result;

        /* Load Template */
        $content['content'] = $this->load->view('admin/courses/view', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    public function status_update_secure()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_edit')) {
            echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')) . '</p>';
            exit;
        }
        /* Validate form input */
        $this->form_validation
            ->set_rules('id', sprintf(lang('alert_id'), lang('menu_course')), 'required|numeric')
            ->set_rules('status', lang('common_status'), 'required|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array(
                'flag' => 0,
                'msg' => validation_errors(),
                'type' => 'fail',
            ));
            exit;
        }

        // data to insert in db table
        $data = array();
        $id = (int) $this->input->post('id');
        $data['cl_secure'] = $this->input->post('status');

        if (empty($id)) {
            $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), lang('menu_course')));
            echo json_encode(array(
                'flag' => 0,
                'msg' => $this->session->flashdata('message'),
                'type' => 'fail',
            ));
            exit;
        }

        $flag = $this->courses_model->save_courses_lecture($data, $id);

        if ($flag) {
            echo json_encode(array(
                'flag' => 1,
                'msg' => 'lecture secure status updated',
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => sprintf(lang('alert_status_fail'), lang('menu_course')),
            'type' => 'fail',
        ));
        exit;
    }
    /**
     * status_update
     */

    public function status_update()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_edit')) {
            echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')) . '</p>';
            exit;
        }
        /* Validate form input */
        $this->form_validation
            ->set_rules('id', sprintf(lang('alert_id'), lang('menu_course')), 'required|numeric')
            ->set_rules('status', lang('common_status'), 'required|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array(
                'flag' => 0,
                'msg' => validation_errors(),
                'type' => 'fail',
            ));
            exit;
        }

        // data to insert in db table
        $data = array();
        $id = (int) $this->input->post('id');
        $data['status'] = $this->input->post('status');

        if (empty($id)) {
            $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), lang('menu_course')));
            echo json_encode(array(
                'flag' => 0,
                'msg' => $this->session->flashdata('message'),
                'type' => 'fail',
            ));
            exit;
        }

        $flag = $this->courses_model->save_courses($data, $id);

        if ($flag) {
            echo json_encode(array(
                'flag' => 1,
                'msg' => sprintf(lang('alert_status_success'), lang('menu_course')),
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => sprintf(lang('alert_status_fail'), lang('menu_course')),
            'type' => 'fail',
        ));
        exit;
    }

    /**
     * featured_update
     */
    public function featured_update()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_edit')) {
            echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')) . '</p>';
            exit;
        }
        /* Validate form input */
        $this->form_validation
            ->set_rules('id', sprintf(lang('alert_id'), lang('menu_course')), 'required|numeric')
            ->set_rules('featured', lang('common_featured'), 'required|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(array(
                'flag' => 0,
                'msg' => validation_errors(),
                'type' => 'fail',
            ));
            exit;
        }

        // data to insert in db table
        $data = array();
        $id = (int) $this->input->post('id');
        $data['featured'] = $this->input->post('featured');

        if (empty($id)) {
            $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), lang('menu_course')));
            echo json_encode(array(
                'flag' => 0,
                'msg' => $this->session->flashdata('message'),
                'type' => 'fail',
            ));
            exit;
        }

        $flag = $this->courses_model->save_courses($data, $id);

        if ($flag) {
            echo json_encode(array(
                'flag' => 1,
                'msg' => $data['featured'] ? sprintf(lang('alert_featured_added'), lang('menu_course')) : sprintf(lang('alert_featured_removed'), lang('menu_course')),
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => sprintf(lang('alert_featured_fail'), lang('menu_course')),
            'type' => 'fail',
        ));
        exit;
    }


    /**
     * delete
     */
    public function delete()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_delete')) {
            echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_delete')) . '</p>';
            exit;
        }
        /* Validate form input */
        $this->form_validation->set_rules('id', sprintf(lang('alert_id'), lang('menu_course')), 'required|numeric');

        /* Data */
        $id = (int) $this->input->post('id');
        $result = $this->courses_model->get_courses_by_id($id);

        if (empty($result)) {
            echo json_encode(array(
                'flag' => 0,
                'msg' => sprintf(lang('alert_not_found'), lang('menu_course')),
                'type' => 'fail',
            ));
            exit;
        }

        $flag = $this->courses_model->delete_courses($id, $result->title);

        if ($flag) {

            // Remove courses images
            if (!empty($result->images))
                $this->file_uploads->remove_files('./upload/courses/', json_decode($result->images));

            echo json_encode(array(
                'flag' => 1,
                'msg' => sprintf(lang('alert_delete_success'), lang('menu_course')),
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => sprintf(lang('alert_delete_fail'), lang('menu_course')),
            'type' => 'fail',
        ));
        exit;
    }
    public function delete_user()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_delete')) {
            echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_delete')) . '</p>';
            exit;
        }
        /* Validate form input */
        $this->form_validation->set_rules('id', sprintf(lang('alert_id'), lang('menu_course')), 'required|numeric');

        /* Data */
        $id = (int) $this->input->post('id');

        $flag = $this->courses_model->delete_suscription($id);

        if ($flag) {

            echo json_encode(array(
                'flag' => 1,
                'msg' => sprintf(lang('alert_delete_success'), lang('menu_course')),
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => sprintf(lang('alert_delete_fail'), lang('menu_course')),
            'type' => 'fail',
        ));
        exit;
    }

    public function delete_lecture()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_delete')) {
            echo json_encode(array('flag' => 0, 'msg' => sprintf(lang('manage_acl_permission_no'), lang('manage_acl_delete'))));
            exit;
        }
        $id = (int) $this->input->post('id');
        // Assuming delete_lecture exists in model, otherwise use delete with table name if model supports
        // Checking courses_model for delete_lecture... 
        // If not found, I might need to add it or use generic delete.
        // For now, I'll assume I can add it to model or use query.
        // Let's use db->delete for safety here if model method ambiguous.
        $this->db->where('id', $id);
        $flag = $this->db->delete('course_lecture');

        if ($flag) {
            echo json_encode(array('flag' => 1, 'msg' => 'Lecture deleted successfully', 'type' => 'success'));
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Failed to delete lecture', 'type' => 'fail'));
        }
        exit;
    }

    public function status_lecture()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_edit')) {
            echo json_encode(array('flag' => 0, 'msg' => sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit'))));
            exit;
        }
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if ($this->db->update('course_lectures', array('cl_secure' => $status), array('id' => $id))) {
            echo json_encode(array('flag' => 1, 'msg' => 'Status updated successfully'));
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Failed to update status'));
        }
        exit;
    }

    /**
     * get lecture details
     */
    public function ajax_get_lecture($id)
    {
        if (!$id) {
            echo json_encode(array('flag' => 0, 'msg' => 'Invalid ID'));
            exit;
        }

        $result = $this->courses_model->get_lecture_courses_by_id($id);

        if ($result) {
            echo json_encode(array('flag' => 1, 'data' => $result));
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Lecture not found'));
        }
        exit;
    }


    /**
     * get_course_categories_levels
     */
    public function get_course_categories_levels()
    {
        /* Validate form input */
        $this->form_validation->set_rules('category_id', sprintf(lang('alert_id'), lang('courses_category')), 'required|is_natural_no_zero', array('is_natural_no_zero' => '<span class="loader text-danger">*' . lang('courses_select_category') . '</span>'));

        if ($this->form_validation->run() === FALSE) {
            echo validation_errors();
            exit;
        }

        $category_id = $this->input->post('category_id');

        /* Data */
        $course_levels = $this->courses_model->get_course_categories_levels($category_id);

        if (empty($course_levels)) {
            echo FALSE;
            exit;
        }

        $gen_html = '<select name="category[]" class="show-tick form-control parent" data-live-search="true">
                                <option value="" selected="selected">-- ' . lang('courses_sub_category') . ' --</option>';

        foreach ($course_levels as $val) {
            $gen_html .= '<option value="' . $val->id . '">' . $val->title . '</option>';
        }

        $gen_html .= '</select>';

        echo $gen_html;
        exit;
    }

}

/* CLasses controller ends */