<?php
if (isset($all)) {

	$age = $all -> Age;
	$disease = $all -> Disease_id;
	$incident = $all -> p_id;
	$sex = $all -> Sex;
	$status = $all -> Status;
	//$id = $all -> id;
}
$id = $this -> uri -> segment(3);
?>
<!--Validation Scripts-->
<link href="<?php echo base_url().'CSS/jquery.validate.css'?>" type="text/css" rel="stylesheet"/>
<script src="<?php echo base_url().'Scripts/jquery.validate.js'?>" type="text/javascript"></script>

<script>
		$(function() {
$("#year").change(function() {
var selected_year = $(this).attr("value");
//Get the last year of the dropdown list
var last_year = $(this).children("option:last-child").attr("value");
//If user has clicked on the last year element of the dropdown list, add 5 more
if($(this).attr("value") == last_year) {
last_year--;
var new_last_year = last_year - 5;
for(last_year; last_year >= new_last_year; last_year--) {
var cloned_object = $(this).children("option:last-child").clone(true);
cloned_object.attr("value", last_year);
cloned_object.text(last_year);
$(this).append(cloned_object);
}
}
});
$("#accordion").accordion({
autoHeight : false,
active: false,
collapsible: true
});
$('#username').click(function(){
/*
* when clicked, this object should populate district names to district dropdown list.
* Initially it sets default values to the 2 drop down lists(districts and facilities)
* then ajax is used is to retrieve the district names using the 'dropdown()' method that has
* 3 arguments(the ajax url, value POSTed and the id of the object to populated)
*/
var code= $("#username").val();
$("#username").html();

json_obj={"url":"<?php echo site_url("user_management/username"); ?>
	",}
	var baseUrl=json_obj.url;
	var id=$(this).attr("value")
	//alert(code);
	dropdown(baseUrl,"username="+id)
	});

	function dropdown(baseUrl,post,identifier){
	/*
	* ajax is used here to retrieve values from the server side and set them in dropdown list.
	* the 'baseUrl' is the target ajax url, 'post' contains the a POST varible with data and
	* 'identifier' is the id of the dropdown list to be populated by values from the server side
	*/
	$.ajax({
	type: "POST",
	url: baseUrl,
	data: post,
	success: function(msg){
	//alert(msg);
	if(msg==""){
	return;
	}else{
	alert('Sorry username is already in use. Please try another')
	}
	$(identifier).html(dropdown);
	},
	error: function(XMLHttpRequest, textStatus, errorThrown) {
	if(textStatus == 'timeout') {}
	}
	}).done(function( msg ) {
	});
	}
	});
</script>

<script>
	function showFields() {

		if ($("#findings").val() == "Other") {

			document.getElementById("pat_info").style.display = "";

		}
		if ($("#action").val() == "Other") {

			document.getElementById("pat_info1").style.display = "";

		}

	}

</script>

<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(function() {
		jQuery("#ValidNumber").validate({
			expression : "if (!isNaN(VAL) && VAL) return true; else return false;",
			message : "Should be a number"
		});
		jQuery("#Email").validate({
			expression : "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
			message : "Should be a valid Email id"
		});
		jQuery("#ValidNumber").validate({
			expression : "if (VAL > 100) return true; else return false;",
			message : "Should be greater than 100"
		});
		jQuery("#Mobile").validate({
			expression : "if (VAL.match(/^[254][0-9]{11}$/)) return true; else return false;",
			message : "Should be a valid Mobile Number"
		});
		jQuery("#ValidField").validate({
			expression : "if (VAL) return true; else return false;",
			message : "Please enter the Required field"
		});
		jQuery("#ValidField1").validate({
			expression : "if (VAL) return true; else return false;",
			message : "Please enter the Required field"
		});
		jQuery("#username").validate({
			expression : "if (VAL) return true; else return false;",
			message : "Please enter the Required field"
		});
		jQuery("#ValidPassword").validate({
			expression : "if (VAL.length > 5 && VAL) return true; else return false;",
			message : "Please enter a valid Password"
		});
		jQuery("#ValidConfirmPassword").validate({
			expression : "if ((VAL == jQuery('#ValidPassword').val()) && VAL) return true; else return false;",
			message : "Confirm password field doesn't match the password field"
		});
	});
	/* ] var input = document.getElementByName("fname");]> */

</script>
<script>
	function callme() {
		//var a= field.value;
		var user = $('#ValidField').val().substr(0, 1);
		var user2 = $('#ValidField1').val();
		var userCom = (user + user2);
		//alert(userCom);
		$('input:text[name=username]').val(userCom);

	}
</script>
<p align="center" style="font-size: 20px;">
	<strong>Report New Suspected Case:</strong>
</p>

<form action="<?php echo base_url().'c_incidents/confirm'?>" onsubmit="return confirm('Are you sure you want to submit this form?');" method="post" >
	<table class="data-table" width="40%">
		<tbody>

			<?php echo validation_errors('<p class="error">', '</p>'); ?>
			<input type="hidden" name="id" value="<?php echo $id?>" />
			<tr>
				<p>
					<td><label for="fname">Incident ID:</label></td>
					<td>
					<input type="text" name="fname" readonly="readonly" readonly="readonly" value="<?php echo $incident; ?>"  />
					</td>
				</p>
			</tr>
			<tr>
				<p>
					<td><label for="fname">Age</label></td>
					<td><input type="number"" name="age" id="Mobile" readonly="readonly" max="3" min="1" required="required" value="<?php echo $age; ?>" /></td>
					</p></tr>
					<tr><p>
					<td><label for="email">Sex: </label></td>
					<td><input type="text" name="sex" id="Email" readonly="readonly" required="required" value="<?php echo $sex; ?>"/></td>
					</p></tr>
					<tr><p>
					<td><label for="status">Status (Alive/Dead): </label></td>
					<td><input type="text" name="status"  readonly="readonly" required="required" value="<?php echo $status?>"   /></td>
					</p></tr>
					<tr>
					<td><label> Response Action :</label></td>
					<td>
						<select name="action">
							<option selected="selected">-- Select Action --</option>
							<option value="Phone Call" >Phone Call</option>
					<option value="Visited">Visited</option> 
					<option value="Sample Taken">Sample Taken</option>
					<option value="Investigations Made">Investigations Made</option>
					<option value="Public Health Action Taken">Public Health Action Taken</option> </select>
						</select>
					</td>
					</tr>
					<tr>
					<td><label> Findings :</label></td>
					<td><select name="findings" id="findings" onchange="showFields()">
					<option selected="selected">-- Select Finding --</option>
					<option value="Meets case definition">Meets case definition</option> 
					<option value="Doesn't meet case">Doesn't meet case</option>
					<option value="Confirmed Outbreak">Confirmed Outbreak</option>
					<option value="Other">Other</option> </select> 
					</td>
			</tr>
		</tbody>
		<tbody id="pat_info"  style="display:none" >
			<tr>
				<td> <label> Other Public health action taken :</label></td>
				<td> <textarea name="others"></textarea></td>
			</tr>
			
		</tbody>
		<tr>
			<td><label> Public Health Action Taken :</label></td>
			<td>
			<select name="actiontaken" id="action" onchange="showFields()">
				<option selected="selected">-- Select Public Health Action Taken --</option>
				<option value="Sprayed">Sprayed</option>
				<option value="Cases Searched in the community">Cases Searched in the community</option>
				<option value="Treated Water">Treated Water</option>
				<option value="Conducted public awareness">Conducted public awareness</option>
				<option value="Other">Other</option>
			</select></td>
		</tr>
		<tbody id="pat_info1"  style="display:none" >
			<tr>
				<td> <label> Other Findings :</label></td>
				<td> <textarea name="others1"></textarea></td>
			</tr>
			
		</tbody>
		<tr>
			<td><label> Comments :</label></td>
			<td>			<textarea name="notes"></textarea></td>
		</tr>

		<tr>
			<p>
				<td><?php echo form_submit('submit', 'Report Outbreak'); ?></td>
			</p>
		</tr>
</form>
</table>