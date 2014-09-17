<?php
# include file to open database connection
include("../Includes/DBConn.php");
# include Fusionmaps Rendering Control file
include("../Includes/FusionCharts.php");
?>
<html>
<head>
	<title>FusionMaps - Database Example</title>
	<?php
	/*
	You need to include the following JS file to embed the map using JavaScript
	Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	When you make your own maps, make sure that the path to this JS file is correct. Else, you would get JavaScript errors.
	*/
	?>	
	<script LANGUAGE="Javascript" SRC="../../../Maps/FusionCharts.js"></script>
	 <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>

<center>
<table width="780px" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
  <tr><td height="90" align="left" valign="bottom"><?php include("../Includes/header.inc"); ?></td>
</tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
  <td align="center" valign="top"><span class='caption'>FusionMaps Demo Application - Database + Drill-down </span></td>
</tr>
<tr>
  <td align="center" valign="top"><span class='text'>State-wise population distribution - with respect to total US population. Click on a state to see more details.</span></td>
</tr>
  <tr><td align="left" valign="top">
<?php
	/*
	In this example, we show how to connect FusionCharts to a database.
	You can connect to any database. Here, we've shown My SQL.
	
	Variables to store XML Data and sum of data
	strXML will be used to store the entire XML document generated
	*/	
	$strXML ="";
	$sumdata =0;
	
	# Connect to the DB
	$link = connectToDB();

	# Generate the map element	
	# Create the opening <map> element and add the attributes that we need.
	$strXML = "<map showCanvasBorder='0' borderColor='FFFFFF' connectorColor='000000' fillAlpha='80' hoverColor='FFFFFF' showBevel='0' numberSuffix='%25 of total US population' legendBorderColor='F1f1f1' hoverColor='FFFFFF' legendPosition='bottom'>";
    
	#define out color range
	$strXML .= "<colorRange>";
	$strXML .= "<color minValue='0' maxValue='0.50' displayValue='0%25 to 0.50%25 of total' color='D64646' />";
	$strXML .= "<color minValue='0.50' maxValue='1' displayValue='0.50%25 to 1%25 of total' color='F6BD0F' />";
	$strXML .= "<color minValue='1' maxValue='3' displayValue='1%25 to 3%25 of total' color='8BBA00' />";
	$strXML .= "<color minValue='3' maxValue='10' displayValue='3%25 or above of total' color='AFD8F8' />";
	$strXML .= "</colorRange>";
	
	# Add the starting element for data
	$strXML .= "<data>";
			
	# Fetch all data now
	# Initialize sum container
	$strQuery = "select  sum(data) datap from fcmap_distribution";
	$result3 = mysql_query($strQuery) or die(mysql_error());
	$rs = mysql_fetch_array($result3);		
	
	#extract total sum
	if(count($rs)!=0)
	 $sumdata=$rs['datap'];
	
	# Fetch all Internal id and data sum 
	$strQuery = "select  Internal_Id, sum(data) datap from fcmap_distribution group by Internal_Id";
	$result = mysql_query($strQuery) or die(mysql_error());
    
	# Check if we've records to show
	if ($result) {
	   # Iterate through each record
		while($rs1= mysql_fetch_array($result)) {
			
			$strQuery ="select * from fcmap_master where Internal_Id='" . $rs1['Internal_Id'] . "'";
			$result1 = mysql_query($strQuery) or die(mysql_error());
			$rs2 = mysql_fetch_array($result1);

			# Generate <entity id=".." value=".." />, calculating sum and Percentage data 
			#and also add link to it 			
			# The link will in format Detailed.php?Internal_Id=Int_Id&map=map_swf.swf - we'll need to URL Encode this link to convert & to %26 (or manually add it as %26 instead of &)
			 
			$strXML .= "<entity id='" . $rs1['Internal_Id'] . "' value='" . round((($rs1['datap'] /  $sumdata) * 100),2) . "' link='Detailed.php?Internal_Id=" . $rs1['Internal_Id'] . "%26map=" . $rs2['map_swf'] . "'  />";
			
		}
	
	# Finally, close <data> element and add
	$strXML .= "</data>";
	# If needed, you can append additional XML tags here - like STYLE or MARKERS
	
	$strXML  .= "<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' /><style type='animation' name='animAlpha' param='_alpha' start='0' duration='1' /><style type='shadow' name='myShadow' color='FFFFFF' distance='1' />";
	$strXML  .= "</definition><application><apply toObject='PLOT' styles='animX,animY' /><apply toObject='LABELS' styles='myShadow,animAlpha' /></application></styles>";
	
	# Finally, close <map> element and add
	$strXML .="</map>";
	
	# Finally Rendering the USA Maps with renderChart() php function present in FusionCharts.php (include file)
	# Also, since we're using dataXML method, we provide a "" value for dataURL here
	#************************************************************************
	
	print renderChart("../../Maps/FCMap_USA.swf","",$strXML,"UsaMap", 750, 460,0,0);
	
	#************************************************************************

  }
  else{
	# Else, display a message that we do not have any records to display
	print '<h3>No Records</h3>';
  }
  mysql_close($link);
?>
<br>

</td>
</tr>
<tr><td><?php include("../Includes/footer.inc"); ?></td>
</tr>
</table>
</center>
</body>
</html>