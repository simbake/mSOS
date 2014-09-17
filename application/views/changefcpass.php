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