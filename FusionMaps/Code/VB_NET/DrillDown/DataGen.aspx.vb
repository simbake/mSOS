Imports System.Text
Imports DataConnection

Partial Class DrillDown_dataGen
    Inherits System.Web.UI.Page

    '''<summary>
    ''' This program calls different functions according to the value of op
    ''' op is passed as Request
    ''' The functions generate XML and relay to map/chart using dataURL method
    '''</summary>
    Protected Sub Page_Load(ByVal ob As Object, ByVal e As EventArgs) Handles Me.Load
        Dim op As String
        op = Request("op")
        ' Depending on op we call function
        Select Case op
            Case "GetUSMapDetails"
                GetUSMapDetails()   'Call GetUSMapDetails

            Case "GetStateDetails"
                GetStateDetails()   'Call GetStateDetails

            Case "getChartEmpStat"
                getChartEmpStat()   'Call getChartEmpStat

        End Select
    End Sub

    ''' <summary>
    ''' This program creates XML for USA Map to show polulation % of each state
    ''' </summary>
    Public Sub GetUSMapDetails()

        'In this example, we show how to connect FusionMaps to a database.
        'You can connect to any database. Here, we've shown MSSQL/Access.

        'strXML will be used to store the entire XML document generated
        Dim strXML As New StringBuilder

        'Variable to store SQL Queries
        Dim strQuery As String

        'Variable to store total Population
        Dim sumdata As Double

        'Generate the map element	
        'Create the opening <map> element and add the attributes that we need.
        strXML.Append("<map borderColor='FFFFFF' fillAlpha='80' showBevel='0' numberSuffix='% of total US population' legendBorderColor='F1f1f1' hoverColor='FFFFFF' legendPosition='bottom'>")
        'Define color ranges
        strXML.Append("<colorRange>")
        strXML.Append("<color minValue='0' maxValue='0.50' displayValue='0% to 0.50% of total' color='D64646' />")
        strXML.Append("<color minValue='0.50' maxValue='1' displayValue='0.50% to 1% of total' color='F6BD0F' />")
        strXML.Append("<color minValue='1' maxValue='3' displayValue='1% to 3% of total' color='8BBA00' />")
        strXML.Append("<color minValue='3' maxValue='10' displayValue='3% or above of total' color='AFD8F8' />")
        strXML.Append("</colorRange>")

        ' store the sql query
        strQuery = "select sum(data) as datap from fcmap_distribution"
        ' Create datareader object
        Dim Rs As New DbConn(strQuery)

        ' Initialize sum container
        sumdata = 0
        ' Check if we've records to show
        If Rs.ReadData.HasRows = True Then
            ' Read first record
            Rs.ReadData.Read()
            ' Store sum 
            sumdata = Convert.ToDouble(Rs.ReadData("datap"))
        End If
        ' Close the reader 
        Rs.ReadData.Close()


        ' Fetch all Internal id and data sum		
        strQuery = "select  Internal_Id, (sum(data) / " & sumdata & ")*100  as datap from fcmap_distribution group by Internal_Id"

        Dim Rs1 As New DbConn(strQuery)


        ' Add map data element
        strXML.Append("<data>")

        ' Check if we've records to show
        If Rs1.ReadData.HasRows = True Then

            ' Iterate through the database
            While Rs1.ReadData.Read()
                ' Create query string 
                strQuery = "select map_swf from fcmap_master where Internal_Id='" + Rs1.ReadData("Internal_Id").ToString() + "'"
                'Open fcmap_master table to get map swf names
                Dim Rs2 As New DbConn(strQuery)
                ' Read first record
                Rs2.ReadData.Read()

                ' The link will in format StateDetails.aspx?Internal_Id=Int_Id&map=map_swf.swf - we'll need to URL Encode this link to convert & to %26 (or manually add it as %26 instead of &)
                Dim LinkURL As String
                LinkURL = Server.UrlEncode("StateDetails.aspx?Internal_Id=" & Rs1.ReadData("Internal_Id").ToString() & "&map=" & Rs2.ReadData("map_swf").ToString())

                ' Generate <entity id=".." value=".." /> and also add link to it 	
                strXML.Append("<entity id='" & Rs1.ReadData("Internal_Id") & "' value='" & Math.Round(Convert.ToDouble(Rs1.ReadData("datap")), 2) & "'  link='" & LinkURL & "'  />")
                Rs2.ReadData.Close()
            End While
        End If
        ' Close reader 
        Rs1.ReadData.Close()

        ' Finally, close <map> element and add
        strXML.Append("</data>")

        ' If needed, you can append additional XML tags here - like STYLE or MARKERS
        strXML.Append("<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' /><style type='animation' name='animAlpha' param='_alpha' start='0' duration='1' /><style type='shadow' name='myShadow' color='FFFFFF' distance='1' /></definition>")
        strXML.Append("<application><apply toObject='PLOT' styles='animX,animY' /><apply toObject='LABELS' styles='myShadow,animAlpha' /></application></styles>")


        ' Close Map element
        strXML.Append("</map>")

        ' Set Proper output content-type
        Response.ContentType = "text/xml"

        ' Just write out the XML data
        ' NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
        Response.Write(strXML.ToString())


    End Sub

    ''' <summary>
    ''' Get State Details : Business, Software, Employee 
    ''' </summary>
    Public Sub GetStateDetails()

        ' Variables to store XML Data and sum of data
        ' strXML will be used to store the entire XML document generated	
        Dim strXML As New StringBuilder
        Dim sumdata As Double

        ' Variable to store SQL Query 
        Dim strQuery As String

        ' Generate the chart element
        strXML.Append("<map  borderColor='FFFFFF' fillAlpha='80' hoverColor='FFFFFF' showBevel='0' legendBorderColor='F1f1f1' legendPosition='bottom'>")

        'Define color ranges
        strXML.Append("<colorRange>")
        strXML.Append("<color minValue='0' maxValue='93' displayValue='0% to 93%' color='D64646' />")
        strXML.Append("<color minValue='93' maxValue='94' displayValue='93% to 94%' color='F6BD0F' />")
        strXML.Append("<color minValue='94' maxValue='95' displayValue='94% to 95%' color='8BBA00' />")
        strXML.Append("<color minValue='95' maxValue='100' displayValue='95% or above' color='AFD8F8' />")
        strXML.Append("</colorRange>")

        ' Start the <data> element
        strXML.Append("<data>")

        ' Fetch entity records
        strQuery = "select a.Internal_Id,a.entity_id,sum(data) as datap from fcmap_distribution a group by a.Internal_Id,a.entity_id having a.Internal_Id='" & Request("Internal_Id") & "'"
        Dim Rs As New DbConn(strQuery)

        ' Set sumdata to Zero
        sumdata = 0

        ' If we've records to iterate, proceed    
        If Rs.ReadData.HasRows = True Then
            ' Read data reader till end
            While Rs.ReadData.Read()

                ' We create custom tool text for each entity. 
                Dim tooltext As String
                tooltext = ""

                ' Total counter
                Dim totEmp As Double
                totEmp = 0

                Dim StateValue As Double, TotalStateValue As Double, StatePer As Double
                StateValue = 0 : TotalStateValue = 0 : StatePer = 0

                ' Get details for the region
                strQuery = "select a.Internal_Id,a.entity_id,b.group_name,sum(data) as datap from fcmap_distribution a, fcmap_group_master b where b.group_id=a.group_id  group by a.Internal_Id ,a.entity_id, b.group_name having a.Internal_Id='" & Rs.ReadData("Internal_Id").ToString() + "' and entity_id='" & Rs.ReadData("entity_id").ToString() & "'"
                Dim Rs1 As New DbConn(strQuery)

                ' Read data till end
                While Rs1.ReadData.Read()

                    ' Caluculate value
                    StateValue = Convert.ToDouble(Rs1.ReadData("datap"))
                    TotalStateValue = Convert.ToDouble(Rs.ReadData("datap"))
                    ' Get percentage of employment
                    StatePer = Math.Round((StateValue / TotalStateValue) * 100, 2)
                    ' Add to tooltext
                    tooltext = tooltext & Convert.ToString(Rs1.ReadData("group_name")) & ":" & StatePer & "% " & Chr(13)
                    ' If it's not unemployed group
                    If Rs1.ReadData("group_name").ToString() <> "Unemployed" Then
                        ' calculate total employed
                        totEmp = totEmp + StatePer
                    End If

                End While
                'close data reader
                Rs1.ReadData.Close()

                ' Generate <entity id=".." value=".." />        
                ' Also append link to Charts.aspx passing all required information (from querystring) and the database
                ' We also add our custom tooltext
                Dim LinkURL As String
                LinkURL = Server.UrlEncode("Charts.aspx?" & Request.ServerVariables("QUERY_STRING") + "&entity_id=" + Rs.ReadData("entity_id"))
                strXML.Append("<entity id='" & Rs.ReadData("entity_id") & "' value='" & totEmp & "' link='" & LinkURL & "'  tooltext='" & tooltext & "' />")

            End While

        End If
        Rs.ReadData.Close()
        ' Finally, close <data> element
        strXML.Append("</data>")

        'Add style 
        strXML.Append("<styles><definition><style type='animation' name='animX' param='_xscale' start='0' duration='1' /><style type='animation' name='animY' param='_yscale' start='0' duration='1' /><style type='animation' name='animAlpha' param='_alpha' start='0' duration='1' /><style type='shadow' name='myShadow' color='FFFFFF' distance='1' /></definition>")
        strXML.Append("<application><apply toObject='PLOT' styles='animX,animY' /><apply toObject='LABELS' styles='myShadow,animAlpha' /></application></styles>")


        ' Close map element
        strXML.Append("</map>")



        ' Set Proper output content-type
        Response.ContentType = "text/xml"
        ' Just write out the XML data
        ' NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
        Response.Write(strXML.ToString())


    End Sub

    ''' <summary>
    ''' This function returns the XML data for the chart for a given subgroup.
    ''' </summary>
    Public Sub getChartEmpStat()

        ' Variable to store XML data
        Dim strXML As New StringBuilder

        ' Variable to store SQL Query
        Dim strQuery As String

        ' Create SQL query string
        strQuery = "select group_id,group_name from fcmap_group_master where group_id=" & Request("groupID")

        ' Open dataReader 
        Dim Rs As New DbConn(strQuery)

        If Rs.ReadData.HasRows = True Then
            ' Read first record    
            Rs.ReadData.Read()
            ' Customize XML Based on which group we've passed as Request 
            If Convert.ToInt16(Rs.ReadData("group_id")) <> 3 Then
                strXML.Append("<chart caption='Employment By " & Rs.ReadData("group_name").ToString() & " Distribution Report'  showBorder='1' formatNumberScale='0' numberSuffix='' showPercentValues ='1' showPercentInToolTip='1' >")
            Else
                strXML.Append("<chart caption='" & Rs.ReadData("group_name").ToString() & " Age Groups report' showBorder='1'  formatNumberScale='0' numberSuffix='' xAxisName='Age Groups' yAxisName='Unemployed' >")
            End If

            ' Create Query String
            strQuery = "select a.Internal_Id,a.entity_id,b.group_name,c.subgroup_name,sum(a.data) as datap from fcmap_distribution a, fcmap_group_master b, fcmap_subgroup_master c where a.group_id=b.group_id and a.subgroup_id=c.subgroup_id group by a.Internal_Id,a.entity_id,b.group_name,c.subgroup_name having a.Internal_Id='" & Request("Internal_Id") & "' and a.entity_id='" & Request("entity_id") & "' and b.group_name='" & Rs.ReadData("group_name").ToString() & "'"
            ' Create  data Reader object
            Dim Rs1 As New DbConn(strQuery)

            ' Iterate through each group-wise record
            If Rs1.ReadData.HasRows = True Then
                ' Fetch all records
                While Rs1.ReadData.Read()
                    ' Generate <set label='..' value='..' />        
                    strXML.Append("<set label='" & Rs1.ReadData("subgroup_name").ToString() & "' value='" & Rs1.ReadData("datap").ToString() & "' />")

                End While

            End If
            Rs1.ReadData.Close()
        End If
        Rs.ReadData.Close()
        ' If needed, you can append additional XML tags here - like STYLE or MARKERS
        strXML.Append("<styles><definition><style name='captionFont' type='Font' size='14' /></definition><application><apply toObject='caption' styles='captionFont'/></application></styles>")
        ' Finally, close <chart> element
        strXML.Append("</chart>")


        ' Set Proper output content-type
        Response.ContentType = "text/xml"
        ' Just write out the XML data
        ' NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
        Response.Write(strXML.ToString())

    End Sub

End Class
