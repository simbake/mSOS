<?php error_reporting(E_ALL^E_NOTICE);

?>
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
</script>


				
				
				<div class="panel panel-default">
					<div class="panel-heading">
						Weekly Summary
						<div style="float:right;"><span class="glyphicon glyphicon-save"></span>
							<a href="<?php echo site_url('weekly_controller/week_summary_report');?>"> Download</a></div>
						
					</div>
					<div class="panel-body" style="overflow-y: auto">
				<table  class="table table-striped table-bordered table-hover table-responsive" id="example" width="100%">
					
				<thead>
				<tr>
				<th>Facility Name</th>
				<th>Date</th>
				<th>Time</th>
				<th>Day</th>
				<th>County</th>
				<th>Contact</th>
				<th>Phone</th>
				<th>System report</th>
				<th>Facility report</th>
				</tr>
				</thead>

				<tbody>
				<?php
				foreach($all as $row):
				?>
				<tr>
				<td><?php echo $row -> Facility->Facility_name; ?></td>
				<td><?php $a = $row->date_week; $dt = new DateTime($a); echo $dt->format('j F, Y') ?></td>
				<td><?php $b = $row->date_week; $dts = new DateTime($b); echo $dts->format('g:i A') ?></td>
				<td><?php echo $dt->format('l'); ?></td>
				<td><?php echo $row -> Facility-> county; ?></td>
				<td><?php echo $row -> Facility-> contact; ?></td>
				<td><?php echo $row -> Facility-> phone_number; ?></td>
				<td><?php echo $row -> sys_number; ?></td>
				<td><?php echo $row -> facility_no; ?></td>
			</tr>
			<?php  endforeach; ?>
			
			</tbody>
</table>
		</div>
	</div>

