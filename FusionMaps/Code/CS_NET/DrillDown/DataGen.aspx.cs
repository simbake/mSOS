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
using DataConnection;


public partial class DrillDown_dataGen : System.Web.UI.Page
{
    ///<summary>
    /// This program calls different functions according to the value of op
    /// op is passed as Request
    /// The functions generate XML and relay to map/chart using dataURL method
    ///</summary>
    protected void Page_Load(object sender, EventArgs e)
    {
        string op;
        op = Request["op"];
        //Depending on op we call function
        switch (op)
        {
            case "GetUSMapDetails":
                GetUSMapDetails();  // Call GetUSMapDetails
                break;
            case "GetStateDetails":
                GetStateDetails();  //Call GetStateDetails
                break;
            case "getChartEmpStat":
                getChartEmpStat();  //Call getChartEmpStat
                break;
        }
    }

   /// <summary>
   /// This program creates XML for USA Map to show polulation % of each state
   /// </summary>
    public void GetUSMapDetails()
    {

        /*
        In this example, we show how to connect FusionMaps to a database.
	    You can connect to any database. Here, we've shown MSSQL/Access.
        */


	    //strXML will be used to store the entire XML document generated
        StringBuilder strXML = new StringBuilder();

        //Variable to store SQL Queries
        string strQuery;
        //Variable to store total Population
        double sumdata;

        //Generate the map element	
        //Create the opening <map> element and add the attributes that we need.
        strXML.Append("<map borderColor='FFFFFF' fillAlpha='80' showBevel='0' numberSuffix='% of total US population' legendBorderColor='F1f1f1' hoverColor='FFFFFF' legendPosition='bottom'>");

        //Define color ranges
        strXML.Append("<colorRange>");
        strXML.Append("<color minValue='0' maxValue='0.50' displayValue='0% to 0.50% of total' color='D64646' />");
        strXML.Append("<color minValue='0.50' maxValue='1' displayValue='0.50% to 1% of total' color='F6BD0F' />");
        strXML.Append("<color minValue='1' maxValue='3' displayValue='1% to 3% of total' color='8BBA00' />");
        strXML.Append("<color minValue='3' maxValue='10' displayValue='3% or above of total' color='AFD8F8' />");
        strXML.Append("</colorRange>");
        
        
        //store the sql query
        //create the datareader object to connect to table
        strQuery = "select sum(data) as datap from fcmap_distribution";
        DbConn Rs = new DbConn(strQuery);

        //Initialize sum container
        sumdata = 0;
        if (Rs.ReadData.HasRows == true)
        {   // read first record
            Rs.ReadData.Read();
            // Store sum 
            sumdata = Convert.ToDouble(Rs.ReadData["datap"]);
        }
        //close the reader 
        Rs.ReadData.Close();

        //Fetch all Internal id and data sum		
        strQuery = "select  Internal_Id, (sum(data) / " + sumdata + ")*100  as datap from fcmap_distribution group by Internal_Id";

        DbConn Rs1 = new DbConn(strQuery);


        // Add map data element
        strXML.Append("<data>");
        
        //Check if we've records to show
        if (Rs1.ReadData.HasRows == true)
        {

            //Iterate through the database
            while (Rs1.ReadData.Read())
            {
                // Create query string
                strQuery = "select map_swf from fcmap_master where Internal_Id='" + Rs1.ReadData["Internal_Id"].ToString() + "'";
                // Open fcmap_master table to get map swf names 
                DbConn Rs2 = new DbConn(strQuery);
                //  Read first record
                Rs2.ReadData.Read();

                // The link will in format StateDetails.aspx?Internal_Id=Int_Id&map=map_swf.swf - we'll need to URL Encode this link to convert & to %26 (or manually add it as %26 instead of &)
                string LinkURL = Server.UrlEncode("StateDetails.aspx?Internal_Id=" + Rs1.ReadData["Internal_Id"].ToString() + "&map=" + Rs2.ReadData["map_swf"].ToString());
                
                
                // Generate <entity id=".." value=".." /> and also add link to it 	
                strXML.AppendFormat("<entity id='{0}' value='{1}' link='{2}' />", Rs1.ReadData["Internal_Id"].ToString(), Math.Round(Convert.ToDouble(Rs1.ReadData["datap"]), 2), LinkURL);

                Rs2.ReadData.Close();
            }
        }

        // Close reader 
        Rs1.ReadData.Close();

        // Finally, close <map> element and add
        strXML.Append("</data>");

        // If needed, you can append additional XML tags here - like STYLE or MARKERS
        strXML.Append("<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' /><style type='animation' name='animAlpha' param='_alpha' start='0' duration='1' /><style type='shadow' name='myShadow' color='FFFFFF' distance='1' /></definition>");
        strXML.Append("<application><apply toObject='PLOT' styles='animX,animY' /><apply toObject='LABELS' styles='myShadow,animAlpha' /></application></styles>");
        
        
        // Close Map element
        strXML.Append("</map>");


        // Set Proper output content-type
        Response.ContentType = "text/xml";
        // Just write out the XML data
        // NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
        Response.Write(strXML.ToString());

    }
    

