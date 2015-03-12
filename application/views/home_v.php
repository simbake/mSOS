<script type="text/javascript">

		function load_map(locations){
		var base_url="<?php echo base_url() ?>
		";
		var myLatlng = new google.maps.LatLng(-0.023559,37.90619);
		var mapOptions = {
		zoom: 6,
		center: myLatlng,
		cluster:false,
		mapTypeId: google.maps.MapTypeId.HYBRID
		}
		var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		var infowindow = new google.maps.InfoWindow();

		for (i = 0; i < locations.length; i++) {

		var contentString = 'Facility :' + locations[i].facility_name+ '<br>Incidents Reported ' +locations[i].total+'<br> <a href="'+base_url+'report_management/facility_alerts/' +locations[i].mfl_code +'" class="linkss">View Details</a>'

		var  marker = new google.maps.Marker({
		position: new google.maps.LatLng(locations[i]['latitude'], locations[i]['longitude']),
		title:locations[i].facility_name,
		icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|9999FF|000000',
		animation: 'DROP'
		});

		google.maps.event.addListener(marker, 'click', (function(marker, contentString) {
		return function() {
		infowindow.setContent(contentString);
		infowindow.open(map, marker);
		}
		})(marker, contentString));

		marker.setMap(map);
		}

		}

		function showFields(disease_value){
		var base_url="<?php echo base_url() ?>";
		
		$('#map_canvas').html('<center style=""><img src="'+base_url+'Images/map_load.GIF"/></center>');
		if(disease_value!=null){
		$.ajax({

		url: base_url+'home_controller/map_Ajax_filter/'+disease_value,
		//data: 'action=check_username&username=' + t.value,
		dataType: 'json',
		type: 'post',
		success: function (j) {
		load_map(j)
		}
		});
		}
		else{
			load_map(0)
		}
		
		}

   </script>
<div class="col-md-9" style="padding-left: 3%;">
<div class="row">
	<div class="col-md-6">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Map <?php
		if (isset($map_diseaseName) && $this -> uri -> segment(3)) {echo " of " . $map_diseaseName;
		}
 ?> <span class="glyphicon glyphicon-globe" style=""></span></h3>
      
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

      	<?php } ?>
      	
			
        	
         <?php echo $map['js']; ?>
		
        <div style="/*border: 1px solid #036;*/ ;" id="container_map">
         <?php echo $map['html']; ?>
        <!--<img src="<?php echo base_url() ?>Images/map.jpg" alt="" class="img-responsive">-->
        	<!-- <div id="map-outer">
	
	
			</div>  -->
        
        </div>
      </div>
    </div>
    </div>
    
    <div class="col-md-6">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Graph <span class="glyphicon glyphicon-stats" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        <?php echo renderChart("" . base_url() . "Scripts/FusionCharts/StackedColumn2Dline.swf", "", $strXML_e5, "e_6", '', 350, false, true); ?>
        </div>
      </div>
    </div>
    
   </div>
   
   </div>
   
    