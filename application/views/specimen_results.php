<?php

if($this->session->userdata("user_indicator")!='KEMRI'){
				redirect("home_controller");
			}
$id=$this -> session -> userdata('user_id');
$level=$this -> session -> userdata('user_level');
 //echo //$map['js']; 
$access_level = $this -> session -> userdata('user_indicator');
$user_is_administrator = false;
$user_is_moh = false;
$user_is_kemri = false;
$user_is_district = false;
$user_is_county = false;
$user_is_moh= false;

if ($access_level == "Administrator") {
	$user_is_administrator = true;
} else if ($access_level == "MOH") {
	$user_is_moh = true;
} else if ($access_level == "KEMRI") {
	$user_is_kemri = true;
} else if ($access_level == "District Administrator") {
	$user_is_district = true;
}else if ($access_level == "County Administrator") {
	$user_is_county = true;
}

$user_id=$this -> session -> userdata('user_id');
$level=$this -> session -> userdata('user_level');
if (isset($all)) {
    
	if(isset($ebola)){
		if($ebola==true){
	$incidentz = $all -> incidence_code;
		}
	}
	else{
		$incidentz = $all -> p_id;
	}
	$id = $all -> id;
}
 
 ?>


<script>

function showFields()
{
 //$('#dialog').dialog();
 if($("#specimen_type").val() == "Stool")
 {
 $('#comment').hide()
 
 }else if($("#specimen_type").val() == "Blood")
 {
$('#comment').hide()

 }else if($("#specimen_type").val() == "Serum")
 {
$('#comment').hide()

 }else if($("#specimen_type").val() == "Human Tissue")
 {
$('#comment').hide()

 }
 
 else if($("#specimen_type").val() == "Other")
 {

document.getElementById("comment").style.display="";

 }
 else{
 $('#comment').hide()
 }
 

}

function conditionscript(){

if($("#condition").val() == "Adequate")
 {
 $('#conditions').hide()
 
 }else if($("#condition").val() == "Inadequate")
 {
$('#conditions').hide()

 }
 else{
 document.getElementById("conditions").style.display="";
 }

}

</script>

	<div class="col-md-2">
		
		</div>
	 <div class="col-md-9" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Specimen Results Form <span class="glyphicon glyphicon-tasks" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">

	 <!-- <legend>Contact Form</legend>-->
         <form class="form-horizontal" method="post" action="<?php if(isset($ebola)){if($ebola==true){echo base_url().'ebola_Reports/specimen_results_submit';}}else{echo base_url().'a_management/specimen_results_submit';} ?>" role="form">
         	<input type="hidden" id="id_1" readonly="readonly" name="id_1" value="<?php echo $this -> uri -> segment(3); ?>"/>
         	<div class="form-group">
    <label for="Incidence_id" class="col-sm-2 control-label">Incident ID: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="Incidence_id" readonly="readonly" value="<?php echo $incidentz ?>" required name="Incidence_id" placeholder="">
    </div>
</div>
<div class="form-group">
    <label for="date_received" class="col-sm-2 control-label">Date Received: </label>
    <div class="col-sm-10">
    	<div class='input-group date'>
      <input type="text" class="form-control" id="date_received"  value="" required name="date_received" placeholder="">
      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
      </span>
      </div>
    </div>
    <script type="text/javascript">
            $(function () {
                $('#date_received').datepicker({
                    
                });
            });
        </script>
</div>

  <div class="form-group">
    <label for="specimen_type" class="col-sm-2 control-label" >Specimen Type: </label>
    <div class="col-sm-10">
      <select id="specimen_type" name="specimen_type" class="form-control" onchange="showFields()">
	<option value="Stool">Stool</option>
	<option value="Blood">Blood</option>
	<option value="Serum">Serum</option>
	<option value="Human Tissue">Human Tissue</option>
	<option value="Other">Other</option>
	</select>
    </div>
  </div>
  <div class="form-group" id="comment" style="display: none">
    <label for="date_received" class="col-sm-2 control-label" >Specimen Condition: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="specimen_comments" name='specimen_comments' placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="condition" class="col-sm-2 control-label" >Specimen Type: </label>
    <div class="col-sm-10">
      <select id="condition" name="condition" class="form-control" onchange="conditionscript()">
	<option value="Adequate">Adequate</option>
	<option value="Inadequate">Inadequate</option>
	<option value="Other">Other</option>
	</select>
    </div>
  </div>
  <div class="form-group" id="conditions" style="display: none">
    <label for="date_received" class="col-sm-2 control-label" >Other Specimen: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="specimen_condition" name='specimen_condition' placeholder="">
    </div>
  </div>
  
  <div class="form-group" >
    <label for="sample_results" class="col-sm-2 control-label">Results: </label>
    <label class="radio-inline">
    <input type="radio" name="sample_results" required value="Negative" id="sample_results"/>Negative. 
    </label>
    <label class="radio-inline">
	<input type="radio" name="sample_results"  value="Positive" id="sample_results"/>Positive.
	</label>
	<label class="radio-inline">
	<input type="radio" name="sample_results"  value="Indeterminate" id="sample_results" />Indeterminate.
	</label>
	<label class="radio-inline">
	<input type="radio" name="sample_results"  value="Not Done" id="sample_results" />Not Done.    
	</label>
	</div>
	<div class="form-group">
    <label for="comments" class="col-sm-2 control-label" >Comments: </label>
    <div class="col-sm-10"> 
      <textarea class="form-control" id="comments" name="comments" rows="6" required placeholder='Comments'></textarea>
    </div>
  </div>
  
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-send"></span> Send Message</button>
    </div>
  </div>
</form>
      
        </div>
      </div>
    </div></div>
    
   <!-- <div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Graph <span class="glyphicon glyphicon-stats" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        </div>
      </div>
    </div></div>-->
    
  </div> 
  
	</div>		
	</div>
	
