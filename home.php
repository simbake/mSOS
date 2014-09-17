<?php //We have included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
include ("Scripts/FusionCharts/FusionCharts.php");
$id=$this -> session -> userdata('user_id');
$level=$this -> session -> userdata('user_level');
?>
<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script> 
      <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/unit_size.js"></script>
      <?php echo $map['js']; ?>
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
          
          
        var url = "<?php echo base_url().'report_management/monthly' ?>
			"
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

			$("#disease").combobox({
			selected: function(event, ui) {

			var dyear =$("#dyear").val();
			var dmonth =$("#dmonth").val();
			var dise=$("#disease").val();
			var names =encodeURI($("#disease option:selected").text());

			var url = "
<?php echo base_url().'report_management/daily' ?>
	"
	$.ajax({
	type: "POST",
	data: "year="+dyear+"&month="+dmonth+"&disease="+dise+"&name="+names,
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
	<div class="col-lg-3">
		
		<div class="row">
		<fieldset>
	<div class="dash_menu">
      <h3 class="accordion" id="">About Us<span></span></h3>
<div class="container">
    <div class="content">
    	 <h3><a href="<?php echo base_url(); ?>about/index" id = '' class="link">Background</a></h3>
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
<h3 class="accordion" id="">Alerts<span></span></h3>
<div class="container">
    <div class="content">
      <h3><a href="<?php echo base_url(); ?>c_incidents/report_incidence" id = '' class="link">Send New Alert</a></h3>
      <h3><a href="<?php echo base_url(); ?>c_incidents/all_diseases_edit" id = '' class="link">Edit Incident</a></h3>
    
    </div>
</div>
<?php if($id==0 || $level!=1){}else{?>
<h3 class="accordion" id="">Disease Management<span></span><h3>
<div class="container">
    <div class="content">
      <h3><a href="<?php echo base_url(); ?>c_disease/manage_d" id = '' class="link">Edit Diseases</a></h3>
         
    </div>
</div>
<h3 class="accordion" id="">Reports<span></span></h3>
<div class="container">
    <div class="content">
      <h3><a href="#" id = '' class="link">Tables</a></h3>
      <h3><a href="<?php echo base_url(); ?>report_management/index" id = '' class="link">Graphs</a></h3>
      <h3><a href="<?php echo base_url(); ?>c_incidents/masterdb" id = '' class="link">Master Database (ReadOnly)</a></h3>
      <h3><a href="<?php echo base_url(); ?>logs/index" id = '' class="link">Access Traffic (ReadOnly)</a></h3>
      <h3><a href="<?php echo base_url(); ?>report_management/responses" id = '' class="link">Responses Download (ReadOnly)</a></h3>
	  <h3><a href="<?php echo base_url(); ?>weekly_controller/index" id = '' class="link">Weekly summary (ReadOnly)</a></h3>
	  <h3><a href="<?php echo base_url(); ?>turn_around_tym_control/index" id = '' class="link">Turn Around Time (ReadOnly)</a></h3>
      <h3><a href="<?php echo base_url(); ?>a_management/kemri_table_view" id = '' class="link">Kemri Reports (ReadOnly)</a></h3>
    </div>
</div>
<?php }?>

</div>

</fieldset>
</div>

<div class="row">
<fieldset>
			<legend>Notifications</legend>
			
           <?php if($disease >0):?>   
		<div class="message warning">
			<h2>Reported Disease(s)</h2>
			<p>
			<a class="link" href="<?php echo site_url("c_disease/incidence_disease/"); ?>"><?php echo $disease; ?> Disease(s)</a> have been Reported.
			</p>
		</div>
		<?php endif; ?>
		<?php if($incident >0):?>
		<div class="message warning">
			<h2>Reported Incidence(s)</h2>
			<p>
			<a class="link" href="<?php echo site_url("c_disease/all_diseases/"); ?>"><?php echo $incident; ?> Incidence(s)</a> have been flagged.
			</p>
		</div>
		 <?php endif; ?>
		
</fieldset>
</div>
		
		<div class="row">
		<fieldset>
			<legend>Confirmed cases</legend>
			<?php if($confirm >0):?>  
			<div class="message information">
			<h2>Confirmed Incidence (s)</h2>
			<p>
			<a class="link" href="#"><?php echo $confirm; ?> Incidence(s)</a> have been confirmed.
			</p>
			</div>
			<?php endif; ?>	
		</fieldset>
		</div>
</div>

	<div class="col-lg-6">
		
		<div class="col-lg-0.5"></div>
		
		<div class="col-lg-12">

			<div class="row">
		<fieldset>
		<legend>Map</legend>
	  <div id="" style="margin-left: 0px;"> <?php echo $map['html']; ?></div>
	  </fieldset>
	  </div>
	  
	  <div class="row">
	  <fieldset>
		<legend>Lifetime Analysis</legend>
    <div><?php echo renderChart("" . base_url() . "Scripts/FusionCharts/StackedColumn2D.swf", "", $strXML_e5, "e_6", 640, 400, false, true); ?></div>
      </fieldset>
      </div>
      
        </div>   
		
	</div>
	
	<div class="col-lg-3">
		<div class="row">
		<fieldset>
			<legend>Filter Map Reports</legend>
			<div class="dash_menu">
<h3 class="accordion" id="">Disease<span></span><h3>
<div class="container">
    <div class="content">
    	<?php foreach($list as $row):?>
      <h3><a href="#" id = '' class="linkss"><?php echo $row -> Full_Name; ?></a></h3>
      <?php endforeach; ?>
    
    </div>
</div>


</div>
		</fieldset></div>
		
	</div>
	</div>
	