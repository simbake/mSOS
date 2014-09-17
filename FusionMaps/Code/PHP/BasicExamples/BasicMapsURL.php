<html>
<head>
	<title>FusionMaps XML Data Show</title>
    <?php
	/*
	We've included ../Includes/FusionCharts.js, which contains functions
	to help us easily embed the Maps.
	*/
	include("../Includes/FusionCharts.php");
	
	# We've included ../Includes/FusionCharts.js, which contains functions
	# to help us easily embed the maps.
	?>
    <script language="javascript" src="../../../Maps/FusionCharts.js"></script>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>
</head>
<body>
<center>
<h2><a href="http://www.fusioncharts.com" target="_blank">FusionMaps</a> - PHP Samples</h2>
<h4>Using dataURL method&nbsp; <br>
  Retrieving data stored in an Array </h4>

   <?php
   
   # We define a $dataURL that contains the name of the Data Provider Page.(getURLdata.php)
   $dataURL="getURLdata.php";
   # Finally Rendering the World8 Maps with renderChart() php function present in FusionCharts.php (include file)
	# Also, since we're using dataURL method, we provide a "" value for dataXML here
	#************************************************************************
	
	print renderChart("../../Maps/FCMap_World8.swf",$dataURL,"","UsaMaps", 750, 460,0,0);
	
	#************************************************************************
   
   ?>
    
<br><br>

</center>
</body>
</html>