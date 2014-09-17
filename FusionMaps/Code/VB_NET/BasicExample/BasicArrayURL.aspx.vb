Imports InfoSoftGlobal

Partial Class BasicArrayExample_dataURL

    Inherits System.Web.UI.Page

    '''<summary>This Function will Help to Generate US Map.</summary>
    Protected Sub Page_Load(ByVal ob As Object, ByVal e As EventArgs) Handles Me.Load
        ' Define dataURL    
        Dim dataURL As String
        ' dataURL that will relay Map XML
        dataURL = "WorldPopulationData.aspx"

        'Create the Map with data contained in dataURL 
        'and Return HTML output that embeds the Map
        'We use FusionCharts class of InfoSoftGlobal namespace (FusionCharts.dll in BIN folder)
        'renderChart() generates the necessary HTML needed to render the map
        Dim mapHTML As String = FusionCharts.RenderChart("../Maps/FCMap_World8.swf", dataURL, "", "mapid", "600", "400", False, False)

        'embed the chart rendered as HTML into Literal - WorldPopulationMap
        WorldPopulationMap.Text = mapHTML


    End Sub
End Class
