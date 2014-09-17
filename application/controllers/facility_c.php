<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Facility_c extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
	public function index() {

		$this -> all_facilities();
	}
	public function all_facilities(){
		$access_level=$this->session->userdata("user_indicator");
		$data['title'] = "Facilities";
		$data['content_view'] = "all_facilities";
		$data['banner_text'] = "Facilities";
		$data['link'] = "all_facilities";
		if($access_level=="Administrator" || $access_level=="MOH" ){
		$data['all'] = Facility::get_all();
		}
		else if($access_level=="District Administrator"){
		$district=$this -> session -> userdata('district');
		$data['all'] = Facility::getby_district($district);
		}
		else if($access_level=="County Administrator"){
			$county=$this->session->userdata("county");
			$data['all'] = Facility::getcounty($county);
		}
		else{
			redirect("user_rights");
		}
		$data['quick_link'] = "all_facilities";
		$this -> load -> view("template", $data);
	}
	public function makead(){
		$id=$this->uri->segment(3);
		$data['title'] = "Make Administrator";
		$data['content_view'] = "add_user_view";
		$data['banner_text'] = "Administrator";
		$data['link'] = "add_user_view";
		$data['level_l'] = Access_level::getAll();
		$data['all'] = Facility::admin($id);
		$data['quick_link'] = "add_user_view";
		$this -> load -> view("template", $data);
	}
	public function edit() {
		$id = $this -> uri -> segment(3);
		$data['title'] = "Edit Facility";
		$data['content_view'] = "facility_edit";
		$data['banner_text'] = "Edit Facility";
		$data['link'] = "facility_edit";
		$data['left_content']="true";
		
		$data['all'] = Facility::get_facility($id);
		$data['quick_link'] = "facility_edit";
		$this -> load -> view("template", $data);

	}

	public function save_edits() {
		$id = $_POST['id'];
		$pno = $_POST['pno'];
		$alternate = $_POST['alternate'];

		$state = Doctrine::getTable('facility') -> findOneById($id);
		$state -> phone_number = $pno;
		$state -> alternate = $alternate;
		$state -> save();

		$this -> all_facilities();
	}
	
	public function district_facilities(){
	$data['title'] = "Facilities";
		$data['content_view'] = "all_facilities";
		$data['banner_text'] = "Facilities";
		$data['link'] = "all_facilities";
		$district=$this -> session -> userdata('district');
		$data['all'] = Facility::getby_district($district);
		//$data['all'] = Facility::get_all();
		$data['quick_link'] = "all_facilities";
		$this -> load -> view("template", $data);
	
	}
	
}