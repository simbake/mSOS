
<?php $current_year = date('Y');
$earliest_year = $current_year - 10;
if(!$this->session->userdata("user_id")){
	redirect("home_controller");
}
?>
		<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
			
			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable( {
					
				} );
			} );
		</script>
		
			<div class="panel panel-default">
				<div class="panel-heading">
					Kemri Response View.
				</div>
			<div class="panel-body">
        <table class="table table-responsive table-bordered table-hover table-striped" id="example" width="100%" >
					<thead>
					<tr>
						<th>Incident Id</th>
						
						<th>Date received</th>
						<!--<th>Date tested</th>-->
						<th>Specimen type</th>
						<th>Specimen condition</th>
						<!--<th>Date Results released</th>-->
						<th>Results|Comments</th>
								    
					</tr>
					</thead>
					
							<tbody>
								<?php
								//print_r($all);
						foreach($all as $row):
						?>
						<tr>
							<td><?php echo $row['incident_id'];?></td>
							<td><?php $a = $row['specimen_received']; $dt = new DateTime($a); echo $dt->format('j F, Y g:i A')?></td>
							<!--<td><?php //$b = $row->lab_test_begun; $dts = new DateTime($b); echo $dt->format('j F, Y g:i A') ?></td>-->
							<td><?php 
							 if($row['specimen_type']=="Other"){
							 echo "<strong>".$row->specimen_type." : </strong>".$row->other_specimen;
							 }
							 else{
							 echo $row['specimen_type'];
							 }
							 ?></td>
							<td><?php 
							if($row['conditions']=="Other"){
							 echo "<strong>".$row->specimen_type." : </strong>".$row->other_condition;
							 }
							 else{
							 echo $row['conditions'];
							 }							
							
							?></td>
							<?php
							$incident_id=$row['incident_id'];
						   $fetch_incidence = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT lab_results,lab_time FROM incidence_ebola WHERE incidence_code='$incident_id'");
							
							foreach($fetch_incidence as $rows):
                              
							?>
							<!--<td><?php  $a=$rows['lab_time']; $dtz = new DateTime($a);?></td>-->
							
							<td><?php echo "<strong>Results: </strong>".$rows['lab_results'].".<br/><strong>Comments:</strong> ".$row['comments']."<br/><strong>Released : </strong><strong>".$dtz->format('j F, Y g:i A')."</strong";?></td>
							
						</tr>
						<?php //endforeach;?>
						<?php endforeach;?>
						<?php endforeach;?>
						</tbody>
						
				</table>
				</div>
			
		
		
	</div>
 