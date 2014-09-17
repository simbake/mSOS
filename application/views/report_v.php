<?php

 //We have included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
include ("Scripts/FusionCharts/FusionCharts.php");
?>
      <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/unit_size.js"></script>
      
<style>
 .ui-combobox {
        position: relative;
        display: inline-block;
        margin-left: 100px;
    }
    .ui-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        /* adjust styles for IE 6/7 */
        *height: 1.7em;
        *top: 0.1em;
    }
    .ui-combobox-input {
        margin: 0;
        padding: 0.3em;
    }
	.message {
	display: block;
	padding: 10px 20px;
	margin: 15px;
	width: 70%;
	margin-left: 15px;
	}
	.warning {
	background: #FEFFC8 url('<?php echo base_url()?>Images/Alert_Resized.png') 20px 50% no-repeat;
	border: 1px solid #F1AA2D;
	width: 70%;
	}
	.message h2 {
	margin-left: 60px;
	margin-bottom: 5px;
	}
	.message p {
	width: auto;
	margin-bottom: 0;
	margin-left: 60px;
	}
	.activity{
	display: block;
	padding: 10px 20px;
	margin: 15px;
	width: 70%;	
	}
	.activity h2 {
	margin-left: 60px;
	margin-bottom: 5px;
	}
	.update{
	background: url('<?php echo base_url()?>Images/updates-resize1.png') 10px 50% no-repeat;
	border: 1px solid black;
	width: 70%;
	height: 40%;
	}
	.update_stock{
	background: url('<?php echo base_url()?>Images/updates-resize1.png') 10px 50% no-repeat;
	border: 1px solid black;
	width: 70%;
	height: 40%;
	}
	.issue{
	background: url('<?php echo base_url()?>Images/Drug-basket-resize.png') 10px 50% no-repeat;
	border: 1px solid black;
	width: 70%;
	height: 40%;
	}
	.order{
	background: url('<?php echo base_url()?>Images/ordering-resize.png') 10px 50% no-repeat;
	border: 1px solid black;
	width: 70%;
	height: 40%;
	}
	.update_order{
	background: url('<?php echo base_url()?>Images/Inventory-resize.png') 10px 50% no-repeat;
	border: 1px solid black;
	width: 70%;
	height: 40%;
	}
	.reports{
	background: url('<?php echo base_url()?>Images/numbers-resize.png') 10px 50% no-repeat;
	border: 1px solid black;
	width: 70%;
	height: 40%;
	}
	.users{
	background: url('<?php echo base_url()?>Images/user-resize.png') 10px 50% no-repeat;
	border: 1px solid black;
	width: 70%;
	height: 40%;
	}
	#left_content{
	width:50%;
	float: left;
	}
	#right_content{
	width:40%;
	float: right;
	}
	.information {
	background: #C3E4FD url('<?php echo base_url()?>Images/Notification_Resized.png') 20px 50% no-repeat;
	border: 1px solid #688FDC;
	margin-left:40px;
	width:76%;
	}
	.graph{
		width:90%;
	border: 1px solid #739F1D;
	}
	.graph h2{
		margin-left:0;
	}
	#main_content{
	overflow:hidden;
	}
	#full_width{
	float:left;
	width:100%
	} 
	.graph_container{
		margin:0 auto;
		width:500px;	
	}
	a{
		text-decoration: none;
	}
</style>
<script>
  	$(function() {
  	
  	   $( "#month" ).combobox({
        	selected: function(event, ui) {
        		
           var data =$("#year").val();
           var month =$("#month").val();
           //var name =encodeURI($("#desc option:selected").text());
          
          
        var url = "<?php echo base_url().'report_management/monthly' ?>
			"
			$.ajax({
			type: "POST",
			data: "year="+data+"&month="+month,
			url: url,
			beforeSend: function() {
			$("#contentlyf").html("");
			},
			success: function(msg) {
			$("#contentlyf").html(msg);

			}
			});
			return false;

			}
			});

			 $("#disease").combobox({
        	selected: function(event, ui) {
        		
           var dyear =$("#dyear").val();
           var dmonth =$("#dmonth").val();
           var dise=$("#disease").val();
           var names =encodeURI($("#disease option:selected").text());
          
          
        var url = "<?php echo base_url().'report_management/daily' ?>
			"
			$.ajax({
			type: "POST",
			data: "year="+dyear+"&month="+dmonth+"&disease="+dise+"&name="+names,
			url: url,
			beforeSend: function() {
			$("#contently").html("");
			},
			success: function(msg) {
			$("#contently").html(msg);

			}
			});
			return false;

			}
			});

		

			

			});
  </script>
