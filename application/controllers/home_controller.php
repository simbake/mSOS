<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Home_Controller extends MY_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {

		$this -> home();
	}

	public function home() {
		if ($this -> session -> userdata("ebola_login") == 1) {
			redirect("Ebola_controller");
		}

		$access_level = $this -> session -> userdata('user_indicator');

		//loading Admin/MOH homepage view
		if ($access_level == "Administrator" || $access_level == "MOH") {
			$this -> session -> userdata('user_id');
			$data['title'] = "System Home";

			$data['title'] = "System Home";
			$data['scripts'] = array("FusionCharts/FusionCharts.js");
			$data['content_view'] = "home_v";
			/*$data['incident'] = Incidence::get_incidence_count();
			 $data['disease'] = Incidence::get_disease_count();
			 $data['confirm'] = Incidence::confirm();*/
			$data['list'] = Diseases::getAll();

			//status per disease

			$perconfirm = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d  
      WHERE i.Disease_id=d.id GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id");

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
			$cases_Inde = array();
			$cases_Not = array();

			for ($t = 0; $t < count($perconfirm); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($perconfirm[$t]['confirmation'] == 'Suspected') {
					$cases_sus[$perconfirm[$t]['acronym']] = array('Suspected' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Negative') {
					$cases_neg[$perconfirm[$t]['acronym']] = array('Negative' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Positive') {
					$cases_conf[$perconfirm[$t]['acronym']] = array('Positive' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Indeterminate') {
					$cases_Inde[$perconfirm[$t]['acronym']] = array('Indeterminate' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Not_Done') {
					$cases_Not[$perconfirm[$t]['acronym']] = array('Not_Done' => intval($perconfirm[$t]['total']));

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
			$cases_Indeterm = array();
			for ($t = 0; $t < count($monthly); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($monthly[$t]['confirmation'] == 'Suspected') {
					$cases_susmon[$monthly[$t]['acronym']] = array('Suspected' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Negative') {
					$cases_negmon[$monthly[$t]['acronym']] = array('Negative' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Positive') {
					$cases_confmon[$monthly[$t]['acronym']] = array('Positive' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Indeterminate') {
					$cases_Indeterm[$monthly[$t]['acronym']] = array('Indeterminate' => intval($monthly[$t]['total']));

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
				if (!array_key_exists($namemon, $cases_negmon)) {
					$cases_Indeterm[$namemon] = array('Indeterminate' => 0);
				}
			}
			krsort($cases_susmon);
			krsort($cases_confmon);
			krsort($cases_negmon);
			krsort($cases_Indeterm);
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

			$strXML_e1 .= "<dataset seriesName='Indeterminate' showValues='0'>";
			foreach ($cases_Indeterm as $Indeterm => $value) {

				$strXML_e1 .= "<set value='$value[Indeterminate]' />";
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
			$cases_indedai = array();
			for ($t = 0; $t < count($daily); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($daily[$t]['confirmation'] == 'Suspected') {
					$cases_susdai[$daily[$t]['acronym']] = array('Suspected' => intval($daily[$t]['total']));

				} else if ($daily[$t]['confirmation'] == 'Negative') {
					$cases_negdai[$daily[$t]['acronym']] = array('Negative' => intval($daily[$t]['total']));

				} else if ($daily[$t]['confirmation'] == 'Positive') {
					$cases_confdai[$daily[$t]['acronym']] = array('Positive' => intval($daily[$t]['total']));
				} else if ($daily[$t]['confirmation'] == 'Indeterminate') {
					$cases_indedai[$daily[$t]['acronym']] = array('Indeterminate' => intval($daily[$t]['total']));
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
				if (!array_key_exists($namedai, $cases_indedai)) {
					$cases_indedai[$namedai] = array('Indeterminate' => 0);
				}

			}
			krsort($cases_susdai);
			krsort($cases_confdai);
			krsort($cases_negdai);
			krsort($cases_indedai);
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

			$strXML_e2 .= "<dataset seriesName='Indeterminate' showValues='0'>";
			foreach ($cases_indedai as $negmon1 => $value) {

				$strXML_e2 .= "<set value='$value[Indeterminate]' />";
			}
			$strXML_e2 .= "</dataset>";

			$strXML_e2 .= "</chart>";
			$data['strXML_e2'] = $strXML_e2;

			$coordinates = Incidence::get_facility_count();

			$data['banner_text'] = "System Home";
			$data['link'] = "home";
		}

		//loading district homepage view
		else if ($access_level == "District Administrator") {
			$district = $this -> session -> userdata('district');
			$data['title'] = "District Home";
			$data['scripts'] = array("FusionCharts/FusionCharts.js");
			$data['content_view'] = "home_v";
			/*$data['incident'] = Incidence::get_incidence_count_district($district);
			 $data['disease'] = Incidence::get_disease_count_district($district);
			 $data['confirm'] = Incidence::confirm_district($district);*/
			$data['list'] = Diseases::getAll();

			//status per disease
			$perconfirm = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d  
      WHERE i.Disease_id=d.id AND i.district='$district'  GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id");

			/*$perconfirm = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d
			 WHERE i.Disease_id=d.id  GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id");*/

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
			$cases_Inde = array();
			for ($t = 0; $t < count($perconfirm); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($perconfirm[$t]['confirmation'] == 'Suspected') {
					$cases_sus[$perconfirm[$t]['acronym']] = array('Suspected' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Negative') {
					$cases_neg[$perconfirm[$t]['acronym']] = array('Negative' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Positive') {
					$cases_conf[$perconfirm[$t]['acronym']] = array('Positive' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Indeterminate') {
					$cases_Inde[$perconfirm[$t]['acronym']] = array('Indeterminate' => intval($perconfirm[$t]['total']));

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
			}

			krsort($cases_sus);
			krsort($cases_conf);
			krsort($cases_neg);
			krsort($cases_Inde);

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

			$strXML_e5 .= "<dataset seriesName='Indeterminate' showValues='0'>";
			foreach ($cases_Inde as $Inde => $value) {

				$strXML_e5 .= "<set value='$value[Indeterminate]' />";
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
			$cases_Indeterm = array();
			for ($t = 0; $t < count($monthly); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($monthly[$t]['confirmation'] == 'Suspected') {
					$cases_susmon[$monthly[$t]['acronym']] = array('Suspected' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Negative') {
					$cases_negmon[$monthly[$t]['acronym']] = array('Negative' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Positive') {
					$cases_confmon[$monthly[$t]['acronym']] = array('Positive' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Indeterminate') {
					$cases_Indeterm[$monthly[$t]['acronym']] = array('Indeterminate' => intval($monthly[$t]['total']));

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
				if (!array_key_exists($namemon, $cases_negmon)) {
					$cases_Indeterm[$namemon] = array('Indeterminate' => 0);
				}
			}
			krsort($cases_susmon);
			krsort($cases_confmon);
			krsort($cases_negmon);
			krsort($cases_Indeterm);
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

			$strXML_e1 .= "<dataset seriesName='Indeterminate' showValues='0'>";
			foreach ($cases_Indeterm as $Indeterm => $value) {

				$strXML_e1 .= "<set value='$value[Indeterminate]' />";
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
			$cases_indedai = array();
			for ($t = 0; $t < count($daily); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($daily[$t]['confirmation'] == 'Suspected') {
					$cases_susdai[$daily[$t]['acronym']] = array('Suspected' => intval($daily[$t]['total']));

				} else if ($daily[$t]['confirmation'] == 'Negative') {
					$cases_negdai[$daily[$t]['acronym']] = array('Negative' => intval($daily[$t]['total']));

				} else if ($daily[$t]['confirmation'] == 'Positive') {
					$cases_confdai[$daily[$t]['acronym']] = array('Positive' => intval($daily[$t]['total']));
				} else if ($daily[$t]['confirmation'] == 'Indeterminate') {
					$cases_indedai[$daily[$t]['acronym']] = array('Indeterminate' => intval($daily[$t]['total']));
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
				if (!array_key_exists($namedai, $cases_indedai)) {
					$cases_indedai[$namedai] = array('Indeterminate' => 0);
				}

			}
			krsort($cases_susdai);
			krsort($cases_confdai);
			krsort($cases_negdai);
			krsort($cases_indedai);
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

			$strXML_e2 .= "<dataset seriesName='Indeterminate' showValues='0'>";
			foreach ($cases_indedai as $negmon1 => $value) {

				$strXML_e2 .= "<set value='$value[Indeterminate]' />";
			}
			$strXML_e2 .= "</dataset>";

			$strXML_e2 .= "</chart>";
			$data['strXML_e2'] = $strXML_e2;
			//maps
			$coordinates = Incidence::get_district($district);

			$data['banner_text'] = "District View";
			$data['link'] = "home";

		}

		//loading county homepage
		else if ($access_level == "County Administrator") {
			$county = $this -> session -> userdata('county');
			$data['title'] = "County Home";
			$data['scripts'] = array("FusionCharts/FusionCharts.js");
			$data['content_view'] = "home_v";
			/*$data['incident'] = Incidence::get_incidence_count_county($county);
			 $data['disease'] = Incidence::get_disease_count_county($county);
			 $data['confirm'] = Incidence::confirm_county($county);*/
			$data['list'] = Diseases::getAll();

			//status per disease

			$perconfirm = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d  
      WHERE i.Disease_id=d.id AND i.county='$county'  GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id");

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
			for ($t = 0; $t < count($perconfirm); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($perconfirm[$t]['confirmation'] == 'Suspected') {
					$cases_sus[$perconfirm[$t]['acronym']] = array('Suspected' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Negative') {
					$cases_neg[$perconfirm[$t]['acronym']] = array('Negative' => intval($perconfirm[$t]['total']));

				} else {
					$cases_conf[$perconfirm[$t]['acronym']] = array('Positive' => intval($perconfirm[$t]['total']));

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
			$monthly = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d  
      WHERE  i.county='$county' AND i.Disease_id=d.id AND YEAR(i.time)='$y' AND MONTH(i.time)='$m' GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id ");
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
			$strXML_e1 = "<chart palette='2' caption='Monthly Alert Analysis' shownames='1' showvalues='0' xAxisName='Diseases' yAxisName='Quantity' useRoundEdges='1' legendBorderAlpha='0'><categories>";

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
			DATE(i.time) as dater FROM incidence i, diseases d  WHERE i.Disease_id=1 AND YEAR(i.time)='$y' AND MONTH(i.time)='$m' AND i.Disease_id=d.id AND i.county='$county' GROUP BY DATE(i.time),i.confirmation");

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
			krsort($cases_confdai);
			krsort($cases_susdai);
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

			//maps
			$coodinates = Incidence::get_county($county);

			$data['banner_text'] = "County View";
			$data['link'] = "home";

		}

		//loading public homepage
		else {
			$data['title'] = "Public Domain";
			$data['scripts'] = array("FusionCharts/FusionCharts.js");
			$data['content_view'] = "home_v";
			$data['incident'] = Incidence::get_incidence_count();
			$data['disease'] = Incidence::get_disease_count();
			$data['confirm'] = Incidence::confirm();
			$data['list'] = Diseases::getAll();

			//status per disease

			$perconfirm = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT count( i.id ) AS total, i.Disease_id, i.confirmation,d.full_name as Full_Name,d.acronym FROM incidence i, diseases d  
      WHERE i.Disease_id=d.id AND d.acronym != 'EBL'  GROUP BY i.Disease_id, i.confirmation ORDER BY i.Disease_id");

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
			$cases_Inde = array();
			$cases_Not = array();

			for ($t = 0; $t < count($perconfirm); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($perconfirm[$t]['confirmation'] == 'Suspected') {
					$cases_sus[$perconfirm[$t]['acronym']] = array('Suspected' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Negative') {
					$cases_neg[$perconfirm[$t]['acronym']] = array('Negative' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Positive') {
					$cases_conf[$perconfirm[$t]['acronym']] = array('Positive' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Indeterminate') {
					$cases_Inde[$perconfirm[$t]['acronym']] = array('Indeterminate' => intval($perconfirm[$t]['total']));

				} else if ($perconfirm[$t]['confirmation'] == 'Not_Done') {
					$cases_Not[$perconfirm[$t]['acronym']] = array('Not_Done' => intval($perconfirm[$t]['total']));

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
			$cases_Indeterm = array();
			for ($t = 0; $t < count($monthly); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($monthly[$t]['confirmation'] == 'Suspected') {
					$cases_susmon[$monthly[$t]['acronym']] = array('Suspected' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Negative') {
					$cases_negmon[$monthly[$t]['acronym']] = array('Negative' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Positive') {
					$cases_confmon[$monthly[$t]['acronym']] = array('Positive' => intval($monthly[$t]['total']));

				} else if ($monthly[$t]['confirmation'] == 'Indeterminate') {
					$cases_Indeterm[$monthly[$t]['acronym']] = array('Indeterminate' => intval($monthly[$t]['total']));

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
				if (!array_key_exists($namemon, $cases_negmon)) {
					$cases_Indeterm[$namemon] = array('Indeterminate' => 0);
				}
			}
			krsort($cases_susmon);
			krsort($cases_confmon);
			krsort($cases_negmon);
			krsort($cases_Indeterm);
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

			$strXML_e1 .= "<dataset seriesName='Indeterminate' showValues='0'>";
			foreach ($cases_Indeterm as $Indeterm => $value) {

				$strXML_e1 .= "<set value='$value[Indeterminate]' />";
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
			$cases_indedai = array();
			for ($t = 0; $t < count($daily); $t++) {
				//echo $perconfirm[$t]['Disease'].'<br>';
				if ($daily[$t]['confirmation'] == 'Suspected') {
					$cases_susdai[$daily[$t]['acronym']] = array('Suspected' => intval($daily[$t]['total']));

				} else if ($daily[$t]['confirmation'] == 'Negative') {
					$cases_negdai[$daily[$t]['acronym']] = array('Negative' => intval($daily[$t]['total']));

				} else if ($daily[$t]['confirmation'] == 'Positive') {
					$cases_confdai[$daily[$t]['acronym']] = array('Positive' => intval($daily[$t]['total']));
				} else if ($daily[$t]['confirmation'] == 'Indeterminate') {
					$cases_indedai[$daily[$t]['acronym']] = array('Indeterminate' => intval($daily[$t]['total']));
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
				if (!array_key_exists($namedai, $cases_indedai)) {
					$cases_indedai[$namedai] = array('Indeterminate' => 0);
				}

			}
			krsort($cases_susdai);
			krsort($cases_confdai);
			krsort($cases_negdai);
			krsort($cases_indedai);
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

			$strXML_e2 .= "<dataset seriesName='Indeterminate' showValues='0'>";
			foreach ($cases_indedai as $negmon1 => $value) {

				$strXML_e2 .= "<set value='$value[Indeterminate]' />";
			}
			$strXML_e2 .= "</dataset>";

			$strXML_e2 .= "</chart>";
			$data['strXML_e2'] = $strXML_e2;

			$data['banner_text'] = "Public Domain";
			$data['link'] = "home";
           $coordinates=$coordinates = Incidence::get_all();;
		}
		$all_diseases = Diseases::getAll();
		$data['all_diseases'] = $all_diseases;
		$data['left_content'] = "true";
		$data['map']=$this->map_php_load($coordinates);
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

	Public function map_Ajax_filter($disease_id) {

		header('Content-Type: application/json');

		if ($disease_id) {
			$coodinates = $coodinates = $fetch_kemri = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT COUNT(i.id) as total,i.id AS incidence_id,i.mfl_code,i.disease_id,i.p_id,f.* FROM Incidence i,facility f WHERE i.disease_id='$disease_id' AND i.mfl_code=f.Facility_code GROUP BY mfl_code");
		} else {
			$coodinates = $coodinates = $fetch_kemri = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT COUNT(i.id) as total,i.id AS incidence_id,i.mfl_code,i.disease_id,i.p_id,f.* FROM Incidence i,facility f WHERE i.mfl_code=f.Facility_code GROUP BY mfl_code");
		}
		echo json_encode($coodinates, JSON_PRETTY_PRINT);

	}

	public function map_php_load($coordinates) {
		//echo count($coodinates);
		$this -> load -> library('googlemaps');
		if ($this -> session -> userdata('user_id')) {
			$config['cluster'] = FALSE;
		} else {
			$config['cluster'] = TRUE;
		}
		$config['center'] = '-0.023559,37.90619';
		$config['zoom'] = '5';
		$this -> googlemaps -> initialize($config);
        
		if($this->session->userdata('user_id')){
		foreach ($coordinates as $coordinate) {

			foreach ($coordinate->incident as $vals) {

				foreach ($coordinate->disease_name as $disease1) {
					$data['map_diseaseName'] = $disease1 -> Full_Name;
					$marker = array();
					$marker['position'] = $vals -> latitude . ',' . $vals -> longitude;
					$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|9999FF|000000';
					$marker['animation'] = 'DROP';
					$marker['infowindow_content'] = 'Facility :' . $vals -> Facility_name . '<br>' . 'Incidents Reported ' . $coordinate -> total . '<br>' . '<a href="' . site_url('report_management/facility_alerts/' . $coordinate -> Mfl_Code) . '" class="linkss">View Details</a>';
					$this -> googlemaps -> add_marker($marker);
				}
			}
		}
		}else{
			foreach ($coordinates as $coordinate) {

			foreach ($coordinate->incident as $vals) {

				foreach ($coordinate->disease_name as $disease1) {

					$marker = array();
					$marker['position'] = $vals -> latitude . ',' . $vals -> longitude;
					//$marker['infowindow_content'] = 'Incident ' . $coordinate -> p_id . '<br>' . $vals -> Facility_name . '<br>' . $disease1 -> Full_Name;

					$this -> googlemaps -> add_marker($marker);
				}
			}
		}
		}

		return $this -> googlemaps -> create_map();
	}

}
