<script>
  	
	function testAge(age){
var n=age.value.replace(/[^\d]+/g,'');// replace all non digits
age.value=n;
}

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
        <h3 class="panel-title">Report Suspected Case <span class="glyphicon glyphicon glyphicon-pushpin" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        <?php  if($this->session->flashdata('error_alert')==1){   ?>
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="text-align:center">Report Successfull!!</div>
            </div>
           <?php } ?> 
        <form class="form-horizontal" method="post" action="<?php echo base_url().'c_incidents/submit' ?>" role="form">
         	<div class="form-group">
    <label for="fname" class="col-sm-2 control-label">Facility Name: </label>
    <div class="col-sm-10">
      <select class="form-control" name="fname" required>
      	<?php 
foreach ($facility as $facility) {
$level=$facility->Facility_name;
$type=$facility->Facility_code;
?>
<option value="<?php echo $type;?>"><?php echo $level;?></option>
<?php }
?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="disease" class="col-sm-2 control-label" >Suspected Disease: </label>
    <div class="col-sm-10">
      <select class="form-control" name="disease" required>
      	<?php 
foreach ($diseases as $diseasez) {
echo	$level=$diseasez->Full_Name;
$id=$diseasez->id;
?>
<option value="<?php echo $id;?>"><?php echo $level;?></option>
<?php }
?>
      	
      </select>
    </div>
  </div>
  
  <div class="form-group">
    <label for="message" class="col-sm-2 control-label">Age: </label>
    <div class="col-sm-10">
      <input type="number" name="age" id="age" class="form-control" onkeypress='validate(event)' required="required"/>
    </div>
  </div>
  <div class="form-group">
    <label for="message" class="col-sm-2 control-label">Sex: </label>
    <div class="col-sm-10">
      <div class="radio">
  <div class="radio-inline">
    <input type="radio" name="sex" class="radio-inline" id="optionsRadios2" required="required" value="M">
    Male
  </div>
  <div class="radio-inline">
    <input type="radio" name="sex" class="radio-inline" id="optionsRadios2" value="F">
    Female
  </div>
</div>
    </div>
  </div>
  <div class="form-group">
    <label for="message" class="col-sm-2 control-label">Status: </label>
    <div class="col-sm-10">
      <div class="radio">
  <div class="radio-inline">
    <input type="radio" name="status" class="radio-inline" id="optionsRadios2" required="required" value="A">
    Alive
  </div>
  <div class="radio-inline">
    <input type="radio" name="status" class="radio-inline" id="optionsRadios2" value="D">
    Dead
  </div>
</div>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-send"></span> Report Case</button>
    </div>
  </div>
</form>

        </div>
      </div>
    </div></div>
    
  </div> 
