
<script>
  		$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable({
					"bJQueryUI" : true
				});
			});
  </script>

	 <div class="col-md-9" style="padding-left: 1.5%;">
	 	
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Disease List <span class="glyphicon glyphicon-globe" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        	
        	<table  class="table table-striped table-bordered table-hover" id="example" width="100%">
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
						foreach($list as $row):?>
						<tr>
							<td><?php echo $row -> Acronym; ?></td>
							<td><?php echo $row -> Full_Name; ?></td>
							<td>
							
							<label class='label label-primary'><span class='glyphicon glyphicon-eye-open'></span><a style="color: white" id = '<?php echo $row -> id; ?>' class="filter_maps"> View Disease Case Definition</a></label>
							</td>
							<td>
						<label class='label label-primary'><span class='glyphicon glyphicon-eye-open'></span><a style="color: white;" id = '<?php echo $row -> id; ?>' class="filter_maps1"> View Disease Case Definition</a></label>

							</td>
						</tr>
						<?php endforeach; ?>
						</tbody>
						
				</table>
        </div>
      </div>
    </div>
    </div>
  
  </div> 
  
	
	