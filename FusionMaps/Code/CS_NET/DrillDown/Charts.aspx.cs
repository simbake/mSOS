using System;
using System.Configuration;
using System.Collections;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;
using System.Web.UI.HtmlControls;
using System.Text;
using InfoSoftGlobal;
using DataConnection;

public partial class DrillDown_DetailedCharts : System.Web.UI.Page
{
    /// <summary>
    /// This function creates 3 charts reflecting the Employment Distribution
    /// </summary>
    public void GetCharts()
    {
        // strXML will be used to store the entire XML document generated
        string strXML, strQuery;
        // define i for counter
        int i;


        //We need to build three charts here. So, we use a loop to iterate through data
        //and build XML on the fly.	
        i = 1;
        // Create SQL Query String
        strQuery = "select group_id from fcmap_group_master";

        // Create dataReader object using DbHelper.GetReader function
        DbConn aReader = new DbConn(strQuery);

        // Check reader has record or not
        if (aReader.ReadData.HasRows == true)
        {
            // Read all Group data
            while (aReader.ReadData.Read())
            {
                // Get the dataURL for the chart
                StringBuilder strURL = new StringBuilder();
                strURL.AppendFormat("DataGen.aspx?op=getChartEmpStat&groupID={0}&entity_id={1}&Internal_Id={2}", aReader.ReadData["group_id"].ToString(), Request["entity_id"], Request["Internal_Id"]);

                Response.Write("<tr><td>");
                // Create the chart - 2 Pie 3D Chart and 1 Column 3Dwith data from strXML
                // If group id is 1,2 then show pie3d chart
                if (Convert.ToInt16(aReader.ReadData["group_id"]) != 3)
                {
                    // Create the Chart with data contained in strURL 
                    // and Return HTML output that embeds the chart
                    // We use FusionCharts class of InfoSoftGlobal namespace (FusionCharts.dll in BIN folder)
                    // RenderChart renders the necessary HTML needed to render the chart
                    Response.Write(FusionCharts.RenderChart("../Charts/Pie3D.swf", Server.UrlEncode(strURL.ToString()), "", "Chart_unemp" + i, "500", "350", false, false));
                }
                else
                {
                    //if group id is 3 then show column3d chart
                    // Create the Chart with data contained in strURL 
                    // and Return HTML output that embeds the chart
                    // We use FusionCharts class of InfoSoftGlobal namespace (FusionCharts.dll in BIN folder)
                    // RenderChart renders the necessary HTML needed to render the chart
                    Response.Write(FusionCharts.RenderChart("../Charts/Column3D.swf", Server.UrlEncode(strURL.ToString()), "", "Chart_emp" + i, "500", "350", false, false));
                }
                Response.Write("</td></tr>");
                // Increase counter i by 1 
                i += 1;
            }
        }
        // close reader
        aReader.ReadData.Close();
    }
}
