<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Report_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['title'] = "System Report";
		$data['scripts'] = array("FusionCharts/FusionCharts.js");
		$data['content_view'] = "report_v";
		$data['incident'] = Incidence::get_incidence_count();
		$data['disease'] = Incidence::get_disease_count();
		$data['confirm'] = Incidence::confirm();
		$data['list'] = Diseases::getAll();

		//status per disease

		$perconfirm = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d  
      WHERE i.Disease_id=d.id  GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id");

		$category = array();
		for ($t = 0; $t < count($perconfirm); $t++) {
			//echo $perconfirm[$t]['Disease'].'<br>';
			$category[$t] = $perconfirm[$t]['acronym'];
		}
		$category = array_unique($category);
		rsort($category);

		$cases_sus = array();
		$cases_conf = array();
		$cases_neg = array();
		$cases_inde = array();
		for ($t = 0; $t < count($perconfirm); $t++) {
			//echo $perconfirm[$t]['Disease'].'<br>';
			if ($perconfirm[$t]['confirmation'] == 'Suspected') {
				$cases_sus[$perconfirm[$t]['acronym']] = array('Suspected' => intval($perconfirm[$t]['total']));

			} else if ($perconfirm[$t]['confirmation'] == 'Negative') {
				$cases_neg[$perconfirm[$t]['acronym']] = array('Negative' => intval($perconfirm[$t]['total']));

			} else if($perconfirm[$t]['confirmation'] == 'Positive') {
				$cases_conf[$perconfirm[$t]['acronym']] = array('Positive' => intval($perconfirm[$t]['total']));

			}
			else if ($perconfirm[$t]['confirmation'] == 'Indeterminate') {
				$cases_inde[$perconfirm[$t]['acronym']] = array('Indeterminate' => intval($perconfirm[$t]['total']));

			}
			//close if statement

		}

		foreach ($category as $name) {

			if (!array_key_exists($name, $cases_sus)) {
				$cases_sus[$name] = array('Suspected' => 0);
			}
			if (!array_key_exists($name, $cases_conf)) {
				$cases_conf[$name] = array('Positive' => 0);
			}

			if (!array_key_exists($name, $cases_neg)) {
				$cases_neg[$name] = array('Negative' => 0);
			}
			if (!array_key_exists($name, $cases_neg)) {
				$cases_inde[$name] = array('Indeterminate' => 0);
			}
		}

		krsort($cases_sus);
		krsort($cases_conf);
		krsort($cases_neg);

		$strXML_e5 = "<chart palette='2' caption='Lifetime Alert Analysis' shownames='1' showvalues='0' xAxisName='Diseases' yAxisName='Quantity' useRoundEdges='1' legendBorderAlpha='0'><categories>";

		foreach ($category as $name) {

			$strXML_e5 .= "<category label='$name' />";
		}
		$strXML_e5 .= "</categories>";

		$strXML_e5 .= "<dataset seriesName='Suspected' showValues='0'>";
		foreach ($cases_sus as $sus => $value) {

			$strXML_e5 .= "<set value='$value[Suspected]' />";
		}
		$strXML_e5 .= "</dataset>";
		$strXML_e5 .= "<dataset seriesName='Positive' showValues='0'>";
		foreach ($cases_conf as $conf => $value) {

			$strXML_e5 .= "<set value='$value[Positive]' />";
		}
		$strXML_e5 .= "</dataset>";

		$strXML_e5 .= "<dataset seriesName='Negative' showValues='0'>";
		foreach ($cases_neg as $neg => $value) {

			$strXML_e5 .= "<set value='$value[Negative]' />";
		}
		$strXML_e5 .= "</dataset>";

		$strXML_e5 .= "</chart>";
		$data['strXML_e5'] = $strXML_e5;

		$y = DATE('Y');
		$m = DATE('m');
		$mo = DATE('M');
		$monthly = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d  
      WHERE i.Disease_id=d.id AND YEAR(i.time)='$y' AND MONTH(i.time)='$m' GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id ");
		$disease_n = array();
		for ($t = 0; $t < count($monthly); $t++) {
			//echo $perconfirm[$t]['Disease'].'<br>';
			$disease_n[$t] = $monthly[$t]['acronym'];
		}

		$disease_n = array_unique($disease_n);
		rsort($disease_n);
		$cases_susmon = array();
		$cases_confmon = array();
		$cases_negmon = array();
		for ($t = 0; $t < count($monthly); $t++) {
			//echo $perconfirm[$t]['Disease'].'<br>';
			if ($monthly[$t]['confirmation'] == 'Suspected') {
				$cases_susmon[$monthly[$t]['acronym']] = array('Suspected' => intval($monthly[$t]['total']));

			} else if ($monthly[$t]['confirmation'] == 'Negative') {
				$cases_negmon[$monthly[$t]['acronym']] = array('Negative' => intval($monthly[$t]['total']));

			} else {
				$cases_confmon[$monthly[$t]['acronym']] = array('Positive' => intval($monthly[$t]['total']));

			}
			//close if statement

		}

		foreach ($disease_n as $namemon) {
			if (!array_key_exists($namemon, $cases_susmon)) {
				$cases_susmon[$namemon] = array('Suspected' => 0);
			}

			if (!array_key_exists($namemon, $cases_confmon)) {
				$cases_confmon[$namemon] = array('Positive' => 0);
			}

			if (!array_key_exists($namemon, $cases_negmon)) {
				$cases_negmon[$namemon] = array('Negative' => 0);
			}
		}
		krsort($cases_susmon);
		krsort($cases_confmon);
		krsort($cases_negmon);
		$strXML_e1 = "<chart palette='2' caption='Monthly Alert Analysis ( $mo )' shownames='1' showvalues='0' xAxisName='Diseases' yAxisName='Quantity' useRoundEdges='1' legendBorderAlpha='0'><categories>";

		foreach ($disease_n as $namemon) {

			$strXML_e1 .= "<category label='$namemon' />";
		}
		$strXML_e1 .= "</categories>";

		$strXML_e1 .= "<dataset seriesName='Suspected' showValues='0'>";
		foreach ($cases_susmon as $sus => $value) {

			$strXML_e1 .= "<set value='$value[Suspected]' />";
		}
		$strXML_e1 .= "</dataset>";
		$strXML_e1 .= "<dataset seriesName='Positive' showValues='0'>";
		foreach ($cases_confmon as $conf => $value) {

			$strXML_e1 .= "<set value='$value[Positive]' />";
		}
		$strXML_e1 .= "</dataset>";

		$strXML_e1 .= "<dataset seriesName='Negative' showValues='0'>";
		foreach ($cases_negmon as $negmon => $value) {

			$strXML_e1 .= "<set value='$value[Negative]' />";
		}
		$strXML_e1 .= "</dataset>";

		$strXML_e1 .= "</chart>";
		$data['strXML_e1'] = $strXML_e1;

		//daily alert analysis
		$daily = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym, 
			DATE(i.time) as dater FROM incidence i, diseases d  WHERE i.Disease_id=1 AND YEAR(i.time)='$y' AND MONTH(i.time)='$m' AND i.Disease_id=d.id GROUP BY DATE(i.time),i.confirmation");

		$disease_d = array();
		for ($t = 0; $t < count($daily); $t++) {
			//echo $perconfirm[$t]['Disease'].'<br>';
			$disease_d[$t] = $daily[$t]['dater'];
		}

		$disease_d = array_unique($disease_d);
		rsort($disease_d);

		$cases_susdai = array();
		$cases_confdai = array();
		$cases_negdai = array();
		for ($t = 0; $t < count($daily); $t++) {
			//echo $perconfirm[$t]['Disease'].'<br>';
			if ($daily[$t]['confirmation'] == 'Suspected') {
				$cases_susdai[$daily[$t]['acronym']] = array('Suspected' => intval($daily[$t]['total']));

			} else if ($daily[$t]['confirmation'] == 'Negative') {
				$cases_negdai[$daily[$t]['acronym']] = array('Negative' => intval($daily[$t]['total']));

			} else {
				$cases_confdai[$daily[$t]['acronym']] = array('Positive' => intval($daily[$t]['total']));
			}
			//close if statement

		}

		foreach ($disease_d as $namedai) {
			if (!array_key_exists($namedai, $cases_susdai)) {
				$cases_susdai[$namedai] = array('Suspected' => 0);
			}
			if (!array_key_exists($namedai, $cases_confdai)) {
				$cases_negdai[$namedai] = array('Negative' => 0);
			}

			if (!array_key_exists($namedai, $cases_confdai)) {
				$cases_confdai[$namedai] = array('Positive' => 0);
			}

		}
		krsort($cases_susdai);
		krsort($cases_confdai);
		krsort($cases_negdai);
		$strXML_e2 = "<chart palette='2' caption='Daily Alert Analysis' shownames='1' showvalues='0' xAxisName='Diseases' yAxisName='Quantity' useRoundEdges='1' legendBorderAlpha='0'><categories>";

		foreach ($disease_d as $namemo) {

			$strXML_e2 .= "<category label='$namemo' />";
		}
		$strXML_e2 .= "</categories>";

		$strXML_e2 .= "<dataset seriesName='Suspected' showValues='0'>";
		foreach ($cases_susdai as $sus1 => $value) {

			$strXML_e2 .= "<set value='$value[Suspected]' />";
		}
		$strXML_e2 .= "</dataset>";
		$strXML_e2 .= "<dataset seriesName='Positive' showValues='0'>";
		foreach ($cases_confdai as $conf1 => $value) {

			$strXML_e2 .= "<set value='$value[Positive]' />";
		}
		$strXML_e2 .= "</dataset>";

		$strXML_e2 .= "<dataset seriesName='Negative' showValues='0'>";
		foreach ($cases_negdai as $negmon1 => $value) {

			$strXML_e2 .= "<set value='$value[Negative]' />";
		}
		$strXML_e2 .= "</dataset>";

		$strXML_e2 .= "</chart>";
		$data['strXML_e2'] = $strXML_e2;

		$data['banner_text'] = "System Reports";
		$data['link'] = "Reports";
		$this -> load -> view("template", $data);

	}

	public function monthly() {
		//$data['scripts'] = array("FusionCharts/FusionCharts.js");
		$y = $_POST['year'];
		$m = $_POST['month'];
		$monthly = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d  
      WHERE i.Disease_id=d.id AND YEAR(i.time)='$y' AND MONTH(i.time)='$m' GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id ");
		$data['monthly'] = $monthly;
		$this -> load -> view("graphs/monthly_v", $data);
	}

	public function daily() {

		$y = $_POST['year'];
		$m = $_POST['month'];
		$d = $_POST['disease'];

		$daily = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym, 
			DATE(i.time) as dater FROM incidence i, diseases d  WHERE i.Disease_id='$d' AND YEAR(i.time)='$y' AND MONTH(i.time)='$m' AND i.Disease_id=d.id GROUP BY DATE(i.time),i.confirmation");
		$data['name'] = $this -> input -> post('name');
		$data['daily'] = $daily;
		$this -> load -> view("graphs/daily", $data);
	}

	public function commodity_excel() {
		$all = Incidence::get_all();
		$data = '<table style="margin-left: 0;" width="80%">';

		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis</td></tr>';
		$data .= '<td><table style="margin-left: 0;" width="80%">
					<thead>
					<tr>
						<th style="text-align:left;"><b>Disease</b></th>
						<th style="text-align:left;"><b>Date</b></th>
						<th style="text-align:left;"><b>Sex</b></th>
						<th style="text-align:left;"><b>Age</b></th>
                        <th style="text-align:left;">Old Age</th>
				        <th style="text-align:left;">Old Sex</th>
				        <th style="text-align:left;">Old Status</th>						
						<th style="text-align:left;"><b>Facility</b></th>
						<th style="text-align:left;"><b>Incident ID</b></th>
						<th style="text-align:left;"><b>Status</b></th>	
							
                        <th style="text-align:left;"><b>Portal</b></th>							
					</tr>
					</thead>';
		foreach ($all as $row) :
			foreach ($row->incident as $d) :
				foreach ($row->disease_name as $faci) :
				$a = $row->Time; $dt = new DateTime($a);
				 
					$data .= '
						<tr>
							<td style="text-align:left;">' . $faci -> Full_Name . '</td>
							<td style="text-align:left;">' . $dt->format('jS F Y g:i A') . '</td>
							<td style="text-align:left;">' . $row -> Sex . '</td>
							<td style="text-align:left;">' . $row -> Age . '</td>
							<td style="text-align:left;">'.$row -> New_Age.'</td>
							<td style="text-align:left;">'. $row -> New_Sex .'</td>				            
				            <td style="text-align:left;">'.$row -> New_Status.' </td>
							<td style="text-align:left;"> ' . $d -> Facility_name . '</td>
							<td style="text-align:left;"> ' . $row -> p_id . '</td>
							<td style="text-align:left;"> ' . $row -> Status . '</td>
							
							';
							 $dat = portal_db::get_supply_plan($row -> p_id);
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
		$filename = "Master_Database";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename.xls");
		echo "$data";
	}

	public function traffic() {
		$all = Logi::getAll();
		$data = '<table style="margin-left: 0;"  width="80%">';

		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis</td></tr>';
		$data .= '<td><table style="margin-left: 0;" width="80%">
					<thead>
					<tr>
						<th style="text-align:left;"><b>Access By</b></th>
						<th style="text-align:left;"><b>Login Time</b></th>
						<th style="text-align:left;"><b>Logout Time</b></th>
						<th style="text-align:left;"><b>Status</b></th>	
						<th style="text-align:left;"><b>Duration</b></th>
						    
					</tr>
					</thead>';
		foreach ($all as $row) :
			foreach ($row->logss as $d) :
                  $a = $row->t_login ;
				  $b=$row->t_logout;
						$dates = new DateTime($a);$dates->format('j F, Y g:i A');
						$dates_1 = new DateTime($b);$dates_1->format('j F, Y g:i A');
						$difference = $dates->diff( $dates_1 );
						          $hours= $difference->format('%h hours');
								  $minutes= $difference->format('%i minutes');
								  $seconds= $difference->format('%s seconds');
								  $diff="";
								  if($hours>0){
								  	$diff.= $hours." ";
								  }
								  if($minutes>0){
								  	$diff.= $minutes." ";
								  }
								  if($seconds){
								  	$diff.= $seconds;
								  }
				$data .= '
						<tr>
							<td style="text-align:left;">' . $d -> fname . '</td>
							<td style="text-align:left;">' . $dates->format('jS F Y g:i A') . '</td>
							<td style="text-align:left;">' . $dates_1->format('jS F Y g:i A') . '</td>
							<td style="text-align:left;">' . $row -> status . '</td>
                            <td style="text-align:left;">' . $diff. '</td>
										
						</tr>';
			endforeach;
		endforeach;

		$data .= '</tbody></table></td>';

		$data .= '</table>';
		$time = date("Y-m-d G:i:s", time());
		$filename = "Traffic";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename.xls");
		echo "$data";
	}

	public function download_response() {
		$access_level=$this->session->userdata("user_indicator");
		if($access_level=="Administrator" || $access_level=="MOH"){
		$all = Incidence::get_all();
		}
		else if($access_level=="District Administrator"){
		$district=$this -> session -> userdata('district');
		$all = Incidence::get_district_incidents($district);
		}
		else if($access_level=="County Administrator"){
		$county=$this->session->userdata("county");
		$all =Incidence::get_county_incidents($county);	
		}
		else{
			echo "Hello";
		}
		$data = '<table  border="0" class="table table-responsive table-striped table-bordered" width="100%">';

		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis</td></tr>';
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
						<th style="text-align:left;">County Response</th>
						<th style="text-align:left;">District Response</th>
						<th style="text-align:left;">Kemri Response</th>
										    
					</tr>
					</thead>';
		foreach($all as $row):
						foreach($row->incident as $d):
						foreach($row->disease_name as $faci):
						foreach($row->logs as $log):
						$a = $row->Time ;
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
							<td style="text-align:left;">' . $row -> p_id .'</td>
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
							<td></td>
							<td style="text-align:left;">';
								$g = $log -> district_incident;
								$g = explode('|', $g);
								$no=count($g);
								if($no>=5){
								$act = $g[0];
								$note = $g[1];
								$find = $g[2];
								$tim = $g[3];
								$take = $g[4];
								$dttg = new DateTime($tim);
								$dis= '<strong>Action :</strong>' . $act . '<br>' . '<strong>Notes :</strong>' . $note . '<br>' . '<strong>Findings :</strong>' . $find . '<br><strong>Time :</strong>' . $dttg -> format('j F, Y g:i A');
								}else{
									$dis= "No Response.";
								}
								$data.=$dis.'</td>';
						
							$incident_id=$row->p_id;
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

	public function filter() {
		$id = $this -> input -> post('id');
		//maps
		$coodinates = Incidence::get_filter($id);
		//echo count($coodinates);
		$this -> load -> library('googlemaps');
		$config['cluster'] = TRUE;
		$config['center'] = '-0.023559,37.90619';
		$config['zoom'] = '6';
		$this -> googlemaps -> initialize($config);

		foreach ($coodinates as $coordinate) {

			foreach ($coordinate->incident as $vals) {

				$marker = array();
				$marker['position'] = $vals -> latitude . ',' . $vals -> longitude;
				//echo $vals -> latitude . ',' . $vals -> longitude.'<br>';
				$this -> googlemaps -> add_marker($marker);

			}
		}
		$data['map'] = $this -> googlemaps -> create_map();
		$this -> load -> view("graphs/map", $data);
	}

	public function facility_alerts() {
		$id = $this -> uri -> segment(3);
		$data['title'] = "Facility Incidents";
		$data['content_view'] = "f_incidents";
		$data['banner_text'] = "Facility Incidents";
		$data['link'] = "f_incidents";
		$data['all'] = Incidence::facility_incidents($id);
		$data['quick_link'] = "f_incidents";
		$this -> load -> view("template", $data);
	}
	public function responses(){
		$data['title'] = "Response Download";
		$data['content_view'] = "response_download";
		$data['banner_text'] = "Download Responses";
		$data['link'] = "response_download";
		$user_level=$this->session->userdata("user_indicator");
		if($user_level=='Administrator' || $user_level=='MOH' ){
		$data['all'] = Incidence::get_all();
		}
		else if($user_level=='District Administrator'){
		$district=$this -> session -> userdata('district');
		$data['all'] = Incidence::get_district_incidents($district);
		}
		else if($user_level=='County Administrator'){
		$county=$this->session->userdata("county");
		$data['all'] =Incidence::get_county_incidents($county);
		}
		else{
			redirect("user_rights");
		}
		$data['quick_link'] = "response_download";
		$this -> load -> view("template", $data);
	}
	public function kemri_response_report(){
	$data=kemri_response::kemri_response_report();
	print_r($data);
	}

}
