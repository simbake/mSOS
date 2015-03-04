<script type="text/javascript">
   	function showFields(disease_value){
   		redirect("home_controller/"+disease_value);
   	}
   	
   </script>
<div class="col-md-9" style="padding-left: 3%;">
<div class="row">

	
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Map <span class="glyphicon glyphicon-globe" style=""></span></h3>
      
      </div>
      <div class="panel-body" style="overflow-y: auto">
      	<?php if($this->session->userdata("user_indicator")=="Administrator"){ ?>
      	<select onchange="showFields(this)">
      	 <option>All Disease</option>
      	<?php foreach($all_diseases as $diseases_all){  ?>
      		<option><?php echo $diseases_all->Full_Name ?></option>
      		<?php } ?>
      	</select>
      	<?php }?>
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        	<?php echo $map['html']; ?>
        <!--<img src="<?php echo base_url() ?>Images/map.jpg" alt="" class="img-responsive">-->
        </div>
      </div>
    </div>
    
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Graph <span class="glyphicon glyphicon-stats" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        <?php echo renderChart("" . base_url() . "Scripts/FusionCharts/StackedColumn2D.swf", "", $strXML_e5, "e_6", '', 400, false, true); ?>
        </div>
      </div>
    </div>
    
   </div>
   
   </div>
   
    