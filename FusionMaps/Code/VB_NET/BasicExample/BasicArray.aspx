<%@ Page Language="VB" AutoEventWireup="false" CodeFile="BasicArray.aspx.vb" Inherits="BasicArrayExample_dataXML" %>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>FusionMaps Sample - Basic Example from array - Using dataXML</title>
    <%
        'We've included ../Maps/FusionCharts.js, which contains functions
        'to help us easily embed the maps.
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
                Using dataXML method&nbsp;<br />
                Retrieving data stored in an Array
            </h4>
            <%
                'This page demonstrates the ease of generating Maps using FusionMaps.
                'For this Map, we've used an array to store world population data.
                'We will make a simple world map showing population of each segment
	
                'Ideally, you would NOT use a physical data file. Instead you'll have 
                'your own ASPX scripts virtually relay the XML data document. 
                'Such examples are also present.
                'For a head-start, we've kept this example very simple.

            %>
            <% 'Generate World Map in the Literal Control WorldPopulationMap%>
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
