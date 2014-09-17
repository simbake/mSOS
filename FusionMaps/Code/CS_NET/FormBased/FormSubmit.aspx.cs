using System;
using System.Data;
using System.Configuration;
using System.Collections;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;
using System.Web.UI.HtmlControls;
using System.Text;
// Using FusionCharts.dll 
using InfoSoftGlobal;

public partial class FormBased_FormSubmit : System.Web.UI.Page
{
    /// <summary>
    /// This program takes Maps Request value and convert into an Array 
    /// Finally it converts  the data into FusionMaps dataXML to render map
    /// </summary>
    protected void Page_Load(object sender, EventArgs e)
    {
        // Define dataArray Two dimension string Array element. 1st column take 
        // map internal id and 2nd column take Value.
        string[,] dataArray = new string[8, 2];

        // Array data assigned from Context object Items
        // In this example, we're directly showing this data back on Map.
        // In your apps, you can do the required processing and then show the 
        // relevant data only.

        dataArray[0, 0] = "01"; dataArray[0, 1] = Context.Items["AS1"].ToString();
        dataArray[1, 0] = "02"; dataArray[1, 1] = Context.Items["EU"].ToString();
        dataArray[2, 0] = "03"; dataArray[2, 1] = Context.Items["AF"].ToString();
        dataArray[3, 0] = "04"; dataArray[3, 1] = Context.Items["NA"].ToString();
        dataArray[4, 0] = "05"; dataArray[4, 1] = Context.Items["SA"].ToString();
        dataArray[5, 0] = "06"; dataArray[5, 1] = Context.Items["CA"].ToString();
        dataArray[6, 0] = "07"; dataArray[6, 1] = Context.Items["OC"].ToString();
        dataArray[7, 0] = "08"; dataArray[7, 1] = Context.Items["ME1"].ToString();

        /*
        Now that we've the data in variables, we need to convert this into XML.
        The simplest method to convert data into XML is using string concatenation.	
        */
        StringBuilder strXML = new StringBuilder();

        //Initialize <map> element
        strXML.Append("<map borderColor='FFFFFF' connectorColor='000000' fillAlpha='70' hoverColor='FFFFFF' showBevel='0'>");

        //  
        strXML.Append("<colorRange>");
        strXML.Append("<color minValue='1' maxValue='350' displayValue='Population - 1 to 350' color='CC0001' />");
        strXML.Append("<color minValue='350' maxValue='500' displayValue='Population - 350 to 500' color='FFD33A' />");
        strXML.Append("<color minValue='500' maxValue='700' displayValue='Population - 500 to 700' color='069F06' />");
        strXML.Append("<color minValue='700' maxValue='1000' displayValue='Population - 700 or above' color='ABF456' />");
        strXML.Append("</colorRange><data>");


        // Fetch Data from array 
        for (int i = 0; i < dataArray.GetLength(0); i++)
        {
            // Set each map <entity> id and value
            strXML.AppendFormat("<entity id='{0}' value='{1}' />", dataArray[i, 0], dataArray[i, 1]);

        }

        // Close  <data> element
        strXML.Append("</data>");

        // Add Style on map
        strXML.Append("<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' />");
        strXML.Append("</definition><application><apply toObject='PLOT' styles='animX,animY' /></application></styles>");

        // Close <map> element
        strXML.Append("</map>");

        // Create Map embedding HTML with data contained in strXML 
        // We use FusionCharts class of InfoSoftGlobal namespace (FusionCharts.dll in BIN folder)
        // renderChart() generates the necessary HTML needed to render the map
        string mapHTML=FusionCharts.RenderChart("../Maps/FCMap_World8.swf", "", strXML.ToString(), "mapid", "600", "400", false, false);

        //embed the chart rendered as HTML into Literal -  FusionMapsContainer
        FusionMapsContainer.Text = mapHTML;
    
    }
    

  

    

}
