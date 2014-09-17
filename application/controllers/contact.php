<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Contact extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');

	}

	public function index() {

		$data['title'] = "Contact Us";
		$data['content_view'] = "contact";
		$data['banner_text'] = "Contact Us";
		
		$data['left_content']="true";
		
		$data['link'] = "contact";
		$data['quick_link'] = "contact";
		$this -> load -> view("template", $data);
	}
	public function send(){
		
		$name=$_POST['names'];
		$email=$_POST['email'];
		$messo=$_POST['message'];
		$messages=htmlspecialchars($messo);
		//echo "Under Maintainace. Please try again later.";
	
  
  		$config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'ddsrmsos@gmail.com';
        $config['smtp_pass']    = 'y3ll0w@#1';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not  
		

       $this->load->library('email', $config);
        $this->email->initialize($config);
		
 
  		$this->email->set_newline("\r\n");
  		$this->email->from($email); // change it to yours
  		$this->email->to('ddsrmsos@gmail.com'); // change it to yours
  		$this->email->bcc('simbake2009@yahoo.com');
  		$this->email->subject('Message From :'.$name);
 		$this->email->message($messages);
 
  if($this->email->send())
 {
	$this->session->set_flashdata("email_message",'Message sent successfull!');
	redirect("contact");
 }
 else
{
    $error=show_error($this->email->print_debugger());
 	$this->session->setflashdata('email_error',$error);
	redirect("contact");
 
}
	}
	

}
