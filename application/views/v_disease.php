
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
							
							<button class='label label-primary' onclick="show_Bootbox(this.value)" value="<?php echo $row->definition;?>"><span class='glyphicon glyphicon-eye-open'></span>View Disease Case Definition</button>
							</td>
							<td>
						<Button class='label label-primary' onclick="show_Bootbox(this.value)" value="<?php echo $row->sample;?>"><span class='glyphicon glyphicon-eye-open'></span>View Sample Definition</Button>

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
  <script>
  	function show_Bootbox(definition){
  		bootbox.alert(definition);
  	}
  </script> 
  
	
	