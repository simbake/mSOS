<?php /*if (!$this -> session -> userdata('user_id')) {
 redirect("user_management/login");
 }*/
 
 
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
<link href="<?php echo base_url().'CSS/style.css'?>" type="text/css" rel="stylesheet"/> 
<link href="<?php echo base_url().'CSS/extra.css'?>" type="text/css" rel="stylesheet"/> 
<link href="<?php echo base_url().'CSS/jquery-ui.css'?>" type="text/css" rel="stylesheet"/> 
<script src="<?php echo base_url().'Scripts/jquery.js'?>" type="text/javascript"></script> 
<script src="<?php echo base_url().'Scripts/jquery-ui.js'?>" type="text/javascript"></script> 

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

</script>
</head>

<body>
<div id="wrapper">
	<div id="top-panel1" style="margin:0px;">
	<div class="partners"></div>
	</div>
	<div id="top-panel" style="margin-top:100px;">
		

		<div class="logo_template">
			<a class="logo_template" href="<?php echo base_url(); ?>" ></a> 
			<div class="logo"></div>
</div>

				<div id="system_title">
					<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">Division of Disease Survillance and Response </span>
					<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">SMS Alert System</span>
					
				</div>
				<div><div class="banner_text" style="float: left"><?php echo $banner_text; ?></div>
				
	</div>
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

<?php } ?>
<?php 
if($user_is_moh){
?>
<a href="<?php echo base_url(); ?>facility_c/all_facilities" class="top_menu_link  first_link <?php
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
<label style=" font-size:20px; float: right; margin-right: 40px; margin-top: 40px;"><?php if(!$this -> session -> userdata('user_id')){?><a  class="link" target="_self" href="<?php echo base_url(); ?>user_management/login">Login</a><?php }
	else{
?>Welcome : <?php echo $this -> session -> userdata('full_name'); ?> <?php echo $this -> session -> userdata('inames'); ?>
 <a  class="link" href="<?php echo base_url(); ?>user_management/logout">Logout?</a>|<a  class="link" href="<?php echo site_url('user_management/user_reset/'.$this -> session -> userdata('identity'))?>">Change Password</a>
 <?php } ?>
	
</label>
</div>

<div id="inner_wrapper"> 
	<div id="sub_menu">
		<?php if($user_is_administrator){?>
			
	
	<a style="width:150px !important" href="<?php echo base_url(); ?>user_management/moh" class="top_menu_link sub_menu_link first_link  <?php
	if ($current == "user_management") {echo "top_menu_active";
	}
	?>">Register Users</a>

	
	<?php }
		if($user_is_kemri){
 ?>
	<a style="width:150px !important" href="<?php echo base_url(); ?>a_management/confirm" class="top_menu_link sub_menu_link first_link  <?php
	if ($current == "a_management") {echo "top_menu_active";
	}
	?>">Confirm Alert</a>
	<?php } ?>
	<?php if($user_is_district){?>
		<a href="<?php echo base_url(); ?>c_incidents/dist_orders" class="top_menu_link  sub_menu_link <?php
		if ($current == "c_incidents") {echo " top_menu_active ";
		}
	?>">District Incident List</a>
<?php } ?>
<?php if($user_is_county){?>
		<a href="<?php echo base_url(); ?>c_incidents/county_orders" class="top_menu_link  sub_menu_link <?php
		if ($current == "c_incidents") {echo " top_menu_active ";
		}
	?>">County Incident List</a>

<?php } ?>
	</div>

<div id="main_wrapper"> 
 
<?php $this -> load -> view($content_view); ?>
 
 
 
<!-- end inner wrapper -->
  <!--End Wrapper div--></div>
    <div id="bottom_ribbon"><div id="footer"><?php $this -> load -> view("footer_v"); ?></div></div>
</body>
</html>
