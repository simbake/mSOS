<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>mSOS | Login</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <link href="<?php echo base_url().'assets/css/style.css'?>" type="text/css" rel="stylesheet"/>
    <link rel="icon" href="<?php echo base_url().'assets/img/coat_of_arms.png'?>" type="image/x-icon" />
    <link href="<?php echo base_url().'assets/metro-bootstrap/docs/font-awesome.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/metro-bootstrap/css/metro-bootstrap.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/boot-strap3/css/bootstrap.min.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/boot-strap3/css/bootstrap-responsive.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/css/normalize.css'?>" type="text/css" rel="stylesheet"/>
	<script src="<?php echo base_url().'assets/scripts/jquery.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/jquery-1.8.0.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/boot-strap3/js/bootstrap.min.js'?>" type="text/javascript"></script>
	<!--<script src="<?php echo base_url().'assets/scripts/alert.js'?>" type="text/javascript"></script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
    	h2{
    		font-size:1.6em;
    	}
    </style>
    <script type="text/javascript">
function changeHashOnLoad() {
     window.location.href += "#";
     setTimeout("changeHashAgain()", "50"); 
}

function changeHashAgain() {
  window.location.href += "1";
}

var storedHash = window.location.hash;
window.setInterval(function () {
    if (window.location.hash != storedHash) {
         window.location.hash = storedHash;
    }
}, 50);
</script> 
  </head>  
  <body data-spy="scroll" data-target=".subnav" data-offset="50" screen_capture_injected="true" style="padding: 0;">
	<div class="navbar  navbar-static-top" id="top-panel">
      
  
	<img style="max-width: 6em; float: left; margin-right: 2px;" src="<?php echo base_url();?>Images/logo.png" class="img-responsive " alt="Responsive image">

				<div id="logo_text" style="margin-top: 0%">
					<span style="font-size: 1.20em;font-weight: bold; ">Division of Disease Survillance and Response</span><br />
					<span style="font-size: 0.95em;font-weight: bold;">SMS Alert System</span><br/>
					<span style="font-size: 0.95em;">SATREPS Project</span>	
				</div>
				
				
				
				
	</div>
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-md-4" style="">
				
			</div>
			<div class="col-md-4" style="">
				
				<?php  $popup=$this->session->flashdata("login_check");
if ($popup=='1') {
	
	echo	'<div class="alert alert-danger alert-dismissable" style="text-align:center;"> Error! Wrong Credentials! Try Again.
<button type="button" class=" close" data-dismiss="alert" aria-hidden="true">×</button>
','</div>';
}
unset($popup);
 ?>
			</div>
			<div class="col-md-4" style="">
				
				
			</div>
		</div>
		
	</div>
	
	
  	
  		   
<div class="container" style="margin-top: 0%;" id="containerlogin">
      <?php
if (isset($_POST['submit'])) {
$salt = '#*seCrEt!@-*%';
$old_pass=@$_POST['oldpass'];
$value=( md5($salt . $old_pass));
$id=$this -> session -> userdata('user_id');
//@$check;
$check=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT password from user WHERE password='$value' AND id='$id'");
if(!$check){
echo "<div class='alert alert-warning alert-dismissable'>
  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
  <div style='text-align:center;'><strong>Notice!</strong> The Old Password is incorrect. Please try again.</div>
</div>";
}
else{

$new_pass=$_POST['newpass'];
$retype_pass=$_POST['password1'];

if($new_pass==$retype_pass){
$pass1=Doctrine::getTable('user')->findOneById($id);
		//$password=$pass1->password;
		//$email=$pass1->email;
		//$value_save=( md5($salt . $new_pass));
		$pass1->password=$new_pass;
		$pass1->save();
		
		$id = $this -> session -> userdata('user_id');
		$time = date("Y-m-d G:i:s", time());
		$status = "Inactive";
		$q = Doctrine_Query::create() -> update('logi') -> set('status', '?', "$status")->set('t_logout', '?', "$time") -> where("user_id='$id' AND status='Active'");
		$q -> execute();

		$data = array();
		$this -> session -> sess_destroy();
		redirect("user_management");
		//echo "<script>alert('HOHOHO complete...')</script>";
		}//end of checking new and retype password if statement
		else{
			
		echo "<div class='alert alert-warning alert-dismissable'>
  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
 <div style='text-align:center;'> <strong>Notice!</strong> New and retyped passwords do not match. Please Try again.</div>
</div>";
			
		}

}



}else{
	echo "<div class='alert alert-warning alert-dismissable'>
  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
  <div style='text-align:center;'><strong>Default Password Detected!</strong> A Password change is required to continue.</div>
</div>  ";
}

?>
              
 <div class="row">
        <div class="col-md-3"></div>
  		<div class="col-md-6"> 
  			<div class="">
 <div id="contain_login" class="">
  	<h2><span style="margin-right: 0.5em;" class="glyphicon glyphicon-lock"></span>User Password Change</h2>	
  	<?php 
    
	 echo form_open(''); ?>
<div id="login" >

		
  <div class="form-group" style="margin-top: 2.3em;">
    <!--<label for="exampleInputEmail1"> Username</label>-->
    <input type="password" class="form-control input-lg" name="oldpass" id="oldpass" placeholder="Enter Old Password" required="required">
  </div>
  <div class="form-group" style="margin-bottom: 2em;">
    <input type="password" class="form-control input-lg" name="newpass" id="newpass" placeholder="Enter New Password" required="required">
  </div>
  
  <div class="form-group" style="margin-bottom: 2em;">
    <input type="password" class="form-control input-lg" name="password1" id="password1" placeholder="ReEnter New Password" required="required">
  </div>
  
   <button type="submit" class="btn btn-primary " name="submit" id="submit" style="margin-bottom: 3%;"><span class="glyphicon glyphicon-edit"></span> Change</button>
   
 <!-- <a class="" style="margin-left: 2%;" href="<?php echo base_url().'user/forgot_password'?>" id="modalbox">Can't access your account ?</a>-->
		
		
</div>

<?php 

		echo form_close();
		?>
</div></div></div>
  		<div class="col-md-3"></div>  
   
 </div><!-- .row -->
 </div><!-- .container -->
 <div id="footer">
      <div class="container">
        <p class="text-muted"> Government of Kenya &copy <?php echo date('Y');?>. All Rights Reserved</p>
      </div>
    </div>
      <!-- JS and analytics only. -->
    <!-- Bootstrap core JavaScript
    	
================================================== -->
		<script>
	$(document).ready(function() {});
		
		</script>

</body>
</html>
