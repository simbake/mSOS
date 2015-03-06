<script type="text/javascript">
   	function showFields(disease_value){
   		/*redirect("home_controller/"+disease_value);*/
   		var base_url="<?php echo base_url();?>";
   		if(disease_value==0){
   		window.location.replace(base_url+"home_controller/");	
   		}else{
   		window.location.replace(base_url+"home_controller/home/"+disease_value);
   		}
   	}
   	
   </script>
<div class="col-md-9" style="padding-left: 3%;">
<div class="row">

	
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Map <?php if(isset($map_diseaseName) && $this->uri->segment(3)){echo " of ".$map_diseaseName;} ?> <span class="glyphicon glyphicon-globe" style=""></span></h3>
      
      </div>
      <div class="panel-body" style="overflow-y: auto">
      	<?php if($this->session->userdata("user_indicator")=="Administrator"){ ?>
      		
      	<select onchange="showFields(this.value)" style="width: auto;" data-live-search="true" title='Please Select Disease To Filter' data-size="5" data-width="auto" class="selectpicker" multiple data-max-options="1" >
      	 <!--<option disabled="disabled">----Please select disease to filter map-----</option>-->
      	 <option value='0'>All Disease</option>
      	<?php foreach($all_diseases as $diseases_all){  ?>
      		<option value="<?php echo $diseases_all->id ?>"><?php echo $diseases_all->Full_Name ?></option>
      		<?php } ?>
      	</select><br/><br/>
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
   
    