    /// <summary>
    /// Get State Details : Business, Software, Employee 
    /// </summary>
    public void GetStateDetails()
    {

        // Variables to store XML Data and sum of data
        // strXML will be used to store the entire XML document generated	
        StringBuilder strXML = new StringBuilder();
        double sumdata;

        //Variable to store SQL Query 
        string strQuery;

        // Generate the map element
        strXML.Append("<map borderColor='FFFFFF' fillAlpha='80' hoverColor='FFFFFF' showBevel='0' legendBorderColor='F1f1f1' legendPosition='bottom'>");

        //Define color ranges
        strXML.Append("<colorRange>");
        strXML.Append("<color minValue='0' maxValue='93' displayValue='0% to 93%' color='D64646' />");
        strXML.Append("<color minValue='93' maxValue='94' displayValue='93% to 94%' color='F6BD0F' />");
        strXML.Append("<color minValue='94' maxValue='95' displayValue='94% to 95%' color='8BBA00' />");
        strXML.Append("<color minValue='95' maxValue='100' displayValue='95% or above' color='AFD8F8' />");
        strXML.Append("</colorRange>");

        
        //Start the <data> element
        strXML.Append("<data>");

        // Fetch entity records
        strQuery = "select a.Internal_Id,a.entity_id,sum(data) as datap from fcmap_distribution a group by a.Internal_Id,a.entity_id having a.Internal_Id='" + Request["Internal_Id"] + "'";
        DbConn Rs = new DbConn(strQuery);
    
        // Set sumdata to Zero
        sumdata = 0;

        // If we've records to iterate, proceed    
        if (Rs.ReadData.HasRows == true)
        {
            // Read data reader till end
            while (Rs.ReadData.Read())
            {
                // We create custom tool text for each entity. 
                string tooltext = "";

                // Total counter
                double totEmp = 0;

                double StateValue, TotalStateValue, StatePer;
                StateValue = 0; TotalStateValue = 0; StatePer = 0;

                //Get details for the region
                strQuery = "select a.Internal_Id,a.entity_id,b.group_name,sum(data) as datap from fcmap_distribution a, fcmap_group_master b where b.group_id=a.group_id  group by a.Internal_Id ,a.entity_id, b.group_name having a.Internal_Id='" + Rs.ReadData["Internal_Id"].ToString() + "' and entity_id='" + Rs.ReadData["entity_id"].ToString() + "'";
                DbConn Rs1 = new DbConn(strQuery);
                
                
                //Read data till end
                while (Rs1.ReadData.Read())
                {
                    // Calculate value
                    StateValue = Convert.ToDouble(Rs1.ReadData["datap"]);
                    TotalStateValue = Convert.ToDouble(Rs.ReadData["datap"]);
                    // Get percentage of employment
                    StatePer = Math.Round((StateValue / TotalStateValue) * 100, 2);
                    // Add to tooltext
                    tooltext += Rs1.ReadData["group_name"].ToString() + ":" + StatePer + "% \n";

                    // If it's not unemployed group
                    if (Rs1.ReadData["group_name"].ToString() != "Unemployed")
                    {   //calculate total employed
                        totEmp += StatePer;
                    }

                }
                //close data reader
                Rs1.ReadData.Close();

                // Generate <entity id=".." value=".." />        
                // Also append link to Charts.aspx passing all required information (from querystring) and the database
                // We also add our custom tooltext
                string LinkURL = Server.UrlEncode("Charts.aspx?" + Request.ServerVariables["QUERY_STRING"] + "&entity_id=" + Rs.ReadData["entity_id"].ToString());
                strXML.AppendFormat("<entity id='{0}' value='{1}' link='{2}' tooltext='{3}' />", Rs.ReadData["entity_id"].ToString(), totEmp, LinkURL, tooltext);

            }
        }
        //close data reader
        Rs.ReadData.Close();

        // Finally, close <data> element
        strXML.Append("</data>");

        //Add style 
        strXML.Append("<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' /><style type='animation' name='animAlpha' param='_alpha' start='0' duration='1' /><style type='shadow' name='myShadow' color='FFFFFF' distance='1' /></definition>");
        strXML.Append("<application><apply toObject='PLOT' styles='animX,animY' /><apply toObject='LABELS' styles='myShadow,animAlpha' /></application></styles>");
        // Close map element
        strXML.Append("</map>");

        
        // Set Proper output content-type
        Response.ContentType = "text/xml";
        // Just write out the XML data
        // NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
        Response.Write(strXML.ToString());

    }


