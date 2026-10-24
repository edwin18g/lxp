<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library Datatables
 *
 * This library handles datatables related functionality
 *
 * @package     Classes
 * @author      DK
 **/

class Datatables
{

    /**
     * @vars
     */
    var $table = '';
    var $columns = array(); // columns to select
    var $column_order = array(); // columns fetch order
    var $column_search = array(); // columns for search
    var $order = array(); // default order     
    var $sort_table2 = '';      // order by other table
    var $CI_LIB;                // CI instance (declared to avoid PHP 8.2 dynamic property deprecation)

    function __construct()
    {
        $this->CI_LIB =& get_instance();
    }

    /**
     * get_datatables
     *
     * @return array
     * 
     **/
    public function get_datatables($table = '', $columns = array(), $column_order = array(), $column_search = array(), $order = array(), $where = array(), $sort_table2 = '')
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->column_order = $column_order;
        $this->column_search = $column_search;
        $this->order = $order;
        $this->sort_table2 = $sort_table2;

        $this->_get_datatables_query();

        if ($this->CI_LIB->input->post('length') != -1)
            $this->CI_LIB->db->limit($this->CI_LIB->input->post('length'), $this->CI_LIB->input->post('start'));

        if (!empty($where))
            $this->CI_LIB->db->where($where);

        return $this->CI_LIB->db->get()
            ->result();
    }

    /**
     * _get_datatables_query
     *
     * @return array
     * 
     **/
    private function _get_datatables_query()
    {
        $this->CI_LIB->db->select($this->columns)
            ->from($this->table);

        if ($this->sort_table2) // join the other table in case of order by other table
            if ($this->sort_table2 === 'group_id') // join the users_groups table 
                $this->CI_LIB->db->join('users_groups', 'users.id = users_groups.user_id');

        $i = 0;

        if (empty($this->column_search))
            $this->column_search = array();

        foreach ($this->column_search as $item) // loop column 
        {
            $search_data = $this->CI_LIB->input->post('search');
            if (isset($search_data['value']) && $search_data['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->CI_LIB->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->CI_LIB->db->like($item, $this->CI_LIB->input->post('search')['value']);
                } else {
                    $this->CI_LIB->db->or_like($item, $this->CI_LIB->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->CI_LIB->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            if ($this->sort_table2) // in case of order by other table
            {
                if ($this->sort_table2 === 'group_id') // order by group_id in users table
                    $this->CI_LIB->db->order_by('users_groups.group_id', $this->CI_LIB->input->post('order')['0']['dir']);
            } else // default case
            {
                // Ignore unknown/blank sort columns (e.g. image or action columns) instead of erroring
                $order_post = $this->CI_LIB->input->post('order');
                $col_index = isset($order_post[0]['column']) ? (int) $order_post[0]['column'] : -1;
                $col = isset($this->column_order[$col_index]) ? $this->column_order[$col_index] : '';
                $dir = (isset($order_post[0]['dir']) && strtolower($order_post[0]['dir']) === 'asc') ? 'ASC' : 'DESC';
                if ($col !== '') {
                    $this->CI_LIB->db->order_by($col, $dir);
                } elseif (!empty($this->order)) {
                    $this->CI_LIB->db->order_by(key($this->order), current($this->order));
                }
            }

        } else if (isset($this->order)) {
            $order = $this->order;
            $this->CI_LIB->db->order_by(key($order), $order[key($order)]);
        }
    }


    /**
     * count_filtered
     *
     * @return array
     * 
     **/
    public function count_filtered($where = array())
    {
        $this->_get_datatables_query();

        if (!empty($where))
            $this->CI_LIB->db->where($where);

        // COUNT(*) in the database instead of fetching every matching row (with all selected columns
        // and subqueries) just to call num_rows(). count_all_results() drops the ORDER BY for us.
        return (int) $this->CI_LIB->db->count_all_results();
    }

    /**
     * count_all
     *
     * @return array
     * 
     **/
    public function count_all($where = array())
    {
        if (!empty($where))
            $this->CI_LIB->db->where($where);

        return $this->CI_LIB->db->from($this->table)
            ->count_all_results();
    }

}
/* End Datatables Library */