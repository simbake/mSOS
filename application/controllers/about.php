<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class About extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
	public function index() {

		$data['title'] = "Background";
		$data['content_view'] = "about_us";
		$data['banner_text'] = "Background";
		$data['link'] = "about_us";
		$data['quick_link'] = "about_us";
	    $data['left_content']="true";
		$this -> load -> view("template", $data);
	}
	
	
}