<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Settings Model
 *
 * This model handles settings module data
 *
 * @package     classiebit
 * @author      prodpk
*/

class Settings_model extends CI_Model {

    /**
     * @vars
     */
    private $_db;


    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // define primary table
        $this->_db = 'settings';
    }


    /**
     * Retrieve all settings
     *
     * @return array|null
     */
    function get_settings()
    {
        $this->_ensure_custom_settings();
        $results = NULL;

        $sql = "
            SELECT *
            FROM {$this->_db}
            ORDER BY sort_order ASC
        ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
            $results = $query->result_array();
        }

        return $results;
    }

    /**
     * Ensure all custom promo & alert settings exist in the database table
     */
    private function _ensure_custom_settings()
    {
        $defaults = array(
            'device_lock_enabled' => array(
                'setting_type' => 'home',
                'name' => 'device_lock_enabled',
                'input_type' => 'dropdown',
                'options' => "0|Disabled\n1|Enabled",
                'is_numeric' => '1',
                'show_editor' => '0',
                'input_size' => 'small',
                'translate' => '0',
                'help_text' => 'Enable or disable automatic device locking when a user logs in from multiple devices',
                'validation' => 'trim',
                'sort_order' => 118,
                'label' => 'Device Lock Security Feature Enabled',
                'value' => '1',
            ),
            'top_alert_enabled' => array(
                'setting_type' => 'home',
                'name' => 'top_alert_enabled',
                'input_type' => 'dropdown',
                'options' => "0|Disabled\n1|Enabled",
                'is_numeric' => '1',
                'show_editor' => '0',
                'input_size' => 'small',
                'translate' => '0',
                'help_text' => 'Enable or disable the top offer alert banner on the home page',
                'validation' => 'trim',
                'sort_order' => 119,
                'label' => 'Top Offer Alert Enabled',
                'value' => '1',
            ),
            'top_alert_btn_text' => array(
                'setting_type' => 'home',
                'name' => 'top_alert_btn_text',
                'input_type' => 'input',
                'options' => '',
                'is_numeric' => '0',
                'show_editor' => '0',
                'input_size' => 'small',
                'translate' => '0',
                'help_text' => 'Button text for the top offer alert bar',
                'validation' => 'trim',
                'sort_order' => 121,
                'label' => 'Top Offer Alert Button Text',
                'value' => 'Claim Offer',
            ),
            'top_alert_btn_url' => array(
                'setting_type' => 'home',
                'name' => 'top_alert_btn_url',
                'input_type' => 'input',
                'options' => '',
                'is_numeric' => '0',
                'show_editor' => '0',
                'input_size' => 'medium',
                'translate' => '0',
                'help_text' => 'Navigation URL or path for the top offer alert button',
                'validation' => 'trim',
                'sort_order' => 122,
                'label' => 'Top Offer Alert Button URL',
                'value' => 'courses',
            ),
            'promo_modal_enabled' => array(
                'setting_type' => 'home',
                'name' => 'promo_modal_enabled',
                'input_type' => 'dropdown',
                'options' => "0|Disabled\n1|Enabled",
                'is_numeric' => '1',
                'show_editor' => '0',
                'input_size' => 'small',
                'translate' => '0',
                'help_text' => 'Enable or disable the promotion modal on the landing page',
                'validation' => 'trim',
                'sort_order' => 176,
                'label' => 'Promotion Modal Enabled',
                'value' => '0',
            ),
            'promo_modal_title' => array(
                'setting_type' => 'home',
                'name' => 'promo_modal_title',
                'input_type' => 'input',
                'options' => '',
                'is_numeric' => '0',
                'show_editor' => '0',
                'input_size' => 'medium',
                'translate' => '0',
                'help_text' => 'Title displayed on the modal',
                'validation' => 'trim',
                'sort_order' => 177,
                'label' => 'Promotion Modal Title',
                'value' => 'Exclusive Offer',
            ),
            'promo_modal_content' => array(
                'setting_type' => 'home',
                'name' => 'promo_modal_content',
                'input_type' => 'textarea',
                'options' => '',
                'is_numeric' => '0',
                'show_editor' => '0',
                'input_size' => 'large',
                'translate' => '0',
                'help_text' => 'Content displayed on the modal',
                'validation' => 'trim',
                'sort_order' => 178,
                'label' => 'Promotion Modal Content',
                'value' => "Don't miss out on our latest courses and exclusive discounts. Enroll today and start your learning journey!",
            ),
            'promo_modal_image' => array(
                'setting_type' => 'home',
                'name' => 'promo_modal_image',
                'input_type' => 'file',
                'options' => '',
                'is_numeric' => '0',
                'show_editor' => '0',
                'input_size' => 'medium',
                'translate' => '0',
                'help_text' => 'Image displayed on the modal (Recommended size: 600x400)',
                'validation' => 'trim',
                'sort_order' => 179,
                'label' => 'Promotion Modal Image',
                'value' => '',
            ),
            'promo_modal_btn_text' => array(
                'setting_type' => 'home',
                'name' => 'promo_modal_btn_text',
                'input_type' => 'input',
                'options' => '',
                'is_numeric' => '0',
                'show_editor' => '0',
                'input_size' => 'small',
                'translate' => '0',
                'help_text' => 'Text for the call-to-action button',
                'validation' => 'trim',
                'sort_order' => 180,
                'label' => 'Modal Button Text',
                'value' => 'Browse Courses',
            ),
            'promo_modal_btn_url' => array(
                'setting_type' => 'home',
                'name' => 'promo_modal_btn_url',
                'input_type' => 'input',
                'options' => '',
                'is_numeric' => '0',
                'show_editor' => '0',
                'input_size' => 'medium',
                'translate' => '0',
                'help_text' => 'URL for the call-to-action button',
                'validation' => 'trim',
                'sort_order' => 181,
                'label' => 'Modal Button URL',
                'value' => 'courses',
            ),
        );

        foreach ($defaults as $setting_name => $setting_data) {
            $check = $this->db->select('id')->where('name', $setting_name)->get($this->_db)->row();
            if (!$check) {
                $this->db->insert($this->_db, $setting_data);
            }
        }
    }


    /**
     * Save changes to the settings
     *
     * @param  array $data
     * @param  int $user_id
     * @return boolean
     */
    function save_settings($data = array(), $user_id = NULL)
    {
        if ($data && $user_id)
        {
            $saved = FALSE;

            foreach ($data as $key => $value)
            {
                $sql = "
                    UPDATE {$this->_db}
                    SET value = " . ((is_array($value)) ? $this->db->escape(serialize($value)) : $this->db->escape($value)) . ",
                        last_update = '" . date('Y-m-d H:i:s') . "',
                        updated_by = " . $this->db->escape($user_id) . "
                    WHERE name = " . $this->db->escape($key) . "
                ";

                $this->db->query($sql);

                if ($this->db->affected_rows() > 0)
                {
                    $saved = TRUE;
                }
            }

            if ($saved)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * get setting row by name
    */
    function get_setting_by_name($name = NULL)
    {
        return $this->db->where(array('name'=>$name))
                        ->get('settings')
                        ->row();
    }

}

/*Settings model ends*/