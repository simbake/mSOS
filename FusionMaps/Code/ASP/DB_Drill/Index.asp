<%@ LANGUAGE="VBScript" %>
<!-- #include file="../Includes/DBConn.asp" -->
<!-- #include file="../Includes/FusionMaps.asp" -->
<html>
<head>
	<title>FusionMaps - Database Example</title>
	<%
	'You need to include the following JS file to embed the map using JavaScript
	'Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	'When you make your own maps, make sure that the path to this JS file is correct. Else, you would get JavaScript errors.
	%>	
	<script LANGUAGE="Javascript" SRC="../../../Maps/FusionCharts.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>

<center>
<table width="780px" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style='BORDER-LEFT:#666666 1px solid; BORDER-RIGHT:#666666 1px solid;'>
  <tr>
  <td align="left" valign="bottom" height='95'>
  <!-- #include file="../Includes/Header.inc" -->
  </td>
</tr>
<tr>
  <td align="center" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="center" valign="top"><span class='caption'>FusionMaps Demo Application - Database + Drill-down </span></td>
</tr>
<tr>
  <td height='5'></td>
</tr>
<tr>
  <td align="center" valign="top"><span class='text'>State-wise population distribution - with respect to total US population. Click on a state to see more details.</span></td>
</tr>
  <tr><td align="left" valign="top">
<%
	'In this example, we show how to connect FusionCharts to a database.
	'You can connect to any database. Here, we've shown MS SQL and Access.
	
	'Variables to store XML Data and sum of data
	'strXML will be used to store the entire XML document generated
	dim strXML, sumdata

	
	'Generate the map element	
	'Create the opening <map> element and add the attributes that we need.
	strXML = "<map showCanvasBorder='0' borderColor='FFFFFF' connectorColor='000000' fillAlpha='80' hoverColor='FFFFFF' showBevel='0' numberSuffix='%25 of total US population' legendBorderColor='F1f1f1' hoverColor='FFFFFF' legendPosition='bottom'>"
	'Define our color range
    strXML = strXML & "<colorRange>"
	strXML = strXML & "<color minValue='0' maxValue='0.50' displayValue='0%25 to 0.50%25 of total' color='D64646' />"
	strXML = strXML & "<color minValue='0.50' maxValue='1' displayValue='0.50%25 to 1%25 of total' color='F6BD0F' />"
	strXML = strXML & "<color minValue='1' maxValue='3' displayValue='1%25 to 3%25 of total' color='8BBA00' />"
	strXML = strXML & "<color minValue='3' maxValue='10' displayValue='3%25 or above of total' color='AFD8F8' />"
	strXML = strXML & "</colorRange>"
	'Add the starting element for data
	strXML = strXML & "<data>"
			
	'Fetch all data now
	'Initialize sum container
	sumdata=0
	strQuery = "select sum(data) as datap from fcmap_distribution"
	set rs = Server.CreateObject("ADODB.Recordset")
	rs.open strQuery,oConn
	'Store sum of all data
	if rs.bof=false then
	  sumdata=rs("datap")
	end if
	'Fetch all Internal id and data sum		
	strQuery = "select  Internal_Id, (sum(data) / " & sumdata & ")*100  as datap from fcmap_distribution group by Internal_Id"	
	set rs1 = Server.CreateObject("ADODB.Recordset")
	rs1.open strQuery,oConn
	         
	'Check if we've records to show
	if rs1.bof=false then
		'Iterate through each record
		do while not rs1.eof			
			strQuery ="select * from fcmap_master where Internal_Id='" + rs1("Internal_Id") + "'"
			set rs2 = Server.CreateObject("ADODB.Recordset")
        	rs2.open strQuery,oConn
			
			'Generate <entity id=".." value=".." /> and also add link to it 			
			'The link will in format Detailed.asp?Internal_Id=Int_Id&map=map_swf.swf - we'll need to URL Encode this link to convert & to %26 (or manually add it as %26 instead of &)
			strXML = strXML & "<entity id='" & rs1("Internal_Id") & "' value='" & round(rs1("datap"),2) & "'  link='Detailed.asp?Internal_Id=" & rs1("Internal_Id") & "%26map=" & rs2("map_swf") & "'  />"
			
           rs1.movenext
		loop
	
	'Finally, close <map> element and add
	strXML = strXML & "</data>"
	'If needed, you can append additional XML tags here - like STYLE or MARKERS
	strXML  = strXML & "<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' /><style type='animation' name='animAlpha' param='_alpha' start='0' duration='1' /><style type='shadow' name='myShadow' color='FFFFFF' distance='1' />"
	strXML  = strXML & "</definition><application><apply toObject='PLOT' styles='animX,animY' /><apply toObject='LABELS' styles='myShadow,animAlpha' /></application></styles>"
	'Close Map element
	strXML  = strXML & "</map>"
	
	'Now, render the map using renderChart function present in FusionMaps.asp (include file)
	'Also, since we're using dataXML method, we provide a "" value for dataURL here
	Call renderChart("../../Maps/FCMap_USA.swf", "", strXML, "Map1Id", "750", "460", false, false)	
  else
   'Else, display a message that we do not have any records to display
   response.write "<h3>No Records</h3>"
  end if
	
  'Clear up memory
  set rs=nothing
  set rs1=nothing
  set rs2=nothing  
  oConn.close
  set oConn=nothing  
%>
</td>
</tr>
<tr>
  <td height='10'></td>
</tr>
<tr><td><!-- #include file="../Includes/Footer.inc" --></td>
</tr>
</table>
</center>
</body>
</html>