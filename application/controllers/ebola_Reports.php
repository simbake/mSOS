<?php
class ebola_Reports extends CI_Controller {
	public function index() {
		redirect("ebola_controller");
	}

	public function all_ebola() {
		if ($this -> session -> userdata("user_indicator") == "KEMRI") {
			redirect("ebola_reports/kemri_lab_results");
		}
		$data['title'] = "Ebola Alerts";
		$data['content_view'] = "all_ebola";
		$data['banner_text'] = "Reported Ebola Incidences";
		$data['link'] = "all_ebola";
		$data['all'] = incidence_ebola::getAll();
		$data['quick_link'] = "all_ebola";
		$data['ebola_admin'] = 'true';
		$this -> load -> view("template", $data);
	}

	public function respond() {
		$id = $this -> uri -> segment(3);
		$data['title'] = "Respond to Ebola Incidents";
		$data['content_view'] = "ebola_response";
		$data['banner_text'] = "Respond to Ebola Incidents";
		$data['link'] = "ebola_response";
		$data['ebola_admin'] = 'true';
		$data['all'] = incidence_ebola::get_confirmation($id);
		$data['quick_link'] = "ebola_response";
		//$data['left_content']="true";
		$this -> load -> view("template", $data);
	}

	public function confirm_response() {
		//Form Validation Rules
        $id = $this -> input -> post('fname');
		if ($id){
			
		$id = $this -> input -> post('fname');
		$u_id = $this -> session -> userdata('user_id');
		$notes = $this -> input -> post('notes');
		$findings = $this -> input -> post('findings');
		$taken = $this -> input -> post('actiontaken');
		$time = date("Y-m-d G:i:s", time());
		$others = $this -> input -> post('others');
		$user = $this -> session -> userdata('user_level');
        $check_list=$this->input->post('check_list');
        //print_r($check_list);exit();
		if ($check_list) {
			$multiple[] = "";
			foreach ($check_list as $check) {
				
				$multiple[] = $check;

			}
		} else {
			$this -> session -> set_flashdata("empty_checkboxes", 1);
			//header("location: javascript://history.go(-1)");
			exit('empty checklist');
		}
		$action = "";
		foreach ($multiple as $key => $check) {

			$action = $action . $check . " , ";
		}
		$d = $action . "|" . $notes . "|" . $findings . "|" . $time . "|" . $taken . "|" . $u_id . "|" . $others;

		$fetch_log = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM Incident_Log_ebola WHERE incident_id='$id'");
		
			if ($fetch_log) {
              if ($user == 1) {
				$data = array('reported' => $u_id, 'Admin_Response' => $d);
				$this -> db -> where('incident_id', $id);
				$this -> db -> update('Incident_Log_ebola', $data);
			}else if ($user == 6) {
				$data = array('reported' => $u_id, 'RRT_Response' => $d);
				$this -> db -> where('incident_id', $id);
				$this -> db -> update('Incident_Log_ebola', $data);
				
			}
			  
			  } else {
			  	if($user == 1){
				$u = new Incident_Log_ebola();
				$u -> incident_id = $id;
				$u -> reported = $u_id;
				$u -> Admin_Response = $d;
				$u -> save();
				}else if($user == 6){
				$u = new Incident_Log_ebola();
				$u -> incident_id = $id;
				$u -> reported = $u_id;
				$u -> RRT_Response = $d;
				$u -> save();	
				}
			}
			// echo "1 and 2";
		}
		redirect("ebola_reports/all_ebola/");

	}

