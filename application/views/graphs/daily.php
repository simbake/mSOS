<?php
include ("Scripts/FusionCharts/FusionCharts.php");

$disease_d = array();
for ($t = 0; $t < count($daily); $t++) {
	//echo $perconfirm[$t]['Disease'].'<br>';
	$disease_d[$t] = $daily[$t]['dater'];
}

$disease_d = array_unique($disease_d);

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
$strXML_e2 = "<chart palette='2' caption='Daily Alert Analysis (Acute hemorrgagic fever syndrome)' shownames='1' showvalues='0' xAxisName='Diseases' yAxisName='Quantity' useRoundEdges='1' legendBorderAlpha='0'><categories>";

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

echo renderChart("" . base_url() . "Scripts/FusionCharts/Charts/MSColumn2D.swf", "", $strXML_e2, "e_2", 800, 400, false, true);
?>