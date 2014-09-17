<%@ Page Language="VB" AutoEventWireup="false" CodeFile="Default.aspx.vb" Inherits="FormBased_ExampleForm" %>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>FusionMaps - Form Based Example </title>
    <style type="text/css">
	    <!--
	        body{font-family:Verdana;font-size:8pt;}
            .text{font-family:Verdana;font-size:8pt;}
	    -->
	</style>
</head>
<body>
    <%
        'In this example, we first present a form to the user, to input data.
        'For a demo, we present a very simple form intended to indicate
        'sales of a product in various countries. 
        'The form is rendered in this page (Default.aspx). It submits its data to
        'FormSubmit.aspx. We retrieve this data, convert into XML and then
        'render the Map.

        'So, basically this page is just a form. 
    %>
    <form id="form1" runat="server">
        <center>
            <h2>
                <a href="http://www.fusioncharts.com" target="_blank">FusionMaps</a> Form-Based
                Data Example</h2>
            <p class='text'>
                Please enter Value for each Country. We'll plot this data on a FusionMaps World.</p>
            <p class='text'>
                To keep things simple, we're not validating for non-numeric data here. So, please
                enter valid numeric values only. In your real-world applications, you can put your
                own validators.</p>
            <table align="center" border="0" cellpadding="2" cellspacing="1" class="text" width="50%">
                <tr>
                    <td align="right" width="50%">
                        <b>Asia:</b>&nbsp;
                    </td>
                    <td width="50%">
                        <asp:TextBox ID="AS1" runat="server" BackColor="#FFFFDD" Text="800" Width="60px"></asp:TextBox></td>
                </tr>
                <tr>
                    <td align="right" width="50%">
                        <b>Europe:</b>&nbsp;
                    </td>
                    <td width="50%">
                        <asp:TextBox ID="EU" runat="server" BackColor="#FFFFDD" Text="300" Width="60px"></asp:TextBox></td>
                </tr>
                <tr>
                    <td align="right" width="50%">
                        <b>Africa:</b>&nbsp;
                    </td>
                    <td width="50%">
                        <asp:TextBox ID="AF" runat="server" BackColor="#FFFFDD" Text="360" Width="60px"></asp:TextBox></td>
                </tr>
                <tr>
                    <td align="right" width="50%">
                        <b>North America:</b>&nbsp;
                    </td>
                    <td width="50%">
                        <asp:TextBox ID="NA" runat="server" BackColor="#FFFFDD" Text="400" Width="60px"></asp:TextBox></td>
                </tr>
                <tr>
                    <td align="right" width="50%">
                        <b>South America:</b>&nbsp;
                    </td>
                    <td width="50%">
                        <asp:TextBox ID="SA" runat="server" BackColor="#FFFFDD" Text="500" Width="60px"></asp:TextBox></td>
                </tr>
                <tr>
                    <td align="right" style="height: 28px">
                        <b>Central America:</b>&nbsp;
                    </td>
                    <td style="height: 28px">
                        <asp:TextBox ID="CA" runat="server" BackColor="#FFFFDD" Text="200" Width="60px"></asp:TextBox></td>
                </tr>
                <tr>
                    <td align="right">
                        <b>Oceania:</b>&nbsp;
                    </td>
                    <td>
                        <asp:TextBox ID="OC" runat="server" BackColor="#FFFFDD" Text="99" Width="60px"></asp:TextBox></td>
                </tr>
                <tr>
                    <td align="right" width="50%">
                        <b>Middle East:</b>
                    </td>
                    <td width="50%">
                        <asp:TextBox ID="ME1" runat="server" BackColor="#FFFFDD" Text="100" Width="60px"></asp:TextBox></td>
                </tr>
                <tr>
                    <td align="right">&nbsp;
                        </td>
                    <td>
                        <asp:Button ID="Chartit" runat="server" OnClick="dosubmit" Text="Map it!" /></td>
                </tr>
            </table>
            <br />
            <br />
            <a href='../Default.aspx'>&laquo; Back to list of examples</a>
        </center>
    </form>
</body>
</html>
