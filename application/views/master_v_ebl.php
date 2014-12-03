<?php error_reporting(E_ALL^E_NOTICE);

?>

<?php $current_year = date('Y');
	$earliest_year = $current_year - 10;
?>
<script type="text/javascript" charset="utf-8">
	

	$(document).ready(function() {
		/* Build the DataTable with third column using our custom sort functions */
		$('#example').dataTable({
			
		});
	}); 
</script>



				<div>
					<!--<div style="margin-left: 80%" >
		<a href="<?php echo site_url('report_management/commodity_excel');?>">
			<div class="activity excel"><h2> Download</h2></div>
		</a></div>-->
		
				
				<!--<h1 style="text-align: center"><?php echo $this -> uri -> segment(3); ?> Master Database View</h1>-->
				<div class="panel panel-default">
					<div class="panel-heading">
						Master Database View
						<?php if($this->session->userdata("user_indicator")=="Administrator" || $this->session->userdata("user_indicator")=="MOH" ){ ?>
						<?php if(isset($ebola_admin)){ ?>
				<div style="float:right;"><span class="glyphicon glyphicon-save"></span><a href="<?php echo site_url('ebola_reports/master_db_download');?>"> Download</a></div>
	
						<?php } else{ ?>
						<div style="float:right;"><span class="glyphicon glyphicon-save"></span><a href="<?php echo site_url('report_management/commodity_excel');?>"> Download</a></div>
					<?php }} ?>
					</div>
					<div class="panel-body" style="overflow-y: auto">
				<table  class="table table-striped table-bordered table-hover table-responsive" id="example" width="100%">
				<thead>
				<tr>

				<th>Phone</th>
				<th>Location</th>
				<th>Date</th>
				<th>Time</th>
				<th>Sex</th>
				<th>Age</th>
				<th>Status</th>
				<th>Old Age</th>
				<th>Old Sex</th>
				<th>Old Status</th>
				<th>Serial</th>
				<th>ID</th>
				
				<th>Portal</th>
				
				</tr>
				</thead>

				<tbody>
				<?php
				foreach($all as $row):
				//foreach($row->disease_name as $faci):

				?>
				<tr>
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
				<td><?php echo $row -> New_Age; ?></td>
				<td><?php echo $row -> New_Sex; ?></td>
				
				<td><?php echo $row -> New_Status; ?></td>
				
				<td><?php echo $row -> case_number; ?></td>
				<td><?php echo $row->msos_code ?></td>
				<td>
				<?php
                    //echo $row -> p_id;
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

				

			</tr>
			<?php endforeach; ?>
			<?php //endforeach; ?>
			<?php //endforeach; ?>

			</tbody>

		</table>
		</div>
	</div>
</div>
