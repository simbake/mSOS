<?php
class weekly_controller extends MY_controller {
	
	
	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');

	}
	
	public function index() {

		$this -> all_weekly();
	}
	
	public function all_weekly(){
		//$this->load->model('weekly_summary_db');
		
		$data['title'] = "Weekly Summary";
		$data['content_view'] = "weekly_summary_view";
		$data['banner_text'] = "Weekly Facilities Summary";
		$data['link'] = "weekly_summary_db";
		$data['all'] = weekly_summary_db::weekly_summary_view();
		$data['quick_link'] = "weekly_summary_db";
		$this -> load -> view("template", $data);
			
	}
	
}
