<div class="col-md-3">
		
	<div class="row">			
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-info-sign">
                            </span> About Us</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-pencil text-success"></span><a href="<?php echo base_url().'about' ?>"> Background</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-flash text-success"></span><a href="<?php echo base_url().'blogs' ?>"> Blog</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-comment text-success"></span><a href="<?php echo base_url().'contact' ?>"> Contact Us</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-book text-success"></span><a href="<?php echo base_url().'faq' ?>"> FAQ</a>
                                        <!--<span class="badge">42</span>-->
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php if($user_is_administrator || $user_is_county || $user_is_district || $user_is_moh){ ?>
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
                                        <span class="glyphicon glyphicon-list-alt text-success"></span></span><a href="<?php echo base_url().'c_incidents/all_diseases' ?>"> Initial Response</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <span class="glyphicon glyphicon-list-alt text-success"></span></span><a href="<?php echo base_url().'report_management/responses' ?>"> Reported Resonse</a>
                                    </td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php } if($user_is_administrator || $user_is_county || $user_is_district || $user_is_moh){ ?>
                <div class="panel panel-default">
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
                                        <span class="glyphicon glyphicon-send text-success"></span><a href="<?php echo base_url().'C_Incidents/report_incidence' ?>"> Send New Alert</a>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-edit text-success"></span><a href="<?php echo base_url().'C_Incidents/all_diseases_edit' ?>"> Edit Incident</a>
                                    </td>
                                </tr>
                               
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php } if($user_is_administrator){?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-briefcase">
                            </span> Disease Management</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                            	
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-edit text-success"></span><a href="<?php echo base_url().'c_disease/manage_d' ?>"> Edit Disease</a>
                                    </td>
                                </tr>
                               
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php } if($user_is_administrator){ ?>
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
                                       <a href="<?php echo base_url().'logs/' ?>">Access Traffic</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'A_Management/kemri_table_view' ?>">Kemri Reports</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'C_Incidents/masterdb' ?>">Master Database</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'Report_Management/responses' ?>">Responses Download</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'turn_around_tym_control/' ?>">Turn Around Time</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'weekly_controller/' ?>">Weekly Summary</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div><?php } ?>
            </div>
        </div>
        
    </div>
</div>

       
      </div>
        </div>      

      </div>    
    </div>
    
    <div class="row">			
			<div class="col-md-12">
				<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Notification <span class="glyphicon glyphicon-bell"></span> </h3>
      		</div>
      <div class="panel-body">
      <?php if($disease >0):?>   
		<div style="height:auto; margin-bottom: 2px" class="warning message ">
			<h5>Reported Disease(s)</h5>
			<p>
			<a class="link" href="<?php echo site_url("c_disease/incidence_disease/"); ?>"><span class="badge"><?php echo $disease; ?></span> Disease(s)</a> have been Reported.
			</p>
		</div>
		<?php endif; ?>
		
		<?php if($incident >0):?>
		<div style="height:auto; margin-bottom: 2px" class="warning message ">
			<h5>Reported Incidence(s)</h5>
			<p>
			<a class="link" href="<?php echo site_url("c_disease/all_diseases/"); ?>"><span class="badge"><?php echo $incident; ?></span> Incidence(s)</a> have been flagged.
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
      		
		<?php if($confirm >0){ ?>  
			<div style="height:auto; margin-bottom: 2px" class="warning message">
			<h5>Confirmed Incidence (s)</h5>
			<p>
			<a class="link" href="#"><span class="badge"><?php echo $confirm; ?></span> Incidence(s)</a> have been confirmed.
			</p>
			</div>
			<?php } else{ ?>
			<div style="height:auto; margin-bottom: 2px" class="warning message">
			<h5>Confirmed Incidence (s)</h5>
			<p>
			<span class="badge">0</span> Incidence(s) have been confirmed.
			</p>
			</div>
		 
		 <?php } ?>
		 
      </div>    
    </div>
	</div>
		</div>
    
	</div>