<%@ LANGUAGE="VBScript" %>
<!-- #include file="../Includes/DBConn.asp" -->
<!-- #include file="../Includes/FusionCharts.asp" -->
<%
'This page is invoked when the user clicks on a region on the employment distribution map 
'contained in Detailed.asp. 

'Here, we show detailed charts for the region.
%>
<html>
<head>
	<title>
	FusionMaps - Database Example
	</title>
	<%
	'You need to include the following JS file to embed the chart using JavaScript
	'Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	'When you make your own charts, make sure that the path to this JS file is correct. Else, you would get JavaScript errors. you would get JavaScript errors.
	%>	
	<script LANGUAGE="Javascript" SRC="../../../Maps/FusionCharts.js"></script>
    <script type="text/javascript">
		FusionCharts.options.html5ChartsSrc = "../Code/Charts/FusionCharts.HC.Charts.js";
	</script>
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
  <td align="center" valign="top"><span class='caption'>Employment Statistics</span></td>
</tr>

<tr>
  <td height='10'></td>
</tr>
<tr>
  <td align="center" valign="top"><a href='javascript:history.back();'><< Click here to go back to Region Map</a></td>
</tr>
<tr>
  <td align="center" valign="top"><a href='Index.asp'><< Or, click here to go back to US Map</a></td>
</tr>

 <tr>
 <td align="left" valign="top">
 <table align='center' cellpadding='2' cellspacing='2'>
  <%
    'strXML will be used to store the entire XML document generated
    dim strXML,sumdata,i
	
	'We need to build three charts here. So, we use a loop to iterate through data
	'and build XML on the fly.	
	i=1	
	strQuery ="select * from fcmap_group_master"
	set rs1 = Server.CreateObject("ADODB.Recordset")
    rs1.open strQuery,oConn
    
	if rs1.bof = false then
		do while not rs1.eof	
			'Get the XML for the chart
			strXML = getChartEmpStatXML(rs1)			
			response.Write "<tr><td>"			
			'Create the chart - 2 Pie 3D Chart and 1 Column 3Dwith data from strXML
			if rs1("group_id")<>3  then
    			response.Write renderChart("../../Charts/Pie3D.swf", "", strXML, "Chart_unemp" & i , 500, 350, false, false)
			else
				response.Write renderChart("../../Charts/Column3D.swf", "", strXML, "Chart_emp" & i , 500, 350, false, false)
			end if
			response.Write "</td></tr>"			
			i=i+1
			rs1.movenext
		loop
	end if  
  set rs=nothing
  set rs1=nothing
  oConn.close
  set oConn=nothing
%>  
</td>
</tr>
</table>
 </td>
</tr>
<tr>
  <td height='10'></td>
</tr>
<tr><td><!-- #include file="../Includes/footer.inc" --></td>
</tr>
</table>
</center>
</body>
</html>
<%
'getChartEmpStatXML method returns the XML data for the chart for a given subgroup.
'rs1 - Recordset containing details of the sub group
Function getChartEmpStatXML(rs1)
	'Variable to store XML data
	Dim strXML
	'Local scope database accessors
	Dim rs, strQuery
	'Based on which group we've been pass
	if (rs1("group_id")<>3) then
    	strXML = "<chart caption='Employment By " & rs1("group_name") & " Distribution Report'  showBorder='1' formatNumberScale='0' numberSuffix='' showPercentValues ='1' showPercentInToolTip='1' >"
	else
		strXML = "<chart caption='" & rs1("group_name") & " Age Groups report' showBorder='1'  formatNumberScale='0' numberSuffix='' xAxisName='Age Groups' yAxisName='Unemployed' >"	
	end if
	
	strQuery = "select a.Internal_Id,a.entity_id,b.group_name,c.subgroup_name,sum(a.data) as datap from fcmap_distribution a, fcmap_group_master b, fcmap_subgroup_master c where a.group_id=b.group_id and a.subgroup_id=c.subgroup_id group by a.Internal_Id,a.entity_id,b.group_name,c.subgroup_name having a.Internal_Id='" & request("Internal_Id") & "' and a.entity_id='" & request("entity_id") & "' and b.group_name='" & rs1("group_name") & "'"
	
	set rs = Server.CreateObject("ADODB.Recordset")
	rs.open strQuery,oConn
    
	'Iterate through each group wise record
	if rs.bof = false then
		'Fetch all Data records
		do while not rs.eof
			'Generate <set label='..' value='..' />        
			strXML = strXML & "<set label='" & rs("subgroup_name") & "' value='" & rs("datap") & "' />"
			rs.movenext
		loop
	end if	
			
	'Add style element for caption
	strXML = strXML & "<styles><definition><style name='captionFont' type='Font' size='14' /></definition><application><apply toObject='caption' styles='captionFont'/></application></styles>"
	'Finally, close <chart> element
	strXML = strXML & "</chart>"
	'Return
	getChartEmpStatXML = strXML
End Function
%>