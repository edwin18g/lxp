<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Controller
 *
 * This class handles users module functionality
 *
 * @package     classiebit
 * @author      prodpk
 */

class Users extends Admin_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->load->model('users_model');
        $this->load->model('user_sessions_model');
        $this->lang->load('auth');

        // Page Title
        $this->set_title(lang('menu_users'));
    }

    /**
     * index
     */
    function index()
    {
        /* Initialize assets */
        $this->include_index_plugins();
        $data = $this->includes;

        // Fetch User Stats
        $data['total_users'] = $this->db->count_all('users');
        $data['active_users'] = $this->db->where('active', 1)->count_all_results('users');
        $data['inactive_users'] = $this->db->where('active', 0)->count_all_results('users');

        $data['t_headers'] = array(
            '#',
            'Image', // Static string for safety
            lang('users_first_name'),
            lang('users_last_name'),
            lang('users_username'),
            lang('users_email'),
            'Phone',
            'Role',
            lang('common_status'),
            lang('action_action'),
        );

        // load views
        $content['content'] = $this->load->view('admin/system/users/index', $data, TRUE);
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
        // Map columns index to DB columns
        $columns_map = array(
            0 => 'users.id',
            1 => 'users.image',
            2 => 'users.first_name',
            3 => 'users.last_name',
            4 => 'users.username',
            5 => 'users.email',
            6 => 'users.mobile',
            7 => 'group_name',
            8 => 'users.active',
        );

        if ($order_post) {
            foreach ($order_post as $o) {
                if (isset($columns_map[$o['column']])) {
                    $orders[$columns_map[$o['column']]] = $o['dir'];
                }
            }
        }

        $list = $this->users_model->get_users_dt($length, $start, $orders, $search);

        $data = array();
        $no = $start;

        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;

            // Image
            if ($val->image) {
                $img_url = base_url('upload/users/images/' . $val->image);
                $row[] = '<div class="user-avatar-premium"><img src="' . $img_url . '" class="img-circle" width="40" height="40" alt="User"></div>';
            } else {
                $initial = mb_substr($val->first_name, 0, 1) . mb_substr($val->last_name, 0, 1);
                $row[] = '<div class="user-initials-premium bg-indigo-soft color-indigo">' . strtoupper($initial) . '</div>';
            }

            $row[] = '<span class="font-weight-bold color-slate">' . $val->first_name . '</span>';
            $row[] = '<span class="font-weight-bold color-slate">' . $val->last_name . '</span>';
            $row[] = '<span class="text-lowercase color-slate-soft">@' . $val->username . '</span>';
            $row[] = '<span class="color-slate-soft">' . $val->email . '</span>';
            $row[] = '<span class="color-slate-soft">' . ($val->mobile ? $val->mobile : '-') . '</span>';

            // Group badge
            $group_class = ($val->group_name == 'admin') ? 'bg-indigo color-white' : 'bg-slate-soft color-slate';
            $row[] = '<span class="badge-premium ' . $group_class . '">' . $val->group_name . '</span>';

            // Status 
            $status_class = $val->active ? 'bg-emerald-soft color-emerald' : 'bg-rose-soft color-rose';
            $status_link = $val->active ? site_url('admin/users/deactivate/' . $val->id) : site_url('admin/users/activate/' . $val->id);
            $status_label = '<span class="badge-premium ' . $status_class . '">' . ($val->active ? lang('users_active') : lang('users_inactive')) . '</span>';
            $row[] = '<a href="' . $status_link . '" class="text-decoration-none">' . $status_label . '</a>';


            // Action
            $action = '<div class="btn-group-premium">';
            // View Offcanvas
            $action .= '<button type="button" class="btn-table-action color-indigo bg-indigo-soft" onclick="openUserSidebar(' . $val->id . ')" title="View Details"><i class="material-icons">visibility</i></button>';
            // Edit Offcanvas
            $action .= '<button type="button" class="btn-table-action color-slate bg-slate-soft" onclick="openUserFormSidebar(' . $val->id . ')" title="Edit"><i class="material-icons">edit</i></button>';
            // Login as User (Impersonate)
            if ($val->id != $this->user['id']) {
                $action .= '<a href="' . site_url('admin/users/login_as_user/' . $val->id) . '" class="btn-table-action color-emerald bg-emerald-soft" title="Login as ' . htmlspecialchars($val->first_name, ENT_QUOTES) . '" onclick="return confirm(\'Login as ' . htmlspecialchars($val->first_name . ' ' . $val->last_name, ENT_QUOTES) . '?\');"><i class="material-icons">login</i></a>';
            }
            // Delete
            $action .= '<button type="button" class="btn-table-action color-rose bg-rose-soft" onclick="ajaxDelete(' . $val->id . ', ``, `User`)" title="Delete"><i class="material-icons">delete_outline</i></button>';

            $action .= '</div>';
            $row[] = $action;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->users_model->count_all_users(),
            "recordsFiltered" => $this->users_model->count_filtered_users($search),
            "data" => $data,
        );

        echo json_encode($output);
    }

    /**
     * get_user_details
     */
    public function get_user_details($id)
    {
        $user = $this->users_model->get_users_by_id($id);

        if ($user) {
            $html = '<div class="user-profile-header animate-up">';
            $html .= '<div class="profile-cover"></div>';
            $html .= '<div class="profile-info-main">';

            // Avatar
            $html .= '<div class="sidebar-avatar-wrapper">';
            if ($user->image) {
                $html .= '<img src="' . base_url('upload/users/images/' . $user->image) . '">';
            } else {
                $initial = mb_substr($user->first_name, 0, 1) . mb_substr($user->last_name, 0, 1);
                $html .= '<div class="sidebar-initials bg-indigo-soft color-indigo">' . strtoupper($initial) . '</div>';
            }
            $html .= '</div>';

            // Name & Role
            $html .= '<div class="profile-name-area">';
            $html .= '<h2>' . ucwords($user->first_name . ' ' . $user->last_name) . '</h2>';
            $html .= '<span class="role-badge">' . $user->group_name . '</span>';
            if ($user->id != $this->user['id']) {
                $html .= '<div style="margin-top: 10px;"><a href="' . site_url('admin/users/login_as_user/' . $user->id) . '" class="btn btn-emerald waves-effect" onclick="return confirm(\'Login as ' . htmlspecialchars($user->first_name . ' ' . $user->last_name, ENT_QUOTES) . '?\');" style="border-radius: 8px; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: #10b981; color: #fff; text-decoration: none;"><i class="material-icons" style="font-size: 18px;">login</i> Login as User</a></div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

            // Details Grid
            $html .= '<div class="details-grid animate-up" style="animation-delay: 0.1s;">';

            // Column 1: Account Information
            $html .= '<div class="info-card">';
            $html .= '<h5><i class="material-icons">account_circle</i> Account Information</h5>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">alternate_email</i></div>';
            $html .= '<div class="row-content"><label>Username</label><p>@' . $user->username . '</p></div>';
            $html .= '</div>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">email</i></div>';
            $html .= '<div class="row-content"><label>Email Address</label><p>' . $user->email . '</p></div>';
            $html .= '</div>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">smartphone</i></div>';
            $html .= '<div class="row-content"><label>Phone Number</label><p>' . ($user->mobile ? $user->mobile : 'Not provided') . '</p></div>';
            $html .= '</div>';
            $html .= '</div>';

            // Column 2: Professional Details
            $html .= '<div class="info-card">';
            $html .= '<h5><i class="material-icons">work</i> Professional Details</h5>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">business_center</i></div>';
            $html .= '<div class="row-content"><label>Profession</label><p>' . ($user->profession ? ucwords($user->profession) : 'N/A') . '</p></div>';
            $html .= '</div>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">history_edu</i></div>';
            $html .= '<div class="row-content"><label>Experience</label><p>' . ($user->experience ? $user->experience . ' Years' : 'N/A') . '</p></div>';
            $html .= '</div>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">language</i></div>';
            $html .= '<div class="row-content"><label>Preferred Language</label><p>' . ucwords($user->language) . '</p></div>';
            $html .= '</div>';
            $html .= '</div>';

            // Column 3: Personal & Activity
            $html .= '<div class="info-card">';
            $html .= '<h5><i class="material-icons">info</i> Personal & Activity</h5>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">wc</i></div>';
            $html .= '<div class="row-content"><label>Gender / DOB</label><p>' . ucfirst($user->gender) . ($user->dob ? ' (' . date('d M Y', strtotime($user->dob)) . ')' : '') . '</p></div>';
            $html .= '</div>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">event_available</i></div>';
            $html .= '<div class="row-content"><label>Member Since</label><p>' . date('d M Y', strtotime($user->date_added)) . '</p></div>';
            $html .= '</div>';

            $html .= '<div class="detail-row">';
            $html .= '<div class="row-icon"><i class="material-icons">verified_user</i></div>';
            $html .= '<div class="row-content"><label>Status</label><p>' . ($user->active ? '<span class="color-emerald">Active</span>' : '<span class="color-rose">Inactive</span>') . '</p></div>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '</div>'; // End Grid

            // About Section (Full Width)
            if ($user->about) {
                $html .= '<div class="info-card animate-up" style="margin-top: 25px; animation-delay: 0.2s;">';
                $html .= '<h5><i class="material-icons">description</i> Bio / About</h5>';
                $html .= '<p style="color: #475569; line-height: 1.6; font-size: 15px; margin: 0;">' . nl2br($user->about) . '</p>';
                $html .= '</div>';
            }

            echo $html;
            exit;
        } else {
            echo '<div class="text-center" style="padding:50px;"><i class="material-icons color-rose" style="font-size:48px;">error_outline</i><p class="text-muted mt-2">User not found.</p></div>';
            exit;
        }
    }



    /**
     * form
     */
    public function form($id = NULL)
    {
        /* Initialize assets */
        $this
            ->add_plugin_theme(array(
                'datepicker/datepicker3.css',
                'datepicker/bootstrap-datepicker.js',
            ), 'admin')
            ->add_js_theme("pages/users/form_i18n.js", TRUE);
        $data = $this->includes;

        $id = (int) $id;

        // in case of edit
        if ($id) {
            $result = $this->users_model->get_users_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), lang('menu_user')));
                redirect($this->uri->segment(1) . '/' . $this->uri->segment(2));
            }

            // hidden field in case of update
            $data['id'] = $result->id;

            // current image & icon
            $data['c_image'] = $result->image;
        } else {
            $result = new stdClass();
        }

        $data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('first_name', !empty($result->first_name) ? $result->first_name : ''),
        );
        $data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('last_name', !empty($result->last_name) ? $result->last_name : ''),
        );
        $data['username'] = array(
            'name' => 'username',
            'id' => 'username',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('username', !empty($result->username) ? $result->username : ''),
        );
        $data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'email',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('email', !empty($result->email) ? $result->email : ''),
        );
        $data['profession'] = array(
            'name' => 'profession',
            'id' => 'profession',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('profession', !empty($result->profession) ? $result->profession : ''),
        );
        $data['experience'] = array(
            'name' => 'experience',
            'id' => 'experience',
            'type' => 'number',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('experience', !empty($result->experience) ? $result->experience : ''),
        );
        $data['about'] = array(
            'name' => 'about',
            'id' => 'about',
            'type' => 'textarea',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('about', !empty($result->about) ? $result->about : ''),
        );
        $data['mobile'] = array(
            'name' => 'mobile',
            'id' => 'mobile',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('mobile', !empty($result->mobile) ? $result->mobile : ''),
        );
        $data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('address', !empty($result->address) ? $result->address : ''),
        );
        $data['gender'] = array(
            'name' => 'gender',
            'id' => 'gender',
            'class' => 'form-control show-tick',
            'options' => array(
                'male' => lang('users_gender_male'),
                'female' => lang('users_gender_female'),
                'other' => lang('users_gender_other')
            ),
            'selected' => $this->form_validation->set_value('gender', !empty($result->gender) ? $result->gender : ''),
        );
        $data['dob'] = array(
            'name' => 'dob',
            'id' => 'dob',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('dob', !empty($result->dob) ? $result->dob : ''),
        );
        $data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'class' => 'form-control',
        );
        $data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password',
            'type' => 'password',
            'class' => 'form-control',
        );
        $data['image'] = array(
            'name' => 'image',
            'id' => 'image',
            'type' => 'file',
            'accept' => 'image/*',
            'class' => 'form-control',
        );
        $data['language'] = array(
            'name' => 'language',
            'id' => 'language',
            'class' => 'form-control show-tick',
            'data-live-search' => "true",
            'options' => $this->languages,
            'selected' => $this->form_validation->set_value('language', !empty($result->language) ? $result->language : $this->config->item('language')),
        );

        /*Get groups*/
        $groups = $this->ion_auth->groups()->result_array();
        foreach ($groups as $val)
            $data['group'][$val['id']] = $val['name'];

        if ($id) // only in case of editing
        {
            $result_group = $this->ion_auth->get_users_groups($result->id)->result_array();
        }

        $data['groups'] = array(
            'name' => 'groups',
            'id' => 'groups',
            'class' => 'form-control show-tick text-capitalize',
            'options' => $data['group'],
            'selected' => $this->form_validation->set_value('groups', !empty($result_group) ? $result_group[0]['id'] : 3),
        );

        $data['status'] = array(
            'name' => 'active',
            'id' => 'active',
            'class' => 'form-control show-tick',
            'options' => array(
                '0' => lang('common_status_inactive'),
                '1' => lang('common_status_active'),
            ),
            'selected' => $this->form_validation->set_value('active', !empty($result->active) ? $result->active : 0),
        );

        /* Load View */
        if ($this->input->is_ajax_request()) {
            echo $this->load->view('admin/users/form', $data, TRUE);
            exit;
        }

        /* Load Template */
        $content['breadcrumb'] = $this->breadcrumb;
        $content['content'] = $this->load->view('admin/users/form', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * save
     */
    public function save()
    {
        $id = NULL;

        // Unique columns
        $result = (object) array();
        $result->username = '';
        $result->email = '';

        if (!empty($_POST['id'])) {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'users', 'p_edit')) {
                echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')) . '</p>';
                exit;
            }

            $id = (int) $this->input->post('id');

            // users can only edit non-admins
            if (!$this->ion_auth->is_admin() && !$this->ion_auth->is_admin($id)) {
                echo '<p>' . lang('users_only_admin_can') . '</p>';
                exit;
            }

            $result = $this->users_model->get_users_by_id($id);

            if (empty($result)) {
                $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), lang('menu_user')));
                echo json_encode(array(
                    'flag' => 0,
                    'msg' => $this->session->flashdata('message'),
                    'type' => 'fail',
                ));
                exit;
            }
        } else {
            if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'users', 'p_add')) {
                echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_add')) . '</p>';
                exit;
            }
        }

        // validators
        $this->form_validation
            ->set_rules('username', lang('users_username'), 'trim|required|min_length[5]|max_length[30]|alpha_dot')
            ->set_rules('email', lang('users_email'), 'trim|required|max_length[128]|valid_email')
            ->set_rules('first_name', lang('users_first_name'), 'required|trim|min_length[2]|max_length[32]')
            ->set_rules('last_name', lang('users_last_name'), 'required|trim|min_length[2]|max_length[32]')
            ->set_rules('language', lang('users_language'), 'required|trim')
            ->set_rules('gender', lang('users_gender'), 'trim|required|in_list[male,female,other]')
            ->set_rules('dob', lang('users_dob'), 'required|trim')
            ->set_rules('profession', lang('users_profession'), 'required|trim|min_length[3]|max_length[256]')
            ->set_rules('experience', lang('users_experience'), 'required|trim|is_natural_no_zero')
            ->set_rules('about', lang('users_about'), 'required|trim|min_length[10]|max_length[256]')
            ->set_rules('mobile', lang('users_mobile'), 'required|trim|min_length[5]|max_length[20]')
            ->set_rules('address', lang('users_address'), 'required|trim|min_length[8]|max_length[256]');

        /*Validate password*/
        if ($id) {
            $this->form_validation
                ->set_rules('password', lang('users_password'), 'trim|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]')
                ->set_rules('password_confirm', lang('users_password_confirm'), 'trim|matches[password]');
        } else {
            $this->form_validation
                ->set_rules('password', lang('users_password'), 'trim|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|required')
                ->set_rules('password_confirm', lang('users_password_confirm'), 'trim|matches[password]|required');
        }

        /*Validate email & username for duplicacy*/
        if ($this->input->post('username') !== $result->username)
            $this->form_validation->set_rules('username', lang('users_username'), 'trim|required|min_length[5]|max_length[30]|is_unique[users.username]|alpha_dot');

        if ($this->input->post('email') != $result->email)
            $this->form_validation->set_rules('email', lang('users_email'), 'trim|required|max_length[128]|valid_email|is_unique[users.email]');

        if (!empty($_FILES['image']['name'])) // if image 
        {
            $file_image = array('folder' => 'users/images', 'input_file' => 'image');
            // Remove old image
            if ($id)
                $this->file_uploads->remove_file('./upload/' . $file_image['folder'] . '/', $result->image);
            // update users image      

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

        // insert data
        $data = array();
        $data['first_name'] = strtolower($this->input->post('first_name'));
        $data['last_name'] = strtolower($this->input->post('last_name'));
        $data['gender'] = strtolower($this->input->post('gender'));
        $data['dob'] = date("Y-m-d h:i:s", strtotime($this->input->post('dob')));
        $data['profession'] = strtolower($this->input->post('profession'));
        $data['experience'] = $this->input->post('experience');
        $data['about'] = $this->input->post('about');
        $data['mobile'] = $this->input->post('mobile');
        $data['address'] = strtolower($this->input->post('address'));
        $data['language'] = strtolower($this->input->post('language'));
        $username = strtolower($this->input->post('username'));
        $email = strtolower($this->input->post('email'));

        if (!empty($filename_image) && !isset($filename_image['error']))
            $data['image'] = $filename_image;

        if (!$id) // register only in case of creating user
        {
            $password = $this->input->post('password');
            $flag = $this->ion_auth->register($username, $password, $email, $data);
        } else // follow the user update process of ion auth
        {
            // only admin and owner of account can edit account
            if ((!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
                $this->session->set_flashdata('error', lang('users_update_only_admin_owner'));
                echo json_encode(array(
                    'flag' => 0,
                    'msg' => $this->session->flashdata('error'),
                    'type' => 'fail',
                ));
                exit;
            }

            $currentGroups = $this->ion_auth->get_users_groups($id)->result();

            // Only allow updating groups if user is admin
            if ($this->ion_auth->is_admin()) {
                //Update the groups user belongs to
                $groupData = $this->input->post('groups');

                if (isset($groupData) && !empty($groupData)) {
                    $this->ion_auth->remove_from_group('', $id);

                    $data['active'] = $this->input->post('active');

                    $this->ion_auth->add_to_group($groupData, $id);
                }

                if ($this->input->post('password') && get_domain() !== 'classiebit.com') {
                    $data['password'] = $this->input->post('password');
                }
            }

            $data['email'] = $email;

            if (get_domain() !== 'classiebit.com')
                $data['username'] = $username;

            $flag = $this->ion_auth->update($id, $data);
        }

        if ($flag) {
            // add batch notification when new batch inserted
            if (!$id) {
                $notification = array(
                    'users_id' => $this->user['id'],
                    'n_type' => 'users',
                    'n_content' => 'noti_new_users',
                    'n_url' => site_url('admin/users'),
                );
                $this->notifications_model->save_notifications($notification);
            }

            if ($id) {
                if (get_domain() !== 'classiebit.com')
                    $this->session->set_flashdata('message', sprintf(lang('alert_update_success'), lang('menu_user')));
                else
                    $this->session->set_flashdata('message', lang('demo_mode'));
            } else {
                $this->session->set_flashdata('message', sprintf(lang('alert_insert_success'), lang('menu_user')));
            }

            echo json_encode(array(
                'flag' => 1,
                'msg' => $this->session->flashdata('message'),
                'type' => 'success',
            ));
            exit;
        }

        if ($id)
            $this->session->set_flashdata('error', sprintf(lang('alert_update_fail'), lang('menu_user')));
        else
            $this->session->set_flashdata('error', sprintf(lang('alert_insert_fail'), lang('menu_user')));

        echo json_encode(array(
            'flag' => 0,
            'msg' => $this->session->flashdata('error'),
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
        $result = $this->users_model->get_users_by_id($id);

        if (empty($result)) {
            $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), lang('menu_user')));
            redirect('admin/users');
        }

        $data['users'] = $result;

        // Get active sessions for this user
        $data['user_sessions'] = $this->user_sessions_model->get_active($id);

        /* Load Template */
        $content['content'] = $this->load->view('admin/system/users/view', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * status_update
     */
    public function status_update()
    {
        if (!$this->acl->get_method_permission($_SESSION['groups_id'], 'users', 'p_edit')) {
            echo '<p>' . sprintf(lang('manage_acl_permission_no'), lang('manage_acl_edit')) . '</p>';
            exit;
        }

        /* Validate form input */
        $this->form_validation
            ->set_rules('id', sprintf(lang('alert_id'), lang('menu_user')), 'required|numeric')
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
        $data['active'] = $this->input->post('status');

        // users can only edit non-admins
        if (!$this->ion_auth->is_admin() && !$this->ion_auth->is_admin($id)) {
            echo '<p>' . lang('users_only_admin_can') . '</p>';
            exit;
        }

        if ($id === 1) {
            echo '<p>' . lang('users_super_admin_no_status') . '</p>';
            exit;
        }

        if (empty($id)) {
            $this->session->set_flashdata('message', sprintf(lang('alert_not_found'), lang('menu_user')));
            echo json_encode(array(
                'flag' => 0,
                'msg' => $this->session->flashdata('message'),
                'type' => 'fail',
            ));
            exit;
        }

        $flag = $this->users_model->save_users($data, $id);

        if ($flag) {
            echo json_encode(array(
                'flag' => 1,
                'msg' => sprintf(lang('alert_status_success'), lang('menu_user')),
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => sprintf(lang('alert_status_fail'), lang('menu_user')),
            'type' => 'fail',
        ));
        exit;

    }

    /**
     * delete
     */
    public function delete($id = NULL)
    {
        if (!$this->ion_auth->is_admin()) {
            echo '<p>' . lang('users_only_admin_can') . '</p>';
            exit;
        }

        /* Validate form input */
        $this->form_validation->set_rules('id', sprintf(lang('alert_id'), lang('menu_user')), 'required|numeric');

        /* Get Data */
        $id = (int) $this->input->post('id');
        $result = $this->users_model->get_users_by_id($id);

        if ($id === 1) {
            echo '<p>' . lang('users_super_admin_no_delete') . '</p>';
            exit;
        }

        if (empty($result)) {
            echo json_encode(array(
                'flag' => 0,
                'msg' => sprintf(lang('alert_not_found'), lang('menu_user')),
                'type' => 'fail',
            ));
            exit;
        }

        if (get_domain() !== 'classiebit.com')
            $flag = $this->ion_auth->delete_user($id);
        else
            $flag = 0;

        if ($flag) {

            // Remove image
            if (!empty($result->image))
                $this->file_uploads->remove_file('./upload/users/images/', $result->image);

            echo json_encode(array(
                'flag' => 1,
                'msg' => sprintf(lang('alert_delete_success'), lang('menu_user')),
                'type' => 'success',
            ));
            exit;
        }

        echo json_encode(array(
            'flag' => 0,
            'msg' => get_domain() !== 'classiebit.com' ? sprintf(lang('alert_delete_fail'), lang('menu_user')) : lang('demo_mode_user'),
            'type' => 'fail',
        ));
        exit;
    }


    /**
     * Unlock Device
     */
    public function unlock_device($id = NULL)
    {
        if (!$this->ion_auth->is_admin()) {
            echo '<p>' . lang('users_only_admin_can') . '</p>';
            exit;
        }

        $id = (int) $id;
        if (empty($id)) {
            $this->session->set_flashdata('error', sprintf(lang('alert_not_found'), lang('menu_user')));
            redirect('admin/users');
        }

        if ($this->users_model->reset_device_lock($id)) {
            $this->session->set_flashdata('message', 'User device has been unlocked successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to unlock user device.');
        }
        redirect('admin/users');
    }

    /**
     * Terminate a specific session for a user
     */
    public function terminate_session($user_id = NULL, $session_id = NULL)
    {
        if (!$this->ion_auth->is_admin()) {
            echo '<p>' . lang('users_only_admin_can') . '</p>';
            exit;
        }

        $user_id = (int) $user_id;
        $session_id = (int) $session_id;

        if (empty($user_id) || empty($session_id)) {
            $this->session->set_flashdata('error', 'Invalid session or user.');
            redirect('admin/users');
        }

        if ($this->user_sessions_model->terminate($session_id, $user_id)) {
            $this->session->set_flashdata('message', 'Session terminated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to terminate session.');
        }

        redirect('admin/users/view/' . $user_id);
    }

    /**
     * Terminate all sessions for a user
     */
    public function terminate_all_sessions($user_id = NULL)
    {
        if (!$this->ion_auth->is_admin()) {
            echo '<p>' . lang('users_only_admin_can') . '</p>';
            exit;
        }

        $user_id = (int) $user_id;

        if (empty($user_id)) {
            $this->session->set_flashdata('error', 'Invalid user.');
            redirect('admin/users');
        }

        $this->user_sessions_model->deactivate_all($user_id);
        $this->session->set_flashdata('message', 'All sessions for this user have been terminated.');

        redirect('admin/users/sessions');
    }

    /**
     * User Sessions List View
     */
    public function sessions()
    {
        /* Initialize assets */
        $this->include_index_plugins();
        $data = $this->includes;

        $data['total_sessions'] = $this->db->count_all('user_sessions');
        $data['active_sessions'] = $this->db->where('is_active', 1)->count_all_results('user_sessions');
        $data['multidevice_users'] = $this->user_sessions_model->count_multidevice_users();
        $data['locked_users'] = $this->user_sessions_model->count_locked_users();

        $data['t_headers'] = array(
            '<input type="checkbox" id="select_all_sessions" class="filled-in chk-col-indigo"><label for="select_all_sessions" style="margin-bottom:0;"></label>',
            '#',
            'User',
            'Active Connections',
            'Total Recorded',
            'Lock Status',
            'Last Active',
            'Action',
        );

        /* Load View */
        $content['content'] = $this->load->view('admin/system/users/sessions', $data, TRUE);
        $this->load->view($this->template, $content);
    }

    /**
     * ajax_sessions_list (Grouped by User)
     */
    public function ajax_sessions_list()
    {
        $start = $this->input->post('start') !== NULL ? (int)$this->input->post('start') : 0;
        $length = $this->input->post('length') !== NULL ? (int)$this->input->post('length') : 10;
        $search_post = $this->input->post('search');
        $search = isset($search_post['value']) ? $search_post['value'] : '';
        $order_post = $this->input->post('order');

        $status_filter = $this->input->post('status_filter') ? $this->input->post('status_filter') : 'all';
        $role_filter = $this->input->post('role_filter') ? $this->input->post('role_filter') : 'all';

        $orders = array();
        $columns_map = array(
            1 => 'users.id',
            2 => 'users.first_name',
            3 => 'active_count',
            4 => 'total_count',
            5 => 'users.device_locked',
            6 => 'max_last_activity',
        );

        if ($order_post) {
            foreach ($order_post as $o) {
                if (isset($columns_map[$o['column']])) {
                    $orders[$columns_map[$o['column']]] = $o['dir'];
                }
            }
        }

        $list = $this->user_sessions_model->get_user_grouped_sessions_dt($length, $start, $orders, $search, $status_filter, $role_filter);

        $data = array();
        $no = $start;

        foreach ($list as $val) {
            $no++;
            $row = array();
            
            // Bulk Checkbox
            $row[] = '<input type="checkbox" id="sess_chk_' . $val->user_id . '" class="filled-in chk-col-indigo session-user-checkbox" value="' . $val->user_id . '"><label for="sess_chk_' . $val->user_id . '" style="margin-bottom:0;"></label>';
            $row[] = $no;

            // User Info
            $user_img = !empty($val->image) ? base_url('upload/users/images/' . $val->image) : base_url('themes/admin/img/avatar2.png');
            $user_name = !empty($val->first_name) ? $val->first_name . ' ' . $val->last_name : 'Unknown User';
            $user_html = '<div style="display:flex; align-items:center; gap:10px;">';
            $user_html .= '<img src="' . $user_img . '" style="width:36px; height:36px; border-radius:50%; object-fit:cover;" onerror="this.onerror=null;this.src=\'' . base_url('themes/admin/img/avatar2.png') . '\';">';
            $user_html .= '<div><div style="font-weight:700; color:#1e293b;">' . htmlspecialchars($user_name) . '</div><div style="font-size:12px; color:#64748b;">' . htmlspecialchars($val->email) . '</div></div>';
            $user_html .= '</div>';
            $row[] = $user_html;

            // Active Connections Count
            if ($val->active_count > 0) {
                $badge_class = ($val->active_count > 1) ? 'bg-amber-soft color-amber' : 'bg-emerald-soft color-emerald';
                $row[] = '<span class="badge-premium ' . $badge_class . '" style="font-weight:700; font-size:12px;"><i class="material-icons" style="font-size:15px; vertical-align:middle; margin-right:2px;">wifi_tethering</i> ' . $val->active_count . ' Active</span>';
            } else {
                $row[] = '<span class="badge-premium bg-slate-soft color-slate">0 Active</span>';
            }

            // Total Sessions Recorded
            $row[] = '<span style="font-weight:600; color:#475569;">' . $val->total_count . ' Sessions</span>';

            // Learning Lock Status
            if ($val->device_locked) {
                $row[] = '<span class="badge-premium bg-rose-soft color-rose" style="font-weight:700;"><i class="material-icons" style="font-size:14px; vertical-align:middle;">lock</i> Locked</span>';
            } else {
                $row[] = '<span class="badge-premium bg-emerald-soft color-emerald"><i class="material-icons" style="font-size:14px; vertical-align:middle;">lock_open</i> Normal</span>';
            }

            // Last Active
            $row[] = '<span style="font-size:13px; color:#64748b;">' . time_elapsed_string($val->max_last_activity) . '</span>';

            // Action
            $actions = '<button type="button" class="btn btn-sm btn-default view-sessions-btn" data-userid="' . $val->user_id . '" data-username="' . htmlspecialchars($user_name) . '" style="border-radius:8px; font-weight:600; color:#4f46e5; border:1px solid #c7d2fe; background:#eef2ff;"><i class="material-icons" style="font-size:16px; vertical-align:middle;">pageview</i> View Sessions</button>';
            
            if ($val->device_locked || $val->active_count > 0) {
                $actions .= ' <a href="' . site_url('admin/users/release_lock/' . $val->user_id) . '" class="btn btn-sm btn-success" style="border-radius:8px; font-weight:600;" onclick="return confirm(\'Release lock and clear all active sessions for ' . htmlspecialchars($user_name) . '?\');"><i class="material-icons" style="font-size:16px; vertical-align:middle;">lock_open</i> Release Lock</a>';
            }

            $row[] = $actions;
            $data[] = $row;
        }

        $output = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $this->user_sessions_model->count_all_grouped_users(),
            "recordsFiltered" => $this->user_sessions_model->count_filtered_grouped_users($search),
            "data" => $data,
        );

        echo json_encode($output);
    }

    /**
     * Release device lock and terminate all sessions for a user
     */
    public function release_lock($user_id = NULL)
    {
        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Only administrators can perform this action.');
            redirect('admin/users/sessions');
        }

        $user_id = (int) $user_id;
        if (!empty($user_id)) {
            // 1. Release lock in users table
            $this->db->where('id', $user_id)->update('users', array('device_locked' => 0, 'last_session_id' => NULL));

            // 2. Deactivate all active sessions in user_sessions
            $this->user_sessions_model->deactivate_all($user_id);

            // 3. Purge session table entries
            $this->db->like('data', 'user_id|s:' . strlen($user_id) . ':"' . $user_id . '";');
            $this->db->delete('ce_sessn');

            $this->session->set_flashdata('message', 'Device lock released and all active sessions cleared for the user.');
        }

        redirect('admin/users/sessions');
    }

    /**
     * Bulk Release device lock and terminate active sessions for multiple users
     */
    public function bulk_release_lock()
    {
        if (!$this->ion_auth->is_admin()) {
            echo json_encode(array('status' => FALSE, 'msg' => 'Only administrators can perform this action.'));
            return;
        }

        $user_ids = $this->input->post('user_ids');
        if (empty($user_ids) || !is_array($user_ids)) {
            echo json_encode(array('status' => FALSE, 'msg' => 'No users selected.'));
            return;
        }

        $count = 0;
        foreach ($user_ids as $id) {
            $user_id = (int) $id;
            if ($user_id > 0) {
                // 1. Release lock in users table
                $this->db->where('id', $user_id)->update('users', array('device_locked' => 0, 'last_session_id' => NULL));

                // 2. Deactivate all active sessions in user_sessions
                $this->user_sessions_model->deactivate_all($user_id);

                // 3. Purge session table entries
                $this->db->like('data', 'user_id|s:' . strlen($user_id) . ':"' . $user_id . '";');
                $this->db->delete('ce_sessn');

                $count++;
            }
        }

        echo json_encode(array(
            'status' => TRUE,
            'msg' => 'Successfully released lock and cleared active sessions for ' . $count . ' user(s).'
        ));
    }

    /**
     * Get user session details for Modal view
     */
    public function ajax_user_sessions_modal($user_id = NULL)
    {
        if (!$user_id) {
            echo json_encode(array('status' => FALSE, 'msg' => 'Invalid User ID'));
            return;
        }

        $this->load->model('users_model');
        $user = $this->users_model->get_users_by_id($user_id);
        $sessions = $this->user_sessions_model->get_all_sessions_by_user($user_id);

        $html = $this->load->view('admin/system/users/sessions_modal', array(
            'user' => $user,
            'sessions' => $sessions
        ), TRUE);

        echo json_encode(array('status' => TRUE, 'html' => $html, 'user_name' => $user ? $user->first_name . ' ' . $user->last_name : 'User'));
    }

    /**
     * Login as User (Impersonate)
     */
    public function login_as_user($id = NULL)
    {
        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Only administrators can perform this action.');
            redirect('admin/users');
        }

        $id = (int) $id;
        if (empty($id)) {
            $this->session->set_flashdata('error', 'Invalid user specified.');
            redirect('admin/users');
        }

        $target_user = $this->users_model->get_users_by_id($id, TRUE);
        if (empty($target_user)) {
            $this->session->set_flashdata('error', 'User not found.');
            redirect('admin/users');
        }

        // Store original admin session if not already impersonating
        if (empty($_SESSION['impersonator'])) {
            $_SESSION['impersonator'] = array(
                'user_id'   => $this->session->userdata('user_id'),
                'logged_in' => $this->session->userdata('logged_in'),
                'groups_id' => isset($_SESSION['groups_id']) ? $_SESSION['groups_id'] : NULL,
                'identity'  => $this->session->userdata('identity'),
                'email'     => $this->session->userdata('email'),
            );
        }

        $this->load->model('ion_auth_model');

        // Set target user session
        $group = $this->ion_auth->get_users_groups($id)->row();
        $_SESSION['groups_id'] = $group ? $group->id : 3;

        $user_obj = $this->ion_auth->user($id)->row();
        if ($user_obj) {
            $this->ion_auth_model->set_session($user_obj);
        }

        $this->session->set_userdata('logged_in', $target_user);
        $this->users_model->save_users(['last_session_id' => session_id()], $id);

        // Record session
        $this->load->model('user_sessions_model');
        $this->user_sessions_model->create($id);

        $this->session->set_flashdata('message', 'You are now logged in as ' . ucwords($target_user['first_name'] . ' ' . $target_user['last_name']));

        // Redirect based on target user role
        if (isset($target_user['role']) && $target_user['role'] == 1) {
            redirect(site_url('/admin'));
        } else {
            redirect(site_url('/courses/my_courses'));
        }
    }

    /**
     * Switch Back to Admin Account
     */
    public function switch_back()
    {
        if (!empty($_SESSION['impersonator'])) {
            $admin_data = $_SESSION['impersonator'];

            $this->session->set_userdata('logged_in', $admin_data['logged_in']);
            $this->session->set_userdata('user_id', $admin_data['user_id']);
            $this->session->set_userdata('identity', $admin_data['identity']);
            $this->session->set_userdata('email', $admin_data['email']);
            $_SESSION['groups_id'] = $admin_data['groups_id'];

            unset($_SESSION['impersonator']);

            $this->session->set_flashdata('message', 'Switched back to your administrator account.');
            redirect('admin/users');
        } else {
            redirect('admin/users');
        }
    }
}



/* Users controller ends */