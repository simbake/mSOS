<div class="col-md-9" style="padding-left: 1.5%;">
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
			     		<form  style="width: 100%" role="form" method="post" action="<?php echo base_url().'c_incidents/confirm_response'?>" enctype="multipart/form-data">
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
  
 

  