    /// <summary>
    /// This function returns the XML data for the chart for a given subgroup.
    /// </summary>
    public void getChartEmpStat()
    {

        // Variable to store XML data
        StringBuilder strXML = new StringBuilder();
        // Variable to store SQL Query
        string strQuery;

        // Create SQL query string
        strQuery = "select group_id,group_name from fcmap_group_master where group_id=" + Request["groupID"];

        // Create data Reader object
        DbConn Rs = new DbConn(strQuery);

        // Open dataReader 

        if (Rs.ReadData.HasRows == true)
        {
            // Read first record  
            Rs.ReadData.Read();
            // Customize XML Based on which group we've passed as Request 
            if (Convert.ToInt16(Rs.ReadData["group_id"]) != 3)
            {
                strXML.AppendFormat("<chart caption='Employment By {0} Distribution Report'  showBorder='1' formatNumberScale='0' numberSuffix='' showPercentValues ='1' showPercentInToolTip='1' >", Rs.ReadData["group_name"].ToString());
            }
            else
            {
                strXML.AppendFormat("<chart caption='{0} Age Groups report' showBorder='1'  formatNumberScale='0' numberSuffix='' xAxisName='Age Groups' yAxisName='Unemployed' >", Rs.ReadData["group_name"].ToString());
            }

            // Create Query String
            strQuery = "select a.Internal_Id,a.entity_id,b.group_name,c.subgroup_name,sum(a.data) as datap from fcmap_distribution a, fcmap_group_master b, fcmap_subgroup_master c where a.group_id=b.group_id and a.subgroup_id=c.subgroup_id group by a.Internal_Id,a.entity_id,b.group_name,c.subgroup_name having a.Internal_Id='" + Request["Internal_Id"] + "' and a.entity_id='" + Request["entity_id"] + "' and b.group_name='" + Rs.ReadData["group_name"].ToString() + "'";
            // Create  data Reader object
            DbConn Rs1 = new DbConn(strQuery);

            // Iterate through each group-wise record
            if (Rs1.ReadData.HasRows == true)
            {
                // Fetch all records
                while (Rs1.ReadData.Read())
                {
                    // Generate <set label='..' value='..' />        
                    strXML.AppendFormat("<set label='{0}' value='{1}' />", Rs1.ReadData["subgroup_name"].ToString(), Rs1.ReadData["datap"].ToString());

                }
            }
            Rs1.ReadData.Close();
        }
        Rs.ReadData.Close();

        // If needed, you can append additional XML tags here - like STYLE or MARKERS
        strXML.Append("<styles><definition><style name='captionFont' type='Font' size='14' /></definition><application><apply toObject='caption' styles='captionFont'/></application></styles>");

        // Finally, close <chart> element
        strXML.Append("</chart>");



        // Set Proper output content-type
        Response.ContentType = "text/xml";
        // Just write out the XML data
        // NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
        Response.Write(strXML.ToString());


    }

}