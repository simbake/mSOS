<?php include'FusionCharts.php' ?>
<html>
<head>
	<title>FusionGadgets Chart Gallery - Gantt Chart</title>
	<script language="JavaScript" src="JSClass/FusionCharts.js"></script>
</head>
<body bgcolor="#ffffff">
<table width='98%' align='center' cellpadding='2' cellspacing='0'>
  <tr>
  <td align="center">
   <div id="chartdiv" align="center">FusionGadgets</div>
   <script type="text/javascript">
		   var chart = new FusionCharts("Charts/Column2D.swf", "ChartId", "500", "300", "0", "0");
		   chart.setDataURL("Gallery/Data/Column2D.xml");		   
		   chart.render("chartdiv");
		</script>
   </td>
   </tr>
   <tr height='10'>
<!--         var url = "<?php echo base_url().'report_management/moh_consumption_report' ?>"
        $.ajax({
          type: "POST",
          data: "ajax="+name+"&id="+data,
          url: url,
          beforeSend: function() {
            $("#content").html("");
          },
          success: function(msg) {
          	alert(msg);
            $("#content").html(msg);
           
          }
        });
        return false; -->
   <td><?php
      	$test="<chart palette='2' caption='Unit Sales' xAxisName='Month' yAxisName='Units' showValues='0' decimals='0' formatNumberScale='0' useRoundEdges='1'>
<set label='Chalo' value='462' />
<set label='Feb' value='857' />
<set label='Mar' value='671' />
<set label='Apr' value='494' />
<set label='May' value='761' />
<set label='Jun' value='960' />

</chart>
";
   
   
    echo renderChart("Charts/Column2D.swf","", rawurlencode($test),"myChartId", 700, 450, false, false);?></td>
   </tr>
   <tr>
    <td align="center">
	<a href='Data/Gantt6.xml' target='_blank'><img src='../Contents/Images/BtnViewXML.gif' border='0' alt='View XML for above chart'></a>
    </td>
   </tr>
</table>
</body>
</html>
