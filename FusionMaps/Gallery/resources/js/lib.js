window.querystring = {};
window.map = null;
window.mapListSearchIndex  = {};
window.mapListSearchKeys  = [];
window.mapListSearchHTML  = "";


$( document ).ready(function () {
    init();
});



function getCommands() {
    window.querystring = window.location.search.convertQuerystringToArray();
}



function showMapFromList(mapName, mapIndex, isMenuItemClicked) {
     if (!mapIndex){
         mapIndex = 0;
     }
    var mapDetails = window.mapListSearchIndex [mapName.toLowerCase()][mapIndex];
    renderMap (mapDetails["swf"], mapName); 
    highlightInList (mapName, mapIndex,isMenuItemClicked);

}

function highlightInList(mapName, mapIndex, isMenuItemClicked) {
    
    var selectedListElement = $("#body #left #mapList .maplistitem").filter( function() {
        return $(this).text().toLowerCase() == mapName.toLowerCase() && parseInt($(this).attr('rel')) == parseInt(mapIndex);
    });


    if (!selectedListElement.hasClass('highlightedlistitem')) {
        $("#body #left #mapList .maplistitem").removeClass('highlightedlistitem');
        selectedListElement.addClass('highlightedlistitem');
        
        if (!isMenuItemClicked ) {
            // slide down group
            var selectedMapGroup = selectedListElement.parent().prev();
            var selectedMapParent = selectedMapGroup.parent().parent().prev();
            
            window.setTimeout (function () {

                if (selectedMapParent.next().is(":hidden")) {
                    selectedMapParent.click();
                }

                window.setTimeout (function () {
                    if (selectedMapGroup.next().is(":hidden")){
                        selectedMapGroup.click();
                    };

                    window.setTimeout ( function() {
                        if (selectedListElement.position()) {
                            
                            $("#body #left #mapList div.accordianitems").scrollTop( selectedListElement.position().top );
                        }
                        
                    }, 100)

                }, 200);

            }, 100);        
        }        
    }
    
}

function renderMap(mapSWF, mapName)
{
    
    if(window.MAPEXPLORER_RENDERER) {
        FusionCharts.setCurrentRenderer(window.MAPEXPLORER_RENDERER);
        updateInputControls();
    }
    
    if (window.MAPDATAVIEW) {
        showWaitingMessageInMapDataView();
    }
    
    
    $('#body #middle #mapDetails #name').html(mapName);
    
    window.MAPISRENDERING = true;
    
    if (window.map) {
        window.map.dispose();
    }
		
    window.setTimeout( function () {
        window.map = new FusionCharts(window.MAPEXPLORER_MAPPATH + mapSWF, "MapId", "100%", "100%", "0", "0");
        window.map.setXMLData( "<map "+getThemedMapAttributes()+"/>" );		   	   
        window.map.render("mapContainer");
            
    }, 0);
			
		
}

function FC_Rendered(DOMId) {
    window.MAPISRENDERING = false;
    if (window.MAPDATAVIEW) {
        window["view"+window.MAPDATAVIEW]();
    }
    
    if ($("#"+DOMId).css("visibility") == "hidden") {
        $("#"+DOMId).css( {"visibility": "visible"});
    }
    
}

function FC_Event(DOMId, eventType, objParams){
	
    if (eventType=="rollOver"){
        $("#hoverDetails").html("Mouse is over <b>" + objParams.lName+"</b>");
    }else{
        $("#hoverDetails").html("");
    }
}

function swapRenderer (name) {
    
    name = name.toLowerCase();
    if (!(window.map instanceof FusionCharts)) 
    {
        return;
    }
    var newMap = window.map.clone({
        renderer: name, 
        id:"MapId_"+ name
    });
    window.map.dispose();
    window.setTimeout( function () {
        
        window.MAPEXPLORER_RENDERER = name;
        document.cookie = "MAPEXPLORER_RENDERER="+name;

        updateInputControls();
        
        newMap.render();
        window.map = newMap;
        
    },0);
	
}

function collapseAllExpandedMenuItems(callback) {
    $(".aaccordianitems:visible, .saccordianitems:visible, .maplistitems:visible").hide( function () {
        
    });
    if (callback) callback();
}

function expandAllCollapsedMenuItems (callback) {
   $(".aaccordianitems:hidden, .saccordianitems:hidden, .maplistitems:hidden").show( function () {
        
    }); 
    if (callback) callback();
}

