<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Faq extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
	public function index() {

		$data['title'] = "FAQ";
		$data['content_view'] = "faq_view";
		$data['banner_text'] = "Frequently Asked Questions.";
		$data['link'] = "faq_view";
		$data['quick_link'] = "faq_view";
		$data['left_content']="true";
        $data['left_content']="true";
        $this -> load -> view("template", $data);
	}
	
	
}