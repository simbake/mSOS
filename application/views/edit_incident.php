<?php

 
if (isset($all)) {

	$age = $all -> Age;
	$disease = $all -> Disease_id;
	$incidents = $all -> p_id;
	$sex = $all -> Sex;
	$status = $all -> Status;
	$id = $all -> id;
}
$idd=$this -> session -> userdata('user_id');
$level=$this -> session -> userdata('user_level');
?>

<script>
  		function validate(evt) {
 var theEvent = evt || window.event;
 var key = theEvent.keyCode || theEvent.which;
 key = String.fromCharCode( key );
 var regex = /[0-9]|\./;
 if( !regex.test(key) ) {
   theEvent.returnValue = false;
   if(theEvent.preventDefault) theEvent.preventDefault();
 }
}
  </script>

	 <div class="col-md-7" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Edit Incident <span class="glyphicon glyphicon-edit" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
     
	 <!-- <legend>Contact Form</legend>-->
         <form class="form-horizontal" method="post" action="<?php echo base_url().'c_incidents/save_edits' ?>" role="form">
         	<div class="form-group">
    <label for="fname" class="col-sm-2 control-label">Incident ID: </label>
    <div class="col-sm-10">
      <input type="text" readonly="readonly" class="form-control" id="fname" value="<?php echo $incidents; ?>" required name="fname" placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="age" class="col-sm-2 control-label" >Age: </label>
    <div class="col-sm-10">
      <input type="number" value="<?php echo $age; ?>" onkeypress='validate(event)' class="form-control" id="age" required name='age'  placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="sex" class="col-sm-2 control-label" >Sex: </label>
    <div class="col-sm-10">
      <input type="text" value="<?php echo $sex; ?>" class="form-control" id="sex" required name='sex'  placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="status" class="col-sm-2 control-label" >Status: </label>
    <div class="col-sm-10">
      <input type="text" value="<?php echo $status; ?>" class="form-control" id="status" required name='status'  placeholder="">
    </div>
  </div>
 <input type="hidden" name="id" id="id" value="<?php echo $this->uri->segment(3) ?>" />
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> Edit Incident</button>
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
  
