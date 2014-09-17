<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class C_Disease extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');

	}

	public function index() {

		$this -> disease_list();
	}

	public function disease_list() {
		$data['title'] = "Disease List";
		$data['content_view'] = "v_disease";
		$data['banner_text'] = "Disease List";
		$data['link'] = "v_disease";
		//$data['disease'] = Diseases::getAll();
		$data['quick_link'] = "v_disease";
		
		$data['list'] = Diseases::getAll();
		$data['left_content']="true";
		
		$this -> load -> view("template", $data);
	}

	public function cases() {
		$id = $_POST['id'];
		if($id){
		$data['case'] = Diseases::getDisease($id);
		$this -> load -> view("graphs/pop", $data);
		}
		else{
			echo "Id not found!!;";
		}
	}
	public function sample() {
		$id = $_POST['id'];
		$data['case'] = Diseases::getDisease($id);
		$this -> load -> view("graphs/sample", $data);
	}

	public function edit_disease() {
		$id= $this -> uri -> segment(3);
		$data['title'] = "Disease Edit";
		$data['content_view'] = "add_case";
		$data['banner_text'] = "Disease Edit";
		$data['link'] = "add_case";
		$data['case'] = Diseases::getDisease($id);
		$data['left_content']="true";
		
		$data['quick_link'] = "add_case";
		$this -> load -> view("template", $data);
		//$this -> load -> view("add_case", $data);
	}
	public function edit_sample() {
		$id= $this -> uri -> segment(3);
		$data['title'] = "Disease Edit";
		$data['content_view'] = "sample_v";
		$data['banner_text'] = "Disease Edit";
		$data['link'] = "sample_v";
		$data['case'] = Diseases::getDisease($id);
		$data['left_content']="true";

		$data['quick_link'] = "sample_v";
		$this -> load -> view("template", $data);
		//$this -> load -> view("add_case", $data);
	}

	public function edit_cases() {
		$id=$_POST['id'];
		$def=$_POST['defition'];
		$state = Doctrine::getTable('diseases') -> findOneById($id);
		$state -> definition = $def;
		$state -> save();
		
		redirect("c_disease/manage_d");
	}
	public function edit_lab() {
		$id=$_POST['id'];
		$sam=$_POST['defition'];
		$state = Doctrine::getTable('diseases') -> findOneById($id);
		$state -> sample = $sam;
		$state -> save();
		redirect("c_disease/manage_d");
	}

	public function incidence_disease() {
		$data['title'] = "Disease Incidents";
		$data['content_view'] = "incidence_disease";
		$data['banner_text'] = "Reported Incidences";
		$data['link'] = "incidence_disease";
		$data['dlist'] = Incidence::get_incidence();
		$data['quick_link'] = "incidence_disease";
		
		$data['left_content']="true";

		
		$this -> load -> view("template", $data);
	}

	public function all_diseases() {
		$id = $this -> uri -> segment(3);
		$data['title'] = "Disease Incidents";
		$data['content_view'] = "all_disease";
		$data['banner_text'] = "Reported Incidences";
		$data['link'] = "all_disease";
		$data['all'] = Incidence::get_all();
		$data['quick_link'] = "all_disease";
		$this -> load -> view("template", $data);
	}

	public function disease_id() {

		$data['title'] = "Disease Incidents";
		$data['content_view'] = "all_disease";
		$data['banner_text'] = "Reported Incidences";
		$data['link'] = "all_disease";
		$data['all'] = Incidence::get_all();
		$data['quick_link'] = "all_disease";
		$this -> load -> view("template", $data);
	}

	public function disease_details() {
		$disease = trim($this -> uri -> segment(3));
		$data['title'] = "Disease Details";
		$data['content_view'] = "details_v";
		$data['banner_text'] = "Reported Incidences";
		$data['link'] = "details_v";
		$data['details'] = Incidence::get_disease($disease);
		$data['quick_link'] = "details_v";
		
		$data['left_content']="true";

		
		$this -> load -> view("template", $data);
	}

	public function mlist() {
		$m = $this -> input -> post('month');
		$y = $this -> input -> post('year');
		$data['month'] = Incidence::month_list($y, $m);
		$this -> load -> view("graph/monthly_v", $data);
	}

	public function manage_d() {
		$data['title'] = "Disease Edit";
		$data['content_view'] = "disease_manage";
		$data['banner_text'] = "Disease Edit";
		$data['link'] = "disease_manage";
		$data['diseases'] = Diseases::getAll();
		$data['quick_link'] = "disease_manage";
		$data['left_content']="true";
		
		$this -> load -> view("template", $data);
	}

}
