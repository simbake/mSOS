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

public partial class FormBased_ExampleForm : System.Web.UI.Page
{
    // This is Form Based Example Program...

    // Event for transfer page control to FormSubmit.aspx
    public void dosubmit(Object sender, EventArgs e)
    {
        // Store Each ASP:TextBox value into Context items
        Context.Items["AS1"] = AS1.Text;
        Context.Items["EU"] = EU.Text;
        Context.Items["AF"] = AF.Text;
        Context.Items["NA"] = NA.Text;
        Context.Items["SA"] = SA.Text;
        Context.Items["CA"] = CA.Text;
        Context.Items["OC"] = OC.Text;
        Context.Items["ME1"] = ME1.Text;
        // Submit the form 
        Server.Transfer("FormSubmit.aspx");

    }
}
