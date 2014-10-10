<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class redirect extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
	
	public function index(){
		
		//$this->leave_view();
		redirect("home_controller");
		
	}
	
	function leave_view(){
		$redirect_function=$this->uri->segment(3);
		//echo $redirect_function;
		if($this->input->ip_address()=='0.0.0.0' || $this->input->ip_address()=='41.89.6.174'){
			 $ip_address= '192.168.133.11';
		} 
		else{
			 $ip_address= '41.89.6.211';
		}
		if($redirect_function=='server_monitor'){
			$data['redirect_url']="http://$ip_address/server_monitor";
		}
		$data['content_view']='redirect_v';
		$data['banner_text']='Redirect Page';
		$data['title'] = "Redirect Page";
		
		$this->load->view('template',$data);
	}
	
}