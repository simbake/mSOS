
<?php $current_year = date('Y');
			$earliest_year = $current_year - 10;
			if($this->session->userdata("user_indicator")!='KEMRI'){
				redirect("home_controller");
			}
		?>
		<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
			

			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable({
				
				});
			});

			function confirmAction() {
				var confirmed = confirm("Are you sure? This will make changes to the existing data.");
				return confirmed;
			}
		</script>
		
			<div class="panel panel-default">
				<div class="panel-heading">
					Kemri Incidence Confirm.
				</div>
      <div class="panel-body">
        <table class="table table-responsive table-hover table-striped" id="example" width="100%" >
					<thead>
					<tr>
						
						<th>Type</th>	
						<th>Diseases</th>
						<th>Date</th>
						<th>Time</th>
						<th>MFL</th>
						<th>HF Name</th>
						<th>Incidence Id</th>
						<th>Status</th>
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
							<td><?php echo $faci -> Full_Name; ?></td>
							<td><?php $a = $row->Time; $dt = new DateTime($a); echo $dt->format('j F, Y') ?></td>
							<td><?php $b = $row->Time; $dts = new DateTime($b); echo $dts->format('g:i A') ?></td>
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
							<td><?php if($row->confirmation=='Suspected'){
							$incident_id=$row -> p_id;
							$fetch_incidence = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT incident_id FROM kemri_response WHERE incident_id='$incident_id'");
							//if($fetch_incidence){incident_id
							//echo $fetch_incidence;
							?>
							
							
							<a href="<?php echo site_url('ebola_Reports/specimen_results/'.$row->id)?>"
				 class='label label-primary'><span class="glyphicon glyphicon-comment"></span> Respond</a>
							<?php 
							//}
						//	else{
							?>
							<!--<a href="<?php echo site_url('a_management/specimen_received/'.$row->id)?>" class="link">Specimen received</a>|<a href="<?php echo site_url('a_management/specimen_results/'.$row->id)?>" class="link">Specimen results</a>-->
							<?php
							//}
							}
							else{
								echo "<label class='label label-default'><span class='glyphicon glyphicon-ok'></span> Done.</label>";
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
 