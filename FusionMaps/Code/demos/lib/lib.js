d=document;
w=window;
m=Math;
l={};
    
l.gt=function(id){
    return d.getElementById(id);
};

l.op=function(ur,nm,pr){
    w.open(ur,nm,pr||'menubar=0,statusbar=0,width=640,height=480,scrollbars=yes');
    return false;
};
g={};
    
g.cn=function(ob,cn){
    l.gt(ob).className=cn;
};

g.sh=function(obs,obh){
    g.cn(obs,'visible');
    if(obh) g.cn(obh,'hidden');
};


var GALLERY_RENDERER = "flash";
var tmpChart = new FusionCharts("../Maps/FCMap_World.swf", "tmpMapId", "560", "400", "0");
var NO_FLASH = tmpChart.options.renderer=="javascript";
tmpChart.dispose();
tmpFlash = null;

if(NO_FLASH || /GALLERY_RENDERER=javascript/i.test(document.cookie) )
{
    GALLERY_RENDERER = 'javascript';
}

if (GALLERY_RENDERER && GALLERY_RENDERER.search(/javascript|flash/i)==0)  FusionCharts.setCurrentRenderer(GALLERY_RENDERER);  


if (typeof jQuery != 'undefined') { 
		
    jQuery(document).ready(function()
    {
		
		
        // automatic orphan location redirection
        if(navigator.userAgent.search(/MSIE/)>=0)
        {
            if(window.__orphanarticle!==false && top === self)	
            {
                window.__orphanarticle = true;
            }
        }
        else 
        {
            if (window.__orphanarticle!==false && window.parent && (window.parent === window || window.parent.location.domain !== window.location.domain)) 
            {
                window.__orphanarticle = true;
            }
        }
		
		
		
		
		
        jQuery("div.qua-button-holder").html
        (
            '<a id="toggleView" class="qua qua-button view-chart-data jschart" href="javascript:void(0)" style="width:185px;'+(GALLERY_RENDERER.toLowerCase() =='javascript'?'display:none;':'')+'"><span>View JavaScript Map</span></a>\n\
			<a id="toggleView" class="qua qua-button view-chart-data flashchart" href="javascript:void(0)" style="width:185px;'+(GALLERY_RENDERER.toLowerCase()  =='flash'?'display:none;':'')+'"><span>View Flash Map</span></a>\n\
			<a class="qua qua-button view-chart-data view-xml" href="javascript:void(0)" style="width:110px;"><span>View XML</span></a>\n\
			<a class="qua qua-button view-chart-data view-json" href="javascript:void(0)" style="width:120px;"><span>View JSON</span></a>'
            );

		
       jQuery("div.show-code-block").html(
	   		'<div class="show-code-block-head">\n\
				<div class="show-code-close-icon"></div>\n\
				<span id="titlebar">XML</span><div class="clear"></div>\n\
			</div>\n\
			<div class="show-code-block-body" align="left">\n\
				<pre class="prettyprint"></pre>\n\
			</div>\n\
			<div class="show-code-block-foot">\n\
				<div class="show-code-close-btn" align="right">\n\
					<a class="qua qua-button" href="javascript:void(0)"><span>Close</span></a>\n\
				</div>\n\
			 </div>'
		);

        if(typeof isJSChartNotAvailable!="undefined" && isJSChartNotAvailable==true)
        {
            jQuery("div.qua-button-holder .jschart").hide();
            jQuery("div.qua-button-holder .flashchart").hide();
			
        }


		$("a.view-xml").unbind("click").click( function() {
			
			$("#titlebar").html("Map XML Data");	
			var chartDATA = "";
			
			var chartCount = 0;
			for(var i in FusionCharts.items)
			{
				if(chartCount>0) 
				{
					chartDATA +="<hr style='height:10px; width:100%; border:none; border-bottom:1px dashed #ddd;'/><hr style='height:10px; width:100%; border:none; border:none;'/>";
				}
				chartCount++;				
				chartDATA += FusionCharts.items[i].getChartData('xml').replace(/\</gi, "&lt;").replace(/\>/gi, "&gt;");
			}

			showChartData(chartDATA);	
		});

		$("a.view-json").unbind("click").click( function() {
										 
			$("#titlebar").html("Map JSON Data");
			var chartDATA = "";

			var chartCount = 0;
			for(var i in FusionCharts.items)
			{
				
				if(chartCount>0) 
				{
					chartDATA +="<hr style='height:10px; width:100%; border:none; border-bottom:1px dashed #ddd;'/><hr style='height:10px; width:100%; border:none; border:none;'/>";
				}
				chartCount++;
				chartDATA += JSON.stringify(FusionCharts.items[i].getChartData('json'), null, 2);		

			}
		
			showChartData(chartDATA);	
		});

		
        jQuery("a.jschart").unbind("click").click ( function()
        {
            jQuery("a.jschart,a.flashchart").toggle();
            swapRenderer("javascript");
        }
        );
			
        jQuery("a.flashchart").unbind("click").click ( function()
        {
            jQuery("a.jschart,a.flashchart").toggle();
            swapRenderer("flash");
        }
        );

        jQuery('.show-code-close-btn a').unbind("click").click(function() {
            jQuery('.show-code-block').hide();
        });
	

        jQuery('.show-code-close-icon').unbind("click").click(function() {
            jQuery('.show-code-block').hide();
        });


        if(NO_FLASH)
        {
            jQuery("#toggleView").remove();
            jQuery(".qua-button-holder").css({
                "width":"350px"
            });
        }
		
    });

}

