  
<style>
	.message {
	display: block;
	padding: 10px 20px;
	margin: 15px;
	width: 70%;
	margin-left: 0px;
	}
	.warning {
	background: #FEFFC8 url('<?php echo base_url()?>Images/Alert_Resized.png') 20px 50% no-repeat;
	border: 1px solid #F1AA2D;
	width: 100%;
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
	width:50%;
	float: right;
	}
	.information {
	background: #C3E4FD url('<?php echo base_url()?>Images/Notification_Resized.png') 20px 50% no-repeat;
	border: 1px solid #688FDC;
	margin-left:0px;
	width:100%;
	}
	.graph{
	
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
		width:800px;	
	}
	a{
		text-decoration: none;
	}
</style>

<div id="container">
	<div class="row">
		<div class="col-sm-1 col-md-1">
			</div>
	
	<div class="col-sm-5 col-md-5">
		<div class="panel panel-default">
		<div class="panel-heading">How to send Alert SMS</div>
		
		<div class="panel-body">
		<div class="message information">
			<h2>Raise an alert</h2>
			<p class="linkss">
			Send the message: Alert mflcode diseasecode age sex status eg. alert atx 14 m a
			</p>
			</div>
			<div class="message information">
			<h2>To Edit an incident</h2>
			<p class="linkss">
			Send the message: Edit incidentID old_disease_acronym new_disease_acronym eg. update MTA3SF9Y7K atx VHF
			</p>
			</div>
			<div class="message information">
			<h2>To Query Formart</h2>
			<p class="linkss">
			Send the message: format update/alert/week eg.
			<ol type="I" class="linkss" style="margin-left: 35px;">
					<li>format Alert</li>
					<li>format Edit</li>
					<li>format Week</li>
					
				</ol>
			</p>
			</div>
			<div class="message information">
			<h2>To Submit a week's summary</h2>
			<p class="linkss">
			Send the message: summary number_of_suspected_cases eg. summary 10
			</p>
			</div>
	  </div>

		</div>
	</div>
	
	<div class="col-sm-5 col-md-5">
		<div class="panel panel-default">
			
			<div class="panel-heading">Response</div>
			<div class="panel-body">
			<div class="message warning">
			<h2>Alert response</h2>
			<p class="linkss">
			Message Received. Action will be taken promptly. The Incident ID is MTA3SF9Y7K
			</p>
			</div>
			<div class="message warning">
			<h2>Edit response</h2>
			<p class="linkss">
			Incident MTA3SF9Y7K has been changed from Anthrax to Yellow Fever
			</p>
			</div>
			<div class="message warning">
			<h2>Format response</h2>
			<p >
				<ol type="I" class="linkss" style="margin-left: 35px;">
					<li>ALERT: alert mflcode diseasecode age sex status eg. alert 13023 atx 14 m a</li>
					<li>Edit: correct incidentID old_disease_acronym new_disease_acronym eg. Edit MTA3SF9Y7K atx VHF</li>
					<li>Summary: summary number_of_suspected_cases eg. summary 10</li>
				</ol>
			</p>
			</div>
			<div class="message warning">
			<h2>Weekly Summary Response</h2>
			<p >
				<ol type="I" class="linkss" style="margin-left: 35px;">
					<li>Thank you for correct data</li>
					<li>You have a discrepancy, please report all of them for incorrect information</li>
					
				</ol>
			</p>
			</div>
          
		</div>
		</div>
		
	</div>

</div>	
</div>
