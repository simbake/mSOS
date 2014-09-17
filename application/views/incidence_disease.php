<script>
$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable( {
					
				} );
			} );
  </script>


	
	 <div class="col-md-9" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Reported Diseases <span class="glyphicon glyphicon-info-sign" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        	
        <table class="table table-responsive table-hover table-striped" id="example" width="100%" >
					<thead>
					<tr>
						<th>Diseases</th>
						<th></th>			    
					</tr>
					</thead>
					
							<tbody>
								<?php
						foreach($dlist as $row):
						foreach($row->disease_name as $faci):

						?>
						<tr>

							<td><?php echo $faci->Full_Name;?></td>
							<td><a href="<?php echo site_url('c_disease/disease_details/'.$row->Disease_id.'/'.$faci->Full_Name);?>" class="link">View Details</a></td>
						</tr>
						<?php endforeach;?>
						<?php endforeach;?>
					
						</tbody>
						
				</table>
        
        </div>
      </div>
    </div></div>

    
  </div> 

