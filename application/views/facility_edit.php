<?php

if (isset($all)) {

	$fname = $all -> Facility_name;
	$id = $all -> id;
	$phone=$all-> phone_number;
	$alternats=$all-> alternate;
}
 
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
        <h3 class="panel-title">Facility Edit <span class="glyphicon glyphicon-edit" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
     
		
	 <!-- <legend>Contact Form</legend>-->
         <form class="form-horizontal" method="post" action="<?php echo base_url().'facility_c/save_edits' ?>" role="form">
         	<input type="hidden" name="id" value="<?php echo $id?>" />
         	<div class="form-group">
    <label for="fname" class="col-sm-2 control-label">Facility Name: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="fname" readonly="readonly" name="fname" value="<?php echo $fname; ?>" placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label" >Phone Number: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="pno" required name='pno' onkeypress='validate(event)' maxlength="12" value="<?php echo $phone; ?>" placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="alternate" class="col-sm-2 control-label">Alternate: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="alternate" name='alternate' maxlength="12"  onkeypress='validate(event)' value="<?php echo $alternats; ?>" placeholder="">
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> Edit Facility</button>
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
  
