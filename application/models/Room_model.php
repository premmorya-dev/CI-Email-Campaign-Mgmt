<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Room_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
        $status = $this->db->insert('room', $data);
        return $this->db->insert_id();

    }

    public function getRooms($data)
    {

        
        // $this->db->join('comments', 'comments.id = blogs.id');
        // $this->db->select('*');
        // $this->db->from('room');         
        // $this->db->where('room_no', $data['filter_room_no']);       
        // $this->db->where('room_name', $data['filter_room_name']);     
        // $this->db->limit($data['per_page'], $data['page']);
        // $query = $this->db->get();

        $sql = "select * from room ";

        $implode = [];

        if(isset($data['filter_room_no']) && $data['filter_room_no'] ){
            $implode[] = " room_no = '".  $data['filter_room_no'] . "' ";
        }

        if(isset($data['filter_room_name']) && $data['filter_room_name'] ){
            $implode[] = " room_name like '%".  $data['filter_room_name'] . "%'";
        }

        if(isset($data['filter_tenent_name']) && $data['filter_tenent_name'] ){
            $implode[] = " tenent_name like '%".  $data['filter_tenent_name'] . "%'";
        }
      
        if( isset($implode) && is_array($implode) && !empty($implode) ){
            $sql .= ' where ' . implode(" AND ",$implode);
        }

        // $sql .= " order by ". $data['sort'];

        $sql .= " limit ". $data['page'].", " . $data['per_page'];
       
        // die($sql);
        $query = $this->db->query($sql);
   
        return $query->result_array();
    }


    public function getRoomById($id)
    {

        $query = $this->db->get_where('room', array('room_no' => $id));

        return $query->row_array();

    }

    public function get_room_count($data)
    {
        // $this->db->select('*');
        // $this->db->from('room');          
        // return $this->db->get()->num_rows();

        $sql = "select * from room ";

        $implode = [];

        if(isset($data['filter_room_no']) && $data['filter_room_no'] ){
            $implode[] = " room_no = '".  $data['filter_room_no'] . "' ";
        }

        if(isset($data['filter_room_name']) && $data['filter_room_name'] ){
            $implode[] = " room_name like '%".  $data['filter_room_name'] . "%'";
        }

        if(isset($data['filter_tenent_name']) && $data['filter_tenent_name'] ){
            $implode[] = " tenent_name like '%".  $data['filter_tenent_name'] . "%'";
        }
      
        if( isset($implode) && is_array($implode) && !empty($implode) ){
            $sql .= ' where ' . implode(" AND ",$implode);
        }

        
        $query = $this->db->query($sql);
   
        return $query->num_rows();
    }





    public function update($data)
    {
       
        $post = array(
            'id' => $data['id'],
            'room_no' => $data['room_no'],
            'room_name' => $data['room_name'],
            'tenent_name' => $data['tenent_name'],
            'address' => $data['address'],
            'telephone' => $data['telephone'],
            'image' => $data['image'],

        );
      
        $this->db->where('room_no', $data['room_no']);
        $status = $this->db->update('room', $post);


        return $status;

    }

    public function delete($id)
    {
        $this->db->delete('room', array('room_no' => $id));
        return true;
    }

    public function multiDelete($ids)
    {
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('employee', array('emp_id' => $id));
            }

        }

        return true;
    }
}