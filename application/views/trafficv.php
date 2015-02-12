<?php error_reporting(E_ALL^E_NOTICE);

?>

<!--Datatables files load-->

<?php $current_year = date('Y');
	$earliest_year = $current_year - 10;
?>
<script>
	
	$(document).ready(function() {
        $('#dataTables-example').dataTable(
		{
		
		}
		);
    });
</script>
		 <div class="row">
		 	<div class="container-fluid">
		 		
          <div class="col-lg-12">
		 <div class="panel panel-default">
                        <div class="panel-heading">
                            User Access Log.
                            <div style="float: right;"><span class="glyphicon glyphicon-save"></span> <a href="<?php echo site_url('report_management/traffic');?>">Download</a></div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                               <table  style="margin-left: 0;" id="dataTables-example" class="table table-striped table-bordered table-hover" width="100%">
					<thead>
					<tr>
						<th>Username</th>
						<th>Status</th>
						<th>Time IN (Y/m/d)</th>
						<th>Time Out</th>
						<th>Duration</th>
						
										    
					</tr>
					</thead>
					
							<tbody>
								<?php
						foreach($all as $row):
						foreach($row->logss as $d):
						?>
						<tr>
							<td><?php echo $d -> fname; ?></td>
							<td><?php echo $row -> status; ?></td>
							<td><?php $a = $row->t_login; $dt = new DateTime($a); echo $dt->format('j F, Y g:i A') ?></td>
							<td><?php $b = $row->t_logout; if(!$b){$dts = new DateTime($b);//echo "Still Active";
							}else{$dts = new DateTime($b); echo $dts->format('j F, Y g:i A');} ?></td>
							<td><?php $difference = $dt->diff( $dts );
                                  $hours= $difference->format('%h hours');
								  $minutes= $difference->format('%i minutes');
								  $seconds= $difference->format('%s seconds');
								  if($hours>0){
								  	echo $hours." ";
								  }
								  if($minutes>0){
								  	echo $minutes." ";
								  }
								  if($seconds){
								  	echo $seconds;
								  }
                                             											 
						?></td>
							
						</tr>
						<?php endforeach; ?>
						<?php endforeach; ?>
						
						</tbody>
						
				</table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
           <!--<h2>Recent Bookins</h2>-->
            
          
        </div>
       </div>
        </div>