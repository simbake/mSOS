<?php error_reporting(E_ALL^E_NOTICE);

    $current_year = date('Y');
	$earliest_year = $current_year - 10;
?>
<script type="text/javascript" charset="utf-8">
	
	$(document).ready(function() {
		/* Build the DataTable with third column using our custom sort functions */
		$('#example').dataTable({
			
		});
	}); 
</script>



				<div class="">
					<div class="panel panel-default">
			     	<div class="panel-heading">
			     		Facility List
			     	</div>
			     	<div class="panel-body" style="overflow-y: auto">
					
				<table  class="table table-striped table-hover table-bordered table-hover table-responsive" id="example" width="100%">
				<thead>
				<tr>
				<th>Type</th>
				<th>Phone Number</th>
				<th>Diseases</th>
				<th>Date</th>
				<th>Time</th>
				<th>Sex</th>
				<th>Age</th>
				<th>MFL</th>
				<th>HF Name</th>
				<th>Incidence Id</th>
				<th>Status</th>
				<th>Login</th>

				<th></th>
				</tr>
				</thead>

				<tbody>
				<?php
				foreach($all as $row):
				foreach($row->incident as $d):
				foreach($row->disease_name as $faci):

				?>
				<tr>
				<td><?php echo $row -> Type; ?></td>
				<td><?php echo $d -> phone_number; ?></td>
				<td><?php echo $faci -> Full_Name; ?></td>
				<td><?php $a = $row->Time; $dt = new DateTime($a); echo $dt->format('j F, Y') ?></td>
				<td><?php $b = $row->Time; $dts = new DateTime($b); echo $dts->format('g:i A') ?></td>
				<td><?php echo $row -> Sex; ?></td>
				<td><?php echo $row -> Age; ?></td>
				<td><?php echo $row -> Mfl_Code; ?></td>
				<td><?php echo $d -> Facility_name; ?></td>
				<td><?php echo $row -> p_id; ?></td>
				<td><?php
				if ($row -> Status == 'D') {
					echo 'Dead';
				} else {
					echo 'Alive';
				}
				?></td>
				<td>Facility</td>

				<td>
				<?php
			         		$incident_id=$row -> p_id;
							$access_types=$this->session->userdata('user_indicator');
							
							$fetch_incidence = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM incidence i, incident_log l WHERE i.p_id =  '$incident_id' AND i.id = l.incident_id");
                           // print_r($fetch_incidence);
						   if($fetch_incidence){
						  // print_r($fetch_incidence);
						  foreach($fetch_incidence as $fetch){
						  
						  //district response check
						  if($access_types=='District Administrator'){
						  $check=$fetch['district_incident'];
						  if($check){
						  echo "<label class='label label-default'><span class='glyphicon glyphicon-ok'></span> Done.</label>";
						  }
						  else{
						  ?>
						  <a href="<?php echo site_url('c_incidents/respond/'.$row->id)?>"
				 class='label label-primary'><span class="glyphicon glyphicon-comment"></span> Respond</a>
						  
						  <?php
						  // echo "District: ".$access_types;
						  }
						  
						  }
						  //County response check
						 else if($access_types=='County Administrator'){
						  $check=$fetch['county_incident'];
						  if($check){
						  echo "<label class='label label-default'><span class='glyphicon glyphicon-ok'></span> Done.</label>";
						 
						  }
						  else{
						  ?>
						  
						  <a href="<?php echo site_url('c_incidents/respond/'.$row->id)?>"
				 class='label label-primary'><span class="glyphicon glyphicon-comment"></span> Respond</a>
						  
						  <?php
						  
						  // echo "county:".$access_types;
						  }
						  
						  }
						  
						  //Administrator or MOH response check
						  else if($access_types=='Administrator' || $access_types=='MOH' ){
						  $check=$fetch['national_incident'];
						  if($check){
						  echo "<label class='label label-default'><span class='glyphicon glyphicon-ok'></span> Done.</label>";
						  }
						  else{
						  ?>
						  <a href="<?php echo site_url('c_incidents/respond/'.$row->id)?>"
				 class='label label-primary'><span class="glyphicon glyphicon-comment"></span> Respond</a>
						  
						  <?php
						  // echo "county";
						  }
						  
						  }
						  break;
						  }
							}
						   
						   else{
						   ?>
						   <a href="<?php echo site_url('c_incidents/respond/'.$row->id)?>"
				 class='label label-primary'><span class="glyphicon glyphicon-comment"></span> Respond</a>
						   <?php 
						   }
                            
							?>
							
							
				
				
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endforeach; ?>
			<?php endforeach; ?>

			</tbody>

		</table>
		</div>
		</div>
		

</div>
