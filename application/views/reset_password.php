<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>mSOS | Password Reset</title>

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
		<link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" type="text/css" rel="stylesheet"/>
		<!--<script src="<?php echo base_url().'assets/scripts/alert.js'?>" type="text/javascript"></script>
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<style>
			h2 {
				font-size: 1.6em;
			}
		</style>
		<script>
			var Timer;
var TotalSeconds=10;


function CreateTimer() {
	var TimerID=$('#timer');
	var Time=10;
Timer = $(TimerID);
TotalSeconds = Time;

UpdateTimer()
window.setTimeout("Tick()", 1000);
}

function Tick() {
	TotalSeconds -= 1;
	if(TotalSeconds==-1){
		window.location.href = "<?php echo base_url().'home_controller' ?>";
	}else{
UpdateTimer()
window.setTimeout("Tick()", 1000);
}
}

function UpdateTimer() {
Timer.html("<strong>"+TotalSeconds+"<strong/>");
}
		</script>

	</head>
	<body data-spy="scroll" data-target=".subnav" data-offset="50" screen_capture_injected="true" style="padding: 0;">
		<div class="navbar  navbar-static-top" id="top-panel">

			<img style="max-width: 6em; float: left; margin-right: 2px;" src="<?php echo base_url(); ?>Images/logo.png" class="img-responsive " alt="Responsive image">

			<div id="logo_text" style="margin-top: 0%">
				<span style="font-size: 1.20em;font-weight: bold; ">Division of Disease Survillance and Response</span>
				<br />
				<span style="font-size: 0.95em;font-weight: bold;">SMS Alert System</span>
				<br/>
				<span style="font-size: 0.95em;">SATREPS Project</span>
			</div>

		</div>
		<div class="container-fluid" id="success_pass" style="display:none">

			<div class="row">
				<div class="col-md-4" style="">

				</div>
				<div class="col-md-4" style="">
 
					<div class="alert alert-danger alert-dismissable" style="text-align:center;">
					Password change successfull! Please use this <a href="<?php echo base_url().'user_management/login' ?>">link</a> to login.
						
					</div>
				</div>
				<div class="col-md-4" style="">

				</div>
			</div>

		</div>
		<?php if($token_control=="Invalid"){ ?>
		<div class="container-fluid">

			<div class="row">
				<div class="col-md-4" style="">

				</div>
				<div class="col-md-4" style="">
 
					<div class="alert alert-danger alert-dismissable" style="text-align:center;">
						<?php echo $error_message ?>  You will be redirected in <p id='timer'><strong>10</strong></p>seconds.
						<script>
							CreateTimer()
						</script>
					</div>
				</div>
				<div class="col-md-4" style="">

				</div>
			</div>

		</div>
		<?php } else if($token_control=="Valid"){ ?>
		<div class="container" style="margin-top: 0%;" id="containerlogin">

			<div class="row" style="">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<div class="">
						<div id="contain_login" class="">
							<h2><span style="margin-right: 0.5em;" class="glyphicon glyphicon-lock"></span>User Password Reset</h2>
							<form>
							<div id="login">

								<div class="form-group" style="margin-top: 2.3em;">
									<input type="password" class="form-control input-lg" name="pass" id="pass" onkeyup="enable_confim()" placeholder="Please enter New Password" required="required">
								</div>

								<div class="form-group" style="margin-bottom: 2em;">

									<div class='input-group date'>
										<span class="input-group-addon"><span id="checker" class="glyphicon glyphicon-remove"></span></span>
										<input type="password" class="form-control input-lg" name="newpass" id="newpass" onkeyup="enable_confim()"  placeholder="Please enter the new password again" required="required">

									</div>
								</div>

								<button type="button" onclick="submit_form()" class="btn btn-primary " disabled="" name="submit" id="submit" style="margin-bottom: 3%;">
									<span class="glyphicon glyphicon-edit"></span> Reset Password
								</button>

								<!-- <a class="" style="margin-left: 2%;" href="<?php echo base_url().'user/forgot_password'?>" id="modalbox">Can't access your account ?</a>-->

							</div>

							<?php

							echo form_close();
							?>
						</div>
					</div>
				</div>
				<div class="col-md-3"></div>

			</div><!-- .row -->
		</div><!-- .container -->
		<?php } ?>
		<div id="footer">
			<div class="container">
				<p class="text-muted">
					Government of Kenya &copy <?php echo date('Y'); ?>. All Rights Reserved
				</p>
			</div>
		</div>
		<!-- JS and analytics only. -->
		<!-- Bootstrap core JavaScript

		================================================== -->
		<script>
			$(document).ready(function() {
					
			});

            
			function enable_confim() {
				var password_length = $('#pass').val();
				var confirm_pass = $('#newpass').val();
				if (password_length == confirm_pass) {

					document.getElementById("submit").disabled = false;
					document.getElementById("checker").setAttribute('class', 'glyphicon glyphicon-ok');

				} else {

					document.getElementById("submit").disabled = true;
					document.getElementById("checker").setAttribute('class', 'glyphicon glyphicon-remove');
				}

			}
			
			function submit_form(){
				var action_url="<?php echo base_url().'user_management/reset_password_submit' ?>";
				var pass = $('#pass').val();
				var confirm_pass = $('#newpass').val();
				var reset_token="<?php echo $this->uri->segment(3); ?>";
				var post_data={"pass":pass,"new_pass":confirm_pass,"token_key":reset_token};
			$.ajax({
				url: action_url,
				data: post_data,
				dataType: 'json',
				type: 'post',
				success: function (j) {
				$('#success_pass').show();
				$('#containerlogin').hide();
				},
				error: function (j){
					
					
					
					}
				});	
			}

		</script>

	</body>
</html>
