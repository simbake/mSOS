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
// Using FusionCharts.dll 
using InfoSoftGlobal;

public partial class BasicArrayExample_dataURL : System.Web.UI.Page
{
 
    ///<summary>This Function will Help to Generate US Map.</summary>
    protected void Page_Load(object sender, EventArgs e)
    {
        // Define dataURL 
        string dataURL;
        // dataURL that will relay Map XML
        dataURL = "WorldPopulationData.aspx";
        
        // Create the Map with data contained in dataURL 
        // and Return HTML output that embeds the Map
        // We use FusionCharts class of InfoSoftGlobal namespace (FusionCharts.dll in BIN folder)
        // renderChart() generates the necessary HTML needed to render the map
        string mapHTML= FusionCharts.RenderChart("../Maps/FCMap_World8.swf", dataURL, "", "mapid", "600", "400", false, false);

        //embed the chart rendered as HTML into Literal - WorldPopulationMap
        WorldPopulationMap.Text = mapHTML;

    }
}
