<?php
class ebola_Reports extends CI_Controller{
	public function index(){
	redirect("ebola_controller");	
	}
	public function all_ebola(){
		if($this->session->userdata("user_indicator")=="KEMRI"){
			redirect("ebola_reports/kemri_lab_results");
		}
		$data['title'] = "Ebola Alerts";
		$data['content_view'] = "all_ebola";
		$data['banner_text'] = "Reported Ebola Incidences";
		$data['link'] = "all_ebola";
		$data['all'] = incidence_ebola::getAll();
		$data['quick_link'] = "all_ebola";
		$data['ebola_admin']='true';
		$this -> load -> view("template", $data);
	}
	public function respond(){
		$id = $this -> uri -> segment(3);
		$data['title'] = "Respond to Ebola Incidents";
		$data['content_view'] = "ebola_response";
		$data['banner_text'] = "Respond to Ebola Incidents";
		$data['link'] = "ebola_response";
		$data['all'] = incidence_ebola::get_confirmation($id);
		$data['quick_link'] = "ebola_response";
		//$data['left_content']="true";
		$this -> load -> view("template", $data);
	}
	
	public function confirm_response() {
		$id = $_POST['fname'];
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

		//$count = Incident_Log_ebola::get_count($id);
		/*$ncount = Incident_Log_ebola::national_get_count($id);
		$ccount = Incident_Log_ebola::county_get_count($id);
		$dcount = Incident_Log_ebola::district_get_count($id);*/
       $fetch_log = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM Incident_Log_ebola l WHERE incident_id='$id'");
		if ($user == 1 || $user==2) {
			   if($fetch_log){
			   
$data=array('reported'=>$u_id, 'national_incident'=>$d);
	$this -> db -> where('incident_id', $id);
	$this -> db -> update('Incident_Log_ebola', $data);			   
			   }else{
				$u = new Incident_Log_ebola();
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
	$this -> db -> update('Incident_Log_ebola', $data);			   
			   }else{
				$u = new Incident_Log_ebola();
				$u -> incident_id = $id;
				$u -> reported = $u_id;
				$u -> district_incident = $d;
				$u -> save();
				}
				
			//echo "4";
		} else if ($user == 3) { //county response
			if($fetch_log){
			   
			   // $updates = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("UPDATE Incident_Log_ebola set reported='$u_id', county_incident='$d' WHERE incident_id='$id'");
			   $data=array('reported'=>$u_id, 'county_incident'=>$d);
	$this -> db -> where('incident_id', $id);
	$this -> db -> update('Incident_Log_ebola', $data);	
			   }else{
				$u = new Incident_Log_ebola();
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
       	
		redirect("ebola_reports/all_ebola/");
       	
       
	   
	}
	 public function ebola_response_download() {
		$all = incidence_ebola::getAll();
		$doc_generated_time=date("Y-m-d G:i:s",time());
		
		$data = '<table  border="0" class="table table-responsive table-striped table-bordered" width="100%">';

		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis</td></tr><tr><td style="text-align:right;">Generated on: '.$doc_generated_time.'<td></tr>';
		$data .= '<td><table style="margin-left: 0;" border=1 width="80%">
					<thead>
					<tr>
					
						<th style="text-align:left;">Type</th>
						<th style="text-align:left;">Phone Number</th>
						<th style="text-align:left;">Diseases</th>
						<th style="text-align:left;">Date</th>
						<th style="text-align:left;">Sex</th>
						<th style="text-align:left;">Age</th>
						<th style="text-align:left;">MFL</th>
						<th style="text-align:left;">HF Name</th>
						<th style="text-align:left;">Incidence Id</th>
						<th style="text-align:left;">Status</th>
						<th style="text-align:left;">Login</th>
						<th style="text-align:left;">Admin And MOH Response</th>
						<th style="text-align:left;">Kemri Response</th>
										    
					</tr>
					</thead>';
		foreach($all as $row):
						foreach($row->facility_info as $d):
						foreach($row->disease_name as $faci):
						foreach($row->logs_ebola as $log):
						$a = $row->incidence_time ;
						$dates = new DateTime($a);
                         
						$data .= '
						<tr>
							<td style="text-align:left;">' . $row -> Type .'</td>
							<td style="text-align:left;">' . $d -> phone_number .'</td>
							<td style="text-align:left;">' . $faci -> Full_Name .'</td>
							<td style="text-align:left;">' .$dates->format('jS F Y g:i A').'</td>
							<td style="text-align:left;">' . $row -> Sex .'</td>
							<td style="text-align:left;">' .$row -> Age .'</td>
							<td style="text-align:left;">' .$row -> Mfl_Code .'</td>
							<td style="text-align:left;">' . $d -> Facility_name .'</td>
							<td style="text-align:left;">' . $row -> incidence_code .'</td>
							<td>';
							if ($row -> Status == 'D') {
								$status='Dead';
							} else {
								$status= 'Alive';
							}
							$data.=$status.'</td>
							<td style="text-align:left;">Facility</td>
							<td style="text-align:left;">';
							
							$c = $log -> national_incident;
							$c = explode('|', $c);
							$no1=count($c);
							if($no1>=5){
							$action = $c[0];
							$notes = $c[1];
							$findings = $c[2];
							$time = $c[3];
							$taken = $c[4];
							$dtt = new DateTime($time);
							$nat= "<strong>Action :</strong>" . $action . "<br>" . "<strong>Notes :</strong>" . $notes . "<br>" . "<strong>Findings :</strong>" . $findings . "<br><strong>Time :</strong>" . $dtt -> format('j F, Y g:i A');
							}else{
								$nat= "No Response.";
							}
								
								$data.=$nat.'</td>
							';
							
						
							$incident_id=$row->incidence_code;
						$fetch_kemri = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM kemri_response WHERE incident_id='$incident_id'");
							if($fetch_kemri){
							foreach($fetch_kemri as $rows){
							$comments=$rows['comments'];
							$a=$row->lab_time; $dtz=new datetime($a);
							$dis= "<td><strong>Results: </strong>".$row->confirmation.".<br/><strong>Comments:</strong> ".$comments."<br/><strong>Released: </strong><strong>".$dtz->format('j F, Y g:i A')."</strong>";
							}
							}
							else{$dis ="<td>No response.";}
							
						$data.=$dis.'</td></tr>';
						 endforeach;
						 endforeach; 
						 endforeach; 
						 endforeach; 
						

		$data .= '</tbody></table></td>';

		$data .= '</table>';
		$time = date("Y-m-d G:i:s", time());
		$filename = "Responses_Download";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename.xls");
		echo "$data";
	}
	public function master_db(){
	    $data['title'] = "Ebola Master Database";
		$data['content_view'] = "master_v";
		$data['banner_text'] = "Ebola Master_database";
		$data['link'] = "master_v";
		$data['all'] = Incidence_ebola::getAll();
		$data['quick_link'] = "master_v";
		$data['ebola_admin']='true';
		$this -> load -> view("template", $data);	
	} 
	public function responses(){
		$data['title'] = "Ebola Response Download";
		$data['content_view'] = "ebola_response_download";
		$data['banner_text'] = "Download Ebola Responses";
		$data['link'] = "response_download";
		$data['all'] = Incidence_ebola::getAll();
		$data['quick_link'] = "ebola_response_download";
		$data['ebola_admin']='true';
		$this -> load -> view("template", $data);
	}
	public function master_db_download() {
		$document_generated_time=date('Y-m-d G:i:s',time());
		$all = Incidence_ebola::getAll();
		$data = '<table border="0" style="margin-left: 0;" width="90%">';
		
		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis</td></tr><tr><td style="text-align:right;">Generated on: '.$document_generated_time.'<td></tr>';
		
		$data .= '<td><table border="1" style="margin-left: 0;" width="80%">
					<thead>
					<tr>
						<th style="text-align:left;"><b>Disease</b></th>
						<th style="text-align:left;"><b>Date</b></th>
						<th style="text-align:left;"><b>Sex</b></th>
						<th style="text-align:left;"><b>Age</b></th>
						<th style="text-align:left;"><b>Status</b></th>
                        <th style="text-align:left;">Old Age</th>
				        <th style="text-align:left;">Old Sex</th>
				        <th style="text-align:left;">Old Status</th>						
						<th style="text-align:left;"><b>Facility</b></th>
						<th style="text-align:left;"><b>Incident ID</b></th>
							
							
                        <th style="text-align:left;"><b>Portal</b></th>							
					</tr>
					</thead>';
		foreach ($all as $row) :
			foreach ($row->facility_info as $d) :
				foreach ($row->disease_name as $faci) :
				$a = $row->incidence_time; $dt = new DateTime($a);
				 
					$data .= '
						<tr>
							<td style="text-align:left;">' . $faci -> Full_Name . '</td>
							<td style="text-align:left;">' . $dt->format('jS F Y g:i A') . '</td>
							<td style="text-align:left;">' . $row -> Sex . '</td>
							<td style="text-align:left;">' . $row -> Age . '</td>
							<td style="text-align:left;"> ' . $row -> Status . '</td>
							<td style="text-align:left;">'.$row -> New_Age.'</td>
							<td style="text-align:left;">'. $row -> New_Sex .'</td>				            
				            <td style="text-align:left;">'.$row -> New_Status.' </td>
							<td style="text-align:left;"> ' . $d -> Facility_name . '</td>
							<td style="text-align:left;"> ' . $row -> incidence_code . '</td>
							
							
							';
							 $dat = portal_db::get_supply_plan($row -> incidence_code);
                       // print_r($dat);				
				$portal="";
				//echo $rows->id;
				if($dat){
				$portal= "Web portal";
				}
				else {
				
				$portal= "SMS Portal";
				}
				$data .= '<td style="text-align:left;">'.$portal.'</td>
						</tr>';
				endforeach;
			endforeach;
		endforeach;

		$data .= '</tbody></table></td>';

		$data .= '</table>';
		$time = date("Y-m-d G:i:s", time());
		$filename = "Ebola_Master_Database";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename.xls");
		echo "$data";
	}
	
	public function kemri_lab_results(){
        $data['title'] = "Ebola Lab Results";
		$data['content_view'] = "ebola_lab_results";
		$data['banner_text'] = "Ebola Lab Results";
		$data['link'] = "ebola_lab_results";
		$data['all'] = Incidence::get_all_ebola();
		$data['quick_link'] = "ebola_lab_results";
		$data['ebola_admin']='true';
		$this -> load -> view("template", $data);
	}
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
		$data['ebola_admin']='true';
		
		$this -> load -> view("template", $data);

}
public function kemri_table_view(){

        $data['title'] = "Kemri Ebola Results View";
		$data['content_view'] = "kemri_ebola_view";
		$data['banner_text'] = "Kemri Ebola Results View";
		$data['link'] = "kemri_view";
		$data['all'] = kemri_response_ebola::ebola_results_view();
		$data['quick_link'] = "kemri_ebola_view";
		$data['ebola_admin']='true';
		$this -> load -> view("template", $data);

}
    
    
   

	
	
}
