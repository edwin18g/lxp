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

        $data['inactive_courses'] = max(0, $data['total_courses'] - $data['active_courses']);

        // Table Header
        $data['t_headers'] = array('Course', 'Category', 'Lectures', 'Learners', 'Updated', 'Featured', 'Status', '');

        // load views
        $content['content'] = $this->load->view('admin/lms/courses/index', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * ajax_list
     */
    public function ajax_list()
    {
        // Read-only endpoint: release the DB session lock (auth already ran in the constructor) so other
        // requests from this admin aren't queued behind the listing query.
        session_write_close();

        $this->load->library('datatables');

        $table = 'courses';
        // Per-course counts use idx_cl_course_section_sort / idx_cs_course_status
        // (application/database/migrations/2026_10_24_course_performance_indexes.sql)
        $columns = array(
            "$table.id",
            "$table.title",
            "$table.images",
            "$table.course_categories_id",
            "$table.featured",
            "$table.status",
            "$table.date_updated",
            "(SELECT cc.title FROM course_categories cc WHERE cc.id = $table.course_categories_id) category_name",
            "(SELECT COUNT(*) FROM course_lecture cl WHERE cl.cl_course_id = $table.id) lecture_count",
            "(SELECT COUNT(*) FROM course_subscription cs WHERE cs.cs_course_id = $table.id AND cs.cs_status = '1') learner_count",
        );
        // Must line up with the table columns in the view
        $columns_order = array(
            "$table.title",
            "category_name",
            "lecture_count",
            "learner_count",
            "$table.date_updated",
            "$table.featured",
            "$table.status",
            "",
        );
        $columns_search = array(
            "$table.title",
        );
        $order = array("$table.date_updated" => 'DESC');

        // Filtering
        $where = array();
        if ($this->input->post('category_id')) {
            $where["$table.course_categories_id"] = (int) $this->input->post('category_id');
        }
        $status = $this->input->post('status');
        if ($status === '0' || $status === '1') {
            $where["$table.status"] = $status;
        }
        if ($this->input->post('featured') === '1') {
            $where["$table.featured"] = '1';
        }

        $result = $this->datatables->get_datatables($table, $columns, $columns_order, $columns_search, $order, $where);
        $data = array();

        // Course images live in upload/courses/images/ (with a *_thumb copy). A wrong or missing path makes every
        // thumbnail a 404 that boots the whole app and waits on the DB session lock, which stalls this page.
        $img_dir = FCPATH . 'upload/courses/images/';
        $default_img = base_url('themes/default/images/course/course-01.jpg');

        foreach ($result as $val) {
            $row = array();

            // Thumbnail: prefer *_thumb, then the original, then the default (only files that exist)
            $img_src = $default_img;
            $images = ($val->images) ? json_decode($val->images) : null;
            if (!empty($images) && is_array($images) && !empty($images[0])) {
                $file = basename($images[0]);
                $thumb = image_to_thumb($file);
                if (is_file($img_dir . $thumb)) {
                    $img_src = base_url('upload/courses/images/' . $thumb);
                } elseif (is_file($img_dir . $file)) {
                    $img_src = base_url('upload/courses/images/' . $file);
                }
            }

            $edit_url = site_url('admin/courses/form/' . $val->id);
            $title = htmlspecialchars($val->title);

            // Course: thumbnail + title + id
            $row[] = '<a href="' . $edit_url . '" class="cl-course">'
                . '<img src="' . $img_src . '" alt="" loading="lazy" decoding="async" width="56" height="40">'
                . '<span class="cl-course-text"><span class="cl-course-title" title="' . $title . '">' . $title . '</span>'
                . '<span class="cl-course-id">ID #' . (int) $val->id . '</span></span></a>';

            $row[] = $val->category_name
                ? '<span class="cl-cat">' . htmlspecialchars($val->category_name) . '</span>'
                : '<span class="cl-muted">—</span>';

            $row[] = '<span class="cl-num' . ($val->lecture_count ? '' : ' is-zero') . '"><i class="material-icons">play_circle_outline</i>' . (int) $val->lecture_count . '</span>';
            $row[] = '<span class="cl-num' . ($val->learner_count ? '' : ' is-zero') . '"><i class="material-icons">people_outline</i>' . (int) $val->learner_count . '</span>';

            $row[] = '<span class="cl-date" title="' . date('d M Y, g:i A', strtotime($val->date_updated)) . '">' . time_elapsed_string($val->date_updated) . '</span>';
            $row[] = featured_switch($val->featured, $val->id);
            $row[] = status_switch($val->status, $val->id);

            $view_url = site_url('courses/detail/') . str_replace(' ', '+', $val->title);
            $row[] = '<div class="cl-actions">'
                . '<a href="' . $edit_url . '" class="cl-btn cl-btn-primary" title="Edit course"><i class="material-icons">edit</i><span>Edit</span></a>'
                . '<a href="' . $view_url . '" target="_blank" rel="noopener" class="cl-btn cl-btn-icon" title="View on website"><i class="material-icons">open_in_new</i></a>'
                . '</div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => (int) $this->input->post('draw'),
            "recordsTotal" => $this->datatables->count_all(),
            "recordsFiltered" => $this->datatables->count_filtered($where),
            "data" => $data,
        );

        // Keep the stat cards in sync after featured/status toggles
        $total = (int) $this->courses_model->count_all_courses();
        $active = (int) $this->courses_model->count_active_courses();
        $output['stats'] = array(
            'all' => $total,
            'active' => $active,
            'inactive' => max(0, $total - $active),
            'featured' => (int) $this->courses_model->count_featured_courses(),
        );

        //output to json format
        echo json_encode($output);
        exit;
    }

    public function ajax_users_list()
    {
        session_write_close(); // read-only: don't hold the DB session lock (other requests on this page queue behind it)
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
            "recordsTotal" => $this->datatables->count_all($where),
            "recordsFiltered" => $this->datatables->count_filtered($where),
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

    public function ajax_get_sections($course_id)
    {
        session_write_close(); // read-only: don't hold the DB session lock (other requests on this page queue behind it)
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $sections = $this->courses_model->get_sections((int) $course_id);
        echo json_encode(['flag' => 1, 'data' => $sections]);
    }

    public function render_curriculum($course_id)
    {
        session_write_close(); // read-only: don't hold the DB session lock (other requests on this page queue behind it)
        $data['curriculum'] = $this->courses_model->get_curriculum((int) $course_id);
        $this->load->view('admin/lms/courses/curriculum_list', $data);
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

        if ($title !== '' && !preg_match('/^[\p{L}\p{N}\s\-\(\)\.,:;!&\'"\?\/]+$/u', $title)) {
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
        $content['content'] = $this->load->view('admin/lms/lecture/index', $data, TRUE);
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
        $content['content'] = $this->load->view('admin/lms/courses/users', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * form
     */
    public function form($id = NULL, $tab = NULL)
    {
        // Tab in the URL: admin/courses/form/{id}/{overview|curriculum|learners}
        $tab = in_array($tab, array('overview', 'curriculum', 'learners'), TRUE) ? $tab : 'overview';
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
        $data['active_tab'] = ((int) $id) ? $tab : 'overview'; // Curriculum/Learners need a saved course

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
        $data['insights'] = !empty($data['id']) ? $this->_course_insights((int) $data['id'], $result) : NULL;

        // Heading for the full-width template's top bar (view vars are shared with the template)
        $data['page_heading'] = !empty($data['title']['value']) ? $data['title']['value'] : (empty($data['id']) ? 'New course' : 'Untitled course');
        $data['page_crumb'] = empty($data['id']) ? 'New course' : 'Edit course';
        $content['content'] = $this->load->view('admin/lms/courses/form', $data, TRUE);
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
            $content['content'] = $this->load->view('admin/lms/courses/user_form_beta', $data, TRUE);
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
        $content['content'] = $this->load->view('admin/lms/courses/user_form', $data, TRUE);
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
                echo json_encode(array('flag' => 0, 'msg' => strip_tags(sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')))));
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
                echo json_encode(array('flag' => 0, 'msg' => strip_tags(sprintf(lang('manage_acl_permission_no'), lang('manage_acl_add')))));
                exit;
            }
        }

        /* Validate form input */
        $this->form_validation
            ->set_rules('title', 'Title', 'trim|required|max_length[200]')
            ->set_rules('description', lang('common_description'), 'trim')
            ->set_rules('featured', lang('common_featured'), 'required|in_list[0,1]')
            ->set_rules('status', lang('common_status'), 'required|in_list[0,1]')
            ->set_rules('meta_title', 'URL / File ID', 'required|trim|max_length[200]')


            ->set_rules('category', 'Content Type', 'required|in_list[1,2,3]', array('in_list' => 'Please select a content type.'));



        if ($this->form_validation->run() === FALSE) {
            // for fetching specific fields errors in order to view errors on each field seperately
            $error_fields = array();
            foreach ($_POST as $key => $val)
                if (form_error($key))
                    $error_fields[] = $key;

            echo json_encode(array(
                'flag' => 0,
                'msg' => trim(strip_tags(validation_errors('', "\n"))),
                'error_fields' => $error_fields,
            ));
            exit;
        }



        // data to insert in db table
        $data = array();
        $data['cl_name'] = $this->input->post('title');
        $data['cl_decsription'] = $this->input->post('description');
        $data['cl_file_name'] = $this->input->post('meta_title');
        $data['cl_status'] = $this->input->post('status');
        $data['cl_secure'] = $this->input->post('featured');
        $data['cl_course_id'] = $this->input->post('course_id');
        $data['section_id'] = (int) $this->input->post('section_id');
        $data['cl_type'] = $this->input->post('category');
        if ($data['cl_type'] == 3) {
            $video_url = $this->generate_youtube_url($data['cl_file_name']);
            if ($video_url === FALSE && preg_match('~vimeo\.com/(?:video/)?(\d+)~', $data['cl_file_name'], $vm)) {
                $video_url = 'https://player.vimeo.com/video/' . $vm[1];
            }
            if ($video_url === FALSE) {
                echo json_encode(array(
                    'flag' => 0,
                    'msg' => "That doesn't look like a YouTube or Vimeo link. Paste the video URL or the 11-character YouTube ID.",
                    'error_fields' => array('meta_title'),
                ));
                exit;
            }
            $data['cl_file_name'] = $video_url;
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
        $url = trim((string) $url);
        if ($url === '') {
            return FALSE;
        }

        // watch?v=…&t=…, youtu.be/…?si=…, embed/, shorts/, live/, v/ — or a bare 11-character ID
        if (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:embed/|watch\?(?:.*&)?v=|shorts/|live/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)
            || preg_match('~^([A-Za-z0-9_-]{11})$~', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        return FALSE;
    }

    public function user_save_beta()
    {

        if (!empty($_POST['course_id'])) {

            if (!empty($_POST['user_id'])) {
                $user_ids = explode(',', $_POST['user_id']);

                foreach ($user_ids as $key => $user_id) {
                    // data to insert in db table
                    $data = array();
                    $data['cs_user_id'] = $user_id;
                    $data['cs_course_id'] = $this->input->post('course_id');
                    $flag = $this->courses_model->save_suscription($data, NULL);
                }
            }
        }

        if ($flag) {
            $this->session->set_flashdata('message', 'Learners enrolled successfully');

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
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['meta_title'] = $this->input->post('meta_title');
        $data['meta_tags'] = $this->input->post('meta_tags');
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

    /**
     * Numbers + setup checklist for the course Overview tab
     */
    private function _course_insights($course_id, $course)
    {
        $db = $this->db;

        $lec = $db->select("COUNT(*) AS total, SUM(cl_status = 1) AS published, SUM(cl_secure = 0) AS public_count,
                SUM(cl_type = 3) AS videos, SUM(cl_type = 2) AS pdfs, SUM(cl_type = 1) AS drive,
                SUM(TRIM(cl_file_name) = '') AS missing_url", FALSE)
            ->where('cl_course_id', $course_id)->get('course_lecture')->row();
        $sections = (int) $db->where('course_id', $course_id)->count_all_results('course_sections');

        $since = date('Y-m-d', strtotime('-30 days'));
        $lr = $db->select("COUNT(*) AS total, SUM(cs_status = '1') AS active,
                SUM(cs_start_date >= " . $db->escape($since) . ") AS new_30", FALSE) // legacy zero dates are never >= $since
            ->where('cs_course_id', $course_id)->get('course_subscription')->row();

        // Progress: completions of currently published lectures by currently enrolled learners
        $published = (int) $lec->published;
        $prog = $db->query("
            SELECT COUNT(*) AS done, COUNT(DISTINCT p.user_id) AS started, MAX(p.completed_at) AS last_at
            FROM user_lecture_progress p
            JOIN course_lecture l ON l.id = p.lecture_id AND l.cl_course_id = ? AND l.cl_status = 1
            JOIN course_subscription s ON s.cs_user_id = p.user_id AND s.cs_course_id = ?
            WHERE p.course_id = ?", array($course_id, $course_id, $course_id))->row();
        $finished = $published ? (int) $db->query("
            SELECT COUNT(*) AS n FROM (
                SELECT p.user_id FROM user_lecture_progress p
                JOIN course_lecture l ON l.id = p.lecture_id AND l.cl_course_id = ? AND l.cl_status = 1
                JOIN course_subscription s ON s.cs_user_id = p.user_id AND s.cs_course_id = ?
                WHERE p.course_id = ? GROUP BY p.user_id HAVING COUNT(DISTINCT p.lecture_id) >= ?
            ) t", array($course_id, $course_id, $course_id, $published))->row()->n : 0;
        $enrolled = (int) $lr->total;
        $avg = ($enrolled && $published) ? round(100 * (int) $prog->done / ($enrolled * $published)) : NULL;

        // Setup checklist (each item says where to fix it)
        $images = !empty($course->images) ? json_decode($course->images) : array();
        $desc = trim(html_entity_decode(strip_tags((string) $course->description)));
        $checks = array(
            array('ok' => mb_strlen($desc) >= 50, 'label' => 'Description of at least 50 characters', 'hint' => mb_strlen($desc) ? mb_strlen($desc) . ' characters now' : 'Empty', 'fix' => 'field:description'),
            array('ok' => !empty($images), 'label' => 'Course image', 'hint' => 'Shown on course cards', 'fix' => 'field:images'),
            array('ok' => $published > 0, 'label' => 'At least one published lecture', 'hint' => $published . ' published', 'fix' => 'tab:curriculum'),
            array('ok' => (int) $lec->missing_url === 0, 'label' => 'Every lecture has a URL / file', 'hint' => (int) $lec->missing_url . ' missing', 'fix' => 'tab:curriculum'),
            array('ok' => $sections > 0 || (int) $lec->total <= 8, 'label' => 'Lectures grouped into sections', 'hint' => $sections ? $sections . ' sections' : 'Recommended once a course has more than 8 lectures', 'fix' => 'tab:curriculum'),
            array('ok' => trim((string) $course->meta_title) !== '' && trim((string) $course->meta_description) !== '', 'label' => 'SEO title and description', 'hint' => 'Helps the course page appear in search', 'fix' => 'field:seo'),
            array('ok' => (string) $course->status === '1', 'label' => 'Course is active (visible to learners)', 'hint' => 'Status is set in Publishing', 'fix' => 'field:status'),
        );
        $done = count(array_filter($checks, function ($c) { return $c['ok']; }));

        return array(
            'lectures' => array('total' => (int) $lec->total, 'published' => $published, 'draft' => (int) $lec->total - $published,
                'public' => (int) $lec->public_count, 'videos' => (int) $lec->videos, 'pdfs' => (int) $lec->pdfs, 'drive' => (int) $lec->drive),
            'sections' => $sections,
            'learners' => array('total' => $enrolled, 'active' => (int) $lr->active, 'new_30' => (int) $lr->new_30),
            'progress' => array('started' => (int) $prog->started, 'finished' => $finished, 'avg' => $avg, 'last_at' => $prog->last_at),
            'updated' => $course->date_updated,
            'checks' => $checks,
            'score' => (int) round(100 * $done / count($checks)),
            'done' => $done,
        );
    }

    /* =====================================================================
     * Course → Learners tab
     * ===================================================================== */

    /**
     * Enrolled learners of a course (server-side DataTables) — JSON
     */
    public function learners_list($course_id = NULL)
    {
        session_write_close(); // read-only
        $course_id = (int) $course_id;
        $search = $this->input->post('search');
        $search = isset($search['value']) ? trim((string) $search['value']) : '';
        $status = $this->input->post('status');

        $filter = function ($db) use ($course_id, $search, $status) {
            $db->from('course_subscription cs')->join('users u', 'u.id = cs.cs_user_id', 'inner')->where('cs.cs_course_id', $course_id);
            if ($search !== '') {
                $db->group_start()->like('u.first_name', $search)->or_like('u.last_name', $search)
                    ->or_like("CONCAT(u.first_name, ' ', u.last_name)", $search)->or_like('u.email', $search)
                    ->or_like('u.mobile', $search)->or_like('u.username', $search)->group_end();
            }
            if ($status === 'active') {
                $db->where('cs.cs_status', '1');
            } elseif ($status === 'inactive') {
                $db->where("(cs.cs_status IS NULL OR cs.cs_status <> '1')", NULL, FALSE);
            }
        };

        $order = $this->input->post('order');
        $columns = $this->input->post('columns');
        $sortable = array('name' => 'u.first_name', 'enrolled' => 'cs.id', 'last_login' => 'u.last_login', 'status' => 'cs.cs_status');
        $col = 'cs.id';
        $dir = 'DESC';
        if (isset($order[0]['column'], $columns[(int) $order[0]['column']]['name']) && isset($sortable[$columns[(int) $order[0]['column']]['name']])) {
            $col = $sortable[$columns[(int) $order[0]['column']]['name']];
            $dir = (isset($order[0]['dir']) && strtolower($order[0]['dir']) === 'asc') ? 'ASC' : 'DESC';
        }

        $this->db->select('cs.id AS cs_id, cs.cs_status, cs.cs_start_date, u.id AS user_id, u.first_name, u.last_name, u.username, u.email, u.mobile, u.image, u.last_login, u.active');
        $filter($this->db);
        $length = (int) $this->input->post('length');
        $rows = $this->db->order_by($col, $dir)->order_by('cs.id', 'DESC')
            ->limit($length > 0 ? min($length, 200) : 25, max(0, (int) $this->input->post('start')))->get()->result();

        $e = function ($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); };
        $data = array();
        foreach ($rows as $r) {
            $name = trim($r->first_name . ' ' . $r->last_name);
            $name = $name !== '' ? $name : $r->username;
            $initials = strtoupper(mb_substr(trim((string) $r->first_name), 0, 1) . mb_substr(trim((string) $r->last_name), 0, 1));
            $initials = preg_match('/^[\p{L}\p{N}]+$/u', $initials) ? $initials : strtoupper(mb_substr((string) $r->username, 0, 1));
            $avatar = '<span class="ul-avatar"><span class="ul-initials">' . $e($initials) . '</span>'
                . ($r->image ? '<img src="' . $e(base_url('upload/users/images/' . $r->image)) . '" alt="" loading="lazy" onerror="this.remove()">' : '') . '</span>';
            $on = ((string) $r->cs_status === '1');
            $enrolled = ($r->cs_start_date && $r->cs_start_date !== '0000-00-00') ? date('d M Y', strtotime($r->cs_start_date)) : '—';

            $data[] = array(
                '<label class="curr-check"><input type="checkbox" class="js-learner-check" value="' . (int) $r->cs_id . '"><span class="curr-check-box"></span></label>',
                '<span class="ul-user">' . $avatar . '<span class="ul-user-text"><span class="ul-name" title="' . $e($name) . '">' . $e($name)
                    . ((int) $r->active !== 1 ? ' <span class="lr-flag" title="This user account is deactivated">Account off</span>' : '') . '</span>'
                    . '<span class="ul-sub" title="' . $e($r->email) . '">' . $e($r->email) . '</span></span></span>',
                '<span class="ul-sub" style="color:#334155">' . ($r->mobile ? $e($r->mobile) : '—') . '</span>',
                '<span class="ul-date">' . $enrolled . '</span>',
                '<span class="ul-sub" style="color:#64748b">' . ($r->last_login ? $e(time_elapsed_string((int) $r->last_login)) : 'Never') . '</span>',
                '<label class="ul-switch" title="' . ($on ? 'Click to deactivate access' : 'Click to activate access') . '"><input type="checkbox"' . ($on ? ' checked' : '')
                    . ' onchange="learnerToggle(' . (int) $r->cs_id . ', this)"><span class="ul-switch-track"><span class="ul-switch-thumb"></span></span>'
                    . '<span class="ul-switch-label">' . ($on ? 'Active' : 'Inactive') . '</span></label>',
                '<button type="button" class="cl-btn cl-btn-icon ul-danger" title="Remove from course" onclick="learnerRemove(' . (int) $r->cs_id . ', ' . $e(json_encode($e($name))) . ')"><i class="material-icons">person_remove</i></button>',
            );
        }

        $filter($this->db);
        $filtered = (int) $this->db->count_all_results();
        $stats = $this->db->select("COUNT(*) AS total, SUM(cs_status = '1') AS active", FALSE)->where('cs_course_id', $course_id)->get('course_subscription')->row();

        echo json_encode(array(
            'draw' => (int) $this->input->post('draw'),
            'recordsTotal' => (int) $stats->total,
            'recordsFiltered' => $filtered,
            'data' => $data,
            'stats' => array('total' => (int) $stats->total, 'active' => (int) $stats->active, 'inactive' => (int) $stats->total - (int) $stats->active),
        ));
        exit;
    }

    /**
     * Bulk / single actions on enrollments of one course (POST course_id, ids[] = enrollment ids, action) — JSON
     * actions: activate, deactivate, remove
     */
    public function learners_bulk()
    {
        $course_id = (int) $this->input->post('course_id');
        $action = (string) $this->input->post('action');
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $this->input->post('ids')))));
        $perm = ($action === 'remove') ? 'p_delete' : 'p_edit';
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', $perm)) {
            echo json_encode(array('flag' => 0, 'msg' => strip_tags(sprintf(lang('manage_acl_permission_no'), lang($perm === 'p_delete' ? 'manage_acl_delete' : 'manage_acl_edit')))));
            exit;
        }
        if (!$course_id || empty($ids)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Select at least one learner.'));
            exit;
        }

        // Only enrollments of this course are touched
        $n = (int) $this->db->where('cs_course_id', $course_id)->where_in('id', $ids)->count_all_results('course_subscription');
        if ($action === 'activate' || $action === 'deactivate') {
            $this->db->where('cs_course_id', $course_id)->where_in('id', $ids)->update('course_subscription', array('cs_status' => $action === 'activate' ? '1' : '0'));
            $msg = sprintf('%d learner%s %s.', $n, $n == 1 ? '' : 's', $action === 'activate' ? 'activated' : 'deactivated');
        } elseif ($action === 'remove') {
            $this->db->where('cs_course_id', $course_id)->where_in('id', $ids)->delete('course_subscription');
            $msg = sprintf('%d learner%s removed from this course.', $n, $n == 1 ? '' : 's');
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Unknown action.'));
            exit;
        }
        echo json_encode(array('flag' => 1, 'msg' => $msg, 'count' => $n));
        exit;
    }

    /**
     * Learners not yet enrolled in the course, for the Enroll dialog (POST q, offset) — JSON
     */
    public function learner_candidates($course_id = NULL)
    {
        session_write_close(); // read-only
        $course_id = (int) $course_id;
        $q = trim((string) $this->input->post('q'));
        $offset = max(0, (int) $this->input->post('offset'));
        $limit = 30;

        $filter = function ($db) use ($course_id, $q) {
            $db->from('users u')
                ->where('u.id IN (SELECT ug.user_id FROM users_groups ug WHERE ug.group_id = 3)', NULL, FALSE)
                ->where('NOT EXISTS (SELECT 1 FROM course_subscription cs WHERE cs.cs_user_id = u.id AND cs.cs_course_id = ' . $course_id . ')', NULL, FALSE);
            if ($q !== '') {
                $db->group_start()->like('u.first_name', $q)->or_like('u.last_name', $q)->or_like("CONCAT(u.first_name, ' ', u.last_name)", $q)
                    ->or_like('u.email', $q)->or_like('u.mobile', $q)->or_like('u.username', $q)->group_end();
            }
        };

        $this->db->select('u.id, u.first_name, u.last_name, u.username, u.email, u.mobile, u.image, u.active');
        $filter($this->db);
        $rows = $this->db->order_by('u.id', 'DESC')->limit($limit, $offset)->get()->result_array();
        $filter($this->db);
        $total = (int) $this->db->count_all_results();

        foreach ($rows as &$r) {
            $r['name'] = trim($r['first_name'] . ' ' . $r['last_name']) ?: $r['username'];
            $r['image'] = $r['image'] ? base_url('upload/users/images/' . $r['image']) : '';
            unset($r['first_name'], $r['last_name']);
        }
        echo json_encode(array('flag' => 1, 'rows' => $rows, 'total' => $total, 'next' => ($offset + $limit < $total) ? $offset + $limit : NULL));
        exit;
    }

    /**
     * Enroll learners (POST course_id, user_ids[] and/or list = emails / phones / usernames; preview=1 to dry-run) — JSON
     */
    public function learners_enroll()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_add')) {
            echo json_encode(array('flag' => 0, 'msg' => strip_tags(sprintf(lang('manage_acl_permission_no'), lang('manage_acl_add')))));
            exit;
        }
        $course_id = (int) $this->input->post('course_id');
        if (!$course_id || !$this->db->where('id', $course_id)->count_all_results('courses')) {
            echo json_encode(array('flag' => 0, 'msg' => 'Course not found.'));
            exit;
        }
        $preview = (int) $this->input->post('preview') === 1;
        $status = (int) $this->input->post('status') === 0 ? '0' : '1';

        $user_ids = array_values(array_unique(array_filter(array_map('intval', (array) $this->input->post('user_ids')))));
        $not_found = array();

        // Pasted list: one per line or comma/semicolon separated; matched against email, mobile or username
        $tokens = array_values(array_unique(array_filter(array_map('trim', preg_split('/[\r\n,;\t]+/', (string) $this->input->post('list'))))));
        if (count($tokens) + count($user_ids) > 2000) {
            echo json_encode(array('flag' => 0, 'msg' => 'Please enroll at most 2000 learners at a time.'));
            exit;
        }
        if ($tokens) {
            $lower = array_map('strtolower', $tokens);
            // where_in(..., FALSE) keeps LOWER(...) unquoted but also skips value escaping, so escape the values here
            $lower_sql = array_map(array($this->db, 'escape'), $lower);
            $found = $this->db->select('id, LOWER(email) AS email, mobile, LOWER(username) AS username', FALSE)->from('users')
                ->group_start()->where_in('LOWER(email)', $lower_sql, FALSE)->or_where_in('mobile', $tokens)->or_where_in('LOWER(username)', $lower_sql, FALSE)->group_end()
                ->get()->result();
            foreach ($tokens as $t) {
                $tl = strtolower($t);
                $match = NULL;
                foreach ($found as $f) {
                    if ($f->email === $tl || (string) $f->mobile === $t || $f->username === $tl) { $match = (int) $f->id; break; }
                }
                if ($match) $user_ids[] = $match; else $not_found[] = $t;
            }
            $user_ids = array_values(array_unique($user_ids));
        }

        if (empty($user_ids)) {
            echo json_encode(array('flag' => $preview ? 1 : 0, 'msg' => 'No matching learners to enroll.', 'enroll' => array(), 'already' => array(), 'not_found' => $not_found));
            exit;
        }

        $already_ids = array_map('intval', array_column($this->db->select('cs_user_id')->where('cs_course_id', $course_id)->where_in('cs_user_id', $user_ids)
            ->get('course_subscription')->result_array(), 'cs_user_id'));
        $new_ids = array_values(array_diff($user_ids, $already_ids));

        $describe = function ($ids) {
            if (!$ids) return array();
            $out = array();
            foreach ($this->db->select('id, first_name, last_name, username, email')->where_in('id', $ids)->get('users')->result() as $u) {
                $out[] = array('id' => (int) $u->id, 'name' => trim($u->first_name . ' ' . $u->last_name) ?: $u->username, 'email' => $u->email);
            }
            return $out;
        };

        if ($preview) {
            echo json_encode(array('flag' => 1, 'enroll' => $describe($new_ids), 'already' => $describe($already_ids), 'not_found' => $not_found));
            exit;
        }

        if ($new_ids) {
            $today = date('Y-m-d');
            $batch = array();
            foreach ($new_ids as $uid) {
                $batch[] = array('cs_user_id' => $uid, 'cs_course_id' => $course_id, 'cs_start_date' => $today, 'cs_end_date' => '0000-00-00', 'cs_status' => $status);
            }
            $this->db->trans_start();
            foreach (array_chunk($batch, 500) as $chunk) {
                $this->db->insert_batch('course_subscription', $chunk);
            }
            $this->db->trans_complete();
            if (!$this->db->trans_status()) {
                echo json_encode(array('flag' => 0, 'msg' => 'Could not enroll the learners. Nothing was saved.'));
                exit;
            }
        }

        $n = count($new_ids);
        $msg = $n ? sprintf('%d learner%s enrolled.', $n, $n == 1 ? '' : 's') : 'No new learners to enroll.';
        if ($already_ids) $msg .= sprintf(' %d already enrolled.', count($already_ids));
        if ($not_found) $msg .= sprintf(' %d not found.', count($not_found));
        echo json_encode(array('flag' => 1, 'msg' => $msg, 'count' => $n));
        exit;
    }

    /**
     * Bulk actions on lectures of one course (POST course_id, ids[], action[, section_id]) — JSON
     * actions: publish, unpublish, secure, public, move, delete
     */
    public function lecture_bulk()
    {
        $course_id = (int) $this->input->post('course_id');
        $action = (string) $this->input->post('action');
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $this->input->post('ids')))));

        $perm = ($action === 'delete') ? 'p_delete' : 'p_edit';
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', $perm)) {
            echo json_encode(array('flag' => 0, 'msg' => strip_tags(sprintf(lang('manage_acl_permission_no'), lang($action === 'delete' ? 'manage_acl_delete' : 'manage_acl_edit')))));
            exit;
        }
        if (!$course_id || empty($ids)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Select at least one lecture.'));
            exit;
        }
        if (count($ids) > 1000) {
            echo json_encode(array('flag' => 0, 'msg' => 'Too many lectures selected at once (max 1000).'));
            exit;
        }

        $updates = array(
            'publish' => array('cl_status' => 1),
            'unpublish' => array('cl_status' => 0),
            'secure' => array('cl_secure' => 1),
            'public' => array('cl_secure' => 0),
        );

        // Only lectures that belong to this course are ever touched (filter applied in each branch)
        if (isset($updates[$action])) {
            $this->db->where('cl_course_id', $course_id)->where_in('id', $ids)->update('course_lecture', $updates[$action]);
            $labels = array('publish' => 'published', 'unpublish' => 'set to draft', 'secure' => 'set to secure', 'public' => 'set to public');
            $n = (int) $this->db->where('cl_course_id', $course_id)->where_in('id', $ids)->count_all_results('course_lecture');
            $msg = sprintf('%d lecture%s %s.', $n, $n == 1 ? '' : 's', $labels[$action]);
        } elseif ($action === 'move') {
            $section_id = (int) $this->input->post('section_id');
            if ($section_id && !$this->db->where('id', $section_id)->where('course_id', $course_id)->count_all_results('course_sections')) {
                echo json_encode(array('flag' => 0, 'msg' => 'That section does not belong to this course.'));
                exit;
            }
            // Append after the lectures already in the target section, keeping the selected order
            $max = (int) $this->db->select_max('sort_order', 'm')->where('cl_course_id', $course_id)->where('section_id', $section_id)
                ->where_not_in('id', $ids)->get('course_lecture')->row()->m;
            $ordered = $this->db->select('id')->where('cl_course_id', $course_id)->where_in('id', $ids)
                ->order_by('section_id', 'ASC')->order_by('sort_order', 'ASC')->get('course_lecture')->result();
            $this->db->trans_start();
            foreach ($ordered as $i => $row) {
                $this->db->where('id', $row->id)->update('course_lecture', array('section_id' => $section_id, 'sort_order' => $max + $i + 1));
            }
            $this->db->trans_complete();
            $n = count($ordered);
            $msg = sprintf('%d lecture%s moved.', $n, $n == 1 ? '' : 's');
        } elseif ($action === 'delete') {
            $this->db->where('cl_course_id', $course_id)->where_in('id', $ids)->delete('course_lecture');
            $n = $this->db->affected_rows();
            $msg = sprintf('%d lecture%s deleted.', $n, $n == 1 ? '' : 's');
        } else {
            echo json_encode(array('flag' => 0, 'msg' => 'Unknown action.'));
            exit;
        }

        echo json_encode(array('flag' => 1, 'msg' => $msg, 'count' => (int) $n));
        exit;
    }

    /**
     * Bulk add lectures from pasted lines: "Title | URL" or just a URL / file id (POST) — JSON
     */
    public function lecture_bulk_add()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_add')) {
            echo json_encode(array('flag' => 0, 'msg' => strip_tags(sprintf(lang('manage_acl_permission_no'), lang('manage_acl_add')))));
            exit;
        }
        $course_id = (int) $this->input->post('course_id');
        $section_id = (int) $this->input->post('section_id');
        $type = (int) $this->input->post('category');
        $status = (int) $this->input->post('status') === 1 ? 1 : 0;
        $secure = (int) $this->input->post('featured') === 1 ? 1 : 0;
        $preview_only = (int) $this->input->post('preview') === 1;
        $lines = preg_split('/\R/', (string) $this->input->post('lines'));

        if (!$course_id || !$this->db->where('id', $course_id)->count_all_results('courses')) {
            echo json_encode(array('flag' => 0, 'msg' => 'Course not found.'));
            exit;
        }
        if (!in_array($type, array(1, 2, 3), TRUE)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Please select a content type.'));
            exit;
        }
        if ($section_id && !$this->db->where('id', $section_id)->where('course_id', $course_id)->count_all_results('course_sections')) {
            echo json_encode(array('flag' => 0, 'msg' => 'That section does not belong to this course.'));
            exit;
        }

        $rows = array();
        foreach ($lines as $i => $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            if (count($rows) >= 200) {
                echo json_encode(array('flag' => 0, 'msg' => 'Please add at most 200 lectures at a time.'));
                exit;
            }
            // "Title | URL" (or tab-separated, as pasted from a spreadsheet); otherwise the whole line is the URL
            $parts = preg_split('/\s*[|\t]\s*/', $line, 2);
            $title = count($parts) === 2 ? trim($parts[0]) : '';
            $url = trim(count($parts) === 2 ? $parts[1] : $parts[0]);
            $row = array('line' => $i + 1, 'title' => $title, 'url' => $url, 'error' => '');

            if ($url === '') {
                $row['error'] = 'Missing URL / file ID';
            } elseif (mb_strlen($url) > 200) {
                $row['error'] = 'URL is longer than 200 characters';
            } elseif ($type === 3) {
                $video = $this->generate_youtube_url($url);
                if ($video === FALSE && preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $vm)) {
                    $video = 'https://player.vimeo.com/video/' . $vm[1];
                }
                if ($video === FALSE) {
                    $row['error'] = 'Not a YouTube or Vimeo link';
                } else {
                    $row['url'] = $video;
                    if ($row['title'] === '') {
                        $row['title'] = $this->_video_title($video);
                    }
                }
            }
            if ($row['error'] === '' && $row['title'] === '') {
                $row['title'] = 'Lecture ' . (count($rows) + 1);
            }
            $row['title'] = mb_substr($row['title'], 0, 200);
            $rows[] = $row;
        }

        if (empty($rows)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Paste at least one line.'));
            exit;
        }

        $valid = array_values(array_filter($rows, function ($r) { return $r['error'] === ''; }));
        if ($preview_only) {
            echo json_encode(array('flag' => 1, 'rows' => $rows, 'valid' => count($valid)));
            exit;
        }
        if (count($valid) !== count($rows)) {
            echo json_encode(array('flag' => 0, 'msg' => 'Fix the lines marked in red first.', 'rows' => $rows));
            exit;
        }

        $max = (int) $this->db->select_max('sort_order', 'm')->where('cl_course_id', $course_id)->where('section_id', $section_id)
            ->get('course_lecture')->row()->m;
        $this->db->trans_start();
        foreach ($valid as $i => $r) {
            $this->db->insert('course_lecture', array(
                'cl_course_id' => $course_id,
                'cl_name' => $r['title'],
                'cl_type' => $type,
                'cl_file_name' => $r['url'],
                'cl_decsription' => '',
                'cl_status' => $status,
                'cl_secure' => $secure,
                'section_id' => $section_id,
                'sort_order' => $max + $i + 1,
            ));
        }
        $this->db->trans_complete();

        if (!$this->db->trans_status()) {
            echo json_encode(array('flag' => 0, 'msg' => 'Could not save the lectures. Nothing was added.'));
            exit;
        }
        echo json_encode(array('flag' => 1, 'msg' => sprintf('%d lecture%s added.', count($valid), count($valid) == 1 ? '' : 's'), 'count' => count($valid)));
        exit;
    }

    /**
     * Title of a YouTube/Vimeo video via oEmbed (no API key); '' if unavailable
     */
    private function _video_title($url)
    {
        $endpoint = (strpos($url, 'vimeo.com') !== FALSE)
            ? 'https://vimeo.com/api/oembed.json?url=' . rawurlencode($url)
            : 'https://www.youtube.com/oembed?format=json&url=' . rawurlencode('https://www.youtube.com/watch?v=' . substr($url, strrpos($url, '/') + 1));
        $ctx = stream_context_create(array('http' => array('timeout' => 4, 'ignore_errors' => TRUE, 'header' => "User-Agent: LMS-lecture-import\r\n")));
        $json = @file_get_contents($endpoint, FALSE, $ctx);
        $data = $json ? json_decode($json, TRUE) : NULL;
        return (is_array($data) && !empty($data['title'])) ? trim((string) $data['title']) : '';
    }

    public function status_lecture()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'courses', 'p_edit')) {
            echo json_encode(array('flag' => 0, 'msg' => sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit'))));
            exit;
        }
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if ($this->db->update('course_lecture', array('cl_secure' => (int) $status ? 1 : 0), array('id' => (int) $id))) {
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
        session_write_close(); // read-only: don't hold the DB session lock (other requests on this page queue behind it)
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

    public function ajax_get_unrolled_users($course_id)
    {
        $keyword = $this->input->post('keyword');
        $params = array(
            'course_id' => $course_id,
            'keyword' => $keyword,
            'limit' => 50
        );
        $users = $this->courses_model->get_user_dropdown($params);

        if (!empty($users)) {
            echo '<table class="table table-hover" style="margin: 0;">';
            echo '<tbody>';
            foreach ($users as $user) {
                echo '<tr>';
                echo '<td style="width: 40px; vertical-align: middle;">';
                echo '<input type="checkbox" id="user_' . $user['id'] . '" class="user-enroll-check filled-in chk-col-blue" value="' . $user['id'] . '">';
                echo '<label for="user_' . $user['id'] . '" style="height: 20px;"></label>';
                echo '</td>';
                echo '<td style="vertical-align: middle;">';
                echo '<div style="font-weight: 600; color: #333;">' . $user['first_name'] . ' ' . $user['last_name'] . '</div>';
                echo '<div style="font-size: 11px; color: #888;">' . $user['email'] . ' | ' . $user['mobile'] . '</div>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="text-center" style="padding: 50px; color: #888;">No learners found.</div>';
        }
    }
}

/* CLasses controller ends */