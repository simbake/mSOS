window.themeId = 0;
var themes = [];


themes[0] = {				
	
    bgalpha:"10,15",
    bgcolor:"375277,E9E9E9",
    canvasbgcolor:"375277,E9E9E9",
    fillColor:"CAD3DB",
    hoverColor:"E6EAEE",
    toolTipBgColor:"FFFFFF",
    toolTipBorderColor:"CAD3DB",
    baseFontColor :"000000",
    borderColor:"FFFFFF",
    canvasBorderColor: "375277",
    canvasBorderAlpha:"40"
};
themes[0] = {				
    canvasBorderColor: "375277",
    canvasBorderAlpha:"0"
};
				
//Blue
themes[1] = {				
    bgalpha:"70,70",
    bgcolor:"547A95,B1D0DF",
    canvasbgcolor:"547A95,B1D0DF",
    fillColor:"1C80C0",
    hoverColor:"88deef",
    toolTipBgColor:"FFFFFF",
    toolTipBorderColor:"1C80C0",
    baseFontColor :"000000",
    borderColor:"FFFFFF",
    canvasBorderColor: "547A95",
    canvasBorderAlpha:"90"
};
//GREEN
themes[2] = {				
    bgalpha:"70,70",
    bgcolor:"566f04,cbd3b2",
    canvasbgcolor:"566f04,cbd3b2",
    fillColor:"A9ba1a",
    hoverColor:"dbe67c",
    toolTipBorderColor:"A9ba1a",
    toolTipBgColor:"FFFFFF",
    baseFontColor :"000000",
    borderColor:"FFFFFF",
    canvasBorderColor: "566f04",
    canvasBorderAlpha:"90"
};
				
//RED
themes[3] = {				
    bgalpha:"70,70",
    bgcolor:"c87d2d,F7C77B",
    canvasbgcolor:"c87d2d,F7C77B",
    fillColor:"B70000,B76666",
    fillAngle: "90",
    hoverColor:"fc9073",
    toolTipBorderColor:"B70000",
    toolTipBgColor:"FFFFFF",
    baseFontColor :"000000",
    borderColor:"FFFFFF",
    canvasBorderColor: "c87d2d",
    canvasBorderAlpha:"90"
									 		
};

var defaultMapAttributes = 
{
    "animation": "0",
    "showshadow": "0",
    "showbevel": "0",
    "showlabels": "0",
    "showmarkerlabels": "1",
    "fillcolor": "F1f1f1",
    "bordercolor": "CCCCCC",
    "basefont": "Verdana",
    "basefontsize": "10",
    "markerbordercolor": "000000",
    "markerbgcolor": "FF5904",
    "markerradius": "6",
    "usehovercolor": "0",
    "hoveronempty": "0",
    "showmarkertooltip": "1"
					
};


function getThemedMapAttributes(themeId) {
   
   
   if ( window.querystring['theme'] ) {
       themeId = parseInt( window.querystring['theme'] );
       window.querystring['theme'] = null;
   }
   
    if (themeId===0) {
       
    }
    else {
        themeId = parseInt(themeId) || window.themeId;
        if(themeId>=themes.length || themeId<0) {
            themeId = 0;
        }
    }    
   
    window.themeId = themeId;
   
    var elms =  $("#configbody a.themes");
    elms.removeClass('higlightbutton');
    $(elms[themeId]).addClass('higlightbutton');
   
    
    
    
    var attr = {};
    for (var i in defaultMapAttributes) {
        attr[i] = defaultMapAttributes[i];
        
        if($("#configbody input:checkbox#"+i).length>0) {
            attr[i] = $("#configbody input:checkbox#"+i).is(":checked")*1;
        }
        
    }
    
    for (var i in themes[themeId]) {
        attr[i] = themes[themeId][i];
    }
    
    return attr;
}