function printMap(){
    if (window.map && window.map.print) window.map.print();
}
function saveMap(){
     if (window.map && window.map.exportChart) window.map.exportChart();
}

function setDefaultRenderer(){
    window.MAPEXPLORER_RENDERER = 'flash';

    var tmpChart = new FusionCharts("Column2D.swf", "tmpChartId", "560", "400", "0", "0");
    window.NO_FLASH = tmpChart.options.renderer=="javascript";
    tmpChart.dispose();
    tmpChart = null;

    if(window.NO_FLASH || /MAPEXPLORER_RENDERER=javascript/i.test(document.cookie) )
    {
        window.MAPEXPLORER_RENDERER = 'javascript';
        updateInputControls();
    }
    
    document.cookie = "MAPEXPLORER_RENDERER="+window.MAPEXPLORER_RENDERER;
    
}

function viewXML() {
    showMapData('XML');
    $("#body #middle #mapDataContainer #titlebar #title").html("<nobr>Map data in XML format</nobr>");	
}

function viewJSON() {
    showMapData('JSON');
    $("#body #middle #mapDataContainer #titlebar #title").html("<nobr>Map data in JSON format</nobr>");
}

function viewCSV() {
    showMapData('CSV');
    $("#body #middle #mapDataContainer #titlebar #title").html("<nobr>Map entity data in CSV format</nobr>");	
}

function viewSS() {
    $("#body #middle #mapDataContainer #titlebar #title").html("<nobr>Map Entity Definition Specification Sheet</nobr>");	
    showMapDataView(getMapSSHTML(), "SS");
    
}


function showMapData(datatype)
{
    
    var mapData = "";
    if (window.map && window.map.getChartData) {
        
        
        if          (datatype == "XML") {
            mapData = window.map.getChartData('xml').replace(/\</gi, "&lt;").replace(/\>/gi, "&gt;");
        }else if    (datatype == "JSON"){ 
            mapData = JSON.stringify( window.map.getChartData('json') ,null, 2);
        }else if    (datatype == "CSV") {
            mapData = window.map.getDataAsCSV ? window.map.getDataAsCSV() : "";
            
        }
        
    }
    showMapDataView('<pre class="prettyprint">'+mapData+'</pre>', datatype, function() {prettyPrint();} );
    
    

}

function getMapSSHTML () {
    var html ='';
    var mapData = window.map.ref.getEntityList ? window.map.ref.getEntityList() : [null];
 
    
    for(var i=0; i< mapData.length; i++) {
        if (mapData[i]) {
            html += ["<tr><td>", mapData[i]["id"].toUpperCase() , "</td><td>", mapData[i]["sName"], "</td><td>", mapData[i]["lName"], "</td></tr>"].join("");
        }
    }
    if ( html != "" ) {
        html = '<table><thead><tr><td width="20%">Internal ID</td><td width="30%">Short Name</td><td width="50%">Long Name</td></tr></thead><tbody>' + html +  '</tbody></table>';
    }
    
    return html;
    
    
}

function closeMapDataView() {
    $("#body #middle #mapDataContainer").fadeOut( function () { 
        $("#body #middle #mapDataContainer #mapData").html( "" );
    });
    window.MAPDATAVIEW = false;
}

function showMapDataView(mapData, datatype, callback) {
    window.MAPDATAVIEW = datatype;
    
    if ($("#body #middle #mapDataContainer").is(":visible")) {
        $("#body #middle #mapDataContainer #mapData").fadeOut( function () {
            $("#body #middle #mapDataContainer #mapData").html(
                window.MAPISRENDERING ? getWaitingMessageInMapDataView() : mapData
            );
            if (callback) callback(); 
            $("#body #middle #mapDataContainer #mapData").fadeIn('slow', function () { 

            });    
     });
     
    }
    else {
        
        $("#body #middle #mapDataContainer #mapData").html( 
            window.MAPISRENDERING ? getWaitingMessageInMapDataView() : mapData
        );
        if (callback) callback(); 
        $("#body #middle #mapDataContainer").fadeIn( 'slow', function () { 
            
        });
    }
}

function getWaitingMessageInMapDataView() {
    return "<table width='100%' height='100%'><tr><td height='100%' align='center' valign='middle' style='font-size:200%; color:#ccc;'>Wait,<br/>Loading Map...</td></tr></table>";
}
function showWaitingMessageInMapDataView() {
    $("#body #middle #mapDataContainer #mapData").fadeOut( 'slow', function() {
        $("#body #middle #mapDataContainer #mapData").html( getWaitingMessageInMapDataView() );
        $("#body #middle #mapDataContainer #mapData").fadeIn('slow');

    });
    
}


