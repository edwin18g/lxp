<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Courses Model
 *
 * This model handles courses module data
 *
 * @package     classiebit
 * @author      prodpk
*/

class Courses_model extends CI_Model {

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
                        ->where(array('parent_id'=>0, 'status !='=>0))
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
    var $i          = 0;
    public function get_courses_levels($course_categories_id) 
    {
        $data = $this->db->select(array('id', 'title', 'parent_id'))
                         ->where(array('id'=>$course_categories_id, 'status !='=>'0'))
                         ->get('course_categories')
                         ->result_array();

        if(count($data))
        {
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
                        ->where(array('id'=>$id))
                        ->get($this->table)->row();
        
    }
    public function get_lecture_courses_by_id($id = FALSE)
    {
        return $this->db->select('*')
                        ->where(array('id'=>$id))
                        ->get('course_lecture')->row();
        
    }
    public function get_user_dropdown($param = array())
    {
       
        $limit              = isset($param['limit']) ? $param['limit'] : false;
        $offset             = isset($param['offset']) ? $param['offset'] : 0;
        $order_by           = isset($param['order_by']) ? $param['order_by'] : 'users.id';
        $direction          = isset($param['direction']) ? $param['direction'] : 'DESC';
        $status             = isset($param['status']) ? $param['status'] : '';
        $count              = isset($param['count']) ? $param['count'] : false;
        $not_deleted        = isset($param['not_deleted']) ? $param['not_deleted'] : false;
        $user_ids           = isset($param['user_ids']) ? $param['user_ids'] : array();
        $keyword            = isset($param['keyword']) ? $param['keyword'] : '';
        $course_id 		    = isset($param['course_id'])?$param['course_id']:0;
        
        $select             = isset($param['select'])?$param['select']:false;
        if($count === true)
        {
            $select         = 'users.id';
        }

        if(!$select)
        {
            $select = 'users.*';
        }
        
        $this->db->select($select);

        
        $this->db->order_by("id", "desc");
        if ($limit) {
            $this->db->limit($limit, $offset);
        }

       
        if ($keyword) 
        {
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
             $this->db->or_like(['first_name' => $keyword,'last_name' => $keyword]);
        }

        
      

        $this->db->where('role',3);
        $this->db->where('users.id NOT IN (select cs_user_id from course_subscription where cs_course_id	 = '.$course_id.')',NULL,FALSE);

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
        return $this->db->select('*')->where('role',3)
                        ->where('users.id NOT IN (select cs_user_id from course_subscription where cs_course_id	 = '.$param['course_id'].')',NULL,FALSE)->limit('50')->order_by("first_name", "asc")
                        ->get('users')->result_array();
        
    }
    function get_leture_by_course_id($id = FALSE)
    {
        
        return $this->db->select('*')
                        ->where('cl_course_id',$id)
                        ->get('course_lecture')->result_array();
        
    }
    /**
     * save_courses
     *
     * @return array
     * 
     **/
    public function save_courses_lecture($data = array(), $id = FALSE)
    {
        if($id) // update
        {
            $this->db->where(array('id'=>$id))
                     ->update('course_lecture', $data);
            return $id;
        }
        else // insert
        {
            $this->db->insert('course_lecture', $data);
            return $this->db->insert_id();
        }
        
    }
    public function save_courses($data = array(), $id = FALSE)
    {
        if($id) // update
        {
            $this->db->where(array('id'=>$id))
                     ->update($this->table, $data);
            return $id;
        }
        else // insert
        {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }
        
    }
    public function save_lecture($data = array(), $id = FALSE)
    {
        if($id) // update
        {
            $this->db->where(array('id'=>$id))
                     ->update('course_lecture', $data);
            return $id;
        }
        else // insert
        {
            $this->db->insert('course_lecture', $data);
            return $this->db->insert_id();
        }
        
    }
    public function save_suscription($data = array(), $id = FALSE)
    {
        if($id) // update
        {
            $this->db->where(array('id'=>$id))
                     ->update('course_subscription', $data);
            return $id;
        }
        else // insert
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
        if($id) // update
        {
            $this->db->delete($this->table, array('id' => $id, 'title'=>$title)); 
        }
        
        return $id;
    }
    public function delete_suscription($id = NULL, $title = NULL)
    {
        if($id) // update
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
                        ->where(array('parent_id'=>$id, 'status !='=>'0'))
                        ->get('course_categories')
                        ->result();
    }

}

/*Courses model ends*/