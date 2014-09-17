
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
						<?php if(isset($ebola_admin)){ ?>
				<div style="float:right;"><span class="glyphicon glyphicon-save"></span><a href="<?php echo site_url('ebola_reports/ebola_response_download');?>"> Download</a></div>
	
						<?php } else{ ?>
                 <div style="float:right;"><span class="glyphicon glyphicon-save"></span><a href="<?php echo site_url('report_management/download_response');?>">Download</a></div>
					<?php }} ?>
			
					</div>
					<div class="panel-body" style="overflow-y: auto">
				<table  class="table table-striped table-bordered table-hover table-responsive" id="example" width="100%">
				
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
						<th>District Response</th>
						<th>County Response</th>
						<th>National Response</th>
						<th>Kemri response</th>
										    
					</tr>
					</thead>
					
							<tbody>
								<?php
						foreach($all as $row):
						foreach($row->incident as $d):
						foreach($row->disease_name as $faci):
						foreach($row->logs as $log):
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
							
							<td>
								<?php
								$g = $log -> district_incident;
								$g = explode('|', $g);
								$no=count($g);
								if($no>=5){
								$act = $g[0];
								$note = $g[1];
								$find = $g[2];
								$tim = $g[3];
								$take = $g[4];
								$dttg = new DateTime($tim);
								echo '<strong>Action :</strong>' . $act . '<br>' . '<strong>Notes :</strong>' . $note . '<br>' . '<strong>Findings :</strong>' . $find . '<br><strong>Time :</strong</>' . $dttg -> format('j F, Y g:i A');
								}else{
									echo "No Response.";
								}
								?>
							</td>
							
							<td>
								<?php
								$g = $log -> county_incident;
								$g = explode('|', $g);
								$no=count($g);
								if($no>=5){
								$act = $g[0];
								$note = $g[1];
								$find = $g[2];
								$tim = $g[3];
								$take = $g[4];
								$dttg = new DateTime($tim);
								echo '<strong>Action :</strong>' . $act . '<br>' . '<strong>Notes :</strong>' . $note . '<br>' . '<strong>Findings :</strong>' . $find . '<br><strong>Time :</strong</>' . $dttg -> format('j F, Y g:i A');
								}else{
									echo "No Response.";
								}
								?>
							</td>
							
							<td><?php
							$c = $log -> national_incident;
							$c = explode('|', $c);
							$no1=count($c);
							if($no1>=5){
							$action = $c[0];
							$notes = $c[1];
							$findings = $c[2];
							$time = $c[3];
							$taken = $c[4];
							$dtt = new DateTime($time);
							echo '<strong>Action :</strong>' . $action . '<br>' . '<strong>Notes :</strong>' . $notes . '<br>' . '<strong>Findings :</strong>' . $findings . '<br><strong>Time :</strong</>' . $dtt -> format('j F, Y g:i A');
							}else{
								echo "No Response.";
							}
								?></td>
							
							<td>
							<?php
							$incident_id=$row->p_id;
						$fetch_kemri = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM kemri_response WHERE incident_id='$incident_id'");
							if($fetch_kemri){
							foreach($fetch_kemri as $rows){
							$comments=$rows['comments'];
							$a=$row->lab_time; $dtz=new datetime($a);
							echo "<strong>Results: </strong>".$row->confirmation.".<br/><strong>Comments:</strong> ".$comments."<br/><strong>Released: </strong><strong>".$dtz->format('j F, Y g:i A')."</strong>";
							}
							}
							else{echo "No response.";}
							
							?>
							</td>
						</tr>
						<?php endforeach; ?>
						<?php endforeach; ?>
						<?php endforeach; ?>
						<?php endforeach; ?>
						</tbody>
						
				</table>
				</div>
				</div>
			
		
		
	</div>
 