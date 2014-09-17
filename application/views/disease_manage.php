


<script>
  		$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable({
					
				});
			});
  </script>
	
	 <div class="col-md-9" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Disease List <span class="glyphicon glyphicon-list-alt" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
       <table class="table table-striped table-bordered table-hover"  style="margin-left: 0;" id="example" width="100%">
					<thead>
					<tr>
						<th>Disease Acronym</th>
						<th>Disease Name</th>
						<th></th>	
						<th></th>	    
					</tr>
					</thead>
					
							<tbody>
								<?php
						foreach($diseases as $row):?>
						<tr>
							<td><?php echo $row -> Acronym; ?></td>
							<td><?php echo $row -> Full_Name; ?></td>
							<td><a href="<?php echo site_url('c_disease/edit_disease/'.$row->id)?>" class="link">Add Disease Case Definition</a></td>
							<td><a href="<?php echo site_url('c_disease/edit_sample/'.$row->id)?>" class="link">Add Lab Sample Handling</a></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
						
				</table>
        </div>
      </div>
    </div></div>

    
  </div> 
  
	</div>		
	</div>	
