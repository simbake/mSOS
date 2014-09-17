<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Charts.aspx.cs" Inherits="DrillDown_DetailedCharts" %>

<%
    /*
    This page is invoked when user clicks on a region on the employment distribution map 
    contained in StateDetails.aspx. 
  
     * Here, we show detailed charts for the region.
    */
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>FusionMaps - Database Example </title>
    <%
        /*
	    You need to include the following JS file to embed the chart using JavaScript
	    Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	    When you make your own charts, make sure that the path to this JS file is correct. Else, you would get JavaScript errors. you would get JavaScript errors.
     */ 
    %>

    <script language="Javascript" src="../Maps/FusionCharts.js"></script>
    <script type="text/javascript">
		FusionCharts.options.html5ChartsSrc = "../Charts/FusionCharts.HC.Charts.js";
	</script>    

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
                Employment Statistics</h2>
            <table align='center' cellpadding='2' cellspacing='2'>
                <% // Show FusionCharts %>
                <% GetCharts(); %>
            </table>
            <br />
            <br />
            <a href='javascript:history.back();'>&laquo; Click here to go back to Region Map</a>
            <br />
            <a href="Default.aspx">&laquo; Click here to go back to US Map</a><br />
            <br />
            <br />
            <a href='../Default.aspx'>&laquo; Back to list of examples</a>
            <br />
            <br />
            <a href='../NoChart.html' target="_blank">Unable to see the CHARTS above?</a>
        </center>
    </form>
</body>
</html>
