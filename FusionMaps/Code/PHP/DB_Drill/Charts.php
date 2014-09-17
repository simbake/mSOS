<?php
# This page is invoked when the user clicks on a region on the employment distribution map 
# contained in Detailed.asp. 

# Here, we show detailed charts for the region.

# include FusionCharts Rendering Control file
include("../Includes/FusionCharts.php");
include("../Includes/DBConn.php");
?>
<html>
<head>
	<title>FusionMaps - Database Example</title>
	<?php
	# You need to include the following JS file to embed the chart using JavaScript
	# Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	# When you make your own charts, make sure that the path to this JS file is correct. Else, you would get JavaScript errors. you would get JavaScript errors.
	?>	
	<script LANGUAGE="Javascript" SRC="../../../Maps/FusionCharts.js"></script>
    <script type="text/javascript">
		FusionCharts.options.html5ChartsSrc = "../Code/Charts/FusionCharts.HC.Charts.js";
	</script>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>

<center>
<table width="780px" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
  <tr><td height="90" align="left" valign="bottom"><?php include("../Includes/header.inc"); ?></td>
</tr>
  <tr>
    <td align="center" valign="top"><span class='caption'>Employment Statistics</span></td>
  </tr>
  <tr>
    <td height='10'></td>
  </tr>
  <tr>
    <td align="center" valign="top"><a href='javascript:history.back();'><< Click here to go back to Region Map</a></td>
  </tr>
  <tr>
    <td align="center" valign="top"><a href='Default.php'><< Or, click here to go back to US Map</a></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr><td align="left" valign="top">
    <div align="center">
      <?php
			
	# Connect to the DB
	$link = connectToDB();
    	 
	# $strXML will be used to store the entire XML document generated
	# We need to build three charts here. So, we use a loop to iterate through data
	# and build XML on the fly.

	$strQuery ="select * from fcmap_group_master";
	$i=1;
   	print "<table width='95%'>";
	$result1 = mysql_query($strQuery) or die(mysql_error());
	if($result1) {
	  
	  while($ors1 = mysql_fetch_array($result1)) {
	    
		# Get the XML for the chart
		# getChartEmpStatXML function is described bellow of the program
		$strXML=getChartEmpStatXML($ors1);	
		
		print "<tr><td class='border'>";
		
		# Create the chart - 2 Pie 3D Chart and 1 Column 3Dwith data from $strXML
		if ($ors1['group_id']==1 or $ors1['group_id']==2){
			print  renderChart("../../Charts/Pie3D.swf", "", $strXML, "UnEmp" . $i , 500, 350, false, false);
		}else{
			print renderChart("../../Charts/Column3D.swf", "", $strXML, "Emp" . $i , 500, 350, false, false);
		}
		print "</td></tr>";
		print "<tr><td height='16px'><img src='images/blank.gif'></td></tr>";
		$i++;
		}
	}
	print "</table>";
	mysql_close($link);
?>
  </td>
</tr>
<tr><td><?php include("../Includes/footer.inc"); ?></td>
</tr>
</table>
</center>
</body>
</html>
<?php
function getChartEmpStatXML($ors1){
# getChartEmpStatXML method returns the XML data for the chart for a given subgroup.
# $ors1 - Recordset containing details of the sub group      

	  # Variable to store XML data
	  $strXML="";
		
		# Based on which group we've been pass
		if ($ors1['group_id']==1 or $ors1['group_id']==2){
			$strXML = "<chart caption='Employment By " . $ors1['group_name'] . " Distribution Report' showBorder='0' formatNumberScale='0' numberSuffix='' showPercentValues ='1' showPercentInToolTip='1' >";
		}else{
			$strXML = "<chart caption='" . $ors1['group_name'] . " Age Groups report' showBorder='0' formatNumberScale='0' numberSuffix='' xAxisName='Age Groups' yAxisName='Unemployed' >";
		
		}
	
		$strQuery = "select a.Internal_Id,a.entity_id,b.group_name,c.subgroup_name,sum(a.data) datap from fcmap_distribution a, fcmap_group_master b, fcmap_subgroup_master c where a.group_id=b.group_id and a.subgroup_id=c.subgroup_id group by a.Internal_Id,a.entity_id,b.group_name,c.subgroup_name having a.Internal_Id='" . $_REQUEST['Internal_Id'] . "' and a.entity_id='" . $_REQUEST['entity_id'] . "' and b.group_name='" . $ors1['group_name'] . "'";
		
		
		$result = mysql_query($strQuery) or die(mysql_error());
    
		# Iterate through each group wise record
		if ($result) {
		 # Fetch all Data records
			
			while($ors = mysql_fetch_array($result)) {
				# Generate <set label='..' value='..' />        
				$strXML .= "<set label='" . $ors['subgroup_name'] . "' value='" . $ors['datap'] . "' />";
			}
		}
	
         # Add style element for caption
	    
		 $strXML .= "<styles><definition><style name='captionFont' type='Font' size='14' /></definition><application><apply toObject='caption' styles='captionFont'/></application></styles>";
     	
		#Finally, close <chart> element
		$strXML .= "</chart>";

        return $strXML;
}
?>