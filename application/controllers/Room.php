<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	 public function __construct()
	 {
		 parent::__construct();
         $this->load->model('email_model','emails');
	//	 $this->load->model('Room_model', 'room');
    // $this->load->library('pagination');
	 }
	public function index()
	{
      
        $this->load->library('email');
      

        $config['protocol'] = 'smtp'; // Your email sending protocol
        $config['smtp_host'] = 'mail.xyzpro.in';
        $config['smtp_port'] = '25';
        $config['smtp_user'] = 'user1@xyzpro.in';
        $config['smtp_pass'] = '#Prem123';
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['newline'] = "\r\n";

        $sender_mail = 'user1@xyzpro.in' ;
        $sender_name = 'Prem Morya' ;
        $receiver_mail = 'premmorya1996@gmail.com' ;
        $subject = 'Subject of Email1';
        $content = 'This is the content of the email.1';

        $this->email->initialize($config);        
        $this->email->from($sender_mail, $sender_name); // Set the sender's email and name
        $this->email->to($receiver_mail ); // Set recipient's email        
        $this->email->subject($subject);
        $this->email->message( $content );
        
        if ($this->email->send()) {
            // echo "<script>alert('Email Sent')</script>";

            $email_data = array(
                'smtp_hostname'     =>   $config['smtp_host'],
                'smtp_user'     =>   $config['smtp_user'],
                'smtp_port'  => $config['smtp_port'],
                'sender_mail'     => $sender_mail,
                'sender_name'     =>  $sender_name ,
                'receiver_mail'     =>$receiver_mail,
                'subject'     =>  $subject ,
                'content'     => $content,
                'open_status'     => '0',
                'delivered_status' => '0',
                'error_log'     =>  '',
            );
    
            $this->emails->addEmail($email_data);

             echo "\n Email Sent";
        } else {
            echo $this->email->print_debugger(); // Display any email sending errors
        }
        
	}

    public function list($page=1,$flag = 'false')
	{

        if( !empty($this->input->post('filter_room_no')) && $this->input->post('filter_room_no') ){
             $filter_room_no = $this->input->post('filter_room_no');
        }else{
            $filter_room_no = '';
        }

        if( !empty($this->input->post('filter_room_name')) && $this->input->post('filter_room_name') ){
            $filter_room_name = $this->input->post('filter_room_name');
        }else{
           $filter_room_name = '';
        }

        if( !empty($this->input->post('filter_tenent_name')) && $this->input->post('filter_tenent_name') ){
            $filter_tenent_name = $this->input->post('filter_tenent_name');
        }else{
            $filter_tenent_name = '';
        }

        $limit = 4;       
        $filter_data = [
            'filter_room_no' => $filter_room_no,
            'filter_room_name' => $filter_room_name,
            'filter_tenent_name' => $filter_tenent_name,   
            //'sort' => $sort,   
            'page' =>($page - 1) * $limit,
            'per_page' => $limit,
        ];


     
        $user_count = $this->room->get_room_count($filter_data);
        $config['base_url'] = base_url() . 'Room/list';
        $config['total_rows'] = $user_count;
        $config['per_page'] = $limit;
        $config['first_url'] = 1;
        $config['use_page_numbers'] = true;

        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['first_link'] = "First";
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $from = ($user_count) ? (($page - 1) * $config['per_page']) + 1 : 0;
        $to = ((($page - 1) * $config['per_page']) > ($user_count - $config['per_page'])) ? $user_count : ((($page - 1) * $config['per_page']) + $config['per_page']);

        $page = ($page - 1) * $config['per_page'];

     
      
        $rooms = $this->room->getRooms( $filter_data );
        $data['rooms'] = [];
        if($rooms){
            foreach($rooms as $room){
                $data['rooms'][] = [
                    'id' => $room['id'],
                    'room_no' =>$room['room_no'],
                    'room_name' => $room['room_name'],
                    'tenent_name' => $room['tenent_name'],
                    'address' => $room['address'],
                    'telephone' => $room['telephone'],
                    'image' => $room['image'],
                    'edit' =>  base_url() . 'Room/edit/'.$room['room_no'],
                    'delete' =>  base_url() . 'Room/delete/'.$room['room_no'],
                ];
            }
        }


        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['result'] = "<div class=\"hint-text\">Showing <b>" . $from . "</b> to <b>" . $to . "</b>  out of <b>" . $user_count . "</b> ( <b>" . ceil($user_count / $config['per_page']) . "</b> Pages ) </div>";

      
	    if($flag == 'false'){ 
            return $this->load->view('backend/rooms_list.php',$data); 
           
        }else{ 
            return $this->load->view('backend/rooms_list.php',$data,true); 
        }
		
	}

	public function add()
	{
        $data['room'] = [];
		$this->load->view('common/backend/header.php');
		$this->load->view('common/backend/navbar.php');
		$this->load->view('common/backend/left_sidebar.php');
		$this->load->view('common/backend/breadcrumb.php');
		$this->load->view('backend/add_room.php',$data);   // main content page
		$this->load->view('common/backend/footer.php');

	}

	public function store()
	{
		
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

            $json = [];
            $json['error'] = 0;
            $this->form_validation->set_rules('room_no', 'Room No', 'required');
            $this->form_validation->set_rules('room_name', 'Room Name', 'required');
            $this->form_validation->set_rules('tenent_name', 'Tenent Name', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('telephone', 'Telephone', 'required');




            if ($this->form_validation->run() == FALSE) {
                $json['error'] = 1;
                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
                $json['error_message'] = [
                    "room_no" => form_error('room_no'),
                    "room_name" => form_error('room_name'),
                    "tenent_name" => form_error('tenent_name'),
					"address" => form_error('address'),
                    "telephone" => form_error('telephone'),

                ];
            } else {

                if (isset($_FILES['image']['name']) && $_FILES['image']['name']) {
                    $file = explode(".", $_FILES['image']['name']);
                    $_FILES['image']['name'] = $file[0] . time() . "." . $file[1];
                }

                $data = array(
                    'room_no' => $this->input->post('room_no'),
                    'room_name' => $this->input->post('room_name'),
					'tenent_name' => $this->input->post('tenent_name'),
                    'image' => $_FILES['image']['name'],
                    'address' => $this->input->post('address'),
                    'telephone' => $this->input->post('telephone')
                );

                $id = $this->room->add($data);



                $config['upload_path'] = './uploads';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['max_width'] = 4000;
                $config['max_height'] = 4000;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $json['error'] = 1;
                    $error = array('error' => $this->upload->display_errors());
                    //  print_r($error['error']);die;
                    $json['success_message'] = [
                        "message" => "<h5 class=\"text-success mt-3\">" . $error['error'] . "!<p></p></h5>"
                    ];


                } else {

                    $data = array('upload_data' => $this->upload->data());

                    $data = array(
                        'image' => $_FILES['image']['name']
                    );

                    $this->db->where('id', $id);
                    $this->db->update('room', $data);
                }

                if ($json['error'] == 0) {
                    $json['success_message'] = [
                        "message" => "<h5 class=\"text-success mt-3\">You logged in successfully !<p></p></h5>"
                    ];
                }
                $this->session->set_flashdata('success', 'Room has been added Successfully!');


            }
            print_r(json_encode($json));
        }

	}

    public function edit($id=0)
	{

        $data['room'] = [];
        if(isset($id) && $id){
           $data['room'] = $this->room->getRoomById($id);
        }
       
        $this->load->view('common/backend/header.php');
		$this->load->view('common/backend/navbar.php');
		$this->load->view('common/backend/left_sidebar.php');
		$this->load->view('common/backend/breadcrumb.php');
		$this->load->view('backend/add_room.php',$data);   // main content page
		$this->load->view('common/backend/footer.php');
       
    }

    public function update($id)
	{
		
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

            $json = [];
            $json['error'] = 0;
            $this->form_validation->set_rules('room_no', 'Room No', 'required');
            $this->form_validation->set_rules('room_name', 'Room Name', 'required');
            $this->form_validation->set_rules('tenent_name', 'Tenent Name', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('telephone', 'Telephone', 'required');




            if ($this->form_validation->run() == FALSE) {
                $json['error'] = 1;
                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
                $json['error_message'] = [
                    "room_no" => form_error('room_no'),
                    "room_name" => form_error('room_name'),
                    "tenent_name" => form_error('tenent_name'),
					"address" => form_error('address'),
                    "telephone" => form_error('telephone'),

                ];
            } else {

                if (isset($_FILES['image']['name']) && $_FILES['image']['name']) {
                    $file = explode(".", $_FILES['image']['name']);
                    $_FILES['image']['name'] = $file[0] . time() . "." . $file[1];
                }

                $data = array(
                    'id' => $id,
                    'room_no' => $this->input->post('room_no'),
                    'room_name' => $this->input->post('room_name'),
					'tenent_name' => $this->input->post('tenent_name'),
                    'image' => $_FILES['image']['name'],
                    'address' => $this->input->post('address'),
                    'telephone' => $this->input->post('telephone')
                );

                $id = $this->room->update($data);



                $config['upload_path'] = './uploads';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['max_width'] = 4000;
                $config['max_height'] = 4000;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $json['error'] = 1;
                    $error = array('error' => $this->upload->display_errors());
                    //  print_r($error['error']);die;
                    $json['error_message'] = [
                        "image" =>  "<h5 class=\"text-danger mt-3\">" . $error['error'] . "</h5>"       
                    ];

                } else {

                    $data = array('upload_data' => $this->upload->data());

                    $data = array(
                        'image' => $_FILES['image']['name']
                    );

                    $this->db->where('id', $id);
                    $this->db->update('room', $data);
                }

                if ($json['error'] == 0) {
                    $json['success_message'] = [
                        "message" => "<h5 class=\"text-success mt-3\">You logged in successfully !<p></p></h5>"
                    ];
                    $this->session->set_flashdata('success', 'Room has been Updated Successfully!');
                }
            


            }
            print_r(json_encode($json));
        }

	}

    public function delete()
	{
        
        $status = false;       
        if($this->input->post('room_no') ){
          $status =  $this->room->delete( $this->input->post('room_no') );
        }
        if($status){          
           $this->session->set_flashdata('success', 'Room has been Deleted Successfully!');
        }

        print_r($status);
     
       
       
    }

}
