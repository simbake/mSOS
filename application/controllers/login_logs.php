<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class login_Logs extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
	public function index() {
		$data['title'] = "Login Logs";
		$data['content_view'] = "trafficv";
		$data['banner_text'] = "Access Traffic";
		$data['link'] = "trafficv";
		$data['all'] = Logi::getAccessLogs();
		$data['quick_link'] = "trafficv";
		$this -> load -> view("template", $data);
	}
	
	
}