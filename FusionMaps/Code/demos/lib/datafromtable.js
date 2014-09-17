function getDataFromTable( tableObj ) {
	var data = {};
	var mapDef = {
		"southamerica" 	: "SA",
		"northamerica" 	: "NA",
		"europe"		: "EU",
		"asia" 			: "AS",
		"africa" 		: "AF",
		"australia" 	: "AU"
		
	};
	var tableArr = {
		entities: jQuery("#myDataTable tr:first").contents().text().toLowerCase().replace(/^[\s\S]+?(\S)/,"$1").replace(/(\S)[\s\r\n\t]+?$/g,"$1").split(/[\n\r]\s+/).slice(1),
		values: jQuery("#myDataTable tr:last").contents().text().replace(/^[\s\S]+?(\S)/,"$1").replace(/(\S)[\s\r\n\t]+?$/g,"$1").split(/[\n\r]\s+/).slice(1)
	};

	
	for (var i in tableArr["entities"] ) {
		
		if (typeof tableArr["entities"][i]=="string") {
			var id = ""+tableArr["entities"][i].replace(/[\n\r\s\t]+?/g,"");	
			data [ mapDef [ id ] ] = tableArr["values"][i] || "";
		}
		
		
			
	}

	
		
	return data;

}


function formMapDataXML ( data ) {
	var xml = '<map includeValueInLabels="1" showlabels="1" showtooltip="1" showshadow="1" showbevel="0" basefont="Verdana" basefontsize="10" exportEnabled="1" showExportDataMenuItem="1" showPrintMenuItem="1" animation="0" exposeHoverEvent="1" showCanvasBorder="1" bgalpha="70,70" bgcolor="566f04,cbd3b2" canvasbgcolor="566f04,cbd3b2" fillColor="A9ba1a" hoverColor="dbe67c" toolTipBorderColor="A9ba1a" toolTipBgColor="FFFFFF" baseFontColor="000000" borderColor="FFFFFF" canvasBorderColor="566f04" canvasBorderAlpha="90">';
	
	xml += '<data>';
	
	for (var i in data) {
		
		if (typeof data[i] == "function" ) continue;
		
		xml += '<entity value="' + data[i] + '" id="' + i + '" />';		
		
	}
	
	xml += '</data>';
	xml += '</map>';	
	
	return xml;
}