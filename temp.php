<?php /*if (!$this -> session -> userdata('user_id')) {
 redirect("user_management/login");
 }*/
 $check=$this->session->userdata('user_id');
//check if the user is logged in
 if($check){
 //retrieve loggin data for the user
 //echo "Passed check";
 $sessionz=$this->session->userdata('session_id');
 //echo $sessionz;
 $fetch= Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM session_activity WHERE session_id='$sessionz'");
 foreach($fetch as $v){
 //echo "session timout but still logged in accepted";
 //echo "active: ".$v['active'];
 if($v['active']==1){
 echo "redirecting";
 redirect('user_management/session_timeout');
 }
 }
 $fetch_logi= Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM logi WHERE user_id='$check' AND status='Active'");
 //if there is loggin data the we have to check if he is registered in the session database or not
 if($fetch_logi){
 //echo "Passed logi";
 foreach($fetch_logi as $value){
// echo "fetching session activity";
 $fetch_session = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM session_activity WHERE user_id='$check' AND logi_id='$value[id]' AND active=0");
//if there is session database data then update the current activity tym else create a table and add data
 $activity_tym=date('Y-m-d G:i:s',time());
 if($fetch_session){
 //echo "session activity data found!!";
 foreach($fetch_session as $k){
   $data=array('last_activity'=>$activity_tym);
	$this -> db -> where('session_id', $this->session->userdata('session_id'),'id',$k['id']);
	$this -> db -> update('session_activity', $data);	
    }
                   }
else{
//echo "session activity data not found";
$session_activity=new session_activity();
				$session_activity->session_id=$this->session->userdata('session_id');
				$session_activity->logi_id=$value['id'];
				$session_activity->user_id=$this->session->userdata('user_id');
				$session_activity->last_activity=$activity_tym;
				/*echo $kemri->incident_id .'<br />';
				echo $kemri->specimen_received;*/
				
				//die();
				$session_activity->save();

}
 }
 }
 }
 
if (!isset($link)) {
	$link = null;
}
if (!isset($quick_link)) {
	$quick_link = null;
}
$access_level = $this -> session -> userdata('user_indicator');
$user_is_administrator = false;
$user_is_moh = false;
$user_is_kemri = false;
$user_is_district = false;
$user_is_county = false;

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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<link rel="icon" href="<?php echo base_url().'Images/coat_of_arms.png'?>" type="image/x-icon" />

<script src="<?php echo base_url().'Scripts/jquery-1.10.2.js'?>" type="text/javascript"></script> 
<script src="<?php echo base_url().'Scripts/jquery-ui.js'?>" type="text/javascript"></script> 
<script src="<?php echo base_url().'Scripts/jquery-ui-timepicker-addon.js'?>" type="text/javascript"></script>

<link href="<?php echo base_url().'CSS/bootstrap.css'?>" type="text/css" rel="stylesheet"/>
<link href="<?php echo base_url().'CSS/bootstrap-theme.css'?>" type="text/css" rel="stylesheet"/>

<link href="<?php echo base_url().'CSS/style.css'?>" type="text/css" rel="stylesheet"/>
<link href="<?php echo base_url().'CSS/extra.css'?>" type="text/css" rel="stylesheet"/>

                                             <!--Scripts-->

 

                                          <!--Bootstrap JS-->
<script src="<?php echo base_url().'Scripts/bootstrap.js'?>" type="text/javascript"></script>

    
    <link href="<?php echo base_url();?>CSS/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <script src="<?php echo base_url();?>Scripts/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>Scripts/dataTables/dataTables.bootstrap.js"></script>




<?php
if (isset($script_urls)) {
	foreach ($script_urls as $script_url) {
		echo "<script src=\"" . $script_url . "\" type=\"text/javascript\"></script>";
	}
}
?>
<?php
if (isset($scripts)) {
	foreach ($scripts as $script) {
		echo "<script src=\"" . base_url() . "Scripts/" . $script . "\" type=\"text/javascript\"></script>";
	}
}
?>
<?php
if (isset($styles)) {
	foreach ($styles as $style) {
		echo "<link href=\"" . base_url() . "CSS/" . $style . "\" type=\"text/css\" rel=\"stylesheet\"/>";
	}
}
?>  
<script type="text/javascript">
	$(document).ready(function() {
		$("#my_profile_link").click(function() {
			$("#logout_section").css("display", "block");
		});

	});

