<?php

$id=$this -> session -> userdata('user_id');
$level=$this -> session -> userdata('user_level');
if(!$id){
	redirect('home_controller');
}
 
 ?>
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
$(function() {
$('#div_county').hide();
$('#div_subCounty').hide();
})
function showFields(){
	var value=document.getElementById('level').value; 
	/*alert(value);*/
	if(value==1 || value==2 || value==5){
	$('#div_county').hide();
    $('#div_subCounty').hide();
    $('#rrt_notify_fields').show();
    if(value==2){
    $('#rrt_notify_fields').hide();	
    }	
	}
	else if(value==3){	
	$('#div_county').show();
	$('#div_subCounty').hide();
	$('#rrt_notify_fields').hide();
	}
	else if(value==4){
	$('#div_subCounty').show();
	$('#div_county').hide();
	$('#rrt_notify_fields').hide();	
	}
	else if(value==6){
	$('#rrt_notify_fields').show();
	$('#div_county').hide();
    $('#div_subCounty').hide();
	}
	else{
	$('#div_county').hide();
    $('#div_subCounty').hide();
    $('#rrt_notify_fields').hide();		
	}
	
}

//Username availability check//
$(document).ready(function () {
	
  var validateUsername = $('#validateUsername');
  $('#username').keyup(function () {
    var t = this; 
    if (this.value != this.lastValue) {
      if (this.timer) clearTimeout(this.timer);
      validateUsername.removeClass('error').html('<img src="../Images/windows_load.GIF" height="16" width="16" /> checking availability...');
     
      var base_url="<?php echo base_url()?>";
      /*alert(base_url);*/
      this.timer = setTimeout(function () {
        $.ajax({
          url: base_url+'user_management/json_response/'+t.value+'/check_username',
          //data: 'action=check_username&username=' + t.value,
          dataType: 'json',
          type: 'post',
          success: function (j) {
          	if(j.ok==false){
            validateUsername.html('<p style="color:red;">'+j.msg+'</p>');
            document.getElementById("submit").disabled = true;
           }else{
           	validateUsername.html('<p style="color:green;">'+j.msg+'</p>');
           	document.getElementById("submit").disabled = false;
           }
          }
        });
      }, 200);
      
      this.lastValue = this.value;
    }
  });
});
  </script>
  <style>
  	input:focus:invalid,
textarea:focus:invalid{
    border:solid 2px #F5192F;
}

input:focus:valid,
textarea:focus:valid{
    border:solid 2px #18E109;
    background-color:#fff;
}
  </style>

	
	<div class="col-md-7" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Register User <span class="glyphicon glyphicon glyphicon-pushpin" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        <?php  if($this->session->flashdata('error_alert')==1){   ?>
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <div style="text-align:center">Report Successfull!!</div>
            </div>
           <?php } ?> 
        <form class="form-horizontal" autocomplete="off" method="post" action="<?php echo base_url().'user_management/admin_submit' ?>" role="form">
         	<div class="form-group">
    <label for="fname" class="col-sm-2 control-label">Names: </label>
    <div class="col-sm-10">
      <input type="text" name="fname" id="fname" class="form-control" required="required"/>
    </div>
  </div>
  <div class="form-group">
    <label for="tell" class="col-sm-2 control-label" >Telephone: </label>
    <div class="col-sm-10">
   <input type="text" name="tell" id="tell" class="form-control" maxlength="12" placeholder="e.g 254720123456" onkeypress='validate(event)' required="required"/>   
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Email: </label>
    <div class="col-sm-10">
      <input type="email" name="email" id="Email" title="Please check that you have entered the email address correctly" placeholder="e.g ddsrmsos@gmail.com" class="form-control" required="required"/>
    </div>
  </div>
  
 <div class="form-group">
    <label for="username" class="col-sm-2 control-label" >Username: </label>
    <div class="col-sm-10">
      <input type="text" name="username" id="username" class="form-control" required="required"/>
      <span id="validateUsername"></span>
    </div>
  </div>
  
  <div class="form-group">
    <label for="type" class="col-sm-2 control-label">Access Level: </label>
    <div class="col-sm-10">
      <select name="type" id="level" class="form-control" onchange="showFields()">
			<?php 
		foreach ($level_l as $level_level) {
			$level=$level_level->level;
			$type=$level_level->id;
			?>
			<option value="<?php echo $type;?>"><?php echo $level;?></option>
		<?php }
		?>
		</select>
    </div>
  </div>
  
  <!-- Start of hidden fields-->

  <div class="form-group" id='div_county'>
    <label for="county" class="col-sm-2 control-label">County: </label>
    <div class="col-sm-10">
      <select name="county" id="county" class="form-control">
		
			<?php foreach ($counties as $county) { ?>
			<option value="<?php echo $county->county;?>"><?php echo $county->county;?></option>
		<?php }
		?>
			</select>
    </div>
  </div>
  
  <div class="form-group" id="div_subCounty">
    <label for="subcounty" class="col-sm-2 control-label">Sub-County: </label>
    <div class="col-sm-10">
      <select name="subcounty" id="subcounty" class="form-control">
			
			<?php foreach ($sub_counties as $subcounties) { ?>
			<option value="<?php echo $subcounties->district;?>"><?php echo $subcounties->district;?></option>
		<?php }
		?>
	 </select>
    </div>
  </div>
  
  <div class="form-group" id='rrt_notify_fields'>
    <label for="rrt_notify" class="col-sm-2 control-label" >RRT Notification: </label>
    <div class="col-sm-10">
      <select name="rrt_notify" id="rrt_notify" class="form-control">
		<option value='0'>No access</option>
		<option value='1'>Receiver</option>
		<option value='2'>Receiver and Sender</option>
		<option value='3'>Sender</option>
	 </select>
    </div>
  </div>
 
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" disabled="disabled" id="submit"><span class="glyphicon glyphicon-send"></span> Register User</button>
    </div>
  </div>
</form>

        </div>
      </div>
    </div></div>
    
  </div> 