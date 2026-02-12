<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sliders Controller
 *
 * This class handles sliders module functionality
 *
 * @package     classiebit
 * @author      prodpk
 */

class Sliders extends Admin_Controller
{

    /**
     * Constructor
     **/
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/sliders_model');

        // Page Title
        $this->set_title('Sliders');
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
            'Title',
            'Subtitle',
            'Order',
            'Status',
            'Image',
            lang('action_action'),
        );

        // load views
        $content['content'] = $this->load->view('admin/cms/index', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * ajax_list
     */
    public function ajax_list()
    {
        $this->load->library('datatables');

        $table = 'sliders';
        $columns = array(
            "$table.id",
            "$table.title",
            "$table.subtitle",
            "$table.order_index",
            "$table.status",
            "$table.image",
        );
        $columns_order = array(
            "#",
            "$table.title",
            "$table.subtitle",
            "$table.order_index",
            "$table.status",
            "$table.image",
        );
        $columns_search = array(
            'title',
            'subtitle',
        );
        $order = array('order_index' => 'ASC');

        $result = $this->datatables->get_datatables($table, $columns, $columns_order, $columns_search, $order);
        $data = array();
        $no = $_POST['start'];

        foreach ($result as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->title;
            $row[] = $val->subtitle;
            $row[] = $val->order_index;
            $row[] = status_switch($val->status, $val->id);
            $row[] = '<img src="' . base_url('upload/sliders/images/' . $val->image) . '" class="img-responsive" width="60" >';
            $row[] = action_buttons('sliders', $val->id, $val->title, 'Slider');
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
     * form
     */
    public function form($id = NULL)
    {
        /* Initialize assets */
        // $this->add_js_theme( "pages/sliders/form_i18n.js", TRUE ); // TODO: Create JS validation file if needed
        $data = $this->includes;

        $id = (int) $id;

        // in case of edit
        if ($id) {
            $result = $this->sliders_model->get_slider_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), 'Slider'));
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
            }

            // hidden field in case of update
            $data['id'] = $result->id;

            // current image & icon
            $data['c_image'] = $result->image;
        }

        $data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('title', !empty($result->title) ? $result->title : ''),
        );
        $data['subtitle'] = array(
            'name' => 'subtitle',
            'id' => 'subtitle',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('subtitle', !empty($result->subtitle) ? $result->subtitle : ''),
        );
        $data['button_text'] = array(
            'name' => 'button_text',
            'id' => 'button_text',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('button_text', !empty($result->button_text) ? $result->button_text : ''),
        );
        $data['button_link'] = array(
            'name' => 'button_link',
            'id' => 'button_link',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('button_link', !empty($result->button_link) ? $result->button_link : ''),
        );
        $data['order_index'] = array(
            'name' => 'order_index',
            'id' => 'order_index',
            'type' => 'number',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('order_index', !empty($result->order_index) ? $result->order_index : 0),
        );
        $data['image'] = array(
            'name' => 'image',
            'id' => 'image',
            'type' => 'file',
            'class' => 'form-control',
            'accept' => 'image/*',
        );
        $data['status'] = array(
            'name' => 'status',
            'id' => 'status',
            'class' => 'form-control show-tick',
            'attr' => 'class="form-control show-tick"',
            'options' => array(
                '0' => lang('common_status_inactive'),
                '1' => lang('common_status_active'),
            ),
            'selected' => $this->form_validation->set_value('status', !empty($result->status) ? $result->status : 0),
        );

        /* Load Template */
        $content['content'] = $this->load->view('admin/cms/sliders/form', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * save
     */
    public function save()
    {
        $id = NULL;
        if (!empty($_POST['id'])) {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'testimonials', 'p_edit')) // Using existing permission for now or create new
            {
                // echo '<p>'.sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')).'</p>';exit;
            }
            $id = (int) $this->input->post('id');

            $result = $this->sliders_model->get_slider_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), 'Slider'));
                echo json_encode(array(
                    'flag' => 0,
                    'msg' => $this->session->flashdata('message'),
                    'type' => 'fail',
                ));
                exit;
            }
        } else {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'testimonials', 'p_add')) {
                // echo '<p>'.sprintf(lang('manage_acl_permission_no'), lang('manage_acl_add')).'</p>';exit;
            }
        }

        /* Validate form input */
        $this->form_validation
            ->set_rules('title', 'Title', 'trim|required|min_length[2]|max_length[255]')
            ->set_rules('subtitle', 'Subtitle', 'trim|required|min_length[2]|max_length[255]')
            ->set_rules('order_index', 'Order', 'trim|required|numeric')
            ->set_rules('status', lang('common_status'), 'required|in_list[0,1]');

        if (!empty($_FILES['image']['name'])) // if image 
        {
            $file_image = array('folder' => 'sliders/images', 'input_file' => 'image');
            // Remove old image
            if ($id && !empty($result->image))
                $this->file_uploads->remove_file('./upload/' . $file_image['folder'] . '/', $result->image);
            // update slider image            
            $filename_image = $this->file_uploads->upload_file($file_image);
            // through image upload error
            if (!empty($filename_image['error']))
                $this->form_validation->set_rules('image_error', lang('common_image'), 'required', array('required' => $filename_image['error']));
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

        $data = array();
        $data['title'] = $this->input->post('title');
        $data['subtitle'] = $this->input->post('subtitle');
        $data['button_text'] = $this->input->post('button_text');
        $data['button_link'] = $this->input->post('button_link');
        $data['order_index'] = $this->input->post('order_index');
        $data['status'] = $this->input->post('status');

        if (!empty($filename_image) && !isset($filename_image['error']))
            $data['image'] = $filename_image;

        $flag = $this->sliders_model->save_slider($data, $id);

        if ($flag) {
            if ($id)
                $this->session->set_flashdata('message', sprintf(lang('alert_update_success'), 'Slider'));
            else
                $this->session->set_flashdata('message', sprintf(lang('alert_insert_success'), 'Slider'));

            echo json_encode(array(
                'flag' => 1,
                'msg' => $this->session->flashdata('message'),
                'type' => 'success',
            ));
            exit;
        }

        if ($id)
            $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), 'Slider'));
        else
            $this->session->set_flashdata('error', sprintf(lang('alert_insert_fail'), 'Slider'));

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
    public function view($id = NULL)
    {
        /* Initialize assets */
        $data = $this->includes;

        /* Get Data */
        $id = (int) $id;
        $result = $this->sliders_model->get_slider_by_id($id);

        if (empty($result)) {
            $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), 'Slider'));
            redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
        }

        $data['slider'] = $result;

        /* Load Template */
        $content['content'] = $this->load->view('admin/cms/sliders/view', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * status_update
     */
    public function status_update()
    {
        /* Validate form input */
        $this->form_validation
            ->set_rules('id', sprintf(lang('alert_id'), 'Slider'), 'required|numeric')
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
            $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), 'Slider'));
            echo json_encode(array(
                'flag' => 0,
                'msg' => $this->session->flashdata('message'),
                'type' => 'fail',
            ));
            exit;
        }

        $flag = $this->sliders_model->save_slider($data, $id);

        if ($flag) {
            echo json_encode(array(
                'flag' => 1,
                'msg' => sprintf(lang('alert_status_success'), 'Slider'),
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => sprintf(lang('alert_status_fail'), 'Slider'),
            'type' => 'fail',
        ));
        exit;

    }

    /**
     * delete
     */
    public function delete($id = NULL)
    {
        /* Validate form input */
        $this->form_validation->set_rules('id', sprintf(lang('alert_id'), 'Slider'), 'required|numeric');

        /* Get Data */
        $id = (int) $this->input->post('id');
        $result = $this->sliders_model->get_slider_by_id($id);

        if (empty($result)) {
            echo json_encode(array(
                'flag' => 0,
                'msg' => sprintf(lang('alert_not_found'), 'Slider'),
                'type' => 'fail',
            ));
            exit;
        }

        $flag = $this->sliders_model->delete_slider($id);

        if ($flag) {

            // Remove image
            if (!empty($result->image))
                $this->file_uploads->remove_file('./upload/sliders/images/', $result->image);

            echo json_encode(array(
                'flag' => 1,
                'msg' => sprintf(lang('alert_delete_success'), 'Slider'),
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => sprintf(lang('alert_delete_fail'), 'Slider'),
            'type' => 'fail',
        ));
        exit;
    }



}

/* Sliders controller ends */
