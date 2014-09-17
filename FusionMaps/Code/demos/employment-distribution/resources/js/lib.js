$(document).ready ( function() {
	
	(function () {
		var employmentData = {},
			random = Math.random,
			round = Math.round,
			mapType = getRequestedMapType() || "FCMap_USA";
		
		function createMap()
		{
			var USAMap = new FusionCharts({ 
					type	: mapType, 
					id		: "EmploymentMap",
					width	: "600", 
					height	: "350"
			});
			USAMap.setTransparent(true);
			USAMap.setJSONData(getMapData());
			USAMap.addEventListener( "rendered", function (e,a) {
				updateRandomEmploymentData(e.sender);
			});
			USAMap.addEventListener( "EntityRollover", function (e,a) {
				showStateEmploymentDetails(e,a);
			});
			USAMap.addEventListener( "EntityRollout", function (e,a) {
		
			});
			
			USAMap.render("mapdiv");
		}
		
		function updateRandomEmploymentData(chart) {
			var entityList = chart.getEntityList(),
				mapData = chart.getJSONData();
			
			mapData.data = [];
			
			for (var i=1; i<entityList.length; i++) {
				var entityMetadata = entityList[i], 
					id = entityMetadata.id.toUpperCase()
					value  = (round((random()*65+5)*10))/10,
					tooltext = entityMetadata.lName + ", " + value +"% people employed";
				
				
				mapData.data.push({ 
					"id" : id,
					"value" : value+"",
					"toolText" : tooltext
				});
				
				employmentData[id] = {
					"Service": (round((random()*35+5)*10))/10,
					"Manufacturing": (round((random()*35+5)*10))/10,
					"Professional": (round((random()*35+5)*10))/10	
				};
			}

			chart.setJSONData(mapData);
		}
		
		function showStateEmploymentDetails(e,a) {
			var id = a.id.toUpperCase();
			var stateData = employmentData[id];
			$("#statenameHTML").html(a.label);
			for (var i in stateData) {
				$("#"+i+"HTML").html("<b>"+i+"</b><br/>"+stateData[i] +"%");
			}
			
		}
		
		function getMapData() {
			
			var mapConfigurations = {
			  "map": {
				"fillAlpha": "100",
				"fillcolor": "FFFFFF",
				"borderColor": "666666",
				"borderThickness": "1",
				"borderAlpha": "100",
				"hoverColor": "A6B3BA",
				"showCanvasBorder": "0",
				"legendPosition": "RIGHT",
				"legendBorderThickness": "1",
				"legendShadow": "0",
				"legendBorderColor" : "CCCCCC",
				"tooltipBorderColor" : "666666",
				"legendBgAlpha": "0",
				"showshadow": "0",
				"showBevel": "0",
				"bgAlpha": "0,0",
				"showLegend": "1",
				"showLabels" : "0"
			  },
			  
			  "colorrange": {
				"color": [
				  {
					"minvalue": "0",
					"maxvalue": "40",
					"displayvalue": "< 40 %",
					"code": "EEEEEE"
				  },
				  {
					"minvalue": "40",
					"maxvalue": "50",
					"displayvalue": "40-50 %",
					"code": "CCCCCC"
				  },
				  {
					"minvalue": "50",
					"maxvalue": "100",
					"displayvalue": "> 50 %",
					"code": "999999"
				  }
				]
			  },
			  "data": []
			};
			
			return mapConfigurations;
		}
		
		function getRequestedMapType() {
			var query = parseQuerystring(window.location.search);
			if (ret = query["maptype"]) {
				$(".mapname").html(query["mapname"] || query["maptype"].replace(/FCMap_/, "") || "");
			}
			return ret;
		}
		
		function parseQuerystring (qs) {
			var arr = {};
			qs.replace(
				new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
				function( $0, $1, $2, $3 ){ arr[$1.toLowerCase()] = $3; }
			);
			return arr;
		}
		
		createMap();			   
	}());
	
});	





