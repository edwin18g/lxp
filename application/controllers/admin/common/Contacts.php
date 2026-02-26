<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contacts Controller
 *
 * This class handles contacts module functionality
 *
 * @package     classiebit
 * @author      prodpk
 */

class Contacts extends Admin_Controller
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // load the users model
        $this->load->model('contact_model');

        // Page Title
        $this->set_title(lang('menu_contacts'));
    }


    /**
     * index
     */
    /**
     * index
     */
    function index()
    {
        /* Initialize assets */
        $this->include_index_plugins();
        $data = $this->includes;

        // Fetch emails directly for mailbox view
        // Using existing model method get_all($limit, $offset, $filters, $sort, $dir)
        $emails_data = $this->contact_model->get_all(50, 0, array(), 'created', 'DESC');
        $data['emails'] = $emails_data['results'];
        $data['total_emails'] = $emails_data['total'];

        // load views
        $content['content'] = $this->load->view('admin/contacts/mailbox', $data, TRUE);
        $this->load->view($this->template, $content);
    }



    /**
     * Marks email message as read
     *
     * @param  int $id
     * @return boolean
     */
    public function read($id)
    {
        if ($id) {
            $read = $this->contact_model->read($id, $this->user['id']);

            if ($read) {
                $results['success'] = sprintf(lang('alert_update_success'), lang('menu_contact'));
            } else {
                $results['error'] = sprintf(lang('alert_update_fail'), lang('menu_contact'));
            }
        } else {
            $results['error'] = sprintf(lang('alert_update_fail'), lang('menu_contact'));
        }

        display_json($results);
        exit;
    }

}

/* Contacts controller ends */