Imports InfoSoftGlobal

Partial Class FusionMapsDBExample_DrillDown
    Inherits System.Web.UI.Page

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load

        ' Define dataURL variable 
        Dim dataURL As String
        ' URLencode dataURL
        dataURL = Server.UrlEncode("DataGen.aspx?op=GetUSMapDetails")

        ' Create the Map with data contained in dataURL 
        ' and embed the chart rendered as HTML into Literal - USMap
        ' We use FusionCharts class of InfoSoftGlobal namespace (FusionCharts.dll in BIN folder)
        ' renderChart() generates the necessary HTML needed to render the map
        Dim mapHTML As String = FusionCharts.RenderChart("../Maps/FCMap_USA.swf", dataURL, "", "mapid", "600", "400", False, False)

        ' embed the chart rendered as HTML into Literal - USMap
        USMap.Text = mapHTML
    End Sub
End Class
