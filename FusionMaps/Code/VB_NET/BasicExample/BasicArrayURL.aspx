<%@ Page Language="VB" AutoEventWireup="false" CodeFile="BasicArrayURL.aspx.vb" Inherits="BasicArrayExample_dataURL" %>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>FusionMaps Sample - Basic Example from array - Using dataURL</title>
    <%
        'We've included FusionCharts.js, which helps in 
        'easy map rendering.
    %>
    <script language="Javascript" src="../Maps/FusionCharts.js"></script>

    <style type="text/css">
	        <!--
	            body{font-family:Verdana;font-size:8pt;}
                .text{font-family:Verdana;font-size:8pt;}
	        -->
	</style>
</head>
<body>
    <form id='form1' name='form1' method='post' runat="server">
        <center>
            <h2>
                <a href="http://www.fusioncharts.com/maps" target="_blank">FusionMaps</a> Examples
            </h2>
            <h4>
                Using dataURL method&nbsp;<br />
                Retrieving data stored in an Array
            </h4>
           <%
               'This page demonstrates the ease of generating Maps using FusionMaps.
               'For this Map, we've used an array to store world population data.
               'We will make a simple world map showing population of each segment
               'We'll have an ASPX script to relay the XML data document. 

            %>
            <% 'Generate World Map in WorldPopulationMap Literal Control %>
            <asp:Literal ID="WorldPopulationMap" runat="server" />
            <br />
            <br />
            <a href='../NoMap.html' target="_blank">Unable to see the MAP above?</a>
            <br />
            <br />
            <h5>
                <a href='../Default.aspx'>&laquo; Back to list of examples</a></h5>
        </center>
    </form>

</body>
</html>
