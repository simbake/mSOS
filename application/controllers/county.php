<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class County extends MY_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$county = $this -> session -> userdata('county');
		$data['title'] = "County Home";
		$data['scripts'] = array("FusionCharts/FusionCharts.js");
		$data['content_view'] = "county_home";
		$data['incident'] = Incidence::get_incidence_count_county($county);
		$data['disease'] = Incidence::get_disease_count_county($county);
		$data['confirm'] = Incidence::confirm_county($county);
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
		//echo count($coodinates);
		$this -> load -> library('googlemaps');
		$config['cluster'] = TRUE;
		$config['center'] = '-0.023559,37.90619';
		$config['zoom'] = '6';
		$this -> googlemaps -> initialize($config);

		foreach ($coodinates as $coordinate) {

			foreach ($coordinate->incident as $vals) {

				foreach ($coordinate->disease_name as $disease1) {

					$marker = array();
					$marker['position'] = $vals -> latitude . ',' . $vals -> longitude;
					//$marker['infowindow_content'] = 'Incident ' . $coordinate -> p_id . '<br>' . $vals -> Facility_name . '<br>' . $disease1 -> Full_Name;

					$this -> googlemaps -> add_marker($marker);
				}
			}
		}

		$data['map'] = $this -> googlemaps -> create_map();
		$data['banner_text'] = "County View";
		$data['link'] = "home";
		$this -> load -> view("template", $data);
	}

}
