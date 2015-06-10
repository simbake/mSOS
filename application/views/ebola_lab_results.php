
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
					KEMRI Incidence Confirm.
				</div>
      <div class="panel-body">
        <table class="table table-responsive table-hover table-striped" id="example" width="100%" >
					<thead>
					<tr>
						
						<th>Type</th>	
						<th>Location</th>
						<th>Date</th>
						<th>Time</th>
						<th>Sex</th>
						<th>Age</th>
						<th>Serial</th>
						<th>ID</th>
						<th>Login</th>
						<th></th>
										    
					</tr>
					</thead>
					
							<tbody>
								<?php
						foreach($all as $row):
						//foreach($row->facility_info as $d):
						//foreach($row->disease_name as $faci):
						
						?>
						<tr>
							<td><?php echo $row -> Type; ?></td>
							<td><?php echo $row -> incidence_location; ?></td>
							<td><?php $a = $row->incidence_time; $dt = new DateTime($a); echo $dt->format('j F, Y') ?></td>
							<td><?php $b = $row->incidence_time; $dts = new DateTime($b); echo $dts->format('g:i A') ?></td>
							<td><?php echo $row -> Sex; ?></td>
							<td><?php echo $row -> Age; ?></td>
							<td><?php echo $row -> case_number; ?></td>
						    <td><?php echo $row -> msos_code; ?></td>
						    <td>
				<?php
                    //echo $row -> p_id;
                    $incidence_id=$row->msos_code;
                $dat = portal_db::get_supply_plan($incidence_id);
                       // print_r($dat);				
				
				//echo $rows->id;
				if($dat){
				echo "Web portal";
				}
				else {
				
				echo "SMS Portal";
				}
				//break;
				
				
				?></td>
							<td><?php if($row->lab_results=='Suspected'){
							//$incident_id=$row -> incidence_code;
							$fetch_incidence = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT incident_id FROM kemri_response_ebola WHERE incident_id='$incidence_id'");
							//if($fetch_incidence){incident_id
							//echo $fetch_incidence;
							?>
							
							
							<a href="<?php echo site_url('ebola_Reports/specimen_results/'.$row->id)?>"
				 class='label label-primary'><span class="glyphicon glyphicon-comment"></span> Confirm</a>
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
						<?php //endforeach; ?>
						<?php //endforeach; ?>
						<?php endforeach; ?>
						
						</tbody>
						
				</table>
				</div>
		
		
		
	</div>
 