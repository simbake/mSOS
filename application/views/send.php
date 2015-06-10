	
	 <div class="col-md-9" style="">
  	<div class="panel panel-success">
      <div class="panel-heading">
      Sms Send <span class="glyphicon glyphicon-phone"></span>	
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <form method="post" action="<?php echo base_url().'a_management/sendtext'?>">
<table width="100%" class="table table-striped  table-responsive table-bordered">
	<tr>
	<td><label>Select County</label></td>
	<td>
		<select name="county" required>
			<option disabled selected="selected">-- Select County --</option>
			<?php 
		foreach ($all as $all) {
			$county=$all->county;
			?>
			
			<option value="<?php echo $county;?>"><?php echo $county;?></option>
		<?php }
		?>
		</select>
	</td>
	</tr>
	<tr>
		<td><label>Message</label></td>
		<td><textarea name="message" style="width: 100%" id="message" name='message' required></textarea></td>
	</tr>
	<tr>
		<td><button type="submit" class="btn btn-default">
			<span class="glyphicon glyphicon-phone"></span> Send Message
		</button></td>
		<td></td>
	</tr>
   
</table>   </form>  </div>   

	</div>
	</div>
  
  