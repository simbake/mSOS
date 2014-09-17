/**
 * FusionMapsGUI: GUI rendering and handling class for FusionMaps XT.
 *
 */
if(typeof infosoftglobal == "undefined") var infosoftglobal = new Object();
if(typeof infosoftglobal.FusionMapsGUI == "undefined") infosoftglobal.FusionMapsGUI = new Object();
infosoftglobal.FusionMapsGUI = function(){
	if (!document.getElementById) { return; }	
	//Store the map id for global usage
	this.mapId = "MainMap";
	//will store whether the rendered map is JavaScript map
	this.isJSMap = false;
	//Path for map storage
	this.mapPath = "../../Maps/";
	//Currently loaded map's index
	this.mapIndex = -1;
	//Get reference to the form - later we'll directly access objects.
	this.gForm = document['guiFORM'];	
	//List of maps that we've to cover
	this.mapList = new Array();	
	//Create container objects
	this.entities = new Array();	
	//Array to store Markers
	//In Markers array, we'll store each marker's ID only, to get referential index
	//The other details will be picked up from the form.
	this.markers = new Array();
	//Array to store marker positions
	this.markerPos = new Array();
	//What mode map is in. We need to keep a track of map mode for the following case:
	//1. User enters bad XML data and switches to preview tab (or XML > Update Chart).
	//2. Map goes into Invalid XML mode and therefore doesn't expose any JavaScript API.
	//3. enableChooseMode and disableChooseMode JavaScript API do not work anymore.
	//4. As such, switching of tabs give an error. So, we can conditionally switch tabs
	//only when required.
	this.chooseMode = false;
	//Define map list
	this.defineMapList();
}
// --------- Following functions help interact with the map ----------------//
infosoftglobal.FusionMapsGUI.prototype.getReferenceToMap = function(){
	//This method is invoked when the map has loaded and rendered. So, we can safely
	//get a reference to the map object.
	this.mapObj = FusionCharts(this.mapId);	
	this.isJSMap = FusionCharts(this.mapId).options.renderer=='javascript' ;
	//If we cannot get a reference to map object, it means	
	//Also, we can now get the map's entities and store it.	
	this.entities = this.mapObj.getEntityList();
}
infosoftglobal.FusionMapsGUI.prototype.defineMapList = function(){
	this.mapList = getMapList();
	
}
infosoftglobal.FusionMapsGUI.prototype.loadMap = function(index){
	//This method loads the map, if the index is a map value
	if(this.mapList[index].isMap){
		//Store the index of new map
		this.mapIndex = index;
		
		if (FusionCharts(this.mapId) && FusionCharts(this.mapId).dispose) {
			FusionCharts(this.mapId).dispose();
		}
		
		var map = new FusionCharts(this.mapPath + this.mapList[index].swf, this.mapId, this.mapList[index].width, this.mapList[index].height, "0", "1");      
		map.setXMLData("<map animation='0' showBevel='0' showShadow='0' fillColor='F1f1f1' borderColor='000000'/>");
		map.render("mapdiv");
		//Update mapNameDiv with the new map's name
		var dv = document.getElementById("mapNameDiv");
		dv.innerHTML = "<span class='text'>Map of " + this.mapList[index].title + "</span>";
	}	
}
infosoftglobal.FusionMapsGUI.prototype.previewMap = function(){
	//This method is called when the user wants to preview map.
	//Get XML data for the map.
	var strXML = this.getFullXMLData();
	//Bug Handling: Due to weird behavior in Firefox when markers are defined, we cannot
	//directly update the map data using it's JS interface. So, if markes are defined
	//and the browser is Firefox (non IE), we re-load the map.
	if ((markerWinOpened==true || this.markers.length>0) && navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) {		
		//Update flag that it's a forced re-load
		isReload = true;
		markerWinOpened = false;

		//Re-load map		
		if (FusionCharts(this.mapId) && FusionCharts(this.mapId).dispose) {
			FusionCharts(this.mapId).dispose();
		}		
		var map = new FusionCharts(this.mapPath + this.mapList[this.mapIndex].swf, this.mapId, this.mapList[this.mapIndex].width, this.mapList[this.mapIndex].height, "0", "1"); 
		map.setXMLData(strXML);
		map.render("mapdiv");
	}else{
		//If IE or if no-markers defined
		//Just update map data
		this.mapObj.setXMLData(strXML);
	}
}
infosoftglobal.FusionMapsGUI.prototype.updateMapfromXML = function(){
	//This method updates the map with XML data contained in the textarea.
	//Bug Handling: Due to weird behavior in Firefox when markers are defined, we cannot
	//directly update the map data using it's JS interface. So, if markes are defined
	//and the browser is Firefox (non IE), we re-load the map.
	if (markerWinOpened==true && navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) {		
		//Update flag that it's a forced re-load
		isReload = true;
		//Re-load map		
		if (FusionCharts(this.mapId) && FusionCharts(this.mapId).dispose) {
			FusionCharts(this.mapId).dispose();
		}
		
		var map = new FusionCharts(this.mapPath + this.mapList[this.mapIndex].swf, this.mapId, this.mapList[this.mapIndex].width, this.mapList[this.mapIndex].height, "0", "1"); 
		map.setXMLData(this.getValue("xmlDataFull"));
		map.render("mapdiv");
	}else{
		//If IE or if no-markers defined
		//Just update map data
		this.mapObj.setXMLData(this.getValue("xmlDataFull"),false);
	}
}
infosoftglobal.FusionMapsGUI.prototype.enableChooseMode = function(){
	//If map is not in Invalid XML mode and we've chooseMode function exposed
	if (typeof this.mapObj.ref.enableChooseMode=="function"){
		this.mapObj.ref.enableChooseMode();
		//Update flag
		this.chooseMode = true;
	}
}
infosoftglobal.FusionMapsGUI.prototype.disableChooseMode = function(){
	//If in choose mode, disable
	if(this.chooseMode == true){
		this.mapObj.ref.disableChooseMode();
		//Update flag
		this.chooseMode = false;
	}
}
// ------------ Form renderers, controllers and handlers ----------------------//
infosoftglobal.FusionMapsGUI.prototype.renderMapSelectionBox = function(divRef){
	//This method renders the map selection drop down box in the divRef div.
	//Get reference to the div	
	var dv = document.getElementById(divRef);
	//Create the HTML for select box
	var selectHTML = "<select name='mapSelector' class='select' onChange=\"javascript:changeMap(document['guiFORM'].mapSelector.value);\">";
	var i;
	for (i=0; i<this.mapList.length; i++){
		selectHTML = selectHTML + "<option value='" + String(i) + "'>" + this.mapList[i].title;
	}
	//Close select tag
	selectHTML = selectHTML + "</select>";
	//Render it in within the select DIV
	dv.innerHTML = selectHTML;
}
infosoftglobal.FusionMapsGUI.prototype.isMapIndex = function(index){
	//This method checks whether the index of the map drop-down list actually belongs to a map
	return this.mapList[index].isMap;
}
infosoftglobal.FusionMapsGUI.prototype.createTabs = function(){
	//This method creates the required tabs for data entry and display
	//Get reference to the div that contains tabs
	var dv = document.getElementById("tabDiv");
	//Update its visibility
	dv.style.display = "inline";
	
	// disable marker defining tab when JavaScript maps are rendered
	// also disable showBevel as bevel is not supported in JavaScript maps
	if (this.isJSMap) {
		document.getElementById("maintabnav3").style.display = "none";
		this.gForm["mShowBevel"].disabled = "disabled";
	}
	
	//Update form for the new map
	//First up, update the entityList form
	this.updateEntityForm();
}
infosoftglobal.FusionMapsGUI.prototype.clearForms = function(){
	//clearForms method clears the form when a map type is changed
	//and a new map is sent for loading.	
	//Switch back to first tab - so that we keep our events track on marker tab
	document.getElementById('maintab').tabber.tabShow(0);
	//Update Entity Form
	var dv = document.getElementById("entityFormDiv");
	dv.innerHTML = "<span class='text'><B>Please wait while the new map is loading.</B></span>";
	//Remove all rows from marker tables
	while (getTableLen("tblMarker")>0){
		deleteLastRow("tblMarker");
	}
	//Clear HTML Code text-area
	this.gForm.htmlCode.value = "";
	//Clear the XML code textareas
	this.gForm.xmlDataFull.value = "";
	this.gForm.xmlEntityTemplate.value = "";
	this.gForm.xmlMarkerFull.value = "";
	this.gForm.xmlMarkerDef.value = "";
	//Hide all tabs
	var dv = document.getElementById("tabDiv");
	//Update its visibility
	dv.style.display = "none";
}
infosoftglobal.FusionMapsGUI.prototype.updateEntityForm = function(){
	//This function updates the entity form, where user can enter data.
	//HTML for the entire form
	var fHTML = "<table width='95%' align='center' cellpadding='2' cellspacing='2' style='border:1px #CCCCCC solid;'>";
	var fHTML = fHTML + "<tr bgColor='#E0E0E0'><td width='25%' class='header' valign='top'>Entity Name</td><td width='8%' class='header' valign='top'>Id</td><td width='12%' class='header' valign='top' align='center'>Value</td><td width='16%' class='header' valign='top' align='center'>Display Value</td><td width='12%' class='header' valign='top'>&nbsp;Tool-tip</td><td width='15%' class='header' valign='top'>&nbsp;Link</td><td width='15%' class='header' valign='top' align='center'>Color</td></tr>";
	for (i=0; i<this.entities.length; i++){
		//Based on i, do alternate coloring
		if (!this.entities[i]) continue;
		if (i % 2==1){
			fHTML = fHTML + "<tr bgColor='#F5F5F5'>";
		}else{
			fHTML = fHTML + "<tr>";
		}
		fHTML = fHTML + "<td width='25%' class='text' valign='middle'>" + String(this.entities[i].lName) + "</td>";
		fHTML = fHTML + "<td width='8%' class='text' valign='middle'>" + String(this.entities[i].id).toUpperCase() + "</td>";
		fHTML = fHTML + "<td width='12%' valign='middle' align='center'><input type='text' class='textbox' size='6' name='eValue" + String(i) + "' onBlur='if(this.value!=\"\" && isNaN(this.value)) {alert(\"You cannot enter a non-numeric value for an entity\"); this.focus();}'/> </td>";																																																																 
		fHTML = fHTML + "<td width='16%' valign='middle' align='center'><input type='text' class='textbox' size='12' name='eDisplayValue" + String(i) + "' /> </td>";
		fHTML = fHTML + "<td width='12%' valign='middle' align='center'><input type='text' class='textbox' size='10' name='eToolText" + String(i) + "' /> </td>";
		fHTML = fHTML + "<td width='14%' valign='middle' align='center'><input type='text' class='textbox' size='12' name='eLink" + String(i) + "' /> </td>";
		fHTML = fHTML + "<td width='15%' align='center' valign='middle'><input type='text' class='textbox' size='6' name='eColor" + String(i) + "' />&nbsp;<input type='button' value='...' style='width:20;' class='select' onClick=\"javascript:openColorPicker(document['guiFORM'].eColor" + String(i) + ");\"></td>";
		fHTML = fHTML + "</tr>";
	}
	fHTML = fHTML + "</table><BR>";
	//Update the DIV with the form information
	var dv = document.getElementById("entityFormDiv");
	dv.innerHTML = fHTML;
}
infosoftglobal.FusionMapsGUI.prototype.renderHTMLCode = function(){
	//This function renders the HTML code the map.
	var strHTML = "<html>\n";
	strHTML = strHTML + "\t<head>\n";
	strHTML = strHTML + "\t\t<title>FusionMaps XT - Map</title>\n";
	strHTML = strHTML + "\t\t<!-- Do not forget to include this JS file and update it's path -->\n";
	strHTML = strHTML + "\t\t<scri" + "pt type=\"text/javascript\" src=\"FusionCharts.js\"></scr" + "ipt>\n";
	strHTML = strHTML + "\t\t</title>\n";
	strHTML = strHTML + "\t</head>\n";
	strHTML = strHTML + "\t<body>\n";
	strHTML = strHTML + "\t\t<!-- Code Block for Map Starts here -->\n";
	strHTML = strHTML + "\t\t<div id='mapDiv'>\n";	
	strHTML = strHTML + "\t\t\tThe map will replace this text. If any users do not have Flash Player 8 (or above), they'll see this message.\n";	
  	strHTML = strHTML + "\t\t</div>\n";	
	strHTML = strHTML + "\t\t<scr" + "ipt type=\"text/javascript\">\n";
	strHTML = strHTML + "\t\t\tvar map = new FusionCharts(\"" + this.mapList[this.mapIndex].swf + "\", \"Map_Id\", " + this.mapList[this.mapIndex].width + ", " + this.mapList[this.mapIndex].height + ", \"0\", \"0\");\n";
	strHTML = strHTML + "\t\t\tmap.setXMLUrl(\"Data.xml\");\n"
	strHTML = strHTML + "\t\t\tmap.render(\"mapDiv\");\n";
	strHTML = strHTML + "\t\t</scr" + "ipt>\n";
	strHTML = strHTML + "\t\t<!-- Code Block for Map Ends here -->\n";
	strHTML = strHTML + "\t</body>\n";
	strHTML = strHTML + "</html>";
	//Update text field
	this.gForm.htmlCode.value = strHTML;
}
infosoftglobal.FusionMapsGUI.prototype.renderXMLCode = function(){
	//This method renders the XML codes for the various code blocks
	this.gForm.xmlDataFull.value = 	this.getFullXMLData();
	//Update Entity XML text area
	this.gForm.xmlEntityTemplate.value = this.getEntityXMLTemplate();
	//Markers XML	
	if (this.markers.length>0){
		//Markers (def & app) text-area
		var strXML = "";
		strXML = strXML + "<markers>\n";
		//Add marker definition tags
		strXML = strXML + "\t<definition>\n" + this.getMarkerDefXML(false) + "\t</definition>\n";
		//Add marker application tags
		strXML = strXML + "\t<application>\n" + this.getMarkerAppXML(false) + "\t</application>\n";
		//Close markers tag
		strXML = strXML + "</markers>\n";		
		this.gForm.xmlMarkerFull.value = strXML;
		//Markers definition XML only.
		var strXML = "";
		strXML = strXML + "<markers>\n";
		//Add marker definition tags
		strXML = strXML + "\t<definition>\n" + this.getMarkerDefXML(false) + "\t</definition>\n";
		//Close markers tag
		strXML = strXML + "</markers>\n";		
		this.gForm.xmlMarkerDef.value = strXML;
	}else{
		//Set empty strings
		this.gForm.xmlMarkerFull.value = "";
		this.gForm.xmlMarkerDef.value = "";
	}
}
infosoftglobal.FusionMapsGUI.prototype.addMarker = function(mX, mY, mId, mLabel, mLabelPos, mShow){
	//This function adds a marker to the map.
	//Encode all the strings to be XML safe
	mId = this.encodeStr(mId);
	mLabel = this.encodeStr(mLabel);
	//Push it to our markers store
	this.markers.push(mId);
	this.markerPos.push({x:mX, y:mY});
	//Now, update the UI with the new marker information.
	//Create a new row in marker table (at end)
	var markerRow = appendRowAtEnd("tblMarker");	
	//Now, create the cells within this and set their properties
	var idCell = markerRow.insertCell(0);
	idCell.width = "10%";
	idCell.valign = "top";
	idCell.bgColor="#f5f5f5";
	idCell.innerHTML = "<span class='text'>" + mId + "</span>";
	
	var labelCell = markerRow.insertCell(1);
	labelCell.width = "30%";
	labelCell.valign = "top";
	labelCell.innerHTML = "<input type='text' class='textbox' name='mLabel_" + mId + "' value='" + mLabel + "' size='25'>";
	
	var labelPosCell = markerRow.insertCell(2);
	labelPosCell.width = "15%";
	labelPosCell.valign = "top";
	labelPosCell.align = "center";
	labelPosCell.innerHTML = "<select name='mLabelPos_" + mId + "' class='select'><option value='top' " + this.isSelected("top",mLabelPos) + ">Top<option value='bottom'" + this.isSelected("bottom",mLabelPos) + ">Bottom<option value='center'" + this.isSelected("center",mLabelPos) + ">Center<option value='left'" + this.isSelected("left",mLabelPos) + ">Left<option value='right'" + this.isSelected("right",mLabelPos) + ">Right</select>";
	
	var showCell = markerRow.insertCell(3);
	showCell.width = "15%";
	showCell.valign = "top";
	showCell.align="center";
	showCell.innerHTML = "<input type='checkbox' name='mShow_" + mId + "' " + ((mShow)?"checked":"") + ">";
	
	var shapeCell = markerRow.insertCell(4);
	shapeCell.width = "15%";
	shapeCell.valign = "top";
	shapeCell.align = "center";
	shapeCell.innerHTML = "<select name='mShape_" + mId + "' class='select'><option value='circle'>Circle<option value='arc'>Arc<option value='triangle'>Triangle<option value='diamond'>Diamond</select>";
	
	var deleteCell = markerRow.insertCell(5);
	deleteCell.width = "10%";
	deleteCell.valign = "top";
	deleteCell.align = "center";
	deleteCell.innerHTML = "<input type='button' class='select' value='X' name='mDelete_" + mId + "' onClick='javaScript:deleteMarker(\"" + mId + "\");'>";	
}
infosoftglobal.FusionMapsGUI.prototype.deleteMarker = function(markerId){
	//Get the index of the maker from id
	var index = this.getMarkerIndexFromId(markerId);
	//Now splice the markers array to remove this
	this.markers.splice(index,1);
	this.markerPos.splice(index,1);
	//Also, delete the table row from UI
	deleteTableRow("tblMarker",index+1);
}
infosoftglobal.FusionMapsGUI.prototype.getMarkers = function(){
	//This method exposes the defined markers of the map, so that we can check for
	//duplicates.
	return this.markers;
}
infosoftglobal.FusionMapsGUI.prototype.getMarkerIndexFromId = function(mId){
	//This method searches for a marker ID in the array and returns its
	//numerical index.
	var index = -1;
	for (i=0; i<this.markers.length; i++){
		//Make a case in-sensitive check
		if (this.markers[i]==mId){
			index=i;
			break;
		}
	}		
	return index;
}
// ------------- The following functions build XML data -----------------//
infosoftglobal.FusionMapsGUI.prototype.getFullXMLData = function(){
	//This method returns the full XML data for the map.
	var strXML = "<map " + this.getMapElementAtts() + " >\n";
	//Add Data
	strXML = strXML + this.getDataAsXML();
	//Add the marker XML - definition & application (if required)
	if (this.markers.length>0){
		strXML = strXML + "\t<markers>\n";
		//Add marker definition tags
		strXML = strXML + "\t\t<definition>\n" + this.getMarkerDefXML(true) + "\t\t</definition>\n";
		//Add marker application tags
		strXML = strXML + "\t\t<application>\n" + this.getMarkerAppXML(true) + "\t\t</application>\n";
		//Close markers tag
		strXML = strXML + "\t</markers>\n";		
	}
	//Close <map>
	strXML = strXML + "</map>";
	//Return
	return strXML;
}
infosoftglobal.FusionMapsGUI.prototype.getMapElementAtts = function(){
	//This method returns the attributes of the <map> element
	var atts = "";
	//Append each of the map attributes
	atts = atts + this.buildAttString("animation","mAnimation",false,"1");
	atts = atts + this.buildAttString("showShadow","mShowShadow",false,"1");
	atts = atts + this.buildAttString("showBevel","mShowBevel",false,"1");
	atts = atts + this.buildAttString("showLegend","mShowLegend",false,"1");
	atts = atts + this.buildAttString("showLabels","mShowLabels",false,"1");
	atts = atts + this.buildAttString("showMarkerLabels","mShowMarkerLabels",false,"2");
	atts = atts + this.buildAttString("useSNameInToolTip","mUseSNameInToolTip",false,"0");
	
	atts = atts + this.buildAttString("includeNameInLabels","mIncludeNameInLabels",false,"1");
	atts = atts + this.buildAttString("includeValueInLabels","mIncludeValueInLabels",false,"0");

	atts = atts + this.buildAttString("fillColor","mFillColor",true,"");
	atts = atts + this.buildAttString("borderColor","mBorderColor",true,"");
	atts = atts + this.buildAttString("connectorColor","mConnectorColor",true,"");
	atts = atts + this.buildAttString("hoverColor","mHoverColor",true,"");
	atts = atts + this.buildAttString("canvasBorderColor","mCanvasBorderColor",true,"");
	atts = atts + this.buildAttString("baseFont","mBaseFont",true,"");
	atts = atts + this.buildAttString("baseFontSize","mBaseFontSize",true,"");
	atts = atts + this.buildAttString("baseFontColor","mBaseFontColor",true,"");
	atts = atts + this.buildAttString("markerBorderColor","mMarkerBorderColor",true,"");
	atts = atts + this.buildAttString("markerBgColor","mMarkerBgColor",true,"");
	atts = atts + this.buildAttString("markerRadius","mMarkerRadius",true,"");	
	atts = atts + this.buildAttString("legendPosition","mLegendPosition",false,"");	

	atts = atts + this.buildAttString("useHoverColor","mUseHoverColor",false,"2");		
	atts = atts + this.buildAttString("showToolTip","mShowToolTip",false,"1");	
	atts = atts + this.buildAttString("showMarkerToolTip","mShowMarkerToolTip",false,"2");
	atts = atts + this.buildAttString("formatNumberScale","mFormatNumberScale",false,"1");
	atts = atts + this.buildAttString("numberPrefix","mNumberPrefix",true,"");
	atts = atts + this.buildAttString("numberSuffix","mNumberSuffix",true,"");	
	//Return atts list
	return atts;
}
infosoftglobal.FusionMapsGUI.prototype.getDataAsXML = function(){
	//This method encodes the data of the map in XML format.
	var dataXML = "\t<data>\n";
	//We need to iterate through all the entities and look for values
	//in their form elements
	for (i=0; i<this.entities.length; i++){
		if (!this.entities[i]) continue;
		//Container for entity element
		var entityEl = "\t\t<entity id='" + this.entities[i].id.toUpperCase() + "' ";
		entityEl = entityEl + this.buildAttString("value","eValue"+i,false,"");
		entityEl = entityEl + this.buildAttString("displayValue","eDisplayValue"+i,true,"");
		entityEl = entityEl + this.buildAttString("toolText","eToolText"+i,true,"");
		entityEl = entityEl + this.buildAttString("link","eLink"+i,true,"");
		entityEl = entityEl + this.buildAttString("color","eColor"+i,true,"");
		//Close entity element
		entityEl = entityEl+ " />\n";
		//Add to entire XML
		dataXML = dataXML + entityEl;
	}	
	//Close data element
	dataXML = dataXML + "\t</data>\n";
	return dataXML;
}
infosoftglobal.FusionMapsGUI.prototype.getEntityXMLTemplate = function(){
	//getEntityXMLTemplate method returns the XML representation for all entities of map.	
	var i;
	var entityXML = "<data>\n";
	for (i=0; i<this.entities.length; i++){
		if (!this.entities[i]) continue;
		entityXML = entityXML + "\t<entity id='" + String(this.entities[i].id).toUpperCase() + "' value='' />\n";
	}
	entityXML = entityXML + "</data>";
	//Return XML Data
	return entityXML;
}
/**
 *  @param	threeTabs	Whether to use three tabs for formatting
*/
infosoftglobal.FusionMapsGUI.prototype.getMarkerDefXML = function(threeTabs){
	//This method returns the marker definition XML
	var defXML = "";
	var i;
	var id;
	for (i=0; i<this.markers.length; i++){
		id = this.markers[i];
		var markerXML = ((threeTabs==true)?"\t\t\t":"\t\t") + "<marker id='" + id + "' x='" + this.markerPos[i].x + "' y='" + this.markerPos[i].y + "' ";
		markerXML = markerXML + this.buildAttString("label","mLabel_"+id,true,"");
		markerXML = markerXML + this.buildAttString("labelPos","mLabelPos_"+id,false,"top");
		markerXML = markerXML + " />\n";
		//Add to entire XML
		defXML = defXML + markerXML;
	}
	return defXML;
}
/**
 *  @param	threeTabs	Whether to use three tabs for formatting
*/
infosoftglobal.FusionMapsGUI.prototype.getMarkerAppXML = function(threeTabs){
	//This method returns the marker application XML
	var appXML = "";
	var i;
	var id;
	var show;
	for (i=0; i<this.markers.length; i++){
		id = this.markers[i];
		//Whether we've to show this data on the map.
		show = this.getValue("mShow_"+id,false);
		if (show=="1"){
			var markerXML = ((threeTabs==true)?"\t\t\t":"\t\t") + "<marker id='" + id + "' ";
			markerXML = markerXML + this.buildAttString("shapeId","mShape_"+id,false,"");
			markerXML = markerXML + " />\n";
			//Add to entire XML
			appXML = appXML + markerXML;
		}
	}
	return appXML;
}

