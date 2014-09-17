<?php 
$access_level = $this -> session -> userdata('user_indicator');
?>

<?php $current_year = date('Y');
$earliest_year = $current_year - 10;
?>
		<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
			
			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable( {
					//"bJQueryUI": true,
					
					//"aaSorting": [ [0,'asc'], [1,'asc'] ],
					//"aoColumnDefs": [
						//{ "sType": 'string-case', "aTargets": [ 2 ] }
					//]
				} );
			} );
		</script>
		
			<div class="" style="margin-top:auto;">
			     
			     <div class="panel panel-default">
			     	<div class="panel-heading">
			     		Edit An Incident
			     	</div>
			     	<div class="panel-body" style="overflow-y: auto">
			     		<div class="table-responsive">
				<!--<h1 style="text-align: center">Facility List</h1>-->
				<table class="table table-striped table-bordered table-hover" id="example" width="100%">
					
					<thead>
				<tr>
				<th>Type</th>
				<th>Phone Number</th>
				<th>Diseases</th>
				<th>Date</th>
				<th>Time</th>
				<th>Sex</th>
				<th>status</th>
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
				<td><?php echo $row -> Status; ?></td>
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
					<a href="<?php echo site_url('c_incidents/edit_i/'.$row->id)?>"
				 class='label label-primary'><span class="glyphicon glyphicon-edit"></span> Edit Incident</a>
				 
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
		
		
	</div>
 