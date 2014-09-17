<?php
	/*
	This page demonstrates the ease of generating Maps using FusionMaps.
	For this Maps, we've used an array to to store world population data
	We will make a simple world map showing  population of each segment
	
	Ideally, you would NOT use a physical data file. Instead you'll have 
	your own ASP scripts virtually relay the XML data document. Such examples are also present.
	For a head-start, we've kept this example very simple.

	Declare array to store world population
	we use wolrd map with 8 entities/continents
	this 2 dimensional array will store 8 rows of data for each continent of the map
	first column of each row will store the Internal Id of each entity on the map
	second column will store population data of each entity
	*/
	
	# Store population data
	# Declare array entity
	# array data assign	
	
	
# Internal IDs of continents & respective population 
$dataArray[0][1]="01"; //Asia
$dataArray[0][2]="3779000000"; //Population 
$dataArray[1][1]="02"; //Europe
$dataArray[1][2]="727000000";//Population
$dataArray[2][1]="03"; //Africa
$dataArray[2][2]="877500000";//Population
$dataArray[3][1]="04"; //North America
$dataArray[3][2]="421500000";//Population
$dataArray[4][1]="05"; //South America
$dataArray[4][2]="379500000";//Population
$dataArray[5][1]="06"; //Central America
$dataArray[5][2]="80200000";//Population
$dataArray[6][1]="07"; //Oceania
$dataArray[6][2]="32000000";//Population
$dataArray[7][1]="08"; //Middle East
$dataArray[7][2]="179000000";//Population

	$strXML="";
	
	# Opening MAP element
	$strXML = "<map showLabels='1' includeNameInLabels='1' borderColor='FFFFFF' fillAlpha='80' showBevel='0' legendPosition='Bottom' >";
    
	# Setting Color ranges : 4 color ranges for population ranges
	$strXML .= "<colorRange>";
	$strXML .= "<color minValue='1' maxValue='100000000' displayValue='Population : Below 100 M' color='CC0001' />";
	$strXML .= "<color minValue='100000000' maxValue='500000000' displayValue='Population :100 - 500 M' color='FFD33A' />";
	$strXML .= "<color minValue='500000000' maxValue='1000000000' displayValue='Population :500 - 1000 M' color='069F06' />";
	$strXML .= "<color minValue='1000000000' maxValue='5000000000' displayValue='Population : Above 1000 M' color='ABF456' />";
	$strXML .= "</colorRange><data>";
	
	# Opening data element that will store map data
	# Using Data from array for each entity 
	for($i=0;$i<=7;$i++){
		$strXML .= "<entity id='" . $dataArray[$i][1] . "' value='" . $dataArray[$i][2] . "' />";
	}
    # closing  data element	
	$strXML .= "</data>";
	
	# closing map element
	$strXML  .= "</map>";
	
	print $strXML;
?>