	public function ebola_response_download() {
		$all = incidence_ebola::get_Response();
		$doc_generated_time=date("Y-m-d G:i:s",time());
		
		$data = '<table  border="0" class="table table-responsive table-striped table-bordered" width="100%">';

		$data .= '  <tr>
		            <td style="font-weight: bold; text-align:left;">
		            DDSR Data Analysis</td></tr><tr><td style="text-align:right;">Generated on: '.$doc_generated_time.'
		            <td>
		            </tr>';
		$data .= '  <td>
		            
		            <table style="margin-left: 0;" border=1 width="80%">
					<thead>
					<tr>
					
						<th style="text-align:left;">Type</th>
						<th style="text-align:left;">Event Name</th>
						<th style="text-align:left;">Phone Number</th>
						<th style="text-align:left;">Location</th>
						<th style="text-align:left;">Date</th>
						<th style="text-align:left;">Time</th>
						<th style="text-align:left;">Sex</th>
						<th style="text-align:left;">Age</th>
						<th style="text-align:left;">Status</th>
						<th style="text-align:left;">Serial</th>
						<th style="text-align:left;">ID</th>
						<th style="text-align:left;">Admin Response</th>
						<th style="text-align:left;">RRT Response</th>
						<th style="text-align:left;">KEMRI response</th>
										    
					</tr>
					</thead>';
					
		                foreach($all as $row):
							foreach($row->disease_name as $event):
						$a = $row->incidence_time; $dt = new DateTime($a);
                         
						$data .= '
						<tbody>
						<tr>
							<td style="text-align:left;">' . $row -> Type .'</td>
							<td style="text-align:left;">' . $event -> disease_name .'</td>
							<td style="text-align:left;">' . $row -> reported_by .'</td>
							<td style="text-align:left;">' . $row -> incidence_location .'</td>
							<td style="text-align:left;">' . $dt->format('j F, Y').'</td>
							<td style="text-align:left;">' . $dt->format('g:i A') .'</td>
							<td style="text-align:left;">' .$row -> Sex .'</td>
							<td style="text-align:left;">' .$row -> Age .'</td>
							<td>';
							if ($row -> Status == 'D') {
								$status='Dead';
							} else {
								$status= 'Alive';
							}
							$data.=$status.'</td>
							<td style="text-align:left;">' . $row -> case_number .'</td>
							<td style="text-align:left;">' . $row -> msos_code .'</td>
							<td style="text-align:left;">';
							$admin_log = $row -> logs_ebola -> toArray();
							if (isset($admin_log['0']['Admin_Response'])) {
							$c = $admin_log['0']['Admin_Response'];
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
							}
							}
							else{
								$nat= "<strong>No Response.</strong>";
							}
								