function updateInputControls() {
    
    if (window.MAPEXPLORER_RENDERER == "javascript") {
        $( "#configbody #showbevel").attr( "disabled", "disabled" );
        $( "#configbody #showbevel").parent().addClass('disabledinput');
    }else {

        $( "#configbody #showbevel").attr( "disabled", false );
        $( "#configbody #showbevel").parent().removeClass('disabledinput');
    }

    
    
}

function getRootMapTitleControls() {
    var html = '<input type="text" id="searchthismap" value="" />&nbsp;<div class="rootecall openedfolder" title="Expand/Collapse all"> </div>';
    return html;
}

function initMapList(){
    var txt = "";
    for(var i in mapList){
        
        
        var mapxpath = [i];
        
        txt +="<div class='rootmaplist accordianbody maplist mcontainer'>";
        //txt +="<div class='accordiantitle'><nobr>" + i + "</nobr></div>";
        txt +="<div class='accordiantitle'><nobr>" + getRootMapTitleControls() + "&nbsp;</nobr></div>";
        
        txt +="<div class='accordianitems'>";
        
        for(var j in mapList[i]){
            
            mapxpath.push(j);
            
            txt +="<div class='srootmaplist saccordianbody maplist mcontainer'>";
            txt +="<div class='saccordiantitle'><nobr>" + j + "</nobr></div>";
            txt +="<div class='saccordianitems'>";
            
            for (var k in mapList[i][j]) {
                
                 mapxpath.push(k);
                 
                txt +="<div class='mcontainer mgroupbody'>";
                txt +="<div class='mgrouptitle closedfolder'><nobr>" + k + "</nobr></div>";
                txt +="<div class='maplistitems'>";
                for (var l in mapList[i][j][k]) {
                    mapxpath.push(l);
                    var tmpArr = mapList[i][j][k][l];
                    tmpArr[ "xpath" ] =  mapxpath.join("/");
                    
                    if ( !window.mapListSearchIndex [l.toLowerCase()] ) {
                        window.mapListSearchIndex [l.toLowerCase()] = [];
                    }
                    window.mapListSearchIndex [l.toLowerCase()].push (tmpArr);
                    
                    window.mapListSearchKeys.push(l);
                    
                    mapxpath.pop();
                    txt +="<div class='maplistitem' rel='"+(window.mapListSearchIndex [l.toLowerCase()].length-1)+"'><nobr>" + l + "</nobr></div>";
                }
                mapxpath.pop();
                
                txt += "</div>";
                txt +="</div>";
            }
            mapxpath.pop();
             
            txt +="</div>";
            txt +="</div>";

        }
        mapxpath.pop();
         
        txt +="</div>";
        txt +="</div>";
        
        window.mapListSearchKeys.sort();
        
        
        var duplicateCount = 0;
        var oldName = "";
        for(var i=0; i<window.mapListSearchKeys.length; i++) {
            if (oldName.toLowerCase() == window.mapListSearchKeys[i].toLowerCase() ) {
                duplicateCount ++; 
            } else {
               duplicateCount = 0; 
               oldName = window.mapListSearchKeys[i];
            }

            var xpath = window.mapListSearchIndex[window.mapListSearchKeys[i].toLowerCase()][duplicateCount]["xpath"].replace(/^[^\/]+?\/|\/[^\/]+?$/g,"").replace (/\//g, " - ");
            window.mapListSearchHTML += '<div class="searchedItem" title="' + xpath + '" rel="' + duplicateCount + '"><a>' + window.mapListSearchKeys[i] + '</a></div>';
        }

    }
    
    $("#body #left #mapList").html(txt);
    
    // collapseAllExpandedMenuItems();
    
    $("#body #left #mapList .mgrouptitle").unbind('click').click( function() {
        var elm = $(this);
        if(elm.next().is(':hidden')) {
            elm.next().slideDown( 'fast', function () {
                elm.removeClass('closedfolder').addClass('openedfolder'); 
            });
            
        }else {
            elm.next().slideUp('fast', function() {
                elm.removeClass('openedfolder').addClass('closedfolder'); 
            });
        }
    });
    
    $("#body #left #mapList .saccordiantitle, #body #left #mapList .aaccordiantitle").unbind('click').click( function() {
        var elm = $(this);
        if(elm.next().is(':hidden')) {
            elm.next().slideDown( 'fast',function () { });
            
        }else {
            elm.next().slideUp( 'fast',function() { });
        }
    });
    
    
    $("#body #left #mapList .maplistitem").click(function()
    {
       var elm = $(this);
       showMapFromList (elm.text().trim(), parseInt( elm.attr('rel')), true );
    }
			
    );

    $("#body #left .rootecall").click( function () {
        var elm = $(this);
        if (elm.hasClass('closedfolder')) {
            
            expandAllCollapsedMenuItems();
            elm.removeClass('closedfolder').addClass('openedfolder');
        } else {
            collapseAllExpandedMenuItems();
            elm.removeClass('openedfolder').addClass('closedfolder');
        }
    });
    
	$("#body #left #searchthismap").focus( function (event) {
        showSearchResultBox();
    });

    $("#body #left #searchthismap").blur( function (event) {
       $("div#searchResultBox").slideUp( 'fast', function ()  { 
           $("#body #left #searchthismap").animate ( {width: "30%"} );
       });
       
    });
    
    $("#body #left #searchthismap").keyup ( function (event) {
        
        if (event.which == 13) {
           var mapName = $(this).val().trim().toLowerCase();
           var mapIndex = 0;
           if (window.mapListSearchIndex [mapName]) {
               $("#body #left #searchthismap").blur();
               showMapFromList(mapName, mapIndex);
           }
           
        }
        
        var value = $(this).val();
        window.setTimeout( function () {
            updateSearchResultBox( "div#searchResultBox", value );
        }, 0);
       
    });
   
    

}		

function showSearchResultBox() {
    
    $("#body #left #searchthismap").stop();
    $("#body #left #searchthismap").width ( $("#body #left #mapList .accordiantitle").width() - 40 );
    
    if (!$("div#searchResultBox").is(":visible")) {
       
       if ( $("div#searchResultBox").html() == "" ) {
           $("div#searchResultBox").html(window.mapListSearchHTML);
           fitSearchContainer(true); 
       } 
       $("div#searchResultBox").show();
       fitSearchContainer(); 
       
       $("div#searchResultBox div.searchedItem").unbind('click').click( function () {
           var mapName = $(this).text();
           var mapIndex = $(this).attr('rel')
           $("#body #left #searchthismap").val(mapName);
           $("#body #left #searchthismap").blur();
           showMapFromList(mapName, parseInt(mapIndex) );
       });
       
       
       
   }
}
		
function updateSearchResultBox(elm, searchedText) {
   var searchedContainer = $(elm);
   if (searchedText=="") {
        searchedContainer.find("div.searchedItem").show();
   }
   else {
       searchedContainer.find("div.searchedItem").each(function(){
           var searchedItem = $(this);
           if (searchedItem.text().search(new RegExp(searchedText, "i")) < 0) {
               searchedItem.hide();
           } else {
               searchedItem.show();
           }
       });
       
   }
   fitSearchContainer();
   
}

function fitSearchContainer (isFirst) {
   var lastSearchedItem, lastSearchedItemOffset, searchedContainerProposedHeight, searchedContainerHeightLimit, searchedContainerCaclHeight
   
   searchedContainerHeightLimit = $("#body #left #mapList").height() - 40 < 21 ? 21 : $("#body #left #mapList").height() - 40;
   searchedContainerCaclHeight = searchedContainerHeightLimit;
   
   if (!isFirst) {
       lastSearchedItem = $("#searchResultBox .searchedItem:visible").last();
       if (lastSearchedItem.length>0) {
            lastSearchedItemOffset = lastSearchedItem.position();
            searchedContainerProposedHeight = Math.round(lastSearchedItemOffset.top)+lastSearchedItem.height() + 2;
            searchedContainerCaclHeight = Math.min (searchedContainerProposedHeight, searchedContainerHeightLimit);
       }
   }
   
   $("div#searchResultBox").css( {
        "width": ($("#body #left #searchthismap").width() - 2) + "px",
        "height": searchedContainerCaclHeight+ "px"
   });
   
   
   
}

function init() {
    
    initVars();
    initDimensions();
    initClicks();
    initMapList();
    initConfig();
    selectMap();
    
}


function initConfig() {
    // $("#body #right #content #swap").click(); 
   
    if( window.NO_FLASH ) {
        $("#configbody .showFlashBtn, #configbody .showJSBtn").hide();
    }
    else {
        if(window.MAPEXPLORER_RENDERER=='flash') {
            $("#configbody .showJSBtn").show();
            $("#configbody .showFlashBtn").hide();

        }else {
            $("#configbody .showJSBtn").hide();
            $("#configbody .showFlashBtn").show();
        }
       
    }
   
    
}

function initVars() {
    getCommands();
    setDefaultRenderer();   
    
}

function selectMap() {
    var selectedMap = "World";
    var selectedMapIndex = 0;
    if(window.querystring['map'] && window.mapListSearchIndex[window.querystring['map'].toLowerCase()]) {
        selectedMap = window.querystring['map'].trim();
        if (window.querystring['index']) {
            selectedMapIndex = parseInt(window.querystring['index']);
            if ( !window.mapListSearchIndex[window.querystring['map'].trim().toLowerCase()][selectedMapIndex] ) {
                selectedMapIndex = 0;
            }
        }
    }else {
        selectedMap = $("#body #left #mapList .maplistitem:first").text().trim();
    }
    
    
    showMapFromList(selectedMap, selectedMapIndex);
}

function initDimensions() {
    // init dimensions
    window.MAPVIEW_FULL = true;
    swapfullscreen(false);
    
    $("#body #content").height( $("body").height()-$("#header").height() - 10 );
    $(window).resize(function() {
        $("#body #left #content").height( $("body").height()-$("#header").height()- 10 );
        $("#body #right #content").height( $("body").height()-$("#header").height()- 10 );
        
        if ($("div#searchResultBox").is(":visible")) {
            window.setTimeout( function () {
                $("#body #left #searchthismap").width ( $("#body #left #mapList .accordiantitle").width() - 40 );
                fitSearchContainer();
            }, 100)
        }
        
        
        
        if (!window.MAPVIEW_FULL) {
           $("#body #middle #content").height( $("body").height()-$("#header").height()- 10 );
           fitMapStage();
        }
        else {
           $("#body #middle #content").height( $("body").height() + 30 ); 
        }
    });    
    
}

function swapfullscreen(isAnimate) {
    window.MAPVIEW_FULL = !window.MAPVIEW_FULL;
    
    // go full-screen
    if (window.MAPVIEW_FULL) {
        if (isAnimate) {
             if ( $.browser.msie && parseInt($.browser.version, 10) < 8 ) {
                $('#body #middle').animate( {"left": "-10px" , "right": "0", "top": (-1*$("#header").height()-10) + "px", "bottom": "-10px"} ,'slow');
                $("#body #middle").find("#content").animate( {"height":  $("body").height() + 20+"px"}); 
                 
             } else {
                $('#body #middle').animate( {"left": "-10px" , "right": "-10px", "top": (-1*$("#header").height()-10) + "px", "bottom": "-10px"} ,'slow');
                $("#body #middle").find("#content").animate( {"height":  $("body").height() + 30+"px"}); 
             }
            
        } else {
             if ( $.browser.msie && parseInt($.browser.version, 10) < 8 ) {
                 $('#body #middle').css({"left": "-10px" , "right": "0", "top": (-1*$("#header").height()-10) + "px", "bottom": "-10px"});     
                 $("#body #middle").find("#content").height( $("body").height() + 20 ); 
             } else {
                 $('#body #middle').css({"left": "-10px" , "right": "-10px", "top": (-1*$("#header").height()-10) + "px", "bottom": "-10px"});     
                 $("#body #middle").find("#content").height( $("body").height() + 30 ); 
             }
        }
        $("#body #middle #content #container #fullscreenbtn a").removeClass('gofull').addClass('outfull'); 
        
        
    }else {
        // back from full-screen
        if (isAnimate) {
            $('#body #middle').animate( {"left": $('#body #left').width()+"px" , "right": $('#body #right').width()+"px", "top": "0", "bottom": "0"} ,'slow');
            $("#body #middle").find("#content").animate( {"height": $("body").height()-$("#header").height()- 10+"px"});
        }else {
            $('#body #middle').css({"left": $('#body #left').width()+"px" , "right": $('#body #right').width()+"px", "top": "0", "bottom": "0"});
            $("#body #middle").find("#content").height( $("body").height()-$("#header").height()- 10 );
            
        }
        $("#body #middle #content #container #fullscreenbtn a").removeClass('outfull').addClass('gofull'); 
    }

    
}

function fitMapStage(isAnimation) {

    if (isAnimation) {
        $('#body #middle').animate( {"left": $('#body #left').width()+"px" , "right": $('#body #right').width()+"px"} ,'slow');
    }else {
        $('#body #middle').css({"left": $('#body #left').width()+"px" , "right": $('#body #right').width()+"px"});
    }
    

}

function initClicks() {
    
    $("#body #right #configbody #printmapBtn").unbind('click').click( function () { 
        printMap();
    });
    
    $("#body #right #configbody #viewXMLBtn").unbind('click').click( function () { 
       viewXML();
    });
    $("#body #right #configbody #viewJSONBtn").unbind('click').click( function () { 
       viewJSON();
    });
    $("#body #right #configbody #viewCSVBtn").unbind('click').click( function () { 
       viewCSV();
    });
    $("#body #right #configbody #viewSSBtn").unbind('click').click( function () { 
       viewSS();
    });
    
    $("#body #middle #mapDataContainer #mapDataContainerContent div#titlebar #close").unbind('click').click( function () { 
       closeMapDataView();
    });
    
    
    $("#body #middle #content #container #fullscreenbtn a").unbind('click').unbind('click').click( function () { 
        swapfullscreen(false);
    });
    
    $("#configbody .showJSBtn").unbind('click').click( function () {
        swapRenderer('javascript');
        $(this).hide().next().show();
        
    });
    
    $("#configbody .showFlashBtn").unbind('click').click( function () {
        swapRenderer('flash');
        $(this).hide().prev().show();
        
    });
    
    $("#configbody input:checkbox").unbind('click').click( function () {
        
        var elm = $(this);
        
        window.setTimeout( function () { 
            window.map.setChartAttribute(elm.attr('id'), elm.is(":checked")*1);
            if (window.MAPDATAVIEW) {
                window["view"+window.MAPDATAVIEW]();
             }
            
        }, 0);
        
        
        
    });

    $("#configbody #basefont, #configbody #basefontsize").unbind('change').change( function () {
        
        var elm = $(this);
        window.setTimeout ( function (){
            window.map.setChartAttribute(elm.attr('id'),elm.val());
            if (window.MAPDATAVIEW) {
                window["view"+window.MAPDATAVIEW]();
             }
        }, 0);
        
        
        
    });

    $("#configbody a.themes").unbind('click').click( function () {
        
        var elm = $(this);
        window.setTimeout ( function (){
            var id = parseInt(elm.attr('id').replace(/themebtn/,"")) || 0;
            window.map.setXMLData("<map "+getThemedMapAttributes(id)+"/>");
             ///$("body").removeClass().addClass('theme'+id);
             if (window.MAPDATAVIEW) {
                window["view"+window.MAPDATAVIEW]();
             }
    
             
        },0);
        
    });
    
    
    
    
    $("#body #left #content #swap").click(
			
        function (){

            var collapsedSize = 50;
            
            if (!window.collapsedLeft) {

                $('#body #left').css({
                    width: collapsedSize+"px"
                });
                
                fitMapStage();
                
                $("#body #left #content #swap").removeClass('goin').addClass('goout');
                $("#body #left #content #container>div").hide();
                
                window.collapsedLeft = true;
            }
            else
            {
                window.collapsedLeft = false;
                $("#body #left #content #container>div").show();
                $("#body #left #content #swap").removeClass('goout').addClass('goin');
                
                var leftPercent = 25;
                $('#body #left').css({
                    width: leftPercent + "%"
                });
                
                fitMapStage();

            }
        }
        );
	
    // 
    $("#body #right").find("#swap").click(function(){
        
        var collapsedSize = 50;
        if(!window.collapsedRight){
						
            $('#body #right').css({
                width:collapsedSize+"px"
            });
            fitMapStage();            
            
            // #body #right #content #swap
            $("#body #right").find("#swap").removeClass('goin').addClass('goout');
            $("#body #right #content #container>div").hide();
            window.collapsedRight = true;
        }
        else
        {
            window.collapsedRight = false;
            $("#body #right #content #container>div").show();
            // #body #right #content #swap
            $("#body #right").find("#swap").removeClass('goout').addClass('goin');
            
            var bodyWidth = $('#body').width();
            var leftPercent = $('#body #left').width()/bodyWidth*100;
            var rightPercent = 20;

            if ( $.browser.msie && parseInt($.browser.version, 10) == 8 ) {
                $('#body #right').css({
                    width: "10%"
                });
            }else {
                $('#body #right').css({
                    width: rightPercent+"%"
                });
                
            }
            
            
            fitMapStage(); 
        }
    });
    
   
    
}
