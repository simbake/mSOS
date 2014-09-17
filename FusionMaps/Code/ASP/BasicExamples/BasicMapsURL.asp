<%@ Language=VBScript %>
<%
'We've included ../Includes/FusionMaps.asp, which contains functions
'to help us easily embed the maps.
%>
<!-- #INCLUDE FILE="../Includes/FusionMaps.asp" -->
<html>
<head>
<title>FusionMaps- ASP DEMO - BASIC CHART FROM ARRAY USING dataURL method</title>
<%
'We've included FusionCharts.js, which helps in 
'easy map rendering.
%>
<script type="text/javascript" language="javascript" src="../../../Maps/FusionCharts.js"></script>
</head>

<body>

<%
dim dataURL 
dataURL ="getURLdata.asp"
Call renderChart("../../Maps/FCMap_World8.swf", dataURL, "", "firstMapDataURL", 750, 460,0,0)

%>


</body>
</html>
