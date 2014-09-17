Imports InfoSoftGlobal

Partial Class DrillStateDetails
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        ' Define dataURL 
        Dim dataURL As String
        ' URLEncode dataURL
        dataURL = Server.UrlEncode("DataGen.aspx?op=GetStateDetails&Internal_Id=" & Request("Internal_Id"))

        ' Create the Map with data contained in dataURL 
        ' and embed the chart rendered as HTML into Literal - StateDetailsMap
        ' We use FusionCharts class of InfoSoftGlobal namespace (FusionCharts.dll in BIN folder)
        ' renderChart() generates the necessary HTML needed to render the map
        Dim mapHTML As String = FusionCharts.RenderChart("../Maps/" + Request("map"), dataURL, "", "mapid", "600", "400", False, False)

        ' embed the chart rendered as HTML into Literal - StateDetailsMap
        StateDetailsMap.Text = mapHTML

    End Sub
End Class
