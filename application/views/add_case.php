<?php


foreach($case as $rowz){
	$acronym=$rowz->Acronym;
	$fullname=$rowz->Full_Name;
	$definition=$rowz->definition;
	$disease_id=$rowz->id;
} 

 ?>
	
	 <div class="col-md-7" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Disease Case Definition: <?php echo $acronym; ?> <span class="glyphicon glyphicon-plus" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        
        <form class="form-horizontal" method="post" action="<?php echo base_url().'c_disease/edit_cases' ?>" role="form">
         	<input type="hidden" name="id" value="<?php echo $disease_id;?>"  />
         	<div class="form-group">
    <label for="names" class="col-sm-2 control-label">Disease: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" readonly="readonly" value="<?php echo $fullname; ?>"/>
    </div>
  </div>
  
  <div class="form-group">
    <label for="message" class="col-sm-2 control-label">Definition: </label>
    <div class="col-sm-10">
      <textarea name="defition" placeholder='' required rows="7" class="form-control"><?php echo $definition;  ?></textarea>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Add Definition</button>
    </div>
  </div>
</form>
        
        
        </div>
      </div>
    </div></div>

    
  </div> 
  
	</div>		
	</div>	
