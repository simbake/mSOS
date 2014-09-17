// function to create chart
function createChart(pindex)
{
	
	if (FusionCharts && FusionCharts("BreakupChart") && FusionCharts("BreakupChart").setXMLData) {
		FusionCharts("BreakupChart").setXMLData(buildChartXML(pindex));
	}
	else {
		var Pie2DChart = new FusionCharts({ 
			type	: "../Code/Charts/Pie2D", 
			id		: "BreakupChart",
			width	: "100%", 
			height	: "100%"
		});
		
		Pie2DChart.setTransparent(true);
		Pie2DChart.setXMLData(buildChartXML(pindex));
		Pie2DChart.addEventListener("rendered", function() {
			$("#chartdiv").append("<div class='popupinfo'><span class='redcolor'>*</span> Data source: <a href='http://en.wikipedia.org/wiki/Indian_general_election,_2009' target='_blank'>Wikipedia</a></div>");										   
		});
		
		Pie2DChart.render("chartdiv");
	}
	
	if (pindex == "000") {
		$(".popupinfo").html("<span class='redcolor'>*</span> Data source: <a href='http://en.wikipedia.org/wiki/Indian_general_election,_2009' target='_blank'>Wikipedia</a>");
	} else {
		$(".popupinfo").html("<a href='JavaScript:createChart(\"000\");'>Click here to show pan-India result in the chart</a>");
	}
	
}


function createMap()
{
	var IndiaMap = new FusionCharts({ 
			type	: "FCMap_India", 
			id		: "ElectionMap",
			width	: "100%", 
			height	: "100%"
	});
	IndiaMap.setTransparent(true);
	IndiaMap.setXMLData(getMapXML());
	IndiaMap.render("mapdiv");
}


// get the index of the highest value in an array
function gethighest(arr) {

	var indx = 0;
	var comp1 = arr[0];
	var comp2;
	for (var i = 1; i<arr.length; i++) {
		comp2 = arr[i];
		if (comp2>comp1) {
			indx = i;
			comp1 = comp2;
		}
	}
	return indx;
}

// build map entity attributes
function getEntityAtt(indx) {
	var str = "";
	str += " id='"+indx+"' value='"+(gethighest(pdata[indx][1])+1)+"' link='j-createChart-"+indx+"' toolText='"+pdata[indx][0]+buildTT(pdata[indx][1])+"' ";
	return str;
}

// build tooltip
function buildTT(arr) {
	var higst = gethighest(arr);
	var str = "";
	for (var i = 0; i<arr.length; i++) {
		str += "{br} "+labels[i]+" - "+arr[i];
	}
	return str;
}


function getMapXML() {
	var strXML = "<map borderColor='ededed' borderAlpha='33' useSNameInLabels='1' hoverColor='cccccc' showCanvasBorder='0' includeNameInLabels='1' legendPosition='BOTTOM' legendBorderThickness='1' legendShadow='0' legendBgAlpha='0' showshadow='0' showBevel='0' bgAlpha='0,0' >";
	//Define color range
	strXML = strXML+"<colorRange>";
	strXML = strXML+"<color color='1E61D1' minValue='1' maxValue='2' displayValue='UPA' />";
	strXML = strXML+"<color color='F3B40B' minValue='2' maxValue='3' displayValue='NDA' />";
	strXML = strXML+"<color color='CC0000' minValue='3' maxValue='4' displayValue='Third Front' />";
	strXML = strXML+"<color color='AEC965' minValue='4' maxValue='5' displayValue='Fourth Front' />";
	strXML = strXML+"<color color='B628AD' minValue='5' maxValue='6' displayValue='Others' />";
	strXML = strXML+"</colorRange>";
	strXML = strXML+"<data>";

	for (var i in pdata) {
		// if data is not for all india
		if (i != "000") {
			strXML += "<entity "+getEntityAtt(i)+"/>";
		}
	}
	strXML = strXML+"</data>";
	strXML += "<styles><definition><style type='font' name='enttext' size='9' bold='0' color='1a2a3a' /><style type='glow' name='whiteshadow'  blurX='4'  blurY='5' color='FFFFFF' Alpha='30'/></definition><application><apply toObject='labels' styles='enttext,whiteshadow' /></application></styles>";
	strXML = strXML+"</map>";
	return strXML;
}


function buildChartXML(pindex) {
	var colors=['1E61D1','F3B40B','CC0000','AEC965','B628AD'];
	var strXML = "<chart showZeroPies='1' plotBorderThickness='1' plotBorderAlpha='100' caption='"+pdata[pindex][0]+"' showPercentInToolTip='1' use3DLighting='0' pieRadius='65' animation='0' showShadow='0' bgAlpha='0,0' borderAlpha='0' >";
	for (var i = 0; i<pdata[pindex][1].length; i++) {
		strXML += "<set label='"+labels[i]+"' value='"+pdata[pindex][1][i]+"' color='"+colors[i]+"' />";

	}
	strXML += "<styles><definition><style type='font' name='captiontext' size='16' bold='0' color='79808a' /><style type='glow' name='whiteshadow'  blurX='2'  blurY='2' color='FFFFFF'/></definition>";
	strXML += "<application><apply toObject='CAPTION' styles='captiontext' /><apply toObject='DATALABELS' styles='whiteshadow' /></application></styles>";
	strXML += "</chart>";

	return strXML;
}

$(document).ready ( function() {
	//india.onRelease = function() { createChart("000"); }
	createMap();
	createChart("000");
	
	

});	





