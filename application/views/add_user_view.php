<?php
if (isset($all)) {
	$name=$all->contact;
	$phone=$all->phone_number;
	$facility=$all->Facility_code;
}
?>
<!--Validation Scripts-->
<link href="<?php echo base_url().'CSS/jquery.validate.css'?>" type="text/css" rel="stylesheet"/> 
<script src="<?php echo base_url().'Scripts/jquery.validate.js'?>" type="text/javascript"></script> 



<script type="text/javascript">
            /* <![CDATA[ */
            jQuery(function(){
                jQuery("#ValidNumber").validate({
                    expression: "if (!isNaN(VAL) && VAL) return true; else return false;",
                    message: "Should be a number"
                });
                jQuery("#Email").validate({
                    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                    message: "Should be a valid Email id"
                });
                jQuery("#ValidNumber").validate({
                    expression: "if (VAL > 100) return true; else return false;",
                    message: "Should be greater than 100"
                });
                jQuery("#Mobile").validate({
                    expression: "if (VAL.match(/^[254][0-9]{11}$/)) return true; else return false;",
                    message: "Should be a valid Mobile Number"
                });
                jQuery("#ValidField").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Required field"
                });
                jQuery("#ValidField1").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Required field"
                });
                jQuery("#username").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Required field"
                });
                 jQuery("#ValidPassword").validate({
                    expression: "if (VAL.length > 5 && VAL) return true; else return false;",
                    message: "Please enter a valid Password"
                });
                jQuery("#ValidConfirmPassword").validate({
                    expression: "if ((VAL == jQuery('#ValidPassword').val()) && VAL) return true; else return false;",
                    message: "Confirm password field doesn't match the password field"
                });
            });
            /* ] var input = document.getElementByName("fname");]> */
           
        </script>
        <script>
        function callme() {
        	//var a= field.value;
        	var user= $('#ValidField').val().substr(0,1);
        	var user2= $('#ValidField1').val();
        	var userCom=(user + user2);
        	//alert(userCom);
            $('input:text[name=username]').val(userCom);
            
        }
        </script>
        
<?php echo form_open('user_management/submit'); ?>

				<table class="data-table" width="800">
					
	
	
	<?php echo validation_errors('<p class="error">','</p>'); ?>
	<input type="hidden" name="facility" readonly="readonly"  value="<?php echo $facility?>"   />
	<tr><p>
		<td><label for="fname">First Name:</label></td>
		<td><input type="text" name="fname" readonly="readonly"  value="<?php echo $name?>"   /></td>
	</p>
	<tr><p>
		<td><label for="fname">Mobile Number: eg 254728242546</label></td>
		<td><input type="text" name="tell" readonly="readonly"  value="<?php echo $phone?>"   /></td>
	</p></tr>
	<tr><p>
		<td><label for="email">E-mail: </label></td>
		<td><input type="text" name="email" id="Email" /></td>
	</p></tr>
	<tr><p>
		<td><label for="username">Username: </label></td>
		<td><input type="text" name="username"   /></td>
	</p></tr>
	<tr><p>
		<td><label for="password">Password: </label></td>
		<td><input type="password" name="password" id="ValidPassword" /></td>
	</p></tr>
	<tr><p>
		<td><label for="passconf">Confirm Password: </label></td>
		<td><input type="password" name="passconf" id="ValidConfirmPassword" /></td>
	</p></tr>
	<tr><p>
		<td><label for="typr">User Type :</label></td>
		
		<td>
			<select name="type">
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
	
	
	<tr><p>
		<td><?php echo form_submit('submit','Create account'); ?></td>
	</p></tr>
	<?php echo form_close(); ?>
	</table>