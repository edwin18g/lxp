<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sliders Model
 *
 * This model handles sliders module data
 *
 * @package     classiebit
 * @author      prodpk
 */

class Sliders_model extends CI_Model
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @vars
     */
    private $table = 'sliders';

    /**
     * get_sliders
     *
     * @return array
     * 
     */
    public function get_sliders()
    {
        return $this->db->select(array(
            "$this->table.id",
            "$this->table.title",
            "$this->table.subtitle",
            "$this->table.button_text",
            "$this->table.button_link",
            "$this->table.image",
            "$this->table.order_index",
            "$this->table.status",
            "$this->table.date_added",
            "$this->table.date_updated",
        ))
            ->order_by('order_index', 'ASC')
            ->get($this->table)
            ->result();

    }

    /**
     * get_active_sliders
     *
     * @return array
     * 
     */
    public function get_active_sliders()
    {
        return $this->db->select(array(
            "$this->table.id",
            "$this->table.title",
            "$this->table.subtitle",
            "$this->table.button_text",
            "$this->table.button_link",
            "$this->table.image",
            "$this->table.order_index",
        ))
            ->where('status', 1)
            ->order_by('order_index', 'ASC')
            ->get($this->table)
            ->result();
    }

    /**
     * get_slider_by_id
     *
     * @return object
     * 
     */
    public function get_slider_by_id($id = FALSE)
    {
        return $this->db->select(array(
            "$this->table.id",
            "$this->table.title",
            "$this->table.subtitle",
            "$this->table.button_text",
            "$this->table.button_link",
            "$this->table.image",
            "$this->table.order_index",
            "$this->table.status",
            "$this->table.date_added",
            "$this->table.date_updated",
        ))
            ->where(array('id' => $id))
            ->get($this->table)
            ->row();

    }

    /**
     * save_slider
     *
     * @return int
     * 
     */
    public function save_slider($data = array(), $id = FALSE)
    {
        if ($id) // update
        {
            $this->db->where(array('id' => $id))
                ->update($this->table, $data);
            return $id;
        } else // insert
        {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }

    }

    /**
     * delete_slider
     *
     * @return bool
     * 
     */
    public function delete_slider($id = NULL)
    {
        if ($id)
            $this->db->delete($this->table, array('id' => $id));

        if ($this->db->affected_rows())
            return TRUE;

        return FALSE;
    }

}

/* Sliders model ends */
