<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Email_model extends CI_Model {


    function __construct()
    {
         parent::__construct();
    }

    public function addEmail($data)
    {
        $this->db->insert('xyzpro_sent_emails', $data);
        $id =  $this->db->insert_id();
        return  $id;
          
    }

    public function getEmailList($id)
    {
        $query = $this->db->get('xyzpro_email_list_'.$id);    
        return  $query->result_array();
          
    }

    public function getTotalEmail($id)
    {
        $total_email = $this->db->count_all('xyzpro_email_list_'.$id);    
        return  $total_email;
          
    }

    public function updateClick($sending_id)
    {
        $post = array(
            'open_status' => '1',
            'open_at' => date('Y-m-d H:i:s')  
        );
      
        $this->db->where('sending_id', $sending_id );
        $status = $this->db->update('xyzpro_sent_emails', $post);
       
        return  $status;
          
    }

    public function delivered($sending_id)
    {
        $post = array(
            'delivered_status' => '1',
            'sent_on' => date('Y-m-d H:i:s')   
        );
      
        $this->db->where('sending_id', $sending_id );
        $status = $this->db->update('xyzpro_sent_emails', $post);
       
        return  $status;
          
    }

}