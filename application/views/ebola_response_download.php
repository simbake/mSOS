
<?php $current_year = date('Y');
	$earliest_year = $current_year - 10;
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
		
			<div>
			
			
				<div class="panel panel-default">
					<div class="panel-heading">
						Responses View
				<?php if($this->session->userdata("user_indicator")=="Administrator" || $this->session->userdata("user_indicator")=="MOH" ){ ?>
						
                 <div style="float:right;"><span class="glyphicon glyphicon-save"></span><a href="<?php echo site_url('ebola_reports/ebola_response_download'); ?>">Download</a></div>
					<?php } ?>
			
					</div>
					<div class="panel-body" style="overflow-y: auto">
				<table  class="table table-striped table-bordered table-hover table-responsive" id="example" width="100%">
				
					<thead>
					<tr>
						<th></th>
						<th>Phone Number</th>
						<th>Location</th>
						<th>Date</th>
						<th>Time</th>
						<th>Sex</th>
						<th>Age</th>
						<th>Status</th>
						<th>Serial</th>
						<th>ID</th>
						<th>National Response</th>
						<th>Kemri response</th>
										    
					</tr>
					</thead>
					
							<tbody>
								<?php
						foreach($all as $row):	
						?>
						<tr>
							<td><?php echo $row -> Type; ?></td>
							<td><?php echo $row -> reported_by; ?></td>
							<td><?php echo $row -> incidence_location; ?></td>
							<td><?php $a = $row->incidence_time; $dt = new DateTime($a); echo $dt->format('j F, Y') ?></td>
							<td><?php $b = $row->incidence_time; $dts = new DateTime($b); echo $dts->format('g:i A') ?></td>
							<td><?php echo $row -> Sex; ?></td>
							<td><?php echo $row -> Age; ?></td>
							<td><?php
							if ($row -> Status == 'D') {
								echo 'Dead';
							} else {
								echo 'Alive';
							}
							?></td>
							<td><?php echo $row -> case_number; ?></td>
							<td><?php echo $row -> msos_code; ?></td>
							
							<td><?php
							$admin_log = $row -> logs_ebola -> toArray();
							if (isset($admin_log['0']['national_incident'])) {
								$c = $admin_log['0']['national_incident'];
								$c = explode('|', $c);
								$no1 = count($c);

								$action = $c[0];
								$notes = $c[1];
								$findings = $c[2];
								$time = $c[3];
								$taken = $c[4];
								$dtt = new DateTime($time);
								echo '<strong>Action :</strong>' . $action . '<br>' . '<strong>Notes :</strong>' . $notes . '<br>' . '<strong>Findings :</strong>' . $findings . '<br><strong>Time :</strong</>' . $dtt -> format('j F, Y g:i A');
							} else {
								echo "No Response.";
							}
								?></td>
							
							<td>
							<?php
							if ($row -> lab_results != 'Suspected') {
								$kemri_response = $row -> kemri_response -> toArray();
								$results_release = new DateTime($row -> lab_time);

								echo "<strong>Results: </strong>" . $row -> lab_results . ".<br/><strong>Comments:</strong> " . $kemri_response['0']['comments'] . "<br/><strong>Released: </strong><strong>" . $results_release -> format('j F, Y g:i A') . "</strong>";
							} else {
								echo "<strong>No response.</strong>";
							}
							//else{echo "No response.";}
							?>
							</td>
						</tr>
						<?php endforeach; ?>
						</tbody>
						
				</table>
				</div>
				</div>
			
		
		
	</div>
 