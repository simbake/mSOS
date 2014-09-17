<%@LANGUAGE="VBSCRIPT" %>
<%
	
	'this page creates the map XML retrieving data from an array 
	'it will just just write out the XML data
	'NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER	
	
	'Declare array to store world population
	' we use wolrd map with 8 entities/continents
	' this 2 dimensional array will store 8 rows of data for each continent of the map
	' first column of each row will store the Internal Id of each entity on the map
	' second column will store population data of each entity
	dim dataArray(8,2)

    'Store population data 
	dataArray(1,1)="01" ' Internal ID of Asia
	dataArray(1,2)="3779000000" ' Asia's population
	dataArray(2,1)="02" ' Internal ID of Europe 
	dataArray(2,2)="727000000"'population
	dataArray(3,1)="03"' Internal ID of Africa
	dataArray(3,2)="877500000"'population
	dataArray(4,1)="04"' Internal ID of North America
	dataArray(4,2)="421500000"'population
	dataArray(5,1)="05"' Internal ID of South America
	dataArray(5,2)="379500000"'population
	dataArray(6,1)="06"' Internal ID of Central America
	dataArray(6,2)="80200000"'population
	dataArray(7,1)="07"' Internal ID of Oceania
	dataArray(7,2)="32000000"'population
	dataArray(8,1)="08"' Internal ID of Middle East
	dataArray(8,2)="179000000"'population
		
	
	'Declare strXML to store dataXML of the map
	dim strXML
	
	'Opening MAP element
	strXML = "<map  showLabels='1' includeNameInLabels='1' borderColor='FFFFFF' fillAlpha='80' showBevel='0' legendPosition='Bottom' >"
    
	'Setting Color ranges : 4 color ranges for population ranges
	strXML = strXML & "<colorRange>"
	strXML = strXML & "<color minValue='0' maxValue='100000000' displayValue='Population : Below 100 M' color='CC0001' />"
	strXML = strXML & "<color minValue='100000000' maxValue='500000000' displayValue='Population :100 - 500 M' color='FFD33A' />"
	strXML = strXML & "<color minValue='500000000' maxValue='1000000000' displayValue='Population :500 - 1000 M' color='069F06' />"
	strXML = strXML & "<color minValue='1000000000' maxValue='5000000000' displayValue='Population : Above 1000 M' color='ABF456' />"
	strXML = strXML & "</colorRange>"
	
	'Opening data element that will store map data
	strXML = strXML & "<data>"
	'Using Data from array for each entity 
	FOR i=1 TO ubound(dataArray)
		strXML = strXML & "<entity id='" & dataArray(i,1) & "' value='" & dataArray(i,2) & "' />"
	NEXT
	'closing  data element
	strXML = strXML & "</data>"
	'closing map element
	strXML  = strXML & "</map>"	
	
	'Set Proper output content-type
	Response.ContentType = "text/xml"
	'Just write out the XML data
	'NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
	response.Write strXML
%>