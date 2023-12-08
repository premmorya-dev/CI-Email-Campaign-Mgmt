<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{

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
        $this->load->model('email_model', 'emails');

    }
    public function sendEmail()
    {


        $this->load->library('email');
        $this->email->clear();
        $config['protocol'] = 'mail';
        $config['smtp_host'] = 'mail.xyzpro.in';
        $config['smtp_port'] = '25';
        $config['smtp_user'] = 'user1@xyzpro.in';
        $config['smtp_pass'] = '#Prem123';
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['newline'] = "\r\n";



        $sender_mail = 'user1@xyzpro.in';
        $sender_name = 'Prem Morya';
        $receiver_mail = 'premmorya1996@gmail.com';
        $subject = 'Subject of Email1';
        $content = 'This is the content of the email.222';

        $email_data = array(
            'smtp_hostname' => $config['smtp_host'],
            'smtp_user' => $config['smtp_user'],
            'smtp_port' => $config['smtp_port'],
            'sender_mail' => $sender_mail,
            'sender_name' => $sender_name,
            'receiver_mail' => $receiver_mail,
            'subject' => $subject,
            'content' => $content,
            'open_status' => '0',
            'delivered_status' => '0',
            'error_log' => '',
            'sent_on' => '',
            'open_at' => ''
        );

        $this->email->initialize($config);
        $this->email->from($sender_mail, $sender_name); // Set the sender's email and name          
        $this->email->subject($subject);


        $campaign_id = 1;

        $email_list_id = 1;
        $total_email = $this->emails->getTotalEmail($email_list_id);

        $chunkSize = 100; // Process 1000 orders at a time
        $totalOrders = $total_email; // Total number of orders
        // $totalOrders = 1; 
        // $chunkSize = 1; 
        echo "\n Time: " . date('Y-m-d H:i:s');
        for ($offset = 0; $offset < $totalOrders; $offset += $chunkSize) {

            $list = $this->db->query("SELECT * FROM xyzpro_email_list_" . $email_list_id . " LIMIT $chunkSize OFFSET $offset")->result_array();


            if (!empty($list)) {
                foreach ($list as $email) {                    
                    $this->email->to($email['email']); // Set recipient's email     
                    $email_data['receiver_mail'] = $email['email'];
                    $sending_id = $this->emails->addEmail($email_data);

                    $content = '<img src="http://xyzpro.in/Email/openTracking/' . $sending_id . '" alt="" width="1" height="1" style="display:none;">';

                    $content .= 'This is the content of the email.';

                    $this->email->message($content);


                    if ($this->email->send(false)) {
                        $status = $this->emails->delivered($sending_id);
                        echo "\n Email Sent <br>";
                    } else {
                        echo $this->email->print_debugger(); // Display any email sending errors
                    }
                }
            }

        }
        echo "\n Time: " . date('Y-m-d H:i:s');




    }


    public function openTracking($id)
    {
        $status = $this->emails->updateClick($id);

    }



    // public function sendMail($id) {
    //     $post = array(
    //         'open_status' => '1'  
    //     );

    //     $this->db->where('sending_id', $id );
    //     $status = $this->db->update('xyzpro_sent_emails', $post);
    // }

    // if(!empty($emails)) {
    //     foreach($emails as $email) {
    //         $this->email->to($email); // Set recipient's email     
    //         if($this->email->send()) {
    //             $status = $this->emails->delivered($sending_id);
    //             echo "\n Email Sent";
    //         } else {
    //             echo $this->email->print_debugger(); // Display any email sending errors
    //         }
    //     }
    // }

    // $query = $this->db->query("select * from xyzpro_campaign c left join  xyzpro_campaign_to_agency ca on ca.campaign_id=c.campaign_id where c.campaign_id='" . $campaign_id . "' order by ca.percentage desc");
    // $agencies = $query->result();
    // $agency_share = [];
    // if($agencies ){
    //    foreach( $agencies  as $agency ){
    //     $agency_share[] = ceil( ($chunkSize/100) * $agency['percentage']) ;
    //    }
    // }

    // $command1 = 'php index.php/Email/sendMail/8 &';
    // exec($command1 );


}
