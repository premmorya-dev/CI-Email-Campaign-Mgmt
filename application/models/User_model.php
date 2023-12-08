<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model {

    function __construct()
    {
         parent::__construct();
    }

    public function register($data)
    {
        $this->db->insert('xyzpro_user', $data);
        $id =  $this->db->insert_id();
        return  $id;
          
    }

    public function checkUser($data)
    {

         $query = $this->db->get_where('xyzpro_user', array('email' => $data['email']));
    
        return  $query->num_rows();
          
    }

    public function checkUserPassword($data)
    {

        //$query = $this->db->get_where('xyzpro_user', array('email' => $data['email'],'password' => $data['password']));
         $query = $this->db->query("SELECT * FROM xyzpro_user WHERE email = '" . $data['email'] . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $data['password']. "'))))) OR password = '" . md5( $data['password']) . "') AND status = '1'");

        return  $query->row_array();
          
    }

    public function isLogged()
    {
      
         if( $this->session->userdata !== null && $this->session->userdata('logged_in') ){
            return true;
         }else{
            return false;
         }
       
 
          
    }

  

}