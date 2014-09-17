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
			     		Facility List
			     	</div>
			     	<div class="panel-body" style="overflow-y: auto">
			     		<div class="table-responsive">
				<!--<h1 style="text-align: center">Facility List</h1>-->
				<table class="table table-striped table-bordered table-hover" id="example" width="100%">
					<thead>
					<tr>
						<th>Facility Code</th>
						<th>Facility Name</th>
						<th>Province</th>
						<th>District</th>
						<th>Division</th>
						<th>Type</th>
						<th>Owner</th>
						<th>Phone Number</th>
						<th>Contact</th>
						<?php if($access_level=='Administrator'){?>	
						<th>Edit</th>	
							<?php }?>		    
					</tr>
					</thead>
					
							<tbody>
								<?php
						foreach($all as $row):?>
						<tr>
							<td><?php echo $row->Facility_code;?></td>
							<td><?php echo $row->Facility_name;?></td>
							<td><?php echo $row->province;?></td>
							<td><?php echo $row->district;?></td>
							<td><?php echo $row->division;?></td>
							<td><?php echo $row->type;?></td>
							<td><?php echo $row->owner;?></td>
							<td><?php echo $row->phone_number;?></td>
							<td><?php echo $row->contact;?></td>
							<?php if($access_level=='Administrator'){?>	
							<td>
							<a href="<?php echo site_url('facility_c/edit/'.$row->id)?>"
				 class='label label-primary'><span class="glyphicon glyphicon-edit"></span>Edit</a>
				 
							<!--<a href="<?php echo site_url('facility_c/edit/'.$row->id)?>" class="link">Edit</a>-->
							
							</td>
							<?php }?>	
						</tr>
						<?php endforeach;?>
						</tbody>
						
				</table>
				</div>
			</div>
			</div>
		
		
	</div>
 