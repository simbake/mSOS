function createMap()
{
	var USAMap = new FusionCharts({ 
			type	: "FCMap_USA", 
			id		: "ElectionMap",
			width	: "100%", 
			height	: "100%"
	});
	USAMap.setTransparent(true);
	USAMap.setXMLData(getMapXML());
	USAMap.render("mapdiv");
}



// build map entity attributes
function getEntityAtt(indx) {
	var str = "";
	str += " id='"+indx+
			"' value='"+(pdata[indx].candidateId)+
			"' displayValue='"+(pdata[indx].showShortName ? indx+", " : "")+(pdata[indx].votes)+
			"' toolText='"+ indx + ": "	 + candidateData[pdata[indx].candidateId].name + " with "+ pdata[indx].votes +" votes' ";
	return str;
}


function getMapXML() {
	var strXML = "<map borderColor='ededed' borderAlpha='33' hoverColor='C1C6D0' showCanvasBorder='0' legendPosition='RIGHT' legendBorderThickness='1' legendShadow='0' legendBgAlpha='0' showshadow='0' showBevel='0' bgAlpha='0,0' >";
	//Define color range
	strXML = strXML+"<colorRange>";
	for (var i=0; i<candidateData.length; i++) {
		strXML += "<color color='"+ candidateData[i].color +"' minValue='"+ i +"' maxValue='"+ (i+1) +"' displayValue='"+ candidateData[i].name +"' />";
	}
	strXML = strXML+"</colorRange>";
	strXML = strXML+"<data>";

	for (var i in pdata) {
			strXML += "<entity "+getEntityAtt(i)+"/>";
	}
	strXML = strXML+"</data>";
	strXML += "<styles><definition><style type='font' name='enttext' size='9' bold='0' color='1a2a3a' /><style type='glow' name='whiteshadow'  blurX='4'  blurY='5' color='FFFFFF' Alpha='30'/></definition><application><apply toObject='labels' styles='enttext,whiteshadow' /></application></styles>";
	strXML = strXML+"</map>";
	return strXML;
}




$(document).ready ( function() {
	createMap();
});	





