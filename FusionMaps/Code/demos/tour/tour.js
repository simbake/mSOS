var dataString ="<map \n\
	animation='0' showShadow='1' showBevel='0' hoverOnEmpty='0' \n\
	showLabels='1'  showMarkerLabels='0' includeValueInLabels='1' \n\
	fillColor='F1f1f1,c1c1c1' borderColor='CCCCCC' markerBorderColor='000000' markerBgColor='FF5904' \n\
	markerRadius='3' numberSuffix='M' \n\
	bgalpha='50,60' bgcolor='C5C9CB,8A959C' \n\
    legendBgColor='666666' legendBgAlpha='66' \n\
    legendAllowDrag ='1' legendBorderColor='f1f1f1' legendPosition='bottom'\n\
	legendShadow='0' legendCaption='Population Ranges:'\n\
	baseFontColor='ffffff' baseFontSize='13' tooltipBgColor='666666' \n\
>\n\
	<colorRange>\n\
		<color minValue='1' maxValue='100' displayValue=' Below 100 M' color='F29C9C' />\n\
		<color minValue='100' maxValue='500' displayValue='100 - 500 M' color='F2E0A1' />\n\
		<color minValue='500' maxValue='1000' displayValue='500 - 1000 M' color='649A64' />\n\
		<color minValue='1000' maxValue='5000000000' displayValue='Above 1000 M' color='E1F5C9' />\n\
	</colorRange>\n\
	 <data>\n\
	        <entity id='NA' value='515' />\n\
	        <entity id='SA' value='373' />\n\
	        <entity id='AS' value='3875' displayValue='Highest' color='008800'/>\n\
	        <entity id='EU' value='727' />\n\
	        <entity id='AF' />\n\
	        <entity id='AU' value='32' />\n\
	 </data>\n\
	 <markers>\n\
	  <definition>\n\
	   <marker id='CA' x='116.65' y='94.85' label='Sales Office' labelPos='top' fillcolor='ff0000'/> \n\
	   <marker id='US' x='131.57' y='153.22' label='Headquarters' labelPos='bottom'/>\n\
	   <marker id='IN' x='499.26' y='202.5' label='Accounts'  labelPos='bottom'/> \n\
	  </definition>\n\
	  <shapes>\n\
	    <shape id='USMap' type='image' url='Resources/us_flag.jpg' labelPadding='12' />\n\
	    <shape id='INMap' type='image' url='Resources/ind_flag.jpg' labelPadding='12' />\n\
	 </shapes>\n\
	  <application>\n\
	   <marker id='CA' shapeId='circle' toolText='Canadaaa{BR}2 Managers{BR}11 Staff'/>\n\
	   <marker id='US' shapeId='USMap' toolText='United States{BR}CEO, CFO, 3 Managers{BR}26 Staff'/>\n\
	   <marker id='IN' shapeId='INMap' toolText='India{BR}1 Manager{BR}5 Accountants'/> \n\
	  </application>  \n\
	    <connectors>\n\
	      <connector from='CA' to='IN' toolText='remote' dashed='0' thickness='2' color='ff0000' alpha='40'/>\n\
	      <connector from='IN' to='US' toolText='direct' dashed='1' thickness='2'  color='0000ff' alpha='90'/>\n\
	   </connectors>\n\
	 </markers>\n\
	 <styles> \n\
	  <definition>\n\
	   <style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>\n\
	   <style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>\n\
	   <style name='myShadow' type='Shadow' distance='1'/>\n\
	   <style name='FONTShadow' type='Shadow' distance='1' blurX='2' blurY='2' quality='2' strength='2' />\n\
	  </definition>\n\
	  <application>\n\
	   <apply toObject='MARKERS' styles='myShadow' /> \n\
	   <apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />\n\
	   <apply toObject='TOOLTIP' styles='TTipFont' />\n\
	   <apply toObject='PLOT' styles='myShadow' />\n\
	   <apply toObject='Labels' styles='FONTShadow' />\n\
	  </application>\n\
	 </styles>\n\
</map>";