infosoftglobal.FusionMapsGUI.prototype.buildAttString = function(attName, elementName, encodeSafe, defaultValue){
	//This method builds the attribute string representation
	var attString = "";
	//Get the value of the element
	var val = this.getValue(elementName, encodeSafe);
	//Now, if the val is different from default value, only then we create the string
	//Else, it makes no sense to add an attribute which still bears its default value
	if (val!=defaultValue){
		attString = attName + "='" + val + "' ";
	}
	//Return
	return attString;
}
// ------------ Generic functions to do various things ----------------- //
infosoftglobal.FusionMapsGUI.prototype.getValue = function(elementName, encodeSafe){
	//This method returns the value of a form element and converts into safe encoding
	//Get reference to the element
	var el = this.gForm[elementName];
	var rtnVal;
	//Based on the type of form element, we send the value back
	switch (el.type){
		case "text":
			rtnVal = el.value;
			break;
		case "textarea":
			rtnVal = el.value;
			break;
		case "select-one":
			rtnVal = el.value;						
			break;
		case "checkbox":
			rtnVal = (el.checked)?"1":"0";
			//No need for encode safe in checkbox
			encodeSafe=false;
			break;
		default:
			rtnVal = "";
			encodeSafe=false;
			break;
	}
	//If we've to encode-safe
	if (encodeSafe==true){
		rtnVal = this.encodeStr(rtnVal);
	}
	return rtnVal;
}
infosoftglobal.FusionMapsGUI.prototype.encodeStr = function(str){
	//This method takes in a string as parameter and encodes the special
	//characters for safe conversion and placement in XML.
	//Replace %
	//str = str.replace(/%/g,"%25");
	//Replace quotation mark	
	str = str.replace(/'/g,"&apos;");
	//Replace ampersand
	//str = str.replace(/&/g,"%26");	
	//Replace Euro sign
	//str = str.replace(/�/g,"%E2%82%AC");
	//Replace pound sign
	//str = str.replace(/�/g,"%A3");
	//Replace < 
	str = str.replace(/</g,"&lt;");
	//Replace >
	str = str.replace(/>/g,"&gt;");
	//Return
	return str;
}
infosoftglobal.FusionMapsGUI.prototype.isSelected = function(selectString, matchString){
	//This method is used to render "selected" option for checkboxes
	if (selectString==matchString){
		return " selected ";
	}else{
		return "";
	}
}
infosoftglobal.FusionMapsGUI.prototype.reInit = function(){
	//This method re-initializes the properties associated with a map.
	//To be called when a new map is loaded.
	this.mapIndex = -1;
	this.chooseMode = false;
	this.entities = new Array();	
	this.markers = new Array();
	this.markerPos = new Array();
}
/* Aliases for easy usage */
var FusionMapsGUI = infosoftglobal.FusionMapsGUI;