var timer = 0;
function set_interval() {
	// the interval 'timer' is set as soon as the page loads
	timer = setInterval("auto_logout()", 300000);
	// the figure '180000' above indicates how many milliseconds the timer be set to.
	// Eg: to set it to 5 mins, calculate 3min = 3x60 = 180 sec = 180,000 millisec.
	// So set it to 180000
}

function reset_interval() {
	//resets the timer. The timer is reset on each of the below events:
	// 1. mousemove   2. mouseclick   3. key press 4. scroliing
	//first step: clear the existing timer

	if(timer != 0) {
		clearInterval(timer);
		timer = 0;
		// second step: implement the timer again
		timer = setInterval("auto_logout()", 10000);
		// completed the reset of the timer
	}
}

function auto_logout() {
	var base_url = $("#base_url").val();
	// this function will redirect the user to the logout script
	window.location ="user_management/logout";
}

function logout() {
	var base_url = $("#base_url").val();
	// this function will redirect the user to the logout script
	window.location =base_url+"user_management/logout";
}


</script>
</head>

<body >
	
<div class="row"><!--main row-->
	<div class="col-lg-12">
	<!--navbar-fixed-top-->

	<div class="navbar navbar-default navbar-fixed-top">
	<div class="row" style="background-color: white; border-bottom: 1px solid silver;"><!--top row-->
		<div class="col-lg-12">
	<div class="row">
		<div class='col-lg-1'>
<img src="http://localhost/msos/Images/logo.png" alt="" class="img-rounded">
      </div>
       
       <div class='col-lg-4'>
                <div id="system_title">
					<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">Division of Disease Survillance and Response </span>
					<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">SMS Alert System</span>
					<span style="display: block; font-size: 14px; margin:2px; font-style:italic;">SATREPS Project</span>
					
				</div>
				
				</div>
				
				<div class="col-lg-1">
				<img src="http://localhost/msos/Images/beta.png" alt="" class="img-thumbnail">
				</div>
				
				<div class="col-lg-4">
					
				<img src="http://localhost/msos/Images/partners.png"  alt="" class="img-rounded">	
				
				</div>
		
		
	</div>
	

	<div class="row">
   
   <div class='col-lg-12'>
   
	<div class='col-lg-4'>
		<!--<div class="banner_text" style="float: left; margin-top: 2%;"><?php echo $banner_text; ?></div>-->
				
	</div>
	
	<div class="col-lg-8">
 <div id="top_menu"> 

 	<?php
	//Code to loop through all the menus available to this user!
	//Fet the current domain
	$menus = $this -> session -> userdata('menu_items');
	$current = $this -> router -> class;
	$counter = 0;
?>
 	<a href="<?php echo base_url(); ?>home_controller" class="top_menu_link  first_link <?php
	if ($current == "home_controller") {echo " top_menu_active ";
	}
?>">Home </a>
<?php 
if($user_is_administrator){
?>


<a href="<?php echo base_url(); ?>facility_c/all_facilities" class="top_menu_link  first_link <?php
if ($current == "facility_c") {echo " top_menu_active ";
}
?>">Facility List</a>

<?php }
 ?>
 
<?php 
if($user_is_moh){
?>
<a href="<?php echo base_url(); ?>facility_c/all_facilities" class="top_menu_link  first_link <?php
if ($current == "facility_c") {echo " top_menu_active ";
}
?>">Facility List</a>
<?php } ?>

<?php 
if($this -> session -> userdata('user_indicator')=="District Administrator"){
?>
<a href="<?php echo base_url(); ?>facility_c/district_facilities" class="top_menu_link  first_link <?php
if ($current == "facility_c") {echo " top_menu_active ";
}
?>">Facility List</a>
<?php } ?>


<a href="<?php echo base_url(); ?>sms/index" class="top_menu_link  first_link <?php
if ($current == "sms") {echo " top_menu_active ";
}
?>">Send SMS</a>