<div id="main_content">
	<div id="left_content">
		<fieldset>
		<legend>Graphical Analysis</legend>
	  <fieldset>
		<legend>Lifetime Analysis</legend>
<div> <?php echo renderChart("" . base_url() . "Scripts/FusionCharts/Charts/MSColumn2D.swf", "", $strXML_e5, "e_6", 700, 400, false, true); ?></div>
</fieldset>
<fieldset>
		<legend>Monthly Analysis</legend>
		<div align="center">
	
	<table>
		<tr>
			<td> Year :
			<select id="year" name="year" >
				<option value="0" selected>--Select Year--</option>
				<option value="2012">2012</option>
				<option value="2013">2013</option>
				<option value="2014">2014</option>
				<option value="2015">2015</option>
			</select></td>
			
			<td> Month :
			<select id="month" name="month" >
				<option>--Select month--</option>
				<option value="1">January</option>
				<option value="2">February</option>
				<option value="3">March</option>
				<option value="4">April</option>
				<option value="5">May</option>
				<option value="6">June</option>
				<option value="7">July</option>
				<option value="8">August</option>
				<option value="9">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select></td>

		</tr>
	</table>

<div id="contentlyf"> <?php echo renderChart("" . base_url() . "Scripts/FusionCharts/Charts/MSColumn2D.swf", "", $strXML_e1, "e_1", 700, 400, false, true); ?></div>
</fieldset>
		<fieldset>
		<legend>Daily Analysis</legend>
		<table>
		<tr align="center">
			<td> Year :
			<select id="dyear" name="dyear" >
				<option value="0" selected>--Select Year--</option>
				<option value="2012">2012</option>
				<option value="2013">2013</option>
				<option value="2014">2014</option>
				<option value="2015">2015</option>
			</select></td>
			
			<td> Month :
			<select id="dmonth" name="dmonth" >
				<option>--Select month--</option>
				<option value="1">January</option>
				<option value="2">February</option>
				<option value="3">March</option>
				<option value="4">April</option>
				<option value="5">May</option>
				<option value="6">June</option>
				<option value="7">July</option>
				<option value="8">August</option>
				<option value="9">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select></td>
			<td> Disease :
			<select id="disease" name="disease" >
				<option>--Select Disease--</option>
				<?php foreach($list as $row){?>
				<option value="<?php echo $row['id'];?>"><?php echo $row['Full_Name'];?></option>
				<?php }?>
				
			</select></td>

		</tr>
	</table>
		<div id="contently"> <?php echo renderChart("" . base_url() . "Scripts/FusionCharts/Charts/MSColumn2D.swf", "", $strXML_e2, "e_2", 800, 400, false, true); ?></div>
		</fieldset>
		</fieldset>
	</div>
	
	
	<div id="right_content">
		<fieldset>
			<legend>Notifications</legend>
			
           <?php if($disease >0):?>   
		<div class="message warning">
			<h2>Reported Disease(s)</h2>
			<p>
			<a class="link" href="<?php echo site_url("c_disease/incidence_disease/"); ?>"><?php echo $disease; ?> Disease(s)</a> have been Reported.
			</p>
		</div>
		<?php endif; ?>
		<?php if($incident >0):?>
		<div class="message warning">
			<h2>Reported Incidence(s)</h2>
			<p>
			<a class="link" href="<?php echo site_url("c_disease/all_diseases/"); ?>"><?php echo $incident; ?> Incidence(s)</a> have been flagged.
			</p>
		</div>
		 <?php endif; ?>
		
		</fieldset>
		<fieldset>
			<legend>Confirmed cases</legend>
			<?php if($confirm >0):?>  
			<div class="message information">
			<h2>Confirmed Incidence (s)</h2>
			<p>
			<a class="link" href="#"><?php echo $confirm; ?> Incidence(s)</a> have been confirmed.
			</p>
			</div>
			<?php endif; ?>
			
			
			
		</fieldset>
	</div>
	
