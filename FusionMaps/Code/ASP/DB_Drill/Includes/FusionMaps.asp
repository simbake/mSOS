<%
'Page: FusionMaps.asp
'Author: InfoSoft Global (P) Ltd.

'This page contains functions that can be used to render FusionMaps.

'encodeDataURL function encodes the dataURL before it's served to FusionMaps.
'If you've parameters in your dataURL, you necessarily need to encode it.
'Param: strDataURL - dataURL to be fed to map
'Param: addNoCacheStr - Whether to add aditional string to URL to disable caching of data
Function encodeDataURL(strDataURL, addNoCacheStr)
	'Add the no-cache string if required
	if addNoCacheStr=true then
		'We add ?FCCurrTime=xxyyzz
		'If the dataURL already contains a ?, we add &FCCurrTime=xxyyzz
		'We replace : with _, as FusionMaps cannot handle : in URLs
		if Instr(strDataURL,"?")<>0 then
			strDataURL = strDataURL & "&FCCurrTime=" & Replace(Now(),":","_")
		else
			strDataURL = strDataURL & "?FCCurrTime=" & Replace(Now(),":","_")
		end if
	end if	
	'URL Encode it
	encodeDataURL = Server.URLEncode(strDataURL)
End Function

'renderChart renders the JavaScript + HTML code required to embed a map.
'This function assumes that you've already included the FusionMaps JavaScript class
'in your page.

' mapSWF - SWF File Name (and Path) of the map which you intend to plot
' strURL - If you intend to use dataURL method for this map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)
' strXML - If you intend to use dataXML method for this map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)
' mapId - Id for the map, using which it will be recognized in the HTML page. Each map on the page needs to have a unique Id.
' mapWidth - Intended width for the map (in pixels)
' mapHeight - Intended height for the map (in pixels)
' debugMode - Whether to start the map in debug mode
' registerWithJS - Whether to ask map to register itself with JavaScript
Function renderChart(mapSWF, strURL, strXML, mapId, mapWidth, mapHeight, debugMode, registerWithJS)
	'First we create a new DIV for each map. We specify the name of DIV as "mapId"Div.			
	'DIV names are case-sensitive.
%>
	<!-- START Script Block for map <%=mapId%> -->
	<div id='<%=mapId%>Div' align='center'>
		Map.
		<%
		'The above text "map" is shown to users before the map has started loading
		'(if there is a lag in relaying SWF from server). This text is also shown to users
		'who do not have Flash Player installed. You can configure it as per your needs.
		%>
	</div>
		<%
		'Now, we render the map using FusionMaps Class. Each map's instance (JavaScript) Id 
		'is named as map_"mapId".		
		%>
	<script type="text/javascript">	
		//Instantiate the map	
		var map_<%=mapId%> = new FusionMaps("<%=mapSWF%>", "<%=mapId%>", "<%=mapWidth%>", "<%=mapHeight%>", "<%=boolToNum(debugMode)%>", "<%=boolToNum(registerWithJS)%>");
		<% 
		'Check whether we've to provide data using dataXML method or dataURL method
		if strXML="" then %>
		//Set the dataURL of the map
		map_<%=mapId%>.setDataURL("<%=strURL%>");
		<% else %>
		//Provide entire XML data using dataXML method 
		map_<%=mapId%>.setDataXML("<%=strXML%>");
		<% end if %>		
		//Finally, render the map.
		map_<%=mapId%>.render("<%=mapId%>Div");
	</script>	
	<!-- END Script Block for map <%=mapId%> -->
	<%
End Function

'renderChartHTML function renders the HTML code for the JavaScript. This
'method does NOT embed the map using JavaScript class. Instead, it uses
'direct HTML embedding. So, if you see the maps on IE 6 (or above), you'll
'see the "Click to activate..." message on the map.
' mapSWF - SWF File Name (and Path) of the map which you intend to plot
' strURL - If you intend to use dataURL method for this map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)
' strXML - If you intend to use dataXML method for this map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)
' mapId - Id for the map, using which it will be recognized in the HTML page. Each map on the page needs to have a unique Id.
' mapWidth - Intended width for the map (in pixels)
' mapHeight - Intended height for the map (in pixels)
' debugMode - Whether to start the map in debug mode
Function renderChartHTML(mapSWF, strURL, strXML, mapId, mapWidth, mapHeight, debugMode)
	'Generate the FlashVars string based on whether dataURL has been provided
	'or dataXML.
	Dim strFlashVars
	if strXML="" then
		'DataURL Mode
		strFlashVars = "&mapWidth=" & mapWidth & "&mapHeight=" & mapHeight & "&debugMode=" & boolToNum(debugMode) & "&dataURL=" & strURL
	else
		'DataXML Mode
		strFlashVars = "&mapWidth=" & mapWidth & "&mapHeight=" & mapHeight & "&debugMode=" & boolToNum(debugMode) & "&dataXML=" & strXML 		
	end if
	%>
	<!-- START Code Block for map <%=mapId%> -->
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"  codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="<%=mapWidth%>" height="<%=mapHeight%>" id="<%=mapId%>">
		<param name="allowScriptAccess" value="always" />
		<param name="movie" value="<%=mapSWF%>"/>		
		<param name="FlashVars" value="<%=strFlashVars%>" />
		<param name="quality" value="high" />
		<embed src="<%=mapSWF%>" FlashVars="<%=strFlashVars%>" quality="high" width="<%=mapWidth%>" height="<%=mapHeight%>" name="<%=mapId%>" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
	<!-- END Code Block for map <%=mapId%> -->
	<%
End Function

'boolToNum function converts boolean values to numeric (1/0)
Function boolToNum(bVal)
	Dim intNum
	if bVal=true then
		intNum = 1
	else
		intNum = 0
	end if
	boolToNum = intNum
End Function
%>