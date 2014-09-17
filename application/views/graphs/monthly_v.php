<?php
include ("Scripts/FusionCharts/FusionCharts.php");
//var_dump($monthly);
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

				}else if ($monthly[$t]['confirmation'] == 'Negative') {
					$cases_negmon[$monthly[$t]['acronym']] = array('Negative' => intval($monthly[$t]['total']));

				}  else {
					$cases_confmon[$monthly[$t]['acronym']] = array('Positive' => intval($monthly[$t]['total']));

				}//close if statement

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
			
			echo renderChart("" . base_url() . "Scripts/FusionCharts/Charts/MSColumn2D.swf", "", $strXML_e1, "e_1", 700, 400, false, true);


?>