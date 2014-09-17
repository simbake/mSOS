Imports Microsoft.VisualBasic
Imports System.web
Imports System.Text
Namespace InfoSoftGlobal
    ''' <summary>
    ''' Summary description for FusionMaps.
    ''' </summary>
    Public Class FusionMaps

        ''' <summary>
        ''' encodes the dataURL before it's served to FusionMaps
        ''' If you have parameters in your dataURL, you'll necessarily need to encode it
        ''' </summary>
        ''' <param name="dataURL">dataURL to be fed to Map</param>
        ''' <param name="noCacheStr">Whether to add aditional string to URL to disable caching of data</param>
        ''' <returns>Encoded dataURL, ready to be consumed by FusionMaps</returns>
        Public Shared Function EncodeDataURL(ByVal dataURL As String, ByVal noCacheStr As Boolean) As String
            Dim result As String = dataURL
            If noCacheStr = True Then

                result = result & IIf(dataURL.IndexOf("?") <> -1, "&", "?")
                'Replace : in time with _, as FusionMaps cannot handle : in URLs
                result = result & "FCCurrTime=" & DateTime.Now.ToString().Replace(":", "_")
            End If

            Return HttpUtility.UrlEncode(result)
        End Function

        ''' <summary>
        ''' Generate html code for rendering Map
        ''' This function assumes that you've already included the FusionMaps JavaScript class in your page
        ''' </summary>
        ''' <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        ''' <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        ''' <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        ''' <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        ''' <param name="MapWidth">Intended width for the Map (in pixels)</param>
        ''' <param name="MapHeight">Intended height for the Map (in pixels)</param>
        ''' <param name="debugMode">Whether to start the Map in debug mode</param>
        ''' <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        ''' ''' <param name="transparent">Whether transparent Map (true / false)</param>
        ''' <returns>JavaScript + HTML code required to embed a Map</returns>
        Private Shared Function RenderMapALL(ByVal MapSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal MapId As String, ByVal MapWidth As String, ByVal MapHeight As String, ByVal debugMode As Boolean, ByVal registerWithJS As Boolean, ByVal transparent As Boolean) As String


            Dim builder As New StringBuilder

            builder.Append("<!-- START Script Block for Map " & MapId & " -->" + Environment.NewLine)
            builder.Append("<div id='" & MapId & "Div' >" & Environment.NewLine)
            builder.Append("Map." & Environment.NewLine)
            builder.Append("</div>" & Environment.NewLine)
            builder.Append("<script type=""text/javascript"">" & Environment.NewLine)
            builder.AppendFormat("var Map_" & MapId & " = new FusionMaps(""" & MapSWF & """, """ & MapId & """, """ & MapWidth & """, """ & MapHeight & """, """ & boolToNum(debugMode) & """, """ & boolToNum(registerWithJS) & """);" & Environment.NewLine)

            If (strXML.Length = 0) Then

                builder.Append("Map_" & MapId & ".setDataURL(""" & strURL & """);" + Environment.NewLine)

            Else

                builder.Append("Map_" & MapId & ".setDataXML(""" & strXML & """);" & Environment.NewLine)
            End If

            If transparent = True Then

                builder.Append("Map_" & MapId & ".setTransparent(true);" + Environment.NewLine)
            End If

            builder.Append("Map_" & MapId & ".render(""" & MapId & "Div"");" & Environment.NewLine)
            builder.Append("</script>" + Environment.NewLine)
            builder.AppendFormat("<!-- END Script Block for Map " & MapId & " -->" & Environment.NewLine)
            Return builder.ToString()
        End Function

        ''' <summary>
        ''' Generate html code for rendering Map
        ''' This function assumes that you've already included the FusionMaps JavaScript class in your page
        ''' </summary>
        ''' <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        ''' <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        ''' <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        ''' <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        ''' <param name="MapWidth">Intended width for the Map (in pixels)</param>
        ''' <param name="MapHeight">Intended height for the Map (in pixels)</param>
        ''' <param name="debugMode">Whether to start the Map in debug mode</param>
        ''' <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        ''' <param name="transparent">Whether transparent Map (true / false)</param>
        ''' <returns>JavaScript + HTML code required to embed a Map</returns>
        Public Shared Function RenderMap(ByVal MapSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal MapId As String, ByVal MapWidth As String, ByVal MapHeight As String, ByVal debugMode As Boolean, ByVal registerWithJS As Boolean, ByVal transparent As Boolean) As String

            Return RenderMapALL(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, registerWithJS, transparent)
        End Function

        ''' <summary>
        ''' Generate html code for rendering Map
        ''' This function assumes that you've already included the FusionMaps JavaScript class in your page
        ''' </summary>
        ''' <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        ''' <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        ''' <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        ''' <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        ''' <param name="MapWidth">Intended width for the Map (in pixels)</param>
        ''' <param name="MapHeight">Intended height for the Map (in pixels)</param>
        ''' <param name="debugMode">Whether to start the Map in debug mode</param>
        ''' <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        ''' <returns>JavaScript + HTML code required to embed a Map</returns>
        Public Shared Function RenderMap(ByVal MapSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal MapId As String, ByVal MapWidth As String, ByVal MapHeight As String, ByVal debugMode As Boolean, ByVal registerWithJS As Boolean) As String

            Return RenderMap(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, registerWithJS, False)
        End Function

        ''' <summary>
        ''' Renders the HTML code for the Map. This
        ''' method does NOT embed the Map using JavaScript class. Instead, it uses
        ''' direct HTML embedding. So, if you see the Maps on IE 6 (or above), you'll
        ''' see the "Click to activate..." message on the Map.
        ''' </summary>
        ''' <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        ''' <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        ''' <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        ''' <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        ''' <param name="MapWidth">Intended width for the Map (in pixels)</param>
        ''' <param name="MapHeight">Intended height for the Map (in pixels)</param>
        ''' <param name="debugMode">Whether to start the Map in debug mode</param>
        ''' <returns></returns>

        Public Shared Function RenderMapHTML(ByVal MapSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal MapId As String, ByVal MapWidth As String, ByVal MapHeight As String, ByVal debugMode As Boolean) As String

            Return RenderMapHTMLALL(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, False, False)
        End Function

        ''' <summary>
        ''' Renders the HTML code for the Map. This
        ''' method does NOT embed the Map using JavaScript class. Instead, it uses
        ''' direct HTML embedding. So, if you see the Maps on IE 6 (or above), you'll
        ''' see the "Click to activate..." message on the Map.
        ''' </summary>
        ''' <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        ''' <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        ''' <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        ''' <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        ''' <param name="MapWidth">Intended width for the Map (in pixels)</param>
        ''' <param name="MapHeight">Intended height for the Map (in pixels)</param>
        ''' <param name="debugMode">Whether to start the Map in debug mode</param>
        ''' <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        ''' <returns></returns>

        Public Shared Function RenderMapHTML(ByVal MapSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal MapId As String, ByVal MapWidth As String, ByVal MapHeight As String, ByVal debugMode As Boolean, ByVal registerWithJS As Boolean) As String

            Return RenderMapHTMLALL(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, registerWithJS, False)
        End Function

        ''' <summary>
        ''' Renders the HTML code for the Map. This
        ''' method does NOT embed the Map using JavaScript class. Instead, it uses
        ''' direct HTML embedding. So, if you see the Maps on IE 6 (or above), you'll
        ''' see the "Click to activate..." message on the Map.
        ''' </summary>
        ''' <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        ''' <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        ''' <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        ''' <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        ''' <param name="MapWidth">Intended width for the Map (in pixels)</param>
        ''' <param name="MapHeight">Intended height for the Map (in pixels)</param>
        ''' <param name="debugMode">Whether to start the Map in debug mode</param>
        ''' <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        ''' <param name="transparent">Whether transparent Map (true / false)</param>
        ''' <returns></returns>
        Public Shared Function RenderMapHTML(ByVal MapSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal MapId As String, ByVal MapWidth As String, ByVal MapHeight As String, ByVal debugMode As Boolean, ByVal registerWithJS As Boolean, ByVal transparent As Boolean) As String

            Return RenderMapHTMLALL(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, registerWithJS, transparent)
        End Function

        Private Shared Function RenderMapHTMLALL(ByVal MapSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal MapId As String, ByVal MapWidth As String, ByVal MapHeight As String, ByVal debugMode As Boolean, ByVal registerWithJS As Boolean, ByVal transparent As Boolean) As String

            'Generate the FlashVars string based on whether dataURL has been provided
            'or dataXML.
            Dim strFlashVars As New StringBuilder()
            Dim flashVariables As String = String.Empty
            If strXML.Length = 0 Then

                'DataURL Mode
                flashVariables = String.Format("&MapWidth={0}&MapHeight={1}&debugMode={2}&registerWithJS={3}&DOMId={4}&dataURL={5}", MapWidth, MapHeight, boolToNum(debugMode), (registerWithJS), MapId, strURL)

            Else
                'DataXML Mode

                flashVariables = String.Format("&MapWidth={0}&MapHeight={1}&debugMode={2}&registerWithJS={3}&DOMId={4}&dataXML={5}", MapWidth, MapHeight, boolToNum(debugMode), boolToNum(registerWithJS), MapId, strXML)
            End If

            strFlashVars.Append("<!-- START Code Block for Map " & MapId & " -->" & Environment.NewLine)
            strFlashVars.Append("<object classid=""clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"" codebase=""http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"" width=""" & MapWidth & """ height=""" & MapHeight & """ name=""" & MapId & """ id==""" & MapId & """ >" & Environment.NewLine)

            strFlashVars.Append("<param name=""allowScriptAccess"" value=""always"" />" + Environment.NewLine)
            strFlashVars.Append("<param name=""movie"" value=""" & MapSWF & """/>" + Environment.NewLine)
            strFlashVars.Append("<param name=""FlashVars"" value=""" & flashVariables & """ />" & Environment.NewLine)
            strFlashVars.Append("<param name=""quality"" value=""high"" />" & Environment.NewLine)

            Dim strwmode As String = ""
            If (transparent = True) Then

                strFlashVars.Append("<param name=""wmode"" value=""transparent"" />" & Environment.NewLine)
                strwmode = "wmode=""transparent"""
            End If

            strFlashVars.AppendFormat("<embed src=""" & MapSWF & """ FlashVars=""" & flashVariables & """ quality=""high"" width=""" & MapWidth & """ height=""" & MapHeight & """ name=""" & MapId & """ id=""" & MapId & """ allowScriptAccess=""always"" type=""application/x-shockwave-flash"" pluginspage=""http://www.macromedia.com/go/getflashplayer"" " & strwmode & " />" + Environment.NewLine)
            strFlashVars.Append("</object>" + Environment.NewLine)
            strFlashVars.AppendFormat("<!-- END Code Block for Map {0} -->" + Environment.NewLine, MapId)
            Dim FlashXML As String = "<div id='" + MapId + "Div'>"
            FlashXML = FlashXML & strFlashVars.ToString() + "</div>"
            Return FlashXML

        End Function

        ''' <summary>
        ''' Transform the meaning of boolean value in integer value
        ''' </summary>
        ''' <param name="value">true/false value to be transformed</param>
        ''' <returns>1 if the value is true, 0 if the value is false</returns>
        Private Shared Function boolToNum(ByVal value As Boolean) As Integer

            Return IIf(value = True, 1, 0)
        End Function

    End Class


End Namespace
