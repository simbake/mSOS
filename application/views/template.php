<?php
//session timeout check
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
if (isset($scripts)) {
	foreach ($scripts as $script) {
		echo "<script src=\"" . base_url() . "Scripts/" . $script . "\" type=\"text/javascript\"></script>";
	}
}


include ("Scripts/FusionCharts/FusionCharts.php");

$id=$this -> session -> userdata('user_id');
$level=$this -> session -> userdata('user_level');
 /*if(isset($map['js'])){
 	echo $map['js'];} */
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

if($access_level=="Administrator" || $access_level=="MOH" ){
	
	            $incidentz= Incidence::get_incidence_count();
				$diseasez= Incidence::get_disease_count();
				$confirmz= Incidence::confirm();
	 
}
else if($access_level=="District Administrator"){
	$district = $this -> session -> userdata('district');
	$incidentz= Incidence::get_incidence_count_district($district);
		$diseasez= Incidence::get_disease_count_district($district);
		$confirmz = Incidence::confirm_district($district);
}
else if($access_level=="County Administrator"){
	    $county = $this -> session -> userdata('county');
	    $incidentz= Incidence::get_incidence_count_county($county);
		$diseasez= Incidence::get_disease_count_county($county);
		$confirmz= Incidence::confirm_county($county);
	
}
else{
	            $incidentz= Incidence::get_incidence_count();
				$diseasez= Incidence::get_disease_count();
				$confirmz= Incidence::confirm();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>mSOS | <?php echo $title;?> </title>    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url().'assets/img/coat_of_arms.png'?>" type="image/x-icon" />
    <link href="<?php echo base_url().'assets/css/style.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/css/normalize.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/css/dashboard.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/css/jquery-ui-1.10.4.custom.min.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/boot-strap3/css/bootstrap.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/boot-strap3/css/bootstrap-responsive.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/css/font-awesome.min.css'?>" type="text/css" rel="stylesheet"/>
  <script src="<?php echo base_url().'assets/scripts/jquery.js'?>" type="text/javascript"></script>
   
   <link href="<?php echo base_url().'assets/css/datepicker.css'?>" type="text/css" rel="stylesheet"/>
   <script src="<?php echo base_url().'assets/scripts/bootstrap-datepicker.js'?>" type="text/javascript"></script>
   
	<link href="<?php echo base_url().'assets/datatable/TableTools.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/datatable/dataTables.bootstrap.css'?>" type="text/css" rel="stylesheet"/>

  <!--clock items-->
  <!--<link href="<?php echo base_url().'assets/css/clock.css'?>" type="text/css" rel="stylesheet"/>
  <script src="<?php echo base_url() ?>assets/scripts/2.0.0/moment.min.js"></script>
  <script src="<?php echo base_url() ?>assets/scripts/clock.js"></script>-->
  <!--End clock items-->
	<!-- <link href="<?php echo base_url().'assets/metro-bootstrap/docs/font-awesome.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/metro-bootstrap/css/metro-bootstrap.css'?>" type="text/css" rel="stylesheet"/>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript">
    </script>
    <style>
.panel-success>.panel-heading {
color: white;
background-color: #528f42;
border-color: #528f42;
border-radius:0;

}
.navbar-default {
background-color: white;
border-color: #e7e7e7;
}
</style>

<script>
  			$(function() {
  	
  	   $( "#month" ).combobox({
        	selected: function(event, ui) {
        		
           var data =$("#year").val();
           var month =$("#month").val();
           //var name =encodeURI($("#desc option:selected").text());
          
          
        var url = "<?php echo base_url().'report_management/monthly' ?>
			"
			$.ajax({
			type: "POST",
			data: "year="+data+"&month="+month,
			url: url,
			beforeSend: function() {
			$("#contentlyf").html("");
			},
			success: function(msg) {
			$("#contentlyf").html(msg);

			}
			});
			return false;

			}
			});

			$("#disease").combobox({
			selected: function(event, ui) {

			var dyear =$("#dyear").val();
			var dmonth =$("#dmonth").val();
			var dise=$("#disease").val();
			var names =encodeURI($("#disease option:selected").text());

			var url = "
<?php echo base_url().'report_management/daily' ?>
	"
	$.ajax({
	type: "POST",
	data: "year="+dyear+"&month="+dmonth+"&disease="+dise+"&name="+names,
	url: url,
	beforeSend: function() {
	$("#contently").html("");
	},
	success: function(msg) {
	$("#contently").html(msg);

	}
	});
	return false;

	}
	});

	});
  </script>
  </head>  
  <body style="" screen_capture_injected="true" onload="set_interval()" onmouseover="reset_interval()" onclick="reset_interval()">
    <!-- Fixed navbar -->
   <div class="navbar navbar-default navbar-fixed-top" id="">
   <div class="container" style="width: 100%;">
        <div class="navbar-header " > 
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         
          <a style="margin-top: auto;" href="<?php if(isset($ebola_admin)){echo base_url().'Ebola_controller';}else{echo base_url().'home_controller';}?>">
          	<img style="display:inline-block; width:auto%; width: 100px; height: 16%;margin-top:-10%" src="<?php echo base_url()?>Images/msos_logo.png" class="img-rounded img-responsive " alt="Responsive image" id="logo" >
          	</a>
				<div id="logo_text" style="display:inline-block; margin-top: 0%">
					<span style="font-size: 1.20em;font-weight: bold; ">Disease Surveillance and Response Unit - Ministry of Health</span><br />
					<span style="font-size: 0.95em;font-weight: bold;">Mobile SMS Based Disease Outbreak ALert System</span><br/>
					<span style="font-size: 0.95em;">SATREPS Project</span><br />	
					<span style="font-size: 0.95em; font-weight: bold;">Developed By:</span><br />
					<span>
					
					<a style="" href="http://www.strathmore.edu" target="about_blank"><img src="<?php echo base_url() ?>Images/strath_logo.png" alt="" class="img-thumbnail img-responsive"></a>
                   
                   </span>
				</div>
				
						
				
        </div>
        

        <div class="navbar-collapse collapse" style="font-weight: bold" id="navigate">
          
          <div class="nav navbar-nav navbar-right">
          	
          	  <div class="row">
          		
          	<div class="col-md-12">
          	<div style="float: right;"><img src="<?php echo base_url() ?>Images/partners.png"  alt="" class="img-rounded img-responsive"></div>&nbsp;&nbsp;&nbsp;
            </div>
            
          	</div>
          	
          <div class="row">
          	<div class="col-md-12">
          	<ul class="nav navbar-nav navbar-right">
     
      <?php if($user_is_kemri==true && isset($ebola_admin)){ ?>
       
      <?php } else{ ?>
      <li class=""><a href="<?php echo site_url().'home_controller';?>" class="">HOME</a> </li>
      <?php } ?>
       <?php  if($user_is_administrator || $user_is_moh || $user_is_kemri){  ?>
       	 <li class=""><a style="background-color: red;" href="<?php echo site_url().'Ebola_controller';?>" class="">Ebola Information</a> </li> 
       	<?php } ?>
       <?php  if(($user_is_administrator || $user_is_district || $user_is_county || $user_is_moh) && !isset($ebola_admin)){  ?>
       <li><a href="<?php echo site_url().'facility_c/all_facilities';?>" class=" ">Facility List</a> </li> 
       <?php  } ?>
       <?php if(!isset($ebola_admin)){ ?><li><a href="<?php echo site_url().'sms/index ';?>" class=" ">Send SMS</a> </li> 
       <li><a href="<?php echo site_url().'c_disease/disease_list';?>" class=" ">Disease List</a> </li> <?php } ?>
       <?php if($user_is_administrator && !isset($ebola_admin)){  ?>
       	<li><a href="<?php echo site_url(); ?>redirect/leave_view/server_monitor" class=" ">Server Monitor</a> </li>
       	<?php } ?>
       <!--<li><a href="" class=" ">User </a></li> -->  
	 

           <?php if($this->session->userdata("user_id")) {    ?>
           	
            <li class="dropdown ">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user" ></span><?php echo $this -> session -> userdata('full_name');?> | <?php echo $this -> session -> userdata('user_indicator');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a style="background: whitesmoke;color: black !important" href="<?php echo site_url("user_management/Change_pass");?>"><span class="glyphicon glyphicon-pencil" style="margin-right: 2%; "></span>Change password</a></li>  
                <li class="divider" style="color:#356635"></li>            
                <li><a style="background: whitesmoke;color: black !important" href="<?php echo site_url("user_management/logout");?>" ><span class="glyphicon glyphicon-off" style="margin-right: 2%;"></span>Log out</a></li>               
              </ul>
            </li>
            
            <?php } else{  ?>
            <li><a href="<?php echo site_url().'User_Management/login';?>" class=" "><span class="glyphicon glyphicon-user" ></span>Login</a> </li> 	
            <?php  }  ?>
            
          </ul>
          </div>
          </div>
          
            </div>
                      
          
          
     
         </div><!--/.nav-collapse -->
      </div>
      <div class="container-fluid" style="/*border: 1px solid #036; */ height: 30px;" id="extras-bar">
      	<div class="row">
      		
      		<div class="col-md-4" style="font-weight:bold; ">
      		<span style="margin-left:2%;">  <?php echo $banner_text;?> </span>
      		 	
     		</div>
      		<div class="col-md-4">     			
      		</div>
      		<div class="col-md-4"  style="text-align: right;">
      			<?php  echo date('l, dS F Y'); ?>
             <span id="clock" style="font-size:0.85em; " ></span>
      		</div>
      	</div>      	
      </div>	
      </div>

    <div class="container-fluid" style="" id="main-content">
<!----------- MSOS top buttons--------->
<div class="container" style="width: 96%; margin-top:5%;">
	<div class="row">
		
		<!--<button type="button" class="btn btn-primary btn-lg btn3d"><span class="glyphicon glyphicon-cloud"></span> Primary</button>-->
		<?php $current = $id=$this->uri->segment(2); //echo $current;
		 if($user_is_administrator && !isset($ebola_admin)){ ?>
		
		<a href="<?php echo base_url(); ?>user_management/moh"><button type="button" class="btn btn-primary <?php if($current=="moh") echo "active"  ?>"><span class="glyphicon glyphicon-user" > Register Users</span></button></a>
		
		<?php } if($user_is_administrator && !isset($ebola_admin)){ ?>
		
		<a href="<?php echo base_url() ?>user_management/users_facility"><button type="button" class="btn btn-primary <?php if($current=="users_facility") echo "active"  ?>"><span class="glyphicon glyphicon-list-alt" > Manage Users</span></button></a>
		
		<?php } if($user_is_administrator && !isset($ebola_admin)){ ?>
		
		<a href="<?php echo base_url(); ?>a_management/sendSMS"><button type="button" class="btn btn-primary <?php if($current=="sendSMS") echo "active"  ?>"><span class="glyphicon glyphicon-envelope" > Send Bulk SMS</span></button></a>
		
		<?php } if($user_is_kemri && !isset($ebola_admin)){ ?>
		
		<a href="<?php echo base_url(); ?>a_management/confirm"><button type="button" class="btn btn-primary <?php if($current=="confirm") echo "active"  ?>"><span class="glyphicon glyphicon-list-alt" > Confirm Alert</span></button></a>
		
		<?php } if($user_is_kemri && isset($ebola_admin)){  ?>
		
		<a href="<?php echo base_url(); ?>ebola_reports/kemri_lab_results"><button type="button" class="btn btn-primary <?php if($current=="kemri_lab_results") echo "active"  ?>"><span class="glyphicon glyphicon-list-alt" > Lab Results</span></button></a>

		<?php } if($user_is_kemri && !isset($ebola_admin)){ ?>
		
		<a href="<?php echo base_url(); ?>a_management/kemri_table_view"><button type="button" class="btn btn-primary <?php if($current=="kemri_table_view") echo "active"  ?>"><span class="glyphicon glyphicon-list-alt" > Confrim View</span></button></a>
	    
	    <?php } if($user_is_kemri && isset($ebola_admin)){ ?>
	  <a href="<?php echo base_url(); ?>ebola_Reports/kemri_table_view"><button type="button" class="btn btn-primary <?php if($current=="kemri_table_view") echo "active"  ?>"><span class="glyphicon glyphicon-list-alt" > Lab Results View</span></button></a>

	    <?php } ?>
	    <?php  if($user_is_district || $user_is_county){ ?>
		
		<a href="<?php echo base_url(); ?>c_incidents/all_diseases"><button type="button" class="btn btn-primary <?php if($current=="all_diseases") echo "active"  ?>"><span class="glyphicon glyphicon-list-alt" > Incidents</span></button></a>
	    
	    <?php } ?>
		
	</div>
</div><br/>
<!-- /.modal -->   
<div class="container" style="width: 96%; margin-top:auto;">
	<div class="row">
		
		<?php if(isset($left_content)){ ?>
		<div class="col-md-3">
		
	<div class="row">			
			<div class="col-md-12">				
			<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Actions <span class="glyphicon glyphicon-list-alt"></span></h3>
      </div>
      <div class="panel-body">
    <div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="panel-group" id="accordion">
            	
               <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
         <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-info-sign"></span> About Us</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse collapse">
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-pencil text-success"></span><a href="<?php echo base_url().'about' ?>"> Background</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-flash text-success"></span><a href="<?php echo base_url().'blogs' ?>"> Blog</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-comment text-success"></span><a href="<?php echo base_url().'contact' ?>"> Contact Us</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-book text-success"></span><a href="<?php echo base_url().'faq' ?>"> FAQ</a>
                                        <!--<span class="badge">42</span>-->
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php if($user_is_administrator || $user_is_county || $user_is_district || $user_is_moh){ ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th">
                            </span> More Action</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-list-alt text-success"></span></span><a href="<?php echo base_url().'c_incidents/all_diseases' ?>"> Initial Response</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <span class="glyphicon glyphicon-list-alt text-success"></span></span><a href="<?php echo base_url().'report_management/responses' ?>"> Reported Resonse</a>
                                    </td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php } if($user_is_administrator || $user_is_county || $user_is_district || $user_is_moh){ ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-phone">
                            </span> Alerts</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                            	
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-send text-success"></span><a href="<?php echo base_url().'C_Incidents/report_incidence' ?>"> Send New Alert</a>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-edit text-success"></span><a href="<?php echo base_url().'C_Incidents/all_diseases_edit' ?>"> Edit Incident</a>
                                    </td>
                                </tr>
                               
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php } if($user_is_administrator){?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-briefcase">
                            </span> Disease Management</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                            	
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-edit text-success"></span><a href="<?php echo base_url().'c_disease/manage_d' ?>"> Edit Disease</a>
                                    </td>
                                </tr>
                               
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php } if($user_is_administrator){ ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="glyphicon glyphicon-file">
                            </span> Reports</a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'logs/' ?>">Access Traffic</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'A_Management/kemri_table_view' ?>">Kemri Reports</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'C_Incidents/masterdb' ?>">Master Database</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'Report_Management/responses' ?>">Responses Download</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'turn_around_tym_control/' ?>">Turn Around Time</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <a href="<?php echo base_url().'weekly_controller/' ?>">Weekly Summary</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div><?php } ?>
            </div>
        </div>
        
    </div>
</div>

       
      </div>
        </div>      

      </div>    
    </div>
    
    <div class="row">			
			<div class="col-md-12">
				<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Notification <span class="glyphicon glyphicon-bell"></span> </h3>
      		</div>
      <div class="panel-body">
      <?php if($diseasez >0):?>   
		<div style="height:auto; margin-bottom: 2px" class="warning message ">
			<h5>Reported Disease(s)</h5>
			<p>
			<a class="link" href="<?php if($this->session->userdata("user_id"))echo site_url("c_disease/incidence_disease/"); ?>"><span class="badge"><?php echo $diseasez; ?></span>Disease(s)</a> have been Reported.
			</p>
		</div>
		<?php endif; ?>
		
		<?php if($incidentz >0):?>
		<div style="height:auto; margin-bottom: 2px" class="warning message ">
			<h5>Reported Incidence(s)</h5>
			<p>
			<a class="link" href="<?php if($this->session->userdata("user_id"))echo site_url("c_incidents/all_diseases/"); ?>"><span class="badge"><?php echo $incidentz; ?></span>Incidence(s)</a> have been flagged.
			</p>
		</div>
		 <?php endif; ?>
		 
		 <?php /*if($facility_dashboard_notifications['facility_donations']>0): ?>
      	 <div style="height:auto; margin-bottom: 2px" class="warning message ">      	
        <h5>Inter Facility Donation</h5> 
        	<p>
			<a class="link" href="<?php echo base_url('issues/confirm_external_issue') ?>"><span class="badge"><?php 
				echo $facility_dashboard_notifications['facility_donations'];?></span> Items have been donated</a> 
			</p>
			 </div>
		  <?php endif; */// Potential Expiries?>
		 
      </div>    
    </div>
	</div>
		</div>
		
		<div class="row">			
			<div class="col-md-12">
				<div class="panel panel-primary">
      		<div class="panel-heading">
        		<h3 class="panel-title">Confirmed cases <span class="glyphicon glyphicon-warning-sign"></span> </h3>
      		</div>
      <div class="panel-body">
      		
		<?php if($confirmz >0){ ?>  
			<div style="height:auto; margin-bottom: 2px" class="warning message">
			<h5>Confirmed Incidence (s)</h5>
			<p>
			<a class="link" href="#"><span class="badge"><?php echo $confirmz; ?></span>Incidence(s)</a> have been confirmed.
			</p>
			</div>
			<?php } else{ ?>
			<div style="height:auto; margin-bottom: 2px" class="warning message">
			<h5>Confirmed Incidence (s)</h5>
			<p>
			<span class="badge">0</span>Incidence(s) have been confirmed.
			</p>
			</div>
		 
		 <?php } ?>
		 
      </div>    
    </div>
	</div>
		</div>
    
	</div>
	
	<?php } ?>
	
	
    <?php $this -> load -> view($content_view);?>
   
    </div>
   </div>
    
    </div> <!-- /container -->
   <div id="footer">
      <div class="container">
        <p class="text-muted"> Government of Kenya &copy <?php echo date('Y');?>. All Rights Reserved
</p>
        
      </div>
    </div>
    <script type="text/javascript">
    /*
 * Auto logout
 */
var timer = 0;
function set_interval() {
  showTime()
  // the interval 'timer' is set as soon as the page loads
  timer = setInterval("auto_logout()", 240000);
  // the figure '1801000' above indicates how many milliseconds the timer be set to.
  // Eg: to set it to 5 mins, calculate 3min = 3x60 = 180 sec = 180,000 millisec.
  // So set it to 180000
}

function reset_interval() {
  showTime()
  //resets the timer. The timer is reset on each of the below events:
  // 1. mousemove   2. mouseclick   3. key press 4. scroliing
  //first step: clear the existing timer

  if(timer != 0) {
    clearInterval(timer);
    timer = 0;
    // second step: implement the timer again
    timer = setInterval("auto_logout()", 240000);
    // completed the reset of the timer
  }
}

function auto_logout() {

  // this function will redirect the user to the logout script
  window.location = "<?php echo base_url(); ?>user_management/logout";
}

/*
* Auto logout end
*/
  function showTime()
{
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
h=checkTime(h);
m=checkTime(m);
s=checkTime(s);
$("#clock").text(h+":"+m);
t=setTimeout('showTime()',1000);

}
function checkTime(i)
{
if (i<10)
  {
  i="0" + i;
  }
return i;
}  
	$(document).ready(function() {
					$('.alert-success').fadeOut(10000, function() {
    // Animation complete.
});
});
</script>
   <script src="<?php echo base_url().'assets/boot-strap3/js/bootstrap.min.js'?>" type="text/javascript"></script>
    <!-- Bootstrap core JavaScript===================== -->	
  <script src="<?php echo base_url().'assets/scripts/jquery-ui-1.10.4.custom.min.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/scripts/highcharts.js'?>" type="text/javascript"></script>
   <script src="<?php echo base_url().'assets/scripts/exporting.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/scripts/jquery.floatThead.min.js'?>" type="text/javascript"></script>	
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="<?php echo base_url().'assets/scripts/hcmp_shared_functions.js'?>" type="text/javascript"></script>
    <!--Datatables==========================  -->
  <script src="<?php echo base_url().'assets/datatable/jquery.dataTables.js'?>" type="text/javascript"></script>	
  <script src="<?php echo base_url().'assets/datatable/dataTables.bootstrap.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/datatable/TableTools.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/datatable/ZeroClipboard.js'?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/datatable/dataTables.bootstrapPagination.js'?>" type="text/javascript"></script>
  <!-- validation ===================== -->
  <script src="<?php echo base_url().'assets/scripts/jquery.validate.min.js'?>" type="text/javascript"></script>
</html>
