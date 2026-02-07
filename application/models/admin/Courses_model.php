<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Courses Model
 *
 * This model handles courses module data
 *
 * @package     classiebit
 * @author      prodpk
 */

class Courses_model extends CI_Model
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
    private $table = 'courses';

    /**
     * get_course_categories_dropdown
     *
     * @return array
     * 
     **/
    public function get_course_categories_dropdown()
    {
        return $this->db->select(array('id', 'title'))
            ->where(array('parent_id' => 0, 'status !=' => 0))
            ->order_by('parent_id')
            ->get('course_categories')
            ->result();
    }

    /**
     * get_courses_levels
     *
     * @return array
     * 
     **/
    var $categories = array();
    var $i = 0;
    public function get_courses_levels($course_categories_id)
    {
        $data = $this->db->select(array('id', 'title', 'parent_id'))
            ->where(array('id' => $course_categories_id, 'status !=' => '0'))
            ->get('course_categories')
            ->result_array();

        if (count($data)) {
            $this->categories[$this->i] = $data[0];
            $this->i++;

            $this->get_courses_levels($data[0]['parent_id']);
        }

        return $this->categories;

    }

    /**
     * get_courses
     *
     * @return array
     * 
     **/
    public function get_courses_by_id($id = FALSE)
    {
        return $this->db->select(array(
            "$this->table.id",
            "$this->table.title",
            "$this->table.description",
            "$this->table.meta_title",
            "$this->table.meta_tags",
            "$this->table.meta_description",
            "$this->table.featured",
            "$this->table.status",
            "$this->table.images",
            "$this->table.course_categories_id",
            "$this->table.date_added",
            "$this->table.date_updated",
        ))
            ->where(array('id' => $id))
            ->get($this->table)->row();

    }
    public function get_lecture_courses_by_id($id = FALSE)
    {
        return $this->db->select('*')
            ->where(array('id' => $id))
            ->get('course_lecture')->row();

    }
    public function get_user_dropdown($param = array())
    {

        $limit = isset($param['limit']) ? $param['limit'] : false;
        $offset = isset($param['offset']) ? $param['offset'] : 0;
        $order_by = isset($param['order_by']) ? $param['order_by'] : 'users.id';
        $direction = isset($param['direction']) ? $param['direction'] : 'DESC';
        $status = isset($param['status']) ? $param['status'] : '';
        $count = isset($param['count']) ? $param['count'] : false;
        $not_deleted = isset($param['not_deleted']) ? $param['not_deleted'] : false;
        $user_ids = isset($param['user_ids']) ? $param['user_ids'] : array();
        $keyword = isset($param['keyword']) ? $param['keyword'] : '';
        $course_id = isset($param['course_id']) ? $param['course_id'] : 0;

        $select = isset($param['select']) ? $param['select'] : false;
        if ($count === true) {
            $select = 'users.id';
        }

        if (!$select) {
            $select = 'users.*';
        }

        $this->db->select($select);


        $this->db->order_by("id", "desc");
        if ($limit) {
            $this->db->limit($limit, $offset);
        }


        if ($keyword) {
            // $this->db->group_start();
            // if(strpos($keyword, ','))
            // {
            //     $group_keyword      =   explode(',', str_replace(array(', ', ' , ', ' ,'),',', $keyword));
            //     if(!empty($group_keyword))
            //     {
            //         $group_query         = "first_name LIKE '%".trim($group_keyword[0])."%' ";
            //         $group_query        .= " OR mobile LIKE '%".trim($group_keyword[0])."%'";

            //         for($i = 0; $i < count($group_keyword); $i++)
            //         {
            //             if(isset($group_keyword[$i]) && !empty($group_keyword[$i]) && $i > 0)
            //             {
            //                 $group_query .= " OR first_name LIKE '%".trim($group_keyword[$i])."%'";
            //                 $group_query .= " OR mobile LIKE '%".trim($group_keyword[$i])."%'";
            //             }
            //         }
            //         $this->db->where($group_query);
            //     }
            // }
            // else
            // {

            // }


            // $this->db->group_end();
            $this->db->or_like(['first_name' => $keyword, 'last_name' => $keyword]);
        }




        $this->db->where('role', 3);
        $this->db->where('users.id NOT IN (select cs_user_id from course_subscription where cs_course_id	 = ' . $course_id . ')', NULL, FALSE);

        // return $this->db->select('*')
        //                 ->limit('50')->order_by("first_name", "asc")
        //                 ->get('users')->result_array();
        if ($count) {
            $query = $this->db->get('users');
            $result = $query->num_rows();
        } else {
            $result = $this->db->get('users')->result_array();
        }
        //  echo $this->db->last_query();//exit;
        return $result;
    }
    function get_user_dropdown_old($param)
    {
        return $this->db->select('*')->where('role', 3)
            ->where('users.id NOT IN (select cs_user_id from course_subscription where cs_course_id	 = ' . $param['course_id'] . ')', NULL, FALSE)->limit('50')->order_by("first_name", "asc")
            ->get('users')->result_array();

    }
    function get_leture_by_course_id($id = FALSE)
    {
        return $this->db->select('*')
            ->where('cl_course_id', $id)
            ->order_by('sort_order', 'ASC')
            ->get('course_lecture')->result_array();
    }

    public function get_sections($course_id)
    {
        return $this->db->where('course_id', $course_id)
            ->order_by('sort_order', 'ASC')
            ->get('course_sections')
            ->result_array();
    }

    public function get_curriculum($course_id)
    {
        $sections = $this->get_sections($course_id);

        // If no sections execute, create a default one and move existing lectures to it? 
        // For now, let's just return what we have. If a lecture has section_id=0, it might be "Uncategorized"

        $curriculum = [];

        // 1. Get all sections
        foreach ($sections as $section) {
            $section['lectures'] = $this->db->select('*')
                ->where('cl_course_id', $course_id)
                ->where('section_id', $section['id'])
                ->order_by('sort_order', 'ASC')
                ->get('course_lecture')
                ->result_array();
            $curriculum[] = $section;
        }

        // 2. Get logic for "Uncategorized" lectures (section_id = 0)
        $uncategorized = $this->db->select('*')
            ->where('cl_course_id', $course_id)
            ->where('section_id', 0)
            ->order_by('sort_order', 'ASC')
            ->get('course_lecture')
            ->result_array();

        if (!empty($uncategorized)) {
            // Check if we should auto-create a default section or just append
            // For this UI, we might want to force everything into a section, but for now let's return them
            array_unshift($curriculum, [
                'id' => 0,
                'title' => 'General / Uncategorized',
                'sort_order' => -1,
                'lectures' => $uncategorized
            ]);
        }

        return $curriculum;
    }

    public function save_section($data, $id = FALSE)
    {
        if ($id) {
            $this->db->where('id', $id)->update('course_sections', $data);
            return $id;
        } else {
            // Get max sort order
            $query = $this->db->where('course_id', $data['course_id'])->select_max('sort_order')->get('course_sections');
            $row = $query->row();
            $max_order = ($row && isset($row->sort_order)) ? $row->sort_order : 0;

            $data['sort_order'] = $max_order + 1;

            $this->db->insert('course_sections', $data);
            return $this->db->insert_id();
        }
    }

    public function delete_section($id)
    {
        // Option 1: Delete lectures? 
        // Option 2: Move lectures to generic?
        // Let's delete the section and set lectures' section_id to 0
        $this->db->where('section_id', $id)->update('course_lecture', ['section_id' => 0]);
        return $this->db->delete('course_sections', ['id' => $id]);
    }

    public function course_exists($course_id)
    {
        return $this->db->where('id', $course_id)->count_all_results('courses') > 0;
    }

    public function section_exists($course_id, $title, $exclude_id = null)
    {
        $this->db->where('course_id', $course_id);
        $this->db->where('title', $title);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('course_sections') > 0;
    }
    /**
     * save_courses
     *
     * @return array
     * 
     **/
    public function save_courses_lecture($data = array(), $id = FALSE)
    {
        if ($id) // update
        {
            $this->db->where(array('id' => $id))
                ->update('course_lecture', $data);
            return $id;
        } else // insert
        {
            $this->db->insert('course_lecture', $data);
            return $this->db->insert_id();
        }

    }
    public function save_courses($data = array(), $id = FALSE)
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
    public function save_lecture($data = array(), $id = FALSE)
    {
        if ($id) // update
        {
            $this->db->where(array('id' => $id))
                ->update('course_lecture', $data);
            return $id;
        } else // insert
        {
            $this->db->insert('course_lecture', $data);
            return $this->db->insert_id();
        }

    }
    public function save_suscription($data = array(), $id = FALSE)
    {
        if ($id) // update
        {
            $this->db->where(array('id' => $id))
                ->update('course_subscription', $data);
            return $id;
        } else // insert
        {
            $this->db->insert('course_subscription', $data);
            return $this->db->insert_id();
        }

    }
    /**
     * delete_courses
     *
     * @return array
     * 
     **/
    public function delete_courses($id = NULL, $title = NULL)
    {
        if ($id) // update
        {
            $this->db->delete($this->table, array('id' => $id, 'title' => $title));
        }

        return $id;
    }
    public function delete_suscription($id = NULL, $title = NULL)
    {
        if ($id) // update
        {
            $this->db->delete('course_subscription', array('id' => $id));
        }

        return $id;
    }


    /**
     * get_course_categories_levels
     *
     * @return array
     * 
     **/
    public function get_course_categories_levels($id = NULL)
    {
        return $this->db->select(array('id', 'title'))
            ->where(array('parent_id' => $id, 'status !=' => '0'))
            ->get('course_categories')
            ->result();
    }

    /**
     * count_all_courses
     */
    public function count_all_courses()
    {
        return $this->db->count_all($this->table);
    }

    /**
     * count_active_courses
     */
    public function count_active_courses()
    {
        return $this->db->where('status', 1)->count_all_results($this->table);
    }

    /**
     * count_featured_courses
     */
    public function count_featured_courses()
    {
        return $this->db->where('featured', 1)->count_all_results($this->table);
    }

    /**
     * update_lecture_order
     */
    public function update_lecture_order($lectures, $section_id = 0)
    {
        if (empty($lectures))
            return false;
        foreach ($lectures as $order => $id) {
            $this->db->where('id', $id)->update('course_lecture', [
                'sort_order' => $order,
                'section_id' => $section_id
            ]);
        }
        return true;
    }

    public function update_section_order($sections)
    {
        if (empty($sections))
            return false;
        foreach ($sections as $order => $id) {
            $this->db->where('id', $id)->update('course_sections', ['sort_order' => $order]);
        }
        return true;
    }

}

/*Courses model ends*/