jQuery(document).ready(function(){
    if(NO_FLASH) jQuery("#toggleView").hide();
});

function swapRenderer (name) {
	
	var repoCharts = [] ;
	
	for(var i in FusionCharts.items)
	{

		var newChart = [];
		var chartCount = 0;
		
		if (!(FusionCharts.items[i] instanceof FusionCharts)) 
		{
			continue;
		}
		
		var fcProperties = {};
		fcProperties["swfUrl"]  = FusionCharts.items[i].args.swfUrl;
		fcProperties["id"]  =  FusionCharts(i).id.replace(/_flash$|_javascript$/i, "") + "_"+name ;
		
		if(name.toLowerCase()!="flash" || name.toLowerCase()!="javascript" )
		{
			name = FusionCharts.items[i].options.renderer=="flash"?"javascript":"flash";
		}
		
		FusionCharts.items[i].options.renderer;
		fcProperties["renderer"]  = name ;
		fcProperties["dataSource"] = FusionCharts.items[i].getXMLData();
		fcProperties["dataFormat"] = "xml";
		fcProperties["height"]  = FusionCharts.items[i].args.height ;
		fcProperties["width"]  = FusionCharts.items[i].args.width;
		fcProperties["renderAt"] = FusionCharts.items[i].options.containerElementId;
		
		repoCharts.push(fcProperties);
		
		if(FusionCharts.items[i] && FusionCharts.items[i].dispose) FusionCharts.items[i].dispose(); 
		
		
	}
	
	window.setTimeout(function() {
		for (var charrConfigId in repoCharts)
		{
			var newChart = [];
			newChart[charrConfigId] = FusionCharts.render(repoCharts[charrConfigId]);
		}
	} ,0 );
		

	

}; 



function showChartData(data)
{
    jQuery('pre.prettyprint').html( data );
	
	var contentAreaInnerMain =  jQuery("#mapdiv>*").position();

    jQuery('.show-code-block').css( { 
		top: (contentAreaInnerMain.top-1) +"px",
		left: (contentAreaInnerMain.left-1) +"px",
		 width: map.width +"px",
		 "height" : map.height +"px"
		 
	}).show();
	
    prettyPrint();
	
	
}

function showMessage(msgText)
{
    if(jQuery('#messageBox #content').length>0)
    {
        jQuery('#messageBox #content').append('<span>'+msgText+'</span>');
    }else
    {
        jQuery('#messageBox').html( '<div id="close">&nbsp;</div><div id="content"><span>' + msgText + '</span></div><div class="clear"></div>' );
        jQuery('#messageBox').fadeIn('slow');
        jQuery('#messageBox #close').click( function() {
            jQuery('#messageBox').remove();
        } );
    }
	
		
}

function showConditionalMessage(msgText, condition)
{
    if(condition) showMessage(msgText);
}
function addConditionalMessage(msgText, condition, isPrepend)
{
    if(condition) addMessage(msgText, isPrepend);
}


function addMessage(msgText, isPrepend)
{
    if(jQuery('#messageBox').is(':hidden'))
    {
        showMessage(msgText);
        return;
    }

    if(isPrepend) jQuery('#messageBox #content').prepend('<span>'+msgText+'</span>');
    else  jQuery('#messageBox #content').append('<span>'+msgText+'</span>');
}


function isLocal()
{
    return (location.protocol.search(/https?/)<0 ? "You seem to be running the sample from local file system. " : "");	
}

function isJSRenderer(chartObj)
{
    return chartObj.options.renderer=='javascript' ;
}


jQuery(document).ready ( function() { 

	jQuery(window).resize(function() {
		if( jQuery(".show-code-block").is(":visible") )  {

			var contentAreaInnerMain =  jQuery("#mapdiv>*").position();
		
			jQuery('.show-code-block').css( { 
				top: (contentAreaInnerMain.top-1) +"px",
				left: (contentAreaInnerMain.left-1) +"px",
				 width: jQuery("#MapId").width() +"px",
				 "height" : jQuery("#MapId").height() +"px"

			 
			});
			
		}
					
    });    


} );
