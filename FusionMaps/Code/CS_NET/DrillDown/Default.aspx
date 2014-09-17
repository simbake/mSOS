<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Default.aspx.cs" Inherits="FusionMapsDBExample_DrillDown" %>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>FusionMaps - Database Example</title>
    <%
        /*   
	    You need to include the following JS file to embed the map using JavaScript
	    Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	    When you make your own maps, make sure that the path to this JS file is correct. Else, 
        you would get JavaScript errors.
      */
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
                <a href="http://www.fusioncharts.com/maps" target="_blank">FusionMaps </a>- Database
                and Drill-Down Example</h2>
            <h4>
                State-wise population distribution - with respect to total US population.</h4>
            Click on a state to see more details.
            <% // Show USA Map %>
            <asp:Literal ID="USMap" runat="server" />
            <br />
            <br />
            <a href='../Default.aspx'>&laquo; Back to list of examples</a>
            <br />
            <br />
            <a href='../NoMap.html' target="_blank">Unable to see the MAP above?</a>
        </center>
    </form>
</body>
</html>
