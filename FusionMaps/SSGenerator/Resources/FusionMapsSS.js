if(typeof infosoftglobal == "undefined") var infosoftglobal = new Object();
if(typeof infosoftglobal.FusionMapsSS == "undefined") infosoftglobal.FusionMapsSS = new Object();
infosoftglobal.FusionMapsSS = function(){
	if (!document.getElementById) { return; }	
	//Store the map id for global usage
	this.mapId = "MainMap";
	//Path for map storage
	this.mapPath = "../Maps/";
	//Currently loaded map's index
	this.mapIndex = -1;
	//Get reference to the form - later we'll directly access objects.
	this.gForm = document['guiFORM'];	
	//List of maps that we've to cover
	this.mapList = new Array();	
	//Create container objects
	this.entities = new Array();	
	//Define map list
	this.defineMapList();
};
// --------- Following functions help interact with the map ----------------//
infosoftglobal.FusionMapsSS.prototype.getReferenceToMap = function(){
	//This method is invoked when the map has loaded and rendered. So, we can safely
	//get a reference to the map object.
	this.mapObj = FusionMaps(this.mapId);			
	//If we cannot get a reference to map object, it means	
	//Also, we can now get the map's entities and store it.	
	this.entities = this.mapObj.getEntityList();
	
};
infosoftglobal.FusionMapsSS.prototype.getSSforPOST = function(){
	var post;
	var title,lname,sname,eId,mc,ssId,tVal;
	
	var title=this.mapList[this.mapIndex].title;
	title=this.mapList[this.mapIndex].title;
	title=title.replace(/\s/g,"_");
	title=title.replace(/[^a-z0-9]/ig,"_");
	title=title.replace(/_+/g,"_");
	title=title.replace(/_$/,"");
	title=title.replace(/^_/,"");
	
	post="map="+title;
		
	for (var i=0; i<this.entities.length; i++){
		if (!this.entities[i]) continue;
		lname = this.entities[i].lName;
		sname = this.entities[i].sName;
		mc =	this.entities[i].mc;
		eId = this.entities[i].id.toUpperCase();
	
		tVal=lname+','+eId+','+sname+','+mc;
		ssId="ss"+i;

		post+="&"+ssId+"="+tVal;
	}

	return post;

};
infosoftglobal.FusionMapsSS.prototype.showSSFull=function(div){
		var ss,title,lname,sname,eId,mc,ssId,tVal;

		title=this.mapList[this.mapIndex].title;
		title=title.replace(/\s/g,"_");
		title=title.replace(/[^a-z0-9]/ig,"_");
		title=title.replace(/_+/g,"_");
		title=title.replace(/_$/,"");
		title=title.replace(/^_/,"");
		
		ss='<TABLE>';

		ss+='<TR><TD class="listTitle">Long Name,Entity Id,Short Name</TD></TR>';
		ss+='<TR><TD><textarea cols="40" rows="28" class="list" >';


		
		for (var i=0; i<this.entities.length; i++){
			if (!this.entities[i]) continue;
			lname = this.entities[i].lName;
			sname = this.entities[i].sName;
			mc =	this.entities[i].mc;
			eId = this.entities[i].id.toUpperCase();
		
			tVal=lname+','+eId+','+sname+'\r\n';
			ssId="ss"+i;

			ss+=tVal;
			
		}

		ss+='</textarea></Td></Tr>';

		ss+="</table>";
		document.getElementById(div).innerHTML=ss;
		
};


infosoftglobal.FusionMapsSS.prototype.renderMapSelectionBox = function(divRef){
	//This method renders the map selection drop down box in the divRef div.
	//Get reference to the div	
	var dv = document.getElementById(divRef);
	//Create the HTML for select box
	var selectHTML = "<select style='width:220px;' id='mapSelector' onChange=\"javascript:changeMap(document.getElementById('mapSelector').value);\">";
	var i;
	for (i=0; i<this.mapList.length; i++){
		selectHTML = selectHTML + "<option value='" + String(i) + "'>" + this.mapList[i].title;
	}
	//Close select tag
	selectHTML = selectHTML + "</select>";
	//Render it in within the select DIV
	dv.innerHTML = selectHTML;
};

infosoftglobal.FusionMapsSS.prototype.loadMap = function(index){
	//This method loads the map, if the index is a map value
	if(this.mapList[index].isMap){
		//Store the index of new map
		document.getElementById("mapTD").className="mapTDOff";
		this.mapIndex = index;
		
		if (FusionCharts(this.mapId) && FusionCharts(this.mapId).dispose) {
			FusionCharts(this.mapId).dispose();
		}
		
		var map = new FusionCharts(this.mapPath + this.mapList[index].swf, this.mapId, "550", "300", "0", "1");      
		map.setXMLData("<map animation='0' showBevel='0' showCanvasBorder='0' showShadow='1' fillColor='CAD3DB' borderColor='FFFFFF' useHoverColor='1' hoverColor='E6EAEE'/>");
		map.render("mapdiv");
		//Update mapNameDiv with the new map's name
		var dv = document.getElementById("mapNameDiv");
		dv.innerHTML = "Map of " + this.mapList[index].title.replace(/\smap/ig,"") ;
	}	
};

infosoftglobal.FusionMapsSS.prototype.defineMapList = function(){
		this.mapList = getMapList();
};
	


var FusionMapsSS = infosoftglobal.FusionMapsSS;