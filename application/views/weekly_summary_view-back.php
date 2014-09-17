<?php error_reporting(E_ALL^E_NOTICE);

?>

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
</script>



				<div>
				<p>
				<h1 style="text-align: center"><?php echo $this -> uri -> segment(3); ?> Weekly Summary</h1>
				<table  style="margin-left: 0;" id="example" width="100%">
				<thead>
				<tr>
				<th>Facility code</th>
				<th>Date</th>
				<th>Time</th>
				<th>System number</th>
				<th>facility number</th
				<th></th>
				</tr>
				</thead>

				<tbody>
				<?php
				foreach($all as $row):
				?>
				<tr>
				<td><?php echo $row -> facility_code; ?></td>
				<td><?php $a = $row->date_week; $dt = new DateTime($a); echo $dt->format('j F, Y') ?></td>
				<td><?php $b = $row->date_week; $dts = new DateTime($b); echo $dts->format('g:i A') ?></td>
				<td><?php echo $row -> sys_number; ?></td>
				<td><?php echo $row -> facility_no; ?></td>
				
				
			</tr>
			<?php endforeach; ?>
			
			</tbody>

		</table>
		</p>

</div>
