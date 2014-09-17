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
						Turn Around Time
						
					</div>
					<div class="panel-body" style="overflow-y: auto">
				<table  class="table table-striped table-bordered table-hover table-responsive" id="example" width="100%">
				<thead>
				<tr>
				<th>Incident Id</th>
				<th>Alert Date</th>
				<th>District Response Date</th>
				<th>County Response Date</th>
				<th>National Resonse Date</th>
				<th>Alert-District Elapsed Time</th>
				<th>Alert-National Elapsed Time</th>
				<th>Alert-Country Elapsed Time</th>
				<th>Kemri Response Date</th>
				<th>District-Kemri Elapsed Time</th>
				<th>National-Kemri Elapsed Time</th>
				<th>Country-Kemri Elapsed Time</th>
				<th>Alert-Kemri Elapsed Time</th>
				</tr>
				</thead>

				<tbody>
				<?php
				$fetch_incidence = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * 
FROM incidence i, incident_log l
WHERE i.id = l.incident_id
AND (l.district_incident !=  'NULL'
OR l.county_incident !=  'NULL'
OR l.national_incident !=  'NULL')
");
                foreach($fetch_incidence as $row):
                $fetch_log = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM kemri_response WHERE incident_id='$row[id]'");
				// foreach($fetch_log as $rowz):
				          //district reponse date
				                $d = $row['district_incident'];
								$d = explode('|', $d);
								$no=count($d);
								if($no>=5){
								//$act = $g[0];
								//$note = $g[1];
								//$find = $g[2];
								$tim = $d[3];
								//$take = $g[4];
								$dttg = new DateTime($tim);
								}
								//county reponse date
							    $c = $row['county_incident'];
								$c = explode('|', $c);
								$no=count($c);
								if($no>=5){
								//$act = $g[0];
								//$note = $g[1];
								//$find = $g[2];
								$tims = $c[3];
								//$take = $g[4];
								$county_reponse = new DateTime($tims);
								}
								//national response date
								 $n = $row['national_incident'];
								$n = explode('|', $n);
								$no=count($n);
								if($no>=5){
								//$act = $g[0];
								//$note = $g[1];
								//$find = $g[2];
								$timy = $n[3];
								//$take = $g[4];
								$national_reponse = new DateTime($timy);
								}
				//echo $row['id'];
				//print_r($row['incidence']['id']);				
				?>
				<tr>
				<td><?php echo $row['p_id']?></td>
				<td><?php $a=$row['time']; $dt = new DateTime($a); echo $dt->format('j F, Y g:i A')?></td>
				<td><?php if($dttg){echo $dttg->format('j F, Y g:i A');} ?></td>
				<td><?php if($county_reponse){echo $county_reponse->format('j F, Y g:i A');} ?></td>
				<td><?php if($national_reponse){echo $national_reponse->format('j F, Y g:i A');} ?></td>
				<td><?php
				if($dt && $dttg){
                $interval = date_diff($dt, $dttg);
                echo "<strong>".$interval->format('%m months %d days %h hours %i minutes %s seconds')."</strong>";
                  }
				?></td>
				<td><?php
				if($dt && $national_reponse){
                $interval = date_diff($dt, $national_reponse);
                echo "<strong>".$interval->format('%d days %h hours %i minutes %s seconds')."</strong>";
                  }
				?></td>
				<td><?php
				if($dt && $county_reponse){
                $interval = date_diff($dt, $county_reponse);
                echo "<strong>".$interval->format('%a days %h hours %i minutes %s seconds')."</strong>";
                  }
				?></td>
				<td><?php $b=$row['lab_time']; if($b!='0000-00-00 00:00:00'){$dts = new DateTime($b); echo $dts->format('j F, Y g:i A');}?></td>
				<td><?php
				if($dttg && $dts){
				$interval = date_diff($dttg, $dts);
                echo "<strong>".$interval->format('%a days %h hours %i minutes %s seconds')."</strong>";
				}
				?></td>
				<td><?php
				if($dttg && $national_reponse){
				$interval = date_diff($dttg, $national_reponse);
                echo "<strong>".$interval->format('%a days %h hours %i minutes %s seconds')."</strong>";
				}
				
				?></td>
				<td><?php
				if($dttg && $v){
				$interval = date_diff($dttg, $county_reponse);
                echo "<strong>".$interval->format('%a days %h hours %i minutes %s seconds')."</strong>";
				}
				?></td>
				<td>
				<?php
				if($dt && $dts){
				$interval = date_diff($dt, $dts);
                echo "<strong>".$interval->format('%a days %h hours %i minutes %s seconds')."</strong>";
				}
				?>
				</td>
			</tr>
			<?php //endforeach; ?>
			<?php endforeach; ?>
			</tbody>

	</table>
		</div>
	</div>
