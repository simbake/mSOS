<?php

$id=$this -> session -> userdata('user_id');
$level=$this -> session -> userdata('user_level');
if(!$id){
	redirect('home_controller');
}
 
 ?>

	
	<div class="">
	 <div class="col-md-7" style="padding-left: auto;">
  	
        
        
<?php echo form_open('user_management/admin_submit'); ?>

	
	<table class="table table-striped  table-responsive table-bordered" width="auto">
				
	<?php echo validation_errors('<p class="error">','</p>'); ?>
	<tbody>
	
	<tr><p>
		<td><label for="fname">Name:</label></td>
		<td><input type="text" name="fname" required    /></td>
	</p>
	<tr><p>
		<td><label for="fname">Mobile Number: eg 254728242546</label></td>
		<td><input type="text" name="tell"  required   /></td>
	</p></tr>
	<tr><p>
		<td><label for="email">E-mail: </label></td>
		<td><input type="TEXT" name="email" id="Email" required /></td>
	</p></tr>
	<tr><p>
		<td><label for="username">Username: </label></td>
		<td><input type="text" required name="username"   /></td>
	</p></tr>
	<p>
		
		<input type="hidden" required value="msos123" name="password" id="ValidPassword" />
	</p>
	<p>
		
		<input type="hidden" name="passconf" value="msos123" required id="ValidConfirmPassword" /></td>
	</p>
	<tr><p>
		<td><label for="typr">User Type :</label></td>
		
		<td>
			<select name="type" id="level" onchange="showFields()">
				<option selected="selected"> -- Select Access Level -- </option>
			<?php 
		foreach ($level_l as $level_level) {
			$level=$level_level->level;
			$type=$level_level->id;
			?>
			<option value="<?php echo $type;?>"><?php echo $level;?></option>
		<?php }
		?>
			</select>
		</td>
	</p></tr>
	</tbody>
	  <tbody id="province11" style="display:none">
			  <tr><p>
		<td><label for="typr">Province :</label></td>
		
		<td>
			<select name="province">
				<option selected="selected" value="NULL"> -- Select County -- </option>
			<?php 
		foreach ($province as $province) {
			$province=$province->county;
			?>
			<option value="<?php echo $province;?>"><?php echo $province;?></option>
		<?php }
		?>
			</select>
			<tbody id="district11" style="display:none">
			  <tr><p>
		<td><label for="typr">District:</label></td>
		
		<td>
			<select name="district">
				<option selected="selected" value="NULL"> -- Select District -- </option>
			<?php 
		foreach ($district as $district) {
			$district=$district->district;
			?>
			<option value="<?php echo $district;?>"><?php echo $district;?></option>
		<?php }
		?>
			</select>
		</td>
	</p></tr>
              
			  
			  </tbody>
	
	<tr><p>
		<td><button type="submit" class="btn-default"><span class="glyphicon glyphicon-user"></span>Create User</button></td><td></td>
	</p></tr>
	<?php echo form_close(); ?>
	</table>
	</div>
    
  </div> 
  