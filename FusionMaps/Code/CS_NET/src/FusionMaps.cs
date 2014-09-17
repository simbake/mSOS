using System;
using System.Text;
using System.Collections;
using System.Web.UI.WebControls;

namespace InfoSoftGlobal
{
    /// <summary>
    /// Summary description for FusionMaps.
    /// </summary>
    public class FusionMaps
    {
        /// <summary>
        /// encodes the dataURL before it's served to FusionMaps
        /// If you have parameters in your dataURL, you'll necessarily need to encode it
        /// </summary>
        /// <param name="dataURL">dataURL to be fed to Map</param>
        /// <param name="noCacheStr">Whether to add aditional string to URL to disable caching of data</param>
        /// <returns>Encoded dataURL, ready to be consumed by FusionMaps</returns>
        public static string EncodeDataURL(string dataURL, bool noCacheStr)
        {
            string result = dataURL;
            if (noCacheStr)
            {
                result += (dataURL.IndexOf("?") != -1) ? "&" : "?";
                //Replace : in time with _, as FusionMaps cannot handle : in URLs
                result += "FCCurrTime=" + DateTime.Now.ToString().Replace(":", "_");
            }

            return System.Web.HttpUtility.UrlEncode(result);
        }

        /// <summary>
        /// Generate html code for rendering Map
        /// This function assumes that you've already included the FusionMaps JavaScript class in your page
        /// </summary>
        /// <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        /// <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        /// <param name="MapWidth">Intended width for the Map (in pixels)</param>
        /// <param name="MapHeight">Intended height for the Map (in pixels)</param>
        /// <param name="debugMode">Whether to start the Map in debug mode</param>
        /// <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        /// /// <param name="transparent">Whether transparent Map (true / false)</param>
        /// <returns>JavaScript + HTML code required to embed a Map</returns>
        private static string RenderMapALL(string MapSWF, string strURL, string strXML, string MapId, string MapWidth, string MapHeight, bool debugMode, bool registerWithJS, bool transparent)
        {

            StringBuilder builder = new StringBuilder();

            builder.AppendFormat("<!-- START Script Block for Map {0} -->" + Environment.NewLine, MapId);
            builder.AppendFormat("<div id='{0}Div' >" + Environment.NewLine, MapId);
            builder.Append("Map." + Environment.NewLine);
            builder.Append("</div>" + Environment.NewLine);
            builder.Append("<script type=\"text/javascript\">" + Environment.NewLine);
            builder.AppendFormat("var Map_{0} = new FusionMaps(\"{1}\", \"{0}\", \"{2}\", \"{3}\", \"{4}\", \"{5}\");" + Environment.NewLine, MapId, MapSWF, MapWidth, MapHeight, boolToNum(debugMode), boolToNum(registerWithJS));
            if (strXML.Length == 0)
            {
                builder.AppendFormat("Map_{0}.setDataURL(\"{1}\");" + Environment.NewLine, MapId, strURL);
            }
            else
            {
                builder.AppendFormat("Map_{0}.setDataXML(\"{1}\");" + Environment.NewLine, MapId, strXML);
            }

            if (transparent == true)
            {
                builder.AppendFormat("Map_{0}.setTransparent({1});" + Environment.NewLine, MapId, "true");
            }

            builder.AppendFormat("Map_{0}.render(\"{1}Div\");" + Environment.NewLine, MapId, MapId);
            builder.Append("</script>" + Environment.NewLine);
            builder.AppendFormat("<!-- END Script Block for Map {0} -->" + Environment.NewLine, MapId);
            return builder.ToString();
        }

        /// <summary>
        /// Generate html code for rendering Map
        /// This function assumes that you've already included the FusionMaps JavaScript class in your page
        /// </summary>
        /// <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        /// <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        /// <param name="MapWidth">Intended width for the Map (in pixels)</param>
        /// <param name="MapHeight">Intended height for the Map (in pixels)</param>
        /// <param name="debugMode">Whether to start the Map in debug mode</param>
        /// <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        /// <param name="transparent">Whether transparent Map (true / false)</param>
        /// <returns>JavaScript + HTML code required to embed a Map</returns>
        public static string RenderMap(string MapSWF, string strURL, string strXML, string MapId, string MapWidth, string MapHeight, bool debugMode, bool registerWithJS, bool transparent)
        {
            return RenderMapALL(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, registerWithJS, transparent);
        }

        /// <summary>
        /// Generate html code for rendering Map
        /// This function assumes that you've already included the FusionMaps JavaScript class in your page
        /// </summary>
        /// <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        /// <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        /// <param name="MapWidth">Intended width for the Map (in pixels)</param>
        /// <param name="MapHeight">Intended height for the Map (in pixels)</param>
        /// <param name="debugMode">Whether to start the Map in debug mode</param>
        /// <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        /// <returns>JavaScript + HTML code required to embed a Map</returns>
        public static string RenderMap(string MapSWF, string strURL, string strXML, string MapId, string MapWidth, string MapHeight, bool debugMode, bool registerWithJS)
        {
            return RenderMap(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, registerWithJS, false);
        }

        /// <summary>
        /// Renders the HTML code for the Map. This
        /// method does NOT embed the Map using JavaScript class. Instead, it uses
        /// direct HTML embedding. So, if you see the Maps on IE 6 (or above), you'll
        /// see the "Click to activate..." message on the Map.
        /// </summary>
        /// <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        /// <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        /// <param name="MapWidth">Intended width for the Map (in pixels)</param>
        /// <param name="MapHeight">Intended height for the Map (in pixels)</param>
        /// <param name="debugMode">Whether to start the Map in debug mode</param>
        /// <returns></returns>

