<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Sms extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
	public function index() {

		$data['title'] = "How to send alerts";
		$data['content_view'] = "send_view";
		$data['banner_text'] = "How to send alerts";
		$data['link'] = "send_view";
		$data['quick_link'] = "send_view";
		$this -> load -> view("template", $data);
	}
	
	
}