<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class C_Incidents extends MY_Controller {
	var $random_chars = "";
	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');

	}

	public function index() {

		$this -> all_diseases();
	}

	public function all_diseases() {
		$data['title'] = "Disease Incidents";
		$data['content_view'] = "all_disease";
		$data['banner_text'] = "Reported Incidences";
		$data['link'] = "all_disease";
		$d = $this -> session -> userdata('district');
		$c=$this -> session -> userdata('county');
		if($d){
		$data['all'] = Incidence::get_district_incidents($d);
		}
		else if($c){
		$data['all'] = Incidence::get_county_incidents($c);
		}
		else{
		$data['all'] = Incidence::get_all();
		}
		
		$data['quick_link'] = "all_disease";
		$this -> load -> view("template", $data);
	}

	public function all_diseases_edit() {
		$data['title'] = "Disease Incidents Edits";
		$data['content_view'] = "edit_all";
		$data['banner_text'] = "Edit Incidences";
		$data['link'] = "edit_all";
		$d = $this -> session -> userdata('district');
		if($d){
		$data['all'] = Incidence::get_district_incidents($d);
		}
		else{
		$data['all'] = Incidence::get_all();
		}
		$data['quick_link'] = "edit_all";
		$this -> load -> view("template", $data);
	}

	public function reported() {
		$data['title'] = "Disease Incidents";
		$data['content_view'] = "reported_v";
		$data['banner_text'] = "Reported Incidences";
		$data['link'] = "all_disease";
		$d = $this -> session -> userdata('district');
		if($d){
		$data['all'] = Incidence::get_district_incidents($d);
		}
		else{
		$data['all'] = Incidence::get_all();
		}
		$data['quick_link'] = "all_disease";
		$this -> load -> view("template", $data);
	}

	public function responds() {
		$data['title'] = "Disease Incidents";
		$data['content_view'] = "responds";
		$data['banner_text'] = "Reported Incidences";
		$data['link'] = "responds";
		$data['all'] = Incidence::get_all();
		$data['quick_link'] = "responds";
		$this -> load -> view("template", $data);
	}

	public function report_incidence() {
	
	
	    $access = $this -> session -> userdata('user_indicator');
		$data['title'] = "Report New Incidents";
		$data['content_view'] = "new_incident";
		if($access=="Administrator" || $access=="MOH"){
		$data['facility'] = Facility::get_all();
		}else{
		$district=$this -> session -> userdata('district');
		$data['facility'] = Facility::getby_district($district);
		}
		$data['diseases'] = Diseases::getAll();
		$data['left_content']="true";
		
		$data['banner_text'] = "Report New Incidents";
		$this -> load -> view("template", $data);
	}

	public function submit() {
	
	$this->load->helper(array('form', 'url'));
	
		$mfl = $this -> input -> post('fname');

		$state = Doctrine::getTable('facility') -> findOneByfacility_code($mfl);
		$disto = $state -> district;
		$count = $state -> county;

		//incident code
		$time = date("Y-m-d G:i:s", time());
		$random_chars = strtoupper(substr(MD5(uniqid(rand(), 1)), 3, 11));

		//echo $random_chars . '<br>' ;
		$d=new portal_db();
		$u = new Incidence();
		$u -> Mfl_Code = $this -> input -> post('fname');
		$u -> district = $disto;
		$u -> county = $count;
		$u -> Disease_id = $this -> input -> post('disease');
		$u -> Age = $this -> input -> post('age');
		$u -> Sex = strtoupper($this -> input -> post('sex'));
		$u -> Status = strtoupper($this -> input -> post('status'));
		$u -> p_id = $random_chars;
		$u -> Time = $time;
		$u -> Type = 'Alert';
		$u -> save();
		//$this -> all_diseases();
		$d-> incident_id=$random_chars;
		$d-> save();
		$this->session->set_flashdata('error_alert',1);
		//$this->session->set_flashdata('alert',1);
		redirect('c_incidents/report_incidence');
		//$this->report_incidence();
		
		
	}
	
	public function check_var_type($variable){
	
	$var=gettype($variable);
	
	}

	public function respond() {
		
		$id = $this -> uri -> segment(3);
		$data['title'] = "Confirm Incidents";
		$data['content_view'] = "response";
		$data['banner_text'] = "Confirm Incidents";
		$data['link'] = "response";
		$data['all'] = Incidence::get_confirmation($id);
		$data['quick_link'] = "response";
		$data['left_content']="true";
		$this -> load -> view("template", $data);
	}

	public function edit_i() {
		$id = $this -> uri -> segment(3);
		$data['title'] = "Edit Incidents";
		$data['content_view'] = "edit_incident";
		$data['banner_text'] = "Edit Incidents";
		$data['link'] = "edit_incident";
		$data['all'] = Incidence::get_confirmation($id);
		$data['quick_link'] = "edit_incident";
		$data['left_content']="true";
		$this -> load -> view("template", $data);
	}

	public function confirm_response() {
		$id = $_POST['id'];
		$u_id = $this -> session -> userdata('user_id');
		//$action = $_POST['action'];
		$notes = $_POST['notes'];
		$findings = $_POST['findings'];
		$taken = $_POST['actiontaken'];
		$time = date("Y-m-d G:i:s", time());
		$others = $_POST['others'];
		$user = $this -> session -> userdata('user_level');
		
		//$id = $_POST['id'];
		//$u_id = $this -> session -> userdata('user_id');
		
		/*$phone=@$_POST['phone'];
		$visited=@$_POST['Visited'];
		$sample=@$_POST['Sample_Taken'];
		$investigations=@$_POST['Investigations_Made'];
		$public_action=@$_POST['Public_Action'];*/
		
		if(!empty($_POST['check_list'])) {
		$multiple[]="";
    foreach($_POST['check_list'] as $check) {
        $multiple[]=$check;
        //$count+1;		
		//echo $check." , ";
			//echo $check; //echoes the value set in the HTML form for each checked checkbox.
                         //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                         //in your case, it would echo whatever $row['Report ID'] is equivalent to.
    }
}
else{
$this->session->set_flashdata("empty_checkboxes",1);
header("location: javascript://history.go(-1)");
}
		$action="";
		//$action = $phone." , ".$visited." , ".$sample." , ".$investigations." , ".$public_action;
		foreach($multiple as $key=>$check){
		$action=$action . $check . " , ";
		//echo "$key: ".$check;
		//echo $check." , ";
		}
		$d = $action . "|" . $notes . "|" . $findings . "|" . $time . "|" . $taken . "|" . $u_id . "|" . $others;

		//$count = Incident_Log::get_count($id);
		/*$ncount = Incident_Log::national_get_count($id);
		$ccount = Incident_Log::county_get_count($id);
		$dcount = Incident_Log::district_get_count($id);*/
       $fetch_log = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM incident_log l WHERE incident_id='$id'");
		if ($user == 1 || $user==2) {
			   if($fetch_log){
			   
$data=array('reported'=>$u_id, 'national_incident'=>$d);
	$this -> db -> where('incident_id', $id);
	$this -> db -> update('incident_log', $data);			   
			   }else{
				$u = new Incident_log();
				$u -> incident_id = $id;
				$u -> reported = $u_id;
				$u -> national_incident = $d;
				$u -> save();
				}
			  // echo "1 and 2";
			
		} else if ($user == 4) { //district response
			
			if($fetch_log){
			   
 $data=array('reported'=>$u_id, 'district_incident'=>$d);
	$this -> db -> where('incident_id', $id);
	$this -> db -> update('incident_log', $data);			   
			   }else{
				$u = new Incident_log();
				$u -> incident_id = $id;
				$u -> reported = $u_id;
				$u -> district_incident = $d;
				$u -> save();
				}
				
			//echo "4";
		} else if ($user == 3) { //county response
			if($fetch_log){
			   
			   // $updates = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("UPDATE incident_log set reported='$u_id', county_incident='$d' WHERE incident_id='$id'");
			   $data=array('reported'=>$u_id, 'county_incident'=>$d);
	$this -> db -> where('incident_id', $id);
	$this -> db -> update('incident_log', $data);	
			   }else{
				$u = new Incident_log();
				$u -> incident_id = $id;
				$u -> reported = $u_id;
				$u -> county_incident = $d;
				$u -> save();
				}
				
			//echo "3";
		}
else{
		exit('no user level found');
}
       if($this->uri->segment(3)=="ebola"){
       	
		redirect("ebola_reports/all_ebola/");
       	
       }
	   else{
		redirect("c_incidents/all_diseases/");
	   }
	}

	public function confirm() {
		$id = $_POST['id'];
		$u_id = $this -> session -> userdata('user_id');
		$action = $_POST['action'];
		$notes = $_POST['notes'];
		$findings = $_POST['findings'];
		$taken = $_POST['actiontaken'];
		$time = date("Y-m-d G:i:s", time());
		$others = $_POST['others'];
		$user = $this -> session -> userdata('user_level');

		$d = $action . "|" . $notes . "|" . $findings . "|" . $time . "|" . $taken . "|" . $u_id . "|" . $others;

		if ($user == 1) {
			$state = Doctrine::getTable('incident_log') -> findOneByid($id);
			$state -> national_incident = $d;
			$state -> save();
		} else if ($user == 4) {
			$state = Doctrine::getTable('incident_log') -> findOneByid($id);
			$state -> district_incident = $d;
			$state -> save();
		} else if ($user == 3) {
			$state = Doctrine::getTable('incident_log') -> findOneByid($id);
			$state -> county_incident = $d;
			$state -> save();
		}

		$data['title'] = "Disease Incidents";
		$data['content_view'] = "all_disease";
		$data['banner_text'] = "Reported Incidences";
		$data['link'] = "all_disease";
		$data['all'] = Incidence::get_all();
		$data['quick_link'] = "all_disease";
		$this -> load -> view("template", $data);
	}


	public function masterdb() {
		$data['title'] = "Master Database";
		$data['content_view'] = "master_v";
		$data['banner_text'] = "Master_database";
		$data['link'] = "master_v";
		$data['all'] = Incidence::get_all();
		$data['quick_link'] = "master_v";
		$this -> load -> view("template", $data);
	}

	public function save_edits() {
		$id = $_POST['id'];
		$age = $_POST['age'];
		$sex = $_POST['sex'];
		$status = $_POST['status'];
		$time = date("Y-m-d G:i:s", time());

		$u = Doctrine::getTable('incidence') -> findOneById($id);
		$ager = $u -> Age;
		$stater = $u -> Status;
		$sex1 = $u -> Sex;

		$u -> New_Age = $ager;
		$u -> New_Sex = $sex1;
		$u -> New_Status = $stater;
		$u -> time_changed = $time;
		$u -> save();

		//exit;

		$state = Doctrine::getTable('incidence') -> findOneById($id);
		$state -> Age = $age;
		$state -> Sex = $sex;
		$state -> Status = $status;
		$state -> save();

		$this -> all_diseases_edit();
	}

}
