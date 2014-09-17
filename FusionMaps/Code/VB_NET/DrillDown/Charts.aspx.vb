Imports InfoSoftGlobal
Imports DataConnection


Partial Class DrillDown_DetailedCharts
    Inherits System.Web.UI.Page

    ''' <summary>
    ''' This function creates 3 charts reflecting the Employment Distribution
    ''' </summary>
    Public Sub GetCharts()
        '  strXML will be used to store the entire XML document generated
        Dim strQuery As String
        ' define i for counter
        Dim i As Integer

        ' We need to build three charts here. So, we use a loop to iterate through data
        ' and build XML on the fly.	
        i = 1
        '  Create SQL Query String
        strQuery = "select group_id from fcmap_group_master"

        ' Create dataReader object using DbHelper.GetReader function
        Dim aReader As New DbConn(strQuery)

        ' Check reader has record or not
        If aReader.ReadData.HasRows = True Then
            ' Read all Group data
            While aReader.ReadData.Read()
                ' Get the dataURL for the chart
                Dim strURL As String
                strURL = Server.UrlEncode("DataGen.aspx?op=getChartEmpStat&groupID=" & aReader.ReadData("group_id").ToString() & "&entity_id=" & Request("entity_id") & "&Internal_Id=" & Request("Internal_Id"))

                Response.Write("<tr><td>")
                ' Create the chart - 2 Pie 3D Chart and 1 Column 3Dwith data from strXML
                If Convert.ToInt16(aReader.ReadData("group_id")) <> 3 Then
                    'If group id is 1,2 then show pie3d chart
                    'Create the Chart with data contained in strURL 
                    'and Return HTML output that embeds the chart
                    Response.Write(FusionCharts.RenderChart("../Charts/Pie3D.swf", strURL, "", "Chart_unemp" & i, "500", "350", False, False))
                Else
                    ' if group id is 3 then show column3d chart
                    Response.Write(FusionCharts.RenderChart("../Charts/Column3D.swf", strURL, "", "Chart_emp" & i, "500", "350", False, False))
                End If
                Response.Write("</td></tr>")
                ' Increase counter i by 1 
                i = i + 1
            End While
            ' close reader
            aReader.ReadData.Close()
        End If


    End Sub
End Class
