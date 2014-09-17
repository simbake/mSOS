var dataString ='<map hoverOnEmpty="0" showShadow="0" showBevel="0" showMarkerLabels="0" useHoverColor="0" showLabels="0" \n\
fillColor="AFCED9" bordercolor="FFFFFF"  canvasBorderColor="AFCED9"  tooltipbgColor="00577F" tooltipborderColor="00577F"\n\
   markerBgColor="00577F" markerBorderColor="00577F" markerRadius="3" > \n\
 <data>  \n\
  <entity id="AL" />\n\
  <entity id="AK" />\n\
  <entity id="AZ" /> \n\
  <entity id="AR" />\n\
  <entity id="CA" />\n\
  <entity id="CO" />\n\
  <entity id="CT" />\n\
  <entity id="DE" /> \n\
  <entity id="FL" /> \n\
  <entity id="GA" />\n\
  <entity id="HI" />\n\
  <entity id="ID" />\n\
  <entity id="IL" />\n\
  <entity id="IN" /> \n\
  <entity id="IA" /> \n\
  <entity id="KS" />\n\
  <entity id="KY" />\n\
  <entity id="LA" />\n\
  <entity id="ME" />\n\
  <entity id="MD" /> \n\
  <entity id="MA" /> \n\
  <entity id="MI" />\n\
  <entity id="MN" />\n\
  <entity id="MS" />\n\
  <entity id="MO" />\n\
  <entity id="MT" /> \n\
  <entity id="NE" /> \n\
  <entity id="NV" />\n\
  <entity id="NH" />\n\
  <entity id="NJ" />\n\
  <entity id="NM" />\n\
  <entity id="NY" /> \n\
  <entity id="NC" /> \n\
  <entity id="ND" />\n\
  <entity id="OH" />\n\
  <entity id="OK" />\n\
  <entity id="OR" />\n\
  <entity id="PA" /> \n\
  <entity id="RI" /> \n\
  <entity id="SC" />\n\
  <entity id="SD" />\n\
  <entity id="TN" />\n\
  <entity id="TX" />\n\
  <entity id="UT" /> \n\
  <entity id="VT" /> \n\
  <entity id="VA" />\n\
  <entity id="WA" />\n\
  <entity id="WV" />\n\
  <entity id="WI" />\n\
  <entity id="WY" /> \n\
  <entity id="DC" /> \n\
 </data>\n\
 <markers>\n\
  <definition>\n\
    <marker id="SE" x="35.34" y="50.56" label="Seattle" /> \n\
    <marker id="CO" x="525.85" y="172.94" label="Columbus" />\n\
    <marker id="MA" x="444.94" y="119.34" label="Madison" />\n\
    <marker id="LA" x="81.86" y="257.89" label="Los Angeles" />\n\
    <marker id="SLC" x="163.79" y="156.76" label="Salt Lake City" />\n\
    <marker id="KC" x="383.25" y="183.05" label="Kansas City" />\n\
    <marker id="AT" x="508.66" y="267" label="Atlanta" />\n\
    <marker id="CH" x="467.19" y="139.56" label="Chicago" /> \n\
    <marker id="OK" x="344.82" y="236.65" label="Oklahoma City" />\n\
    <marker id="NO" x="432.81" y="314.53" label="New Orleans" /> \n\
  </definition> \n\
  <shapes>\n\
    <shape id="Icon" type="image" URL="Resources/PlaneIcon.gif"/>\n\
  </shapes>\n\
  <application> \n\
    <marker id="SE" shapeId="Icon" /> \n\
    <marker id="SP" shapeId="Icon" />\n\
    <marker id="CO" shapeId="Icon" />\n\
    <marker id="MA" shapeId="Icon" />\n\
    <marker id="LA" shapeId="Icon" /> \n\
    <marker id="SLC" shapeId="Icon" />\n\
    <marker id="KC" shapeId="Icon" /> \n\
    <marker id="AT" shapeId="Icon" />\n\
    <marker id="CH" shapeId="Icon" /> \n\
    <marker id="OK" shapeId="Icon" />\n\
    <marker id="NO" shapeId="Icon" /> \n\
  </application>\n\
  <connectors>\n\
   <connector from="SE" to="SLC" toolText="Seattle - Salt Lake City: 689 miles" dashed="1" color="00577F" alpha="40"/> \n\
   <connector from="CH" to="AT" toolText="Chicago - Atlanta: 606 miles" dashed="1" color="00577F"  alpha="40"/>\n\
   <connector from="SE" to="LA" toolText="Seattle - Los Angeles: 954 miles" dashed="1" color="00577F"  alpha="40"/> \n\
   <connector from="AT" to="LA" toolText="Atlanta - Los Angeles: 1946 miles" dashed="1" color="00577F"  alpha="40"/>\n\
   <connector from="LA" to="NO" toolText="Los Angeles - New Orleans: 1645 miles" dashed="1" color="00577F"  alpha="40"/> \n\
   <connector from="KC" to="MA" toolText="Kansas City - Madison: 381 miles" dashed="1" color="00577F"  alpha="40"/>\n\
   <connector from="SE" to="OK" toolText="Seattle - Oklahoma City: 1499 miles" dashed="1" color="00577F"  alpha="40"/> \n\
   <connector from="MA" to="SE" toolText="Madison - Seattle: 1595 miles" dashed="1" color="00577F"  alpha="40"/>\n\
   <connector from="KC" to="SLC" toolText="Kansas City - Salt Lake City: 905 miles" dashed="1" color="00577F"  alpha="40"/> \n\
   <connector from="SLC" to="CH" toolText="Salt Lake City - Chicago: 1239 miles" dashed="1" color="00577F"  alpha="40"/>\n\
   <connector from="CO" to="SLC" toolText="Columbus - Salt Lake City: 1575 miles" dashed="1" color="00577F"  alpha="40"/> \n\
   <connector from="NO" to="CO" toolText="New Orleans - Columbus: 355 miles" dashed="1" color="00577F"  alpha="40"/>\n\
   <connector from="OK" to="CH" toolText="Oklahoma City - Chicago: 682 miles" dashed="1" color="00577F"  alpha="40"/> \n\
  </connectors>\n\
  </markers>\n\
  <styles>\n\
  <definition>\n\
   <style name="ToolTipStyle" type="font" bgColor="00577F" borderColor="00577F" color="FFFFFF"/>\n\
   <style name="animalpha" type="animation" param="_alpha" start="0" duration="1" /> \n\
  </definition>\n\
  <application>\n\
   <apply toObject="TOOLTIP" styles="ToolTipStyle" />\n\
   <apply toObject="MARKERCONNECTORS" styles="animAlpha" />\n\
   <apply toObject="MARKERS" styles="animAlpha" />\n\
  </application>\n\
  </styles>\n\
</map>';