								$data.=$nat.'</td>';
								$data.='<td style="text-align:left;">';
							$admin_log = $row -> logs_ebola -> toArray();
							if (isset($admin_log['0']['RRT_Response'])) {
							$c = $admin_log['0']['RRT_Response'];
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
							}
							}
							else{
								$nat= "<strong>No Response.</strong>";
							}
								
								$data.=$nat.'</td>';
                             if ($row -> lab_results != 'Suspected') {
							 $kemri_response = $row -> kemri_response -> toArray();
								$results_release = new DateTime($row -> lab_time);
							$dis= "<td><strong>Results: </strong>" . $row -> lab_results . ".<br/><strong>Comments:</strong> " . $kemri_response['0']['comments'] . "<br/><strong>Released: </strong><strong>" . $results_release -> format('j F, Y g:i A') . "</strong>";
							}
							
							else{$dis ="<td><strong>No response.</strong>";}
							
						$data.=$dis.'</td></tr>';
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

	public function master_db() {
		$data['title'] = "Ebola Master Database";
		$data['content_view'] = "master_v_ebl";
		$data['banner_text'] = "Ebola Master_database";
		$data['link'] = "master_v";
		$data['all'] = Incidence_ebola::getAll();
		$data['quick_link'] = "master_v";
		$data['ebola_admin'] = 'true';
		$this -> load -> view("template", $data);
	}

	public function responses() {
		$data['title'] = "Ebola Response Download";
		$data['content_view'] = "ebola_response_download";
		$data['banner_text'] = "Download Ebola Responses";
		$data['link'] = "response_download";
		$data['all'] = Incidence_ebola::get_Response();
		//$all=Incidence_ebola::get_Response();
		$data['quick_link'] = "ebola_response_download";
		$data['ebola_admin'] = 'true';
		//print_r($all);
		$this -> load -> view("template", $data);
	}

	public function master_db_download() {
		$document_generated_time = date('Y-m-d G:i:s', time());
		$all = Incidence_ebola::getAll();
		$data = '<table border="0" style="margin-left: 0;" width="90%">';

		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis</td></tr><tr><td style="text-align:right;">Generated on: ' . $document_generated_time . '<td></tr>';

		$data .= '<td><table border="1" style="margin-left: 0;" width="80%">
					<thead>
					<tr>
			    <th style="text-align:left;">Phone</th>
			    <th style="text-align:left;">Event</th>
				<th style="text-align:left;">Location</th>
				<th style="text-align:left;">Date</th>
				<th style="text-align:left;">Time</th>
				<th style="text-align:left;">Sex</th>
				<th style="text-align:left;">Age</th>
				<th style="text-align:left;">Status</th>
				<th style="text-align:left;">Serial</th>
				<th style="text-align:left;">ID</th>
                <th style="text-align:left;"><b>Portal</b></th>							
					</tr>
					</thead>';
		foreach ($all as $row) :
			foreach($row->disease_name as $event):
			//$a = $row->incidence_time; $dt = new DateTime($a);
			$a = $row -> incidence_time;
			$dt = new DateTime($a);
			$data .= '
						<tr>
							<td style="text-align:left;">' . $row -> reported_by . '</td>
							<td style="text-align:left;">' . $event -> disease_name . '</td>
							<td style="text-align:left;">' . $row -> incidence_location . '</td>
							<td style="text-align:left;">' . $dt -> format('j F, Y') . '</td>
							<td style="text-align:left;">' . $dt -> format('g:i A') . '</td>
							<td style="text-align:left;"> ' . $row -> Sex . '</td>
							<td style="text-align:left;">' . $row -> Age . '</td>
							<td style="text-align:left;">' . $row -> Status . '</td>				            
							<td style="text-align:left;"> ' . $row -> case_number . '</td>
							<td style="text-align:left;"> ' . $row -> msos_code . '</td>
							';
			$dat = portal_db::get_supply_plan($row -> msos_code);
			// print_r($dat);
			$portal = "";
			//echo $rows->id;
			if ($dat) {
				$portal = "Web portal";
			} else {

				$portal = "SMS Portal";
			}
			$data .= '<td style="text-align:left;">' . $portal . '</td>
						</tr>';
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

	public function kemri_lab_results() {
		$data['title'] = "Ebola Lab Results";
		$data['content_view'] = "ebola_lab_results";
		$data['banner_text'] = "Ebola Lab Results";
		$data['link'] = "ebola_lab_results";
		$data['all'] = incidence_ebola::getAll();
		$data['quick_link'] = "ebola_lab_results";
		$data['ebola_admin'] = 'true';
		$this -> load -> view("template", $data);
	}

	public function specimen_results() {
		$id_incident = $this -> uri -> segment(3);
		$data['title'] = "Specimen Results";
		$data['content_view'] = "specimen_results";
		$data['banner_text'] = "Specimen Results";
		$data['link'] = "specimen_results";
		//$data['all'] = Incidence::get_suspected();
		$data['all'] = incidence_ebola::get_confirmation($id_incident);
		//$data['id_incident']=$id_incident;
		$data['quick_link'] = "specimen_results";

		$data['incident'] = incidence_ebola::get_incidence_ebola_count();
		$data['disease'] = incidence_ebola::get_disease_count();
		$data['confirm'] = incidence_ebola::confirm_ebola();
		$data['ebola_admin'] = 'true';
		$data['ebola'] = true;

		$this -> load -> view("template", $data);

	}

	public function kemri_table_view() {

		$data['title'] = "Kemri Ebola Results View";
		$data['content_view'] = "kemri_ebola_view";
		$data['banner_text'] = "Kemri Ebola Results View";
		$data['link'] = "kemri_view";
		$data['all'] = kemri_response_ebola::kemri_results_view();
		$data['quick_link'] = "kemri_ebola_view";
		$data['ebola_admin'] = 'true';
		$this -> load -> view("template", $data);

	}

	public function specimen_results_submit() {
		// getting form data
		$incident_id = $this -> input -> post('Incidence_id', TRUE);
		$date_received = $this -> input -> post('date_received');
		$date_1 = new datetime($date_received);
		// $date_begun=$this->input->post('date_test_begun',TRUE);
		//$date_1=new datetime($date_begun);
		$date_released = date("Y-m-d G:i:s", time());
		$specimen_type = $this -> input -> post('specimen_type', TRUE);
		$type_other = $this -> input -> post('specimen_comments', TRUE);
		$condition = $this -> input -> post('condition', TRUE);
		$other_cond = $this -> input -> post('specimen_condition', TRUE);
		$results = $this -> input -> post('sample_results', TRUE);
		$comments = $_POST['comments'];
		$id_table_incident = $this -> input -> post('id_1', TRUE);
		//echo $incident_id;

		//save to kemri_response table.
		$kemri = new kemri_response_ebola();
		$kemri -> incident_id = $incident_id;
		$kemri -> specimen_received = $date_1 -> format('Y-m-d');
		$kemri -> specimen_type = $specimen_type;
		if ($specimen_type == "Other") {
			$kemri -> other_specimen = $type_other;
		} else {
			$type_other = "";
			$kemri -> other_specimen = $type_other;
		}
		$kemri -> conditions = $condition;
		if ($condition == "Other") {
			$kemri -> other_condition = $other_cond;
		} else {
			$other_cond = "";
			$kemri -> other_condition = $other_cond;
		}
		$kemri -> comments = $comments;
		$kemri -> save();

		//update incidence table
		$data = array('lab_results' => $results, 'lab_time' => $date_released);
		$this -> db -> where('msos_code', $incident_id);

		$this -> db -> update('incidence_ebola', $data);
		//$this->confirm();
		/*$ebola_receivers=User::ebola_Kemri_receivers();
		 $messo="Kemri Lab Results: Ebola incident ID: ".$incident_id." found as: ".$results.". Lab time:  ".$date_released;
		 $message= rawurlencode($messo);
		 do{
		 $send_to=$ebola_receivers->telephone;
		 $syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=$send_to&text=$messo");
		 }
		 while($ebola_receivers);*/
		$all = User::ebola_Kemri_receivers();
		$message = "KEMRI Lab Results For The Suspected Ebola incident ID: " . $incident_id . " found as: " . $results . ". Comments: " . $comments . ". Lab time:  " . $date_released;
		foreach ($all as $row) {
			$error_r = rawurlencode($message);
			$sender_telephone = $row -> telephone;
			//echo "Sent to: ".$sender_telephone."<br/>";
			$syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=$sender_telephone&text=$error_r");
		}

		redirect('ebola_reports/kemri_lab_results');

	}

	public function kemri_report_download() {
		$document_generated_time = date('Y-m-d G:i:s', time());
		$all = kemri_response_ebola::kemri_results_view();
		$data = '<table border="0" style="margin-left: 0;" width="90%">';

		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis</td></tr><tr><td style="text-align:right;">Generated on: ' . $document_generated_time . '<td></tr>';

		$data .= '<td><table border="1" style="margin-left: 0;" width="80%">
					<thead>
					<tr>
				        <th style="text-align:left;">mSOS Id</th>
						<th style="text-align:left;">Date received</th>
						<th style="text-align:left;">Specimen type</th>
						<th style="text-align:left;">Specimen condition</th>
						<th style="text-align:left;">Results|Comments</th>							
					</tr>
					</thead>';
		foreach ($all as $row) :
			$a = $row['specimen_received'];
			$dt = new DateTime($a);
			$data .= '
						<tr>
							<td style="text-align:left;">' . $row['incident_id'] . '</td>
							<td style="text-align:left;">' . $dt -> format('j F, Y') . '</td>
							<td style="text-align:left;">';
			if ($row['specimen_type'] == "Other") {
				$data .= '<strong>' . $row -> specimen_type . ': </strong>' . $row -> other_specimen;
			} else {
				$data .= $row['specimen_type'];
			}

			$data .= '</td>';
			$data .= '<td>';
			if ($row['conditions'] == "Other") {
				$data .= "<strong>" . $row -> specimen_type . " : </strong>" . $row -> other_condition;
			} else {
				$data .= $row['conditions'];
			}

			$data .= '</td>';
			$incident_id = $row['incident_id'];
			$fetch_incidence = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT lab_results,lab_time FROM incidence_ebola WHERE msos_code='$incident_id'");
			foreach ($fetch_incidence as $rows) :
				$a = $rows['lab_time'];
				$dtz = new DateTime($a);
				$data .= '<td><strong>Results: </strong>' . $rows['lab_results'] . '<br/><strong>Comments:</strong>' . $row['comments'] . '<br/><strong>Released : </strong><strong>' . $dtz -> format('j F, Y g:i A') . '</strong></td>';

				$data .= '</tr>';
			endforeach;
		endforeach;
		$data .= '</tbody></table></td>';

		$data .= '</table>';
		$time = date("Y-m-d G:i:s", time());
		$filename = "Kemri_Report";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename.xls");
		echo "$data";

	}

	function raise_alert() {
		$access = $this -> session -> userdata('user_indicator');
		$data['title'] = "Report New Ebola Incident";
		$data['content_view'] = "new_ebola";
		$data['banner_text'] = "Report New Ebola Incident";
		$this -> load -> view("template", $data);
	}

}
