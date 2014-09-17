var dataString ='<map animation="0" showShadow="0" showBevel="0" showLabels="1"  fillColor="F1f1f1" borderColor="CCCCCC" baseFont="Verdana" baseFontSize="10" legendPosition="bottom" useHoverColor="1" showToolTip="0" showMarkerToolTip="1"  >\n\
 <data>\n\
  <entity id="NA"  font="Arial" fontsize="20" fontColor="0372AB" fontBold="1"/>\n\
  <entity id="SA"  font="Verdana" fontSize="16" fontColor="990000" fontBold="1"/>\n\
  <entity id="EU"  font="Arial" fontsize="14" fontColor="660066" fontBold="1"/>\n\
  <entity id="AS"  font="Arial" fontsize="20" fontColor="0372AB" fontBold="1"/>\n\
  <entity id="AF"  font="Verdana" fontSize="16" fontColor="990000" fontBold="1"/> \n\
  <entity id="AU"  font="Arial" fontsize="14" fontColor="660066" fontBold="1"/>\n\
 </data>\n\
 \n\
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