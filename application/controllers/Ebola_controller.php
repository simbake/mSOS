<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ebola_controller extends MY_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {

		if ($this -> session -> userdata('user_id')) {
			$this -> home();
		} else {
			redirect("home_controller");
		}
	}

	public function home() {

		$access_level = $this -> session -> userdata('user_indicator');

		//loading RRT homepage view
		if ($access_level == "Administrator" || $access_level == "Rapid Response" || $access_level == "KEMRI") {

			$this -> session -> userdata('user_id');
			/*$data['incident'] = Incidence::get_incidence_count();
			 $data['disease'] = Incidence::get_disease_count();
			 $data['confirm'] = Incidence::confirm();*/

			//status per disease

			$perconfirm = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.lab_results,d.disease_name as disease_name,d.disease_acronym FROM incidence_ebola i, rrt_diseases d  
      WHERE i.Disease_id=d.id GROUP BY i.Disease_id, i.lab_results ORDER BY i.Disease_id");

			$category = array();
			for ($t = 0; $t < count($perconfirm); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				$category[$t] = $perconfirm[$t]['disease_name'];
			}
			$category = array_unique($category);
			rsort($category);
			
			//print_r($perconfirm);exit;

			$cases_sus = array();
			$cases_conf = array();
			$cases_neg = array();
			$cases_Inde = array();
			$cases_Not = array();

			for ($t = 0; $t < count($perconfirm); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($perconfirm[$t]['lab_results'] == 'Suspected') {
					$cases_sus[$perconfirm[$t]['disease_name']] = array('Suspected' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['lab_results'] == 'Negative') {
					$cases_neg[$perconfirm[$t]['disease_name']] = array('Negative' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['lab_results'] == 'Positive') {
					$cases_conf[$perconfirm[$t]['disease_name']] = array('Positive' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['lab_results'] == 'Indeterminate') {
					$cases_Inde[$perconfirm[$t]['disease_name']] = array('Indeterminate' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['lab_results'] == 'Not_Done') {
					$cases_Not[$perconfirm[$t]['disease_name']] = array('Not_Done' => intval($perconfirm[$t]['total']));

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
				if (!array_key_exists($name, $cases_Inde)) {
					$cases_Inde[$name] = array('Indeterminate' => 0);
				}
				if (!array_key_exists($name, $cases_Not)) {
					$cases_Not[$name] = array('Not_Done' => 0);
				}
			}

			krsort($cases_sus);
			krsort($cases_conf);
			krsort($cases_neg);
			krsort($cases_Inde);
			krsort($cases_Not);

			$strXML_e5 = "<chart palette='2' caption='Lifetime Alert Analysis' shownames='1' canvasbgColor='' canvasbgAlpha='90' showvalues='0' xAxisName='Diseases' yAxisName='Quantity' useRoundEdges='1' legendBorderAlpha='0'><categories>";

			foreach ($category as $name) {

				$strXML_e5 .= "<category label='$name' />";
			}
			$strXML_e5 .= "</categories>";

			$strXML_e5 .= "<dataset seriesName='Suspected' color='#FFA500'   showValues='0'>";
			foreach ($cases_sus as $sus => $value) {
				if ($value['Suspected'] != 0) {
					$strXML_e5 .= "<set value='$value[Suspected]' />";
				}
			}
			$strXML_e5 .= "</dataset>";
			$strXML_e5 .= "<dataset seriesName='Positive' color='#FF0000' showValues='0'>";
			foreach ($cases_conf as $conf => $value) {
				if ($value['Positive'] != 0) {
					$strXML_e5 .= "<set value='$value[Positive]' />";
				}
			}
			$strXML_e5 .= "</dataset>";

			$strXML_e5 .= "<dataset seriesName='Negative' color='#008000' showValues='0'>";
			foreach ($cases_neg as $neg => $value) {
				if ($value['Negative'] != 0) {
					$strXML_e5 .= "<set value='$value[Negative]' />";
				}
			}
			$strXML_e5 .= "</dataset>";

			$strXML_e5 .= "<dataset seriesName='Indeterminate' color='#FFFF00' showValues='0'>";
			foreach ($cases_Inde as $Inde => $value) {
				if ($value['Indeterminate'] != 0) {
					$strXML_e5 .= "<set value='$value[Indeterminate]' />";
				}
			}
			$strXML_e5 .= "</dataset>";

			$strXML_e5 .= "<dataset seriesName='Not Done' color='#0000FF' showValues='0'>";
			foreach ($cases_Not as $Not => $value) {
				if ($value['Not_Done'] != 0) {
					$strXML_e5 .= "<set value='$value[Not_Done]' />";
				}
			}
			$strXML_e5 .= "</dataset>";

			$strXML_e5 .= "</chart>";
			$data['strXML_e5'] = $strXML_e5;


			/*$coodinates = incidence_ebola::get_ebola_count();

			 //echo count($coodinates);
			 $this -> load -> library('googlemaps');
			 $config['cluster'] = FALSE;
			 $config['center'] = '-0.023559,37.90619';
			 $config['zoom'] = '6';
			 $this -> googlemaps -> initialize($config);

			 foreach ($coodinates as $coordinate) {

			 foreach ($coordinate->incident as $vals) {

			 foreach ($coordinate->disease_name as $disease1) {

			 $marker = array();
			 $marker['position'] = $vals -> latitude . ',' . $vals -> longitude;
			 $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|9999FF|000000';
			 $marker['animation'] = 'DROP';
			 $marker['infowindow_content'] = 'Facility :' . $vals -> Facility_name . '<br>' . 'Incidents Reported ' . $coordinate -> total . '<br>' . '<a href="' . site_url('report_management/facility_alerts/' . $coordinate -> Mfl_Code) . '" class="linkss">View Details</a>';
			 $this -> googlemaps -> add_marker($marker);
			 }
			 }
			 }

			 $data['map'] = $this -> googlemaps -> create_map();*/

			/*} else if ($access_level == "District Administrator") {
			 redirect("district/index");
			 } else if ($access_level == "County Administrator") {
			 redirect("county/index");
			 } else if ($access_level == "KEMRI") {
			 redirect("kemri/index");
			 }*/
			//$this -> load -> view("template", $data);
			/*$pass_check=$this->session->userdata('pass_check');
			 if($pass_check){
			 echo "<script>alert('Password change was sucessfull')</script>";
			 $pass_check=null;
			 }*/
		}

		$data['banner_text'] = "Rapid Response Home";
		$data['link'] = "Ebola_Information";
		$data['title'] = "Rapid Response";
		$data['content_view'] = "ebola_v";
		$data['scripts'] = array("FusionCharts/FusionCharts.js");
		$all_diseases = rrt_diseases::getAll();
		$data['all_diseases'] = $all_diseases;
		$data['ebola_admin'] = 'true';

		$this -> load -> view("template", $data);

	}

	function load_stock() {
		$data['title'] = "Stock level";
		$data['content_view'] = "stock";
		$data['scripts'] = array("FusionCharts/FusionCharts.js");
		$data['banner_text'] = "System Home";
		$data['quick_link'] = "load_stock";
		$data['link'] = "home";
		$this -> load -> view("template", $data);

	}

	public function session_timeout() {
		$data['title'] = "Session Timeout";
		$data['content_view'] = "session_timeout";
		$data['banner_text'] = "Session Timeout";
		$data['link'] = "session_timeout";
		$data['quick_link'] = "session_timeout";
		$this -> load -> view("template", $data);
		//$this->load->view('session_timeout');
		//echo "<strong>Session Timeout!! Please login to continue..</strong>";
	}

}
