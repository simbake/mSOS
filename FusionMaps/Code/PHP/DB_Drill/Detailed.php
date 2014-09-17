<?php
/*
  This page is invoked when the user clicks on the population distribution map 
  contained in index.php. From there, we pass the internal id of the state and the
  SWF name of the map which represents that state.

  Here, we show more details on that particular state.
*/
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
    <td align="center" valign="top"><span class='caption'>State-wise employment distribution</span></td>
  </tr>
  <tr>
    <td height='5'></td>
  </tr>
  <tr>
    <td align="center" valign="top"><span class='text'>Click on a region to see more details.</span></td>
  </tr>
  <tr>
    <td height='10'></td>
  </tr>
  <tr>
    <td align="center" valign="top"><a href='Default.php'><< Click here to go back to US Map</a></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr><td align="left" valign="top">
<?php
		
	# Connect to the DB
	$link = connectToDB();

	# Variables to store XML Data and sum of data
	# $strXML will be used to store the entire XML document generated	
	# Generate the Map element
	
	$strXML = "<map showCanvasBorder='0' borderColor='FFFFFF' connectorColor='000000' fillAlpha='80' hoverColor='FFFFFF' showBevel='0' legendBorderColor='F1f1f1' hoverColor='FFFFFF' legendPosition='bottom'>";
    $strXML .= "<colorRange>";
	$strXML .= "<color minValue='0' maxValue='93' displayValue='0%25 to 93%25' color='D64646' />";
	$strXML .= "<color minValue='93' maxValue='94' displayValue='93%25 to 94%25' color='F6BD0F' />";
	$strXML .= "<color minValue='94' maxValue='95' displayValue='94%25 to 95%25' color='8BBA00' />";
	$strXML .= "<color minValue='95' maxValue='100' displayValue='95%25 or above' color='AFD8F8' />";
	$strXML .= "</colorRange>";
	
	$strXML .="<data>";
			
	# Fetch all entity records
	
	$strQuery ="select  a.Internal_Id,a.entity_id,sum(data) datap from fcmap_distribution a group by a.Internal_Id,a.entity_id having a.Internal_Id='" . $_REQUEST['Internal_Id']  . "'";
	
	
	$result = mysql_query($strQuery) or die(mysql_error());
    
	# If we've records to iterate, proceed
	if ($result) {
		while($rs = mysql_fetch_array($result)) {
			# Get details for the region	
		    $strQuery ="select a.Internal_Id,a.entity_id,b.group_name,sum(data) datap from fcmap_distribution a, fcmap_group_master b where b.group_id=a.group_id  group by a.Internal_Id ,a.entity_id, b.group_name having a.Internal_Id='" . $rs['Internal_Id'] . "' and entity_id='" . $rs['entity_id'] . "'";
			
			# We'll create out custom tool text for each entity. So, create a place holder.
			$tooltext=""; 
			# Total counter
			$totEmp=0;
			$result2 = mysql_query($strQuery) or die(mysql_error());
			while($rs2 = mysql_fetch_array($result2)){
			   # Calucation value, Get percentage of employment
			   # Add to tool text
			   $tooltext .=  $rs2['group_name'] . ":" . round((($rs2['datap'] /  $rs['datap']) * 100),2) . "%25 \\n";
			   # If it's not unemployed group
			   if ($rs2['group_name']!='Unemployed'){
			      $totEmp += round((($rs2['datap'] /  $rs['datap']) * 100),2);
			   }
			 }
		
		
			# Generate <entity id=".." value=".." />        
			# Also append link to Charts.php passing all required information (from querystring) and the database
			# We also add our custom tool text
			      
			$strXML .= "<entity id='" . $rs['entity_id'] . "' value='" . $totEmp . "'  link='Charts.php?" . urlencode($QUERY_STRING) . "%26entity_id=" . $rs['entity_id'] . "' tooltext='" . $tooltext . "' />";
			
		}
	}
	mysql_close($link);

	# Finally, close <data> element
	$strXML .= "</data>";
	
	# Adding styles element
	$strXML .= "<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' /><style type='animation' name='animAlpha' param='_alpha' start='0' duration='1' /><style type='shadow' name='myShadow' color='FFFFFF' distance='1' />";
	$strXML .= "</definition><application><apply toObject='PLOT' styles='animX,animY' /><apply toObject='LABELS' styles='myShadow,animAlpha' /></application></styles>";
	
	# Closing map element
	$strXML .="</map>";
	
	# Now, render the map using renderChart function present in FusionCharts.php (include file)
	# Also, since we're using dataXML method, we provide a "" value for dataURL here
	#****************************************************************************
	
	print renderChart("../../Maps/" . $_REQUEST['map'] ,"",$strXML,"Maps", 750, 460,0,0);
	
	#****************************************************************************
?>	

</tr>
<tr><td><?php include("../Includes/footer.inc"); ?></td>
</tr>
</table>
</center>
</body>
</html>