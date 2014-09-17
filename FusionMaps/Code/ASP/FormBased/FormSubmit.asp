<%@ Language=VBScript %>
<%
	'We've included ../Includes/FusionMaps.asp, which contains functions
	'to help us easily embed the maps.
%>
<!-- #INCLUDE FILE="../Includes/FusionMaps.asp" -->
<html>
<head>
	<title>	FusionMaps ASp Sample- Form Based Data Example	</title>
 	<%
	'We've included ../Includes/FusionCharts.js, which contains functions
	'to help us easily embed the maps.
	%>
      <script type="text/javascript" language="javascript" src="../../../Maps/FusionCharts.js"></script>

	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.text{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>
</head>
	
<body>

<center>
<h2><a href="http://www.fusioncharts.com" target="_blank">FusionMaps</a> - ASP Samples</h2>
<h4>
  Form-Based Data : Rendering Map </h4>
<%	
	'this page accepts data from submitted by default.asp
	'it sets the values to the world map
	
	'We first request the data from the Form of Default.asp and store in an array
	dim dataArray(8,2)

    'storing Form data to an array 
	dataArray(1,1)="01": dataArray(1,2)=int(request("AS"))
	dataArray(2,1)="02": dataArray(2,2)=int(request("EU"))
	dataArray(3,1)="03": dataArray(3,2)=int(request("AF"))
	dataArray(4,1)="04": dataArray(4,2)=int(request("NA"))
	dataArray(5,1)="05": dataArray(5,2)=int(request("SA"))
	dataArray(6,1)="06": dataArray(6,2)=int(request("CA"))
	dataArray(7,1)="07": dataArray(7,2)=int(request("OC"))
	dataArray(8,1)="08": dataArray(8,2)=int(request("ME"))
	
	
	'In this example, we're directly showing this data on the map.
	'In your apps, you can do the required processing and then show the 
	'relevant data only.
	
	'Now that we've the data in an array, we need to convert this into XML.
	'The simplest method to convert data into XML is using string concatenation.	
	Dim strXML
	
	'Initialize <map> element
	
	strXML = "<map includeValueInLabels='1' borderColor='FFFFFF' connectorColor='000000' fillAlpha='70' fillColor ='efeaef' hoverColor='cfefdd' showBevel='0' numberPrefix='$'>"
    
	
	'You can always define <colorRange> here to get color categories. We ommit it here.
	
	
	'opening data element
	strXML = strXML & "<data>"
	
	
	'Retrieving data from array  to assign to each entity
	for i=1 to ubound(dataArray)
		strXML = strXML & "<entity id='" & dataArray(i,1) & "' value='" & dataArray(i,2) & "' />"
	next
    
	'closing data element
	strXML = strXML & "</data>"
	
	'closing map element
	strXML  = strXML & "</map>"	
	
	'Create the Maps with data from strXML
	Call renderChart("../../Maps/FCMap_World8.swf", "", strXML, "firstMap", 750, 460,0,0)
		
%>
	
<a href='javascript:history.go(-1);'>Enter data again</a>
<br><br>

</center>
</body>
</html>