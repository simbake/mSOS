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
using InfoSoftGlobal;

public partial class FusionMapsDBExample_DrillDown : System.Web.UI.Page
{

    protected void Page_Load(object sender, EventArgs e)
    {

        // Define dataURL variable
        // URLencode dataURL
        string dataURL = Server.UrlEncode("DataGen.aspx?op=GetUSMapDetails");

        // Create the Map with data contained in dataURL 
        // and embed the chart rendered as HTML into Literal - USMap
        // We use FusionCharts class of InfoSoftGlobal namespace (FusionCharts.dll in BIN folder)
        // renderChart() generates the necessary HTML needed to render the map
        string mapHTML=FusionCharts.RenderChart("../Maps/FCMap_USA.swf", dataURL, "", "mapid", "600", "400", false, false);

        //embed the chart rendered as HTML into Literal - USMap
        USMap.Text = mapHTML;


    }

}
