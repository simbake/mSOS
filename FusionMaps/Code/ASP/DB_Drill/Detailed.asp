<%@ LANGUAGE="VBScript" %>
<!-- #include file="../Includes/DBConn.asp" -->
<!-- #include file="../Includes/FusionMaps.asp" -->
<%
'This page is invoked when the user clicks on the population distribution map 
'contained in Index.asp. From there, we pass the internal id of the state and the
'SWF name of the map which represents that state.

'Here, we show more details on that particular state.
%>
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
  <td align="center" valign="top"><a href='Index.asp'><< Click here to go back to US Map</a></td>
</tr>

 <tr><td align="left" valign="top">
<%	
	'Variables to store XML Data
	'strXML will be used to store the entire XML document generated	
	dim strXML
		
	'strXML will be used to store the entire XML document generated
	'Generate the chart element
	strXML = strXML & "<map showCanvasBorder='0' borderColor='FFFFFF' connectorColor='000000' fillAlpha='80' hoverColor='FFFFFF' showBevel='0' legendBorderColor='F1f1f1' hoverColor='FFFFFF' legendPosition='bottom'>"
    strXML = strXML & "<colorRange>"
	strXML = strXML & "<color minValue='0' maxValue='93' displayValue='0%25 to 93%25' color='D64646' />"
	strXML = strXML & "<color minValue='93' maxValue='94' displayValue='93%25 to 94%25' color='F6BD0F' />"
	strXML = strXML & "<color minValue='94' maxValue='95' displayValue='94%25 to 95%25' color='8BBA00' />"
	strXML = strXML & "<color minValue='95' maxValue='100' displayValue='95%25 or above' color='AFD8F8' />"
	strXML = strXML & "</colorRange>"
	'Start the <data> element
	strXML = strXML & "<data>"
			
	'Fetch all entity records
	strQuery ="select a.Internal_Id,a.entity_id,sum(data) as datap from fcmap_distribution a group by a.Internal_Id,a.entity_id having a.Internal_Id='" & request("Internal_Id")  & "'"
	
	set rs = Server.CreateObject("ADODB.Recordset")
	rs.open strQuery,oConn
	
	'If we've records to iterate, proceed    
	if rs.bof=false then	
		do while not rs.eof				
			'Get details for the region
			strQuery ="select a.Internal_Id,a.entity_id,b.group_name,sum(data) as datap from fcmap_distribution a, fcmap_group_master b where b.group_id=a.group_id  group by a.Internal_Id ,a.entity_id, b.group_name having a.Internal_Id='" & rs("Internal_Id")  &  "' and entity_id='" & rs("entity_id") & "'"
		
			set rs2 = Server.CreateObject("ADODB.Recordset")
        	rs2.open strQuery,oConn
			'We'll create out custom tool text for each entity. So, create a place holder.
			tooltext="" 
			'Total counter
			totEmp=0			
			dim StateValue,TotalStateValue,StatePer
			StateValue=0: TotalStateValue=0: StatePer=0
			do while not rs2.eof 
			 ' Calucation value
			 StateValue=cdbl(rs2("datap"))
			 TotalStateValue=cdbl(rs("datap"))
			 'Get percentage of employment
			 StatePer=round((StateValue /  TotalStateValue) * 100,2)
			 			 
			 'Add to tool text
			 tooltext = tooltext & rs2("group_name") & ":" & StatePer & "%25 \n"
			 'If it's not unemployed group
			 if rs2("group_name") <> "Unemployed" then
			    totEmp = totEmp + StatePer
			 end if
			 rs2.movenext
			loop
		
			'Generate <entity id=".." value=".." />        
			'Also append link to Charts.asp passing all required information (from querystring) and the database
			'We also add our custom tool text
			strXML = strXML & "<entity id='" & rs("entity_id") & "' value='" & totEmp & "'  link='Charts.asp?" & server.URLEncode(request.ServerVariables("QUERY_STRING")) & "%26entity_id=" & rs("entity_id") & "' tooltext='" & tooltext & "' />"
	     rs.movenext		
		loop
	end if
	
	'Finally, close <data> element
	strXML = strXML & "</data>"
	strXML  = strXML & "<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' /><style type='animation' name='animAlpha' param='_alpha' start='0' duration='1' /><style type='shadow' name='myShadow' color='FFFFFF' distance='1' />"
	strXML  = strXML & "</definition><application><apply toObject='PLOT' styles='animX,animY' /><apply toObject='LABELS' styles='myShadow,animAlpha' /></application></styles>"
	strXML = strXML & "</map>"
	
	'Now, render the map using renderChart function present in FusionMaps.asp (include file)
	'Also, since we're using dataXML method, we provide a "" value for dataURL here
	Call renderChart("../../Maps/" & Request("map"), "", strXML, "Map1Id", "750", "460", false, false)	
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
<%
  set rs=nothing
  set rs1=nothing
  set rs2=nothing
  oConn.close
  set oConn=nothing
  
  Function Rand(Low,High)
     Randomize
	 Rand = Int((High - Low + 1) * Rnd + Low)
  End Function

%>