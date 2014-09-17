

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
        <h3 class="panel-title"><?php $dname=str_replace("%20", " ", $this->uri->segment(4)); echo $dname; ?> Details <span class="glyphicon glyphicon-info-sign" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        	
        <table class="table table-responsive table-hover table-striped" id="example" width="100%" >
					<thead>
					<tr>

						<th>Sex</th>
						<th>Age</th>
						<th>Incidence Id</th>
						<th></th>				    
					</tr>
					</thead>
					
							<tbody>
								<?php
						foreach($details as $row):
						foreach($row->disease_name as $faci):?>
						<tr>

							<td><?php echo $row->Sex;?></td>
							<td><?php echo $row->Age;?></td>
							<td><?php echo $row->p_id;?></td>
							<td><!--<a href="#" class="link">Add more Data</a>--></td>
						</tr>
						<?php endforeach;?>
						<?php endforeach;?>
						</tbody>
						
				</table>
        
        </div>
      </div>
    </div></div>

    
  </div> 
  