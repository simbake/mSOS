<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class A_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
	public function index() {

		$this -> confirm();
	}
	
	public function confirm(){
		$data['title'] = "Confirm Alerts";
		$data['content_view'] = "confirm";
		$data['banner_text'] = "Confirm Alerts";
		$data['link'] = "confirm";
		$data['all'] = Incidence::get_All();
		$data['quick_link'] = "confirm";
		$this -> load -> view("template", $data);
	}
	public function sendSMS(){
        $data['title'] = "Send Bulk SMS";
        $data['content_view'] = "send";
        $data['banner_text'] = "Bulk SMS";
        $data['link'] = "send";
        $data['all'] = Facility::County();
		$data['left_content']="true";
		
		//$data['list'] = Diseases::getAll();
        $data['quick_link'] = "send";
        $this -> load -> view("template", $data);
    }
    public function sendtext(){
        $county=$_POST['county'];
        $message=$_POST['message'];
        
        $all= Facility::getcounty($county);
        foreach($all as $row){        
        $error_r = rawurlencode($message);
        $syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=$row[phone_number]&text=$error_r");
        
        }
        $this->sendSMS();
    }
	public function edit(){
		$time = date("Y-m-d G:i:s", time());
		$id=$this->uri->segment(3);
		$state=Doctrine::getTable('incidence')->findOneById($id);
		$state->confirmation='Positive';
		$state->lab_time=$time;
		$state->Type='Confirmation';
		$state->save();
		
		$myobj = Doctrine::getTable('incidence') -> findOneById($id);
		$idd = $myobj -> p_id;
		
		$all= User::admin();
		
		foreach($all as $row){		
		$error = 'Incident '.$idd. ' has been confirmed. The case is confirmed.';
		$error_r = rawurlencode($error);
        $syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=$row[telephone]&text=$error_r");
		}

		$data['title'] = "Confirm Alerts";
		$data['content_view'] = "confirm";
		$data['banner_text'] = "Confirm Alerts";
		$data['link'] = "confirm";
		$data['all'] = Incidence::get_suspected();
		$data['quick_link'] = "confirm";
		$this -> load -> view("template", $data);
	}
	public function reject(){
		$time = date("Y-m-d G:i:s", time());
		$id=$this->uri->segment(3);
		$state=Doctrine::getTable('incidence')->findOneById($id);
		$state->confirmation='Negative';
		$state->Type='Negative';
		$state->lab_time=$time;
		$state->save();
		
		$myobj = Doctrine::getTable('incidence') -> findOneById($id);
		$idd = $myobj -> p_id;
		
		$all= User::admin();
		
		foreach($all as $row){		
		$error = 'Incident '.$idd. ' is not confirmed. The case is Negative.';
		$error_r = rawurlencode($error);
        $syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=$row[telephone]&text=$error_r");
        
		}
		
		$data['title'] = "Confirm Alerts";
		$data['content_view'] = "confirm";
		$data['banner_text'] = "Confirm Alerts";
		$data['link'] = "confirm";
		$data['all'] = Incidence::get_suspected();
		$data['quick_link'] = "confirm";
		$this -> load -> view("template", $data);
	}
	
	/*public function specimen_received(){
$data['title'] = "Specimen Received";
$id = $this -> uri -> segment(3);
		$data['content_view'] = "specimen_received";
		$data['banner_text'] = "Specimen Received";
		$data['link'] = "specimen_received";
		//$data['all'] = Incidence::get_suspected();
		$data['all'] = Incidence::get_confirmation($id);
		$data['quick_link'] = "specimen_received";
		$this -> load -> view("template", $data);

}*/

public function specimen_results(){
$id_incident = $this -> uri -> segment(3);
$data['title'] = "Specimen Results";
		$data['content_view'] = "specimen_results";
		$data['banner_text'] = "Specimen Results";
		$data['link'] = "specimen_results";
		//$data['all'] = Incidence::get_suspected();
		$data['all'] = Incidence::get_confirmation($id_incident);
		//$data['id_incident']=$id_incident;
		$data['quick_link'] = "specimen_results";
		
		$data['incident'] = Incidence::get_incidence_count();
		$data['disease'] = Incidence::get_disease_count();
		$data['confirm'] = Incidence::confirm();
		
		$this -> load -> view("template", $data);

}

public function specimen_results_submit(){
// getting form data
  $incident_id=$this->input->post('Incidence_id',TRUE);
  $date_received=$this -> input -> post('date_received');
  $date_1=new datetime($date_received);
 // $date_begun=$this->input->post('date_test_begun',TRUE);
  //$date_1=new datetime($date_begun);
  $date_released=date("Y-m-d G:i:s", time());
  $specimen_type=$this->input->post('specimen_type',TRUE);
  $type_other=$this->input->post('specimen_comments',TRUE);
  $condition=$this->input->post('condition',TRUE);
  $other_cond=$this->input->post('specimen_condition',TRUE);
  $results=$this->input->post('sample_results',TRUE);
  $comments=$_POST['comments'];
  $id_table_incident=$this->input->post('id_1',TRUE);
 //echo $incident_id;
 
//save to kemri_response table.
                $kemri=new kemri_response();
				$kemri->incident_id=$incident_id;
				$kemri->specimen_received=$date_1->format('Y-m-d');
				$kemri->specimen_type=$specimen_type;
				if($specimen_type=="Other"){
				$kemri->other_specimen=$type_other;
				}
				else{
				$type_other="";
				$kemri->other_specimen=$type_other;
				}
				$kemri->conditions=$condition;
				if($condition=="Other"){
				$kemri->other_condition=$other_cond;
				}
				else{
				$other_cond="";
				$kemri->other_condition=$other_cond;
				}
				$kemri->comments=$comments;
				$kemri->save();


		
	//update incidence table
	$data=array('confirmation'=>$results, 'lab_time'=>$date_released);
	$this -> db -> where('p_id', $incident_id);
	$this -> db -> update('incidence', $data);	
    //$this->confirm();
    if($this->session->userdata('ebola_login')==1){
    redirect('ebola_reports/kemri_lab_results');	
    }else{
	redirect('a_management/confirm');
	}

}

public function kemri_table_view(){

        $data['title'] = "Confirm Alerts";
		$data['content_view'] = "kemri_view";
		$data['banner_text'] = "Kemri View";
		$data['link'] = "kemri_view";
		$data['all'] = kemri_response::kemri_results_view();
		$data['quick_link'] = "kemri_view";
		$this -> load -> view("template", $data);

}



}