<a href="<?php echo base_url(); ?>c_disease/disease_list" class="top_menu_link  first_link <?php
if ($current == "c_disease") {echo " top_menu_active ";
}
?>">Disease List</a>
<a ref="#" class="top_menu_link" id="my_profile_link">IDSR SMS Alert <?php if(!$this -> session -> userdata('user_id')){ echo '';}else{?> | <?php echo $access_level?> <?php } ?></a>
 </div>
</div><!-- end of column div-->

</div>
 </div>
 
 <div class="row">
 	<div class="col-lg-12">
 		
 	<div class="col-lg-7">
 	<div class="banner_text" style="float: left; margin-top: 2%;"><?php echo $banner_text; ?></div>
 	</div>
 	<div class="col-lg-5">
<label style=" font-size:20px; float: right; margin-right: 40px; margin-top: 60px;"><?php if(!$this -> session -> userdata('user_id')){?><a  class="link" target="_self" href="<?php echo base_url(); ?>user_management/login">Login</a><?php }
	else{
?>Welcome : <?php echo $this -> session -> userdata('full_name'); ?> <?php echo $this -> session -> userdata('inames'); ?>
 <a  class="link" href="<?php echo base_url(); ?>user_management/logout">Logout?</a>|<a  class="link" href="<?php echo site_url('user_management/Change_pass/'.$this -> session -> userdata('user_id'))?>">Change Password</a>
 <?php } ?>
	
</label>
</div>
</div>

</div>
</div>

</div><!--end of top row-->
</div>
	
	
	<!--End of topnav-->
<!--middle of the site interface-->

<div class='container-fluid '> 
<div style=" margin: auto;" class='row '> 
	<div class="col-lg-12">
		
	<div class="row">
		<div class="col-lg-12">
	<div id="sub_menu">
		<?php if($user_is_administrator){?>
			
	
	<a style="width:150px !important" href="<?php echo base_url(); ?>user_management/moh" class="top_menu_link sub_menu_link first_link  <?php
	if ($current == "user_management") {echo "top_menu_active";
	}
	?>">Register Users</a>
	<a style="width:150px !important" href="<?php echo base_url(); ?>user_management/users_facility" class="top_menu_link sub_menu_link first_link  <?php
	if ($current == "user_management") {echo "top_menu_active";
	}
	?>">Manage Users</a>
      <a style="width:150px !important" href="<?php echo base_url(); ?>a_management/sendSMS" class="top_menu_link sub_menu_link first_link  <?php
    if ($current == "home_contoller") {echo "top_menu_active";
    }
    ?>">Send Bulk SMS</a>
	
	<?php }
		if($user_is_kemri){
 ?>
	<a style="width:150px !important" href="<?php echo base_url(); ?>a_management/confirm" class="top_menu_link sub_menu_link first_link  <?php
	if ($current == "a_management") {echo "top_menu_active";
	}
	?>">Confirm Alert</a>
	<?php } ?>
	<?php 
		if($user_is_kemri){
 ?>
	<a style="width:150px !important" href="<?php echo base_url(); ?>a_management/kemri_table_view" class="top_menu_link sub_menu_link first_link  <?php
	if ($current == "a_management") {echo "top_menu_active";
	}
	?>">Response Views</a>
	<?php } ?>	
	<?php if($user_is_district){?>
		<a href="<?php echo base_url(); ?>c_incidents/all_diseases" class="top_menu_link  sub_menu_link <?php
		if ($current == "c_incidents") {echo " top_menu_active ";
		}
	?>">District Incident List</a>
<?php } ?>
<?php if($user_is_county){?>
		<a href="<?php echo base_url(); ?>c_incidents/all_diseases" class="top_menu_link  sub_menu_link <?php
		if ($current == "c_incidents") {echo " top_menu_active ";
		}
	?>">County Incident List</a>

<?php } ?>
</div> 
</div>
</div>

<div class="row"> <div class="col-lg-12"><?php $this -> load -> view($content_view); ?></div></div> 

<div class="row"><div id="bottom_ribbon"><div id="footer"><?php $this -> load -> view("footer_v"); ?></div></div></div>
    
    </div></div></div>
    
    </div>
 </div><!--end of main row-->
</body>
</html>
