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
					<span style="font-size: 1.20em;font-weight: bold; ">Disease Survillance and Response - Ministry of Health</span><br />
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
	
	
  	
  		   
<div class="container" style="margin-top: 3%;" id="containerlogin">
      
                
 <div class="row">
        <div class="col-md-3"></div>
  		<div class="col-md-6"> 
  			<div class="">
  <div id="contain_login" class="">
  	<h2><span style="margin-right: 0.5em;" class="glyphicon glyphicon-lock"></span>Forgot Password?</h2>	
  	<?php 
    
	 echo form_open('user_management/forgot_pass_submit'); ?>
<div id="login" >

		
  <div class="form-group" style="margin-top: 2.3em;">
    <!--<label for="exampleInputEmail1"> Username</label>-->
    <div class='input-group date'>
    	<span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-user"></span>
      </span>
    <input type="email" class="form-control input-lg" name="email_address" id="email_address" placeholder="Please Enter Your Email" required="required">
      
      </div>
  </div>
   <button type="submit" class="btn btn-primary " name="register" id="register" style="margin-bottom: 3%;"><span class="glyphicon glyphicon-log-in"></span> Submit</button>
   
   
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
