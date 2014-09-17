var dataString ='<map animation="0" showShadow="0" showBevel="0" showLabels="0"  showMarkerLabels="1" fillColor="F1f1f1" borderColor="CCCCCC" baseFont="Verdana" baseFontSize="10" markerBorderColor="000000" markerBgColor="FF5904" markerRadius="6" legendPosition="bottom" useHoverColor="0" showToolTip="0" showMarkerToolTip="1">\n\
 <data>\n\
  <entity id="NA"  />\n\
  <entity id="SA"  />\n\
  <entity id="EU"  />\n\
  <entity id="AS"  />\n\
  <entity id="AF"  /> \n\
  <entity id="AU"  />\n\
 </data>\n\
 <markers>\n\
  <definition>\n\
   <marker id="CA" x="116.65" y="94.85" label="Sales Office" labelPos="top"/> \n\
   <marker id="US" x="131.57" y="133.22" label="Headquarters" labelPos="bottom"/>\n\
   <marker id="CN" x="532.3" y="150.68" label="Call Center"  labelPos="bottom"/> \n\
   <marker id="BR" x="228.55" y="276.03" label="Production Center"  labelPos="bottom"/>\n\
   <marker id="AU" x="621.83" y="311.21" label="Q & A"  labelPos="bottom"/> \n\
   <marker id="RU" x="532.3" y="76.73" label="Back Office"  labelPos="bottom"/>\n\
   <marker id="IN" x="499.26" y="202.5" label="Accounts"  labelPos="bottom"/> \n\
  </definition>\n\
  <shapes>\n\
    <shape id="USMap" type="image" url="Resources/us_flag.jpg" labelPadding="12" />\n\
    <shape id="CAMap" type="image" url="Resources/canada_flag.jpg" labelPadding="12" /> \n\
    <shape id="CNMap" type="image" url="Resources/china_flag.jpg" labelPadding="12" />\n\
    <shape id="BRMap" type="image" url="Resources/brazil_flag.jpg" labelPadding="12" /> \n\
    <shape id="AUMap" type="image" url="Resources/aus_flag.jpg" labelPadding="12" />\n\
    <shape id="RUMap" type="image" url="Resources/rus_flag.jpg" labelPadding="12" /> \n\
    <shape id="INMap" type="image" url="Resources/ind_flag.jpg" labelPadding="12" />\n\
 </shapes>\n\
  <application>\n\
   <marker id="CA" shapeId="CAMap" toolText="Canada&lt;BR&gt;2 Managers&lt;BR&gt;11 Staff"/>\n\
   <marker id="US" shapeId="USMap" toolText="United States&lt;BR&gt;CEO, CFO, 3 Managers&lt;BR&gt;26 Staff"/>\n\
   <marker id="CN" shapeId="CNMap" toolText="China&lt;BR&gt;1 Manager&lt;BR&gt;7 Support Staff"/> \n\
   <marker id="BR" shapeId="BRMap" toolText="Brazil&lt;BR&gt;COO, 2 Managers&lt;BR&gt;32 Factory Staff"/>\n\
   <marker id="AU" shapeId="AUMap" toolText="Australia&lt;BR&gt;1 Manager&lt;BR&gt;(Outsourced Agency)"/>\n\
   <marker id="RU" shapeId="RUMap" toolText="Russia&lt;BR&gt;1 Manager&lt;BR&gt;6 Staff"/>\n\
   <marker id="IN" shapeId="INMap" toolText="India&lt;BR&gt;1 Manager&lt;BR&gt;5 Accountants"/> \n\
  </application>  \n\
 </markers>\n\
 <styles> \n\
  <definition>\n\
   <style name="TTipFont" type="font" isHTML="1"  color="FFFFFF" bgColor="666666" size="11"/>\n\
   <style name="HTMLFont" type="font" color="333333" borderColor="CCCCCC" bgColor="FFFFFF"/>\n\
   <style name="myShadow" type="Shadow" distance="1"/>\n\
  </definition>\n\
  <application>\n\
   <apply toObject="MARKERS" styles="myShadow" /> \n\
   <apply toObject="MARKERLABELS" styles="HTMLFont,myShadow" />\n\
   <apply toObject="TOOLTIP" styles="TTipFont" />\n\
  </application>\n\
 </styles>\n\
</map>';