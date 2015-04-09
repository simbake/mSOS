<?php 
               $incidentz= incidence_ebola::get_incidence_ebola_count();
				//$diseasez= Incidence::get_disease_count();
				$confirmz= incidence_ebola::confirm_ebola();?>
<div class="col-md-3">
		
	<?php if($this->session->userdata("user_indicator")!='KEMRI'){ ?> <div class="row">			
			<div class="col-md-12">				
			<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Actions <span class="glyphicon glyphicon-list-alt"></span></h3>
      </div>
      <div class="panel-body">
    <div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="panel-group" id="accordion">
            	      
              <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th">
                            </span> More Action</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-list-alt text-success"></span></span><a href="<?php echo base_url().'ebola_Reports/all_ebola' ?>"> Initial Response</a>
                                    </td>
                                </tr>
                            
                                
                            </table>
                        </div>
                    </div>
              </div>
              <!--<div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-phone">
                            </span> Alerts</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                            	
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-send text-success"></span><a href="<?php echo base_url().'ebola_Reports/raise_alert' ?>"> Send New Alert</a>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-edit text-success"></span><a href="<?php echo base_url().'ebola_Reports/edit_alert' ?>"> Edit Incident</a>
                                    </td>
                                </tr>
                               
                            </table>
                        </div>
                    </div>
              </div>-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="glyphicon glyphicon-file">
                            </span> Reports</a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                               
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'ebola_reports/kemri_table_view' ?>">Kemri Reports</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'ebola_Reports/master_db' ?>">Master Database</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'ebola_Reports/responses' ?>">Responses Download</a>
                                    </td>
                                </tr>
                                
 
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>

       
      </div>
        </div>      

      </div>    
  </div><?php } ?>
    
    <div class="row">			
			<div class="col-md-12">
				<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Notification <span class="glyphicon glyphicon-bell"></span> </h3>
      		</div>
      <div class="panel-body">
      
		<?php if($incidentz >0):?>
		<div style="height:auto; margin-bottom: 2px" class="warning message ">
			<h5>Reported Incidence(s)</h5>
			<p>
			<a class="link" href="<?php if($this->session->userdata("user_id"))echo site_url("ebola_Reports/all_ebola/"); ?>"><span class="badge"><?php echo $incidentz; ?></span>Incidence(s)</a> have been flagged.
			</p>
		</div>
		 <?php endif; ?>
		 
		 <?php /*if($facility_dashboard_notifications['facility_donations']>0): ?>
      	 <div style="height:auto; margin-bottom: 2px" class="warning message ">      	
        <h5>Inter Facility Donation</h5> 
        	<p>
			<a class="link" href="<?php echo base_url('issues/confirm_external_issue') ?>"><span class="badge"><?php 
				echo $facility_dashboard_notifications['facility_donations'];?></span> Items have been donated</a> 
			</p>
			 </div>
		  <?php endif; */// Potential Expiries?>
		 
      </div>    
    </div>
	</div>
		</div>
		
		<div class="row">			
			<div class="col-md-12">
				<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Confirmed cases <span class="glyphicon glyphicon-warning-sign"></span> </h3>
      		</div>
      <div class="panel-body">
      		
		<?php if($confirmz >0){ ?>  
			<div style="height:auto; margin-bottom: 2px" class="warning message">
			<h5>Confirmed Incidence (s)</h5>
			<p>
			<a class="link" href="#"><span class="badge"><?php echo $confirmz; ?></span>Incidence(s)</a> have been confirmed.
			</p>
			</div>
			<?php } else{ ?>
			<div style="height:auto; margin-bottom: 2px" class="warning message">
			<h5>Confirmed Incidence (s)</h5>
			<p>
			<span class="badge">0</span>Incidence(s) have been confirmed.
			</p>
			</div>
		 
		 <?php } ?>
		 
      </div>    
    </div>
	</div>
		</div>
    
	</div>
	
<div class="col-md-8" style="padding-left: 3%;">
<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Map <span class="glyphicon glyphicon-globe" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        	<?php //echo $map['html']; ?>
        </div>
      </div>
    </div></div>
    
    <div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Graph <span class="glyphicon glyphicon-stats" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        <?php echo renderChart(base_url() . "Scripts/FusionCharts/StackedColumn2D.swf", "", $strXML_e5, "e_6", '', 400, false, true); ?>
        </div>
      </div>
    </div>
    </div>
    
    </div>