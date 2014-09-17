<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
		</style>
<?php $current_year = date('Y');
			$earliest_year = $current_year - 10;
		?>
		<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc'] = function(x, y) {
				return ((x < y) ? -1 : ((x > y) ? 1 : 0));
			};

			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x, y) {
				return ((x < y) ? 1 : ((x > y) ? -1 : 0));
			};

			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable({
					"bJQueryUI" : true,

					"aaSorting" : [[0, 'asc'], [1, 'asc']],
					"aoColumnDefs" : [{
						"sType" : 'string-case',
						"aTargets" : [2]
					}]
				});
			});

			function confirmAction() {
				var confirmed = confirm("Are you sure? This will make changes to the existing data.");
				return confirmed;
			}
		</script>
		
			<div>
	
			<p>
				<h1 style="text-align: center"><?php echo $this -> uri -> segment(3); ?> Responses Report</h1>
				<table  style="margin-left: 0;" id="example" width="100%">
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
						<th>Admin And MOH Response</th>
						
						<th>District Response</th>
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
			</p>
		
		
	</div>
 