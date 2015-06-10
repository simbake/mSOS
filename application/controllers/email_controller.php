<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class email_controller extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');

	}
	
	public function ebola_user_notification(){
		exit("Not allowed");
		//$messages=htmlspecialchars($messo);
		//echo "Under Maintainace. Please try again later.";
	
  
  		$config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'ddsrmsos@gmail.com';
        $config['smtp_pass']    = 'Y1MR3Wq3pn';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not  
		

       $this->load->library('email', $config);
        $this->email->initialize($config);
		
        $rrt_members=user::Ebola_RRT_users();
		foreach($rrt_members as $users){
			$data['fname']=$users->fname;
			$data['username']=$users->username;
			$data['email']=$users->email;
		$messages = $this->load->view('email_template', $data, TRUE);
  		$this->email->set_newline("\r\n");
  		$this->email->from('ddsrmsos@gmail.com'); // change it to yours
  		$this->email->to($data['email']); // change it to yours
  		//$this->email->bcc('simbake2009@yahoo.com');
  		$this->email->subject('Message From :mSOS');
 		$this->email->message($messages);
 
  if($this->email->send())
 {
	/*$this->session->set_flashdata("email_message",'Message sent successfull!');
	redirect("contact");*/
	echo 'Message sent successfull! User: '.$data['email'];
 }
 else
{
	 	
    echo "Error for user: ". $data['email']."<br/>";
	 echo $this->email->print_debugger();
	 /*$error=show_error($this->email->print_debugger());
 	$this->session->setflashdata('email_error',$error);
	redirect("contact");*/
 
}
		}
	}	
		
		
}
	