        public static string RenderMapHTML(string MapSWF, string strURL, string strXML, string MapId, string MapWidth, string MapHeight, bool debugMode)
        {
            return RenderMapHTMLALL(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, false, false);
        }

        /// <summary>
        /// Renders the HTML code for the Map. This
        /// method does NOT embed the Map using JavaScript class. Instead, it uses
        /// direct HTML embedding. So, if you see the Maps on IE 6 (or above), you'll
        /// see the "Click to activate..." message on the Map.
        /// </summary>
        /// <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        /// <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        /// <param name="MapWidth">Intended width for the Map (in pixels)</param>
        /// <param name="MapHeight">Intended height for the Map (in pixels)</param>
        /// <param name="debugMode">Whether to start the Map in debug mode</param>
        /// <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        /// <returns></returns>

        public static string RenderMapHTML(string MapSWF, string strURL, string strXML, string MapId, string MapWidth, string MapHeight, bool debugMode, bool registerWithJS)
        {
            return RenderMapHTMLALL(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, registerWithJS, false);
        }

        /// <summary>
        /// Renders the HTML code for the Map. This
        /// method does NOT embed the Map using JavaScript class. Instead, it uses
        /// direct HTML embedding. So, if you see the Maps on IE 6 (or above), you'll
        /// see the "Click to activate..." message on the Map.
        /// </summary>
        /// <param name="MapSWF">SWF File Name (and Path) of the Map which you intend to plot</param>
        /// <param name="strURL">If you intend to use dataURL method for this Map, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="strXML">If you intend to use dataXML method for this Map, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="MapId">Id for the Map, using which it will be recognized in the HTML page. Each Map on the page needs to have a unique Id.</param>
        /// <param name="MapWidth">Intended width for the Map (in pixels)</param>
        /// <param name="MapHeight">Intended height for the Map (in pixels)</param>
        /// <param name="debugMode">Whether to start the Map in debug mode</param>
        /// <param name="registerWithJS">Whether to ask Map to register itself with JavaScript</param>
        /// <param name="transparent">Whether transparent Map (true / false)</param>
        /// <returns></returns>
        public static string RenderMapHTML(string MapSWF, string strURL, string strXML, string MapId, string MapWidth, string MapHeight, bool debugMode, bool registerWithJS, bool transparent)
        {
            return RenderMapHTMLALL(MapSWF, strURL, strXML, MapId, MapWidth, MapHeight, debugMode, registerWithJS, transparent);
        }

        private static string RenderMapHTMLALL(string MapSWF, string strURL, string strXML, string MapId, string MapWidth, string MapHeight, bool debugMode, bool registerWithJS, bool transparent)
        {
            //Generate the FlashVars string based on whether dataURL has been provided
            //or dataXML.
            StringBuilder strFlashVars = new StringBuilder();
            string flashVariables = String.Empty;
            if (strXML.Length == 0)
            {
                //DataURL Mode
                flashVariables = String.Format("&MapWidth={0}&MapHeight={1}&debugMode={2}&registerWithJS={3}&DOMId={4}&dataURL={5}", MapWidth, MapHeight, boolToNum(debugMode), (registerWithJS), MapId, strURL);
            }
            else
            //DataXML Mode
            {
                flashVariables = String.Format("&MapWidth={0}&MapHeight={1}&debugMode={2}&registerWithJS={3}&DOMId={4}&dataXML={5}", MapWidth, MapHeight, boolToNum(debugMode), boolToNum(registerWithJS), MapId, strXML);
            }

            strFlashVars.AppendFormat("<!-- START Code Block for Map {0} -->" + Environment.NewLine, MapId);
            strFlashVars.AppendFormat("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"{0}\" height=\"{1}\" name=\"{2}\" id==\"{2}\" >" + Environment.NewLine, MapWidth, MapHeight, MapId);
            strFlashVars.Append("<param name=\"allowScriptAccess\" value=\"always\" />" + Environment.NewLine);
            strFlashVars.AppendFormat("<param name=\"movie\" value=\"{0}\"/>" + Environment.NewLine, MapSWF);
            strFlashVars.AppendFormat("<param name=\"FlashVars\" value=\"{0}\" />" + Environment.NewLine, flashVariables);
            strFlashVars.Append("<param name=\"quality\" value=\"high\" />" + Environment.NewLine);

            string strwmode = "";
            if (transparent == true)
            {
                strFlashVars.Append("<param name=\"wmode\" value=\"transparent\" />" + Environment.NewLine);
                strwmode = "wmode=\"transparent\"";
            }

            strFlashVars.AppendFormat("<embed src=\"{0}\" FlashVars=\"{1}\" quality=\"high\" width=\"{2}\" height=\"{3}\" name=\"{4}\" id=\"{4}\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" {5} />" + Environment.NewLine, MapSWF, flashVariables, MapWidth, MapHeight, MapId, strwmode);
            strFlashVars.Append("</object>" + Environment.NewLine);
            strFlashVars.AppendFormat("<!-- END Code Block for Map {0} -->" + Environment.NewLine, MapId);
            string FlashXML = "<div id='" + MapId + "Div'>"; FlashXML += strFlashVars.ToString() + "</div>";
            return FlashXML;


        }

        /// <summary>
        /// Transform the meaning of boolean value in integer value
        /// </summary>
        /// <param name="value">true/false value to be transformed</param>
        /// <returns>1 if the value is true, 0 if the value is false</returns>
        private static int boolToNum(bool value)
        {
            return value ? 1 : 0;
        }

    }

}
