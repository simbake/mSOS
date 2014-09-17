<?php
  
  # include Fusionmaps Rendering Control file
  # to help us easily embed the maps.
  include("../Includes/FusionCharts.php");
?>
<html>
<head>
	<title>FusionMaps PHP Sample- Form Based Data Example</title>
	<?
	/*
	You need to include the following JS file, if you intend to embed the Maps using JavaScript.
	Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	When you make your own Maps, make sure that the path to this JS file is correct. Else, you would get JavaScript errors.
	*/
	?>	
	
	<script type="text/javascript" language="javascript" src="../../../Maps/FusionCharts.js"></script>
		
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.text{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>
</head>
	
<body>

<center>
<h2><a href="http://www.fusioncharts.com" target="_blank">FusionMaps</a> - PHP Samples</h2><h4>
  Form-Based Data : Rendering Map </h4>
<?
	
	# this page accepts data from submitted by default.asp
	# it sets the values to the world map
	
	# We first request the data from the Form of Default.asp and store in an array
	
	# storing Form data to an array 
	$dataArray[0][1]="01"; $dataArray[0][2]=$_REQUEST['AS'];
	$dataArray[1][1]="02"; $dataArray[1][2]=$_REQUEST['EU'];
	$dataArray[2][1]="03"; $dataArray[2][2]=$_REQUEST['AF'];
	$dataArray[3][1]="04"; $dataArray[3][2]=$_REQUEST['NA'];
	$dataArray[4][1]="05"; $dataArray[4][2]=$_REQUEST['SA'];
	$dataArray[5][1]="06"; $dataArray[5][2]=$_REQUEST['CA'];
	$dataArray[6][1]="07"; $dataArray[6][2]=$_REQUEST['OC'];
	$dataArray[7][1]="08"; $dataArray[7][2]=$_REQUEST['ME'];
	
	/*
	In this example, we're directly showing this data on the map.
	In your apps, you can do the required processing and then show the 
	relevant data only.
	
	Now that we've the data in an array, we need to convert this into XML.
	The simplest method to convert data into XML is using string concatenation.	
	*/	
	
	# Initialize <map> element
	$strXML="";
	$strXML = "<map includeValueInLabels='1' borderColor='FFFFFF' connectorColor='000000' fillAlpha='70' fillColor ='efeaef' hoverColor='cfefdd' showBevel='0' numberPrefix='$'>";
    
	# You can always define <colorRange> here to get color categories. We ommit it here.
	
	# opening data element
	$strXML .= "<data>";
	
	
	# Retrieving data from array  to assign to each entity
	for($i=0;$i<=7;$i++){
        $strXML .= "<entity id='" . $dataArray[$i][1] . "' value='" . $dataArray[$i][2] . "' />";
	}
    
	# closing data element	
	$strXML .= "</data>";
	
	# closing map element
	$strXML  .= "</map>";
	
	
	# Create the Maps with data from strXML
	
	# Finally Rendering the USA Maps with renderChart() php function present in FusionCharts.php (include file)
	# Also, since we're using dataXML method, we provide a "" value for dataURL here
	#************************************************************************
	
	print renderChart("../../Maps/FCMap_World8.swf","", $strXML, "firstMap", 750, 460,0,0);
	
	#************************************************************************
		
?>
    
<br />
<a href='javascript:history.go(-1);'>Enter data again</a>
<br><br>

</center>
</body>
</html>