<?php

//We have included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
include ("Scripts/FusionCharts/FusionCharts.php");
?>
<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script> 
 <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/unit_size.js"></script>
      <?php echo $map['js']; ?>
      <script type="text/javascript">
$(document).ready(function(){
   $(".filter_maps").click(function(){
   	var id=$(this).attr('id');
   	//alert(id);
      var url = "<?php echo base_url().'report_management/filter'?>";
        $.ajax({
          type: "POST", 
          
          data: "id="+id,
          url: url,
          beforeSend: function() {
            $("#mapshow").html("");
          },
          success: function(msg) {
            $("#mapshow").html(msg);
             }
         });
    });

});
</script>
<script>
	$(function() {
		$(document).ready(function() {
			//$('.accordion').accordion({defaultOpen: ''});
			//custom animation for open/close
			$.fn.slideFadeToggle = function(speed, easing, callback) {
				return this.animate({
					opacity : 'toggle',
					height : 'toggle'
				}, speed, easing, callback);
			};

			$('.accordion').accordion({
				defaultOpen : 'section1',
				cookieName : 'nav',
				speed : 'medium',
				animateOpen : function(elem, opts) {//replace the standard slideUp with custom function
					elem.next().slideFadeToggle(opts.speed);
				},
				animateClose : function(elem, opts) {//replace the standard slideDown with custom function
					elem.next().slideFadeToggle(opts.speed);
				}
			});
		});

	}); 
</script>
<script>
  			$(function() {
  	
  	   $( "#month" ).combobox({
        	selected: function(event, ui) {
        		
           var data =$("#year").val();
           var month =$("#month").val();
           //var name =encodeURI($("#desc option:selected").text());
          
          
        var url = "<?php echo base_url().'report_management/monthly' ?>"
			$.ajax({
			type: "POST",
			data: "year="+data+"&month="+month,
			url: url,
			beforeSend: function() {
			$("#contentlyf").html("");
			},
			success: function(msg) {
			$("#contentlyf").html(msg);

			}
			});
			return false;

			}
			});

			$( "#disease" ).combobox({
			selected: function(event, ui) {

			var dyear =$("#dyear").val();
			var dmonth =$("#dmonth").val();
			var dise=$("#disease").val();
			var names =encodeURI($("#disease option:selected").text());

			var url = "<?php echo base_url().'report_management/daily' ?>";
	$.ajax({
	type: "POST",
	data: "year="+dyear+"&dmonth="+dmonth+"&disease="+dise,
	url: url,
	beforeSend: function() {
	$("#contently").html("");
	},
	success: function(msg) {
	$("#contently").html(msg);

	}
	});
	return false;

	}
	});

	});
  </script>
<div id="main_content">
	<div class="leftpanel">
		<fieldset>
	<div class="dash_menu">
  <h3 class="accordion" id="">About Us<span></span><h3>
<div class="container">
    <div class="content">
    	 <h3><a href="#" id = '' class="link">Background</a></h3>
    	 <h3><a href="<?php echo base_url(); ?>faq/index" id = '' class="link">FAQ</a></h3>
    	 <h3><a href="<?php echo base_url(); ?>blogs/index" id = '' class="link">Blog</a></h3>
    	 <h3><a href="<?php echo base_url(); ?>contact/index" id = '' class="link">Contact Us</a></h3>
    </div>
</div>
<h3 class="accordion" id="">More Action<span></span></h3>
<div class="container">
    <div class="content">
    	 <h3><a href="<?php echo base_url(); ?>c_incidents/all_diseases" id = '' class="link">Initial Response</a></h3>
    	 <h3><a href="<?php echo base_url(); ?>report_management/responses" id = '' class="link">Reported Response</a></h3>
    </div>
</div>
<h3 class="accordion" id="">Alerts<span></span><h3>
<div class="container">
    <div class="content">
      <h3><a href="<?php echo base_url(); ?>c_incidents/report_incidence" id = '' class="link">Send New Alert</a></h3>
      <h3><a href="<?php echo base_url(); ?>c_incidents/all_diseases_edit" id = '' class="link">Edit Incident</a></h3>
    
    </div>
</div>
</div>

</fieldset>
<fieldset>
	<legend>Alerts</legend>
	<?php if($disease >0):?>   
		<div class="message warning">
			<h2>Reported Disease(s)</h2>
			<p class="linkss">
			<?php echo $disease; ?> Disease(s)</a> have been flagged.
			</p>
		</div>
		<?php endif; ?>
		<?php if($incident >0):?>
		<div class="message warning">
			<h2>Reported Incidence(s)</h2>
			<p class="linkss">
			<?php echo $incident; ?> Incidence(s)</a> have been flagged.
			</p>
		</div>
		 <?php endif; ?>
		
		</fieldset>
		<fieldset>
			<legend>Confirmed cases</legend>
			<?php if($confirm >0):?>  
			<div class="message warning">
			<h2>Confirmed Incidence (s)</h2>
			<p class="linkss">
			<?php echo $confirm; ?> Incidence(s)</a> have been lab confirmed.
			</p>
			</div>
			<?php endif; ?>
</fieldset>
</div>
	<div id="left_content">
		
		
		<fieldset>
		<legend>Map</legend>
	  <div id="mapshow" style="margin-left: 0px;"> <?php echo $map['html']; ?></div>
	  </fieldset>
	  <fieldset>
		<legend>Lifetime Analysis</legend>
<div> <?php echo renderChart("" . base_url() . "Scripts/FusionCharts/StackedColumn2D.swf", "", $strXML_e5, "e_6", 700, 400, false, true); ?></div>
</fieldset>

		
	</div>
	<div class="rightpanel">
		<fieldset>
			<legend>Filter Map Reports</legend>
			<div class="dash_menu">
<h3 class="accordion" id="">Disease<span></span><h3>
<div class="container">
    <div class="content">
    	<?php foreach($list as $row):?>
      <h3><a  id = '<?php echo $row -> id; ?>' class="filter_maps"><?php echo $row -> Full_Name; ?></a></h3>
      <?php endforeach; ?>
    
    </div>
</div>


</div>
		</fieldset>
		
	</div>
	</div>
	
	
	
