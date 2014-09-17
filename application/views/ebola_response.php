<?php 
               $incidentz= Incidence::get_incidence_ebola_count();
				//$diseasez= Incidence::get_disease_count();
				$confirmz= Incidence::confirm_ebola();?>
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
                                       <a href="<?php echo base_url().'A_Management/kemri_table_view' ?>">Kemri Reports</a>
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
    </div>
    
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
			<a class="link" href="<?php if($this->session->userdata("user_id"))echo site_url("c_incidents/all_diseases/"); ?>"><span class="badge"><?php echo $incidentz; ?></span>Incidence(s)</a> have been flagged.
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

<div class="col-md-9" style="padding-left: 1%;">
	 	<?php

if (isset($all)) {

	$age = $all -> Age;
	$disease = $all -> Disease_id;
	$incidents = $all -> p_id;
	$sex = $all -> Sex;
	$status = $all -> Status;
	$id = $all -> id;
}
?>

  	 <script>
	function showFields() {
          
		if ($("#findings").val() == "Other") {

			document.getElementById("pat_info").style.display = "";

		}
		if ($("#action").val() == "Other") {

			document.getElementById("pat_info1").style.display = "";

		}
		if($("#action").val() != "Other"){
		$('#pat_info1').hide();
		}
		if($("#findings").val() != "Other"){
		$('#pat_info').hide();
		}
		

	}

</script>
			     
			     <div class="panel panel-success">
			     	<div class="panel-heading">
			     		Reported Incident <span class="glyphicon glyphicon-info-sign"></span>
			     	</div>
			     	<div class="panel-body" style="overflow-y: auto">
			     		<form  style="width: 100%" role="form" method="post" action="<?php echo base_url().'c_incidents/confirm_response/ebola'?>" enctype="multipart/form-data">
			     			<input type="hidden" name="id" id="id" value="<?php echo $this->uri->segment(3); ?>" />
			     			<div class="row">
			     			<div class="col-lg-6">
			     	             <div class="form-group">
                                            <label>Incident ID: </label>
                                            <input type="text" class="form-control" readonly="readonly" value="<?php echo $incidents; ?>" name="fname" id="fname" />
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                  </div>
                                  <div class="form-group">
                                            <label>Sex: </label>
                                            <input type="text" class="form-control" readonly="readonly" value="<?php echo $sex; ?>" name="sex" id="sex" />
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                  </div>
                                  <div class="checkbox-inline">
                                 <label>
                                    <input type="checkbox" name="check_list[]" value="Phone Call">
                                       Phone Call
                                  </label>
                                  
                                  </div>
                                  <div class="checkbox-inline">
                                 <label>
                                    <input type="checkbox" name="check_list[]" value="Visited">
                                       Visited
                                  </label>
                                  
                                  </div>
                                  <div class="checkbox-inline">
                                 <label>
                                    <input type="checkbox" name="check_list[]" value="Sample Taken">
                                       Sample Taken
                                  </label>
                                  
                                  </div>
                                  <div class="checkbox-inline">
                                 <label>
                                    <input type="checkbox" name="check_list[]" value="Investigations Made">
                                       Investigations Made
                                  </label>
                                  
                                  </div>
                                  <div class="checkbox-inline">
                                 <label>
                                    <input type="checkbox" name="check_list[]" value="Public Heath Action Taken">
                                       Public Heath Action Taken
                                  </label>
                                  
                                  </div>
                                        <div class="form-group">
                                            <textarea name="notes" placeholder='Comments' class="form-control" rows="3"></textarea>
                                           
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                         </div>
			     	
			     	</div>
			     		
			     		<div class="col-lg-6">
			     	             <div class="form-group">
                                            <label>Age: </label>
                                            <input type="number" class="form-control" readonly="readonly" value="<?php echo $age; ?>" name="age" id="age" />
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                  </div>
                                  <div class="form-group">
                                            <label>Status: </label>
                                            <input type="text" class="form-control" readonly="readonly" value="<?php echo $status; ?>" name="status" id="status" />
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                  </div>
                                  
                                       <div class="form-group">
                                            <label>Findings: </label>
                                            <select class="form-control" required id="findings" name="findings" onchange="showFields()" required>
                                            	
                                            <option disabled="disabled">-- Select Finding --</option>
					                        <option value="Meets case definition">Meets case definition</option> 
					                        <option value="Doesn't meet case">Doesn't meet case</option>
					                        <option value="Confirmed Outbreak">Confirmed Outbreak</option>
					                        <option value="Other">Other</option>											
											
											</select>
                                        </div>
                                        
                                        <div class="form-group" id="pat_info"  style="display: none">
                                            <label>Other Findings: </label>
                                            <input type="text" class="form-control" value="" name="others" id="others" />
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                         </div>
                                         
                                         <div class="form-group">
                                            <label>Public Health Action Taken: </label>
                                            <select class="form-control" required id="action" name="actiontaken" onchange="showFields()" required>
                                            	
                                           <option disabled="disabled">-- Select Public Health Action Taken --</option>
				                           <option value="Sprayed">Sprayed</option>
				                           <option value="Cases Searched in the community">Cases Searched in the community</option>
				                           <option value="Treated Water">Treated Water</option>
				                           <option value="Conducted public awareness">Conducted public awareness</option>
				                           <option value="Other">Other</option>											
											
											</select>
                                        </div>
                                        
                                        <div class="form-group" id="pat_info1"  style="display: none">
                                            <label>Other Findings: </label>
                                            <input type="text" class="form-control" value="" name="others1" id="others1" />
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                         </div>
                                  
			     		</div>
			     		</div>
			     		<div class="row">
			     			   <div class="col-lg-6">
			     			   	<div class="form-group">
                             <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-comment"></span> Respond to Incident</button>
							            </div>
                                        </div>

			     		</div>
			     			</form>
			     	</div>
			     </div>
			    
   
    
  </div> 
  
 

  

