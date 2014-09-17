<?php error_reporting(E_ALL ^ E_NOTICE);
$id = $this -> uri -> segment(3);

?>
<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
		</style>
<?php $current_year = date('Y');
			$earliest_year = $current_year - 10;
		?>
		<script type="text/javascript">
$(document).ready(function(){
   $(".filter_maps").click(function(){
   	var id=$(this).attr('id');
   	//alert(id);
      var url = "<?php echo base_url().'c_disease/cases'?>";
        $.ajax({
          type: "POST", 
          
          data: "id="+id,
          url: url,
          beforeSend: function() {
            $("#pop").html("");
          },
          success: function(msg) {
           $("#pop").html(msg);
          	$( "#pop" ).dialog({
           autoOpen: true,
           height: 300,
            width: 600,
            modal: true
           
        });
            $("#mapshow").html(msg);
             }
         });
    });
    
     $(".filter_maps1").click(function(){
   	var id=$(this).attr('id');
   	//alert(id);
      var url = "<?php echo base_url().'c_disease/sample'?>";
        $.ajax({
          type: "POST", 
          
          data: "id="+id,
          url: url,
          beforeSend: function() {
            $("#pop1").html("");
          },
          success: function(msg) {
           $("#pop1").html(msg);
          	$( "#pop1" ).dialog({
           autoOpen: true,
           height: 300,
            width: 600,
            modal: true
           
        });
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
		<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc'] = function(x, y) {
				return ((x < y) ? -1 : ((x > y) ? 1 : 0));
			};

			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x, y) {
				return ((x < y) ? 1 : ((x > y) ? -1 : 0));
			};

			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable({
					"bJQueryUI" : true,

					"aaSorting" : [[0, 'asc'], [1, 'asc']],
					"aoColumnDefs" : [{
						"sType" : 'string-case',
						"aTargets" : [2]
					}]
				});
			});
		</script>
		<div id="main_content">
	<div class="leftpanel">
		<fieldset>
			<legend>Menu</legend>
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
    <?php if($id==''){}else{?>
    <h3 class="accordion" id="">More Action<span></span></h3>
<div class="container">
    <div class="content">
    	 <h3><a href="<?php echo base_url(); ?>c_incidents/all_diseases" id = '' class="link">Initial Response</a></h3>
    	 <h3><a href="<?php echo base_url(); ?>c_incidents/reported" id = '' class="link">Reported Response</a></h3>
    </div>
</div>
<h3 class="accordion" id="">Alerts<span></span></h3>
<div class="container">
    <div class="content">
      <h3><a href="<?php echo base_url(); ?>c_incidents/report_incidence" id = '' class="link">Send New Alert</a></h3>
      <h3><a href="<?php echo base_url(); ?>c_incidents/all_diseases_edit" id = '' class="link">Edit Incident</a></h3>
    
    </div>
</div>
<?php if($level!=1){}else{?>
<h3 class="accordion" id="">Disease Management<span></span><h3>
<div class="container">
    <div class="content">
      <h3><a href="<?php echo base_url(); ?>c_disease/manage_d" id = '' class="link">Edit Diseases</a></h3>
         
    </div>
</div>
<h3 class="accordion" id="">Report<span></span></h3>
<div class="container">
    <div class="content">
      <h3><a href="#" id = '' class="link">Tables</a></h3>
      <h3><a href="<?php echo base_url(); ?>report_management/index" id = '' class="link">Graphs</a></h3>
      <h3><a href="<?php echo base_url(); ?>c_incidents/masterdb" id = '' class="link">Master Database (ReadOnly)</a></h3>
      <h3><a href="<?php echo base_url(); ?>logs/index" id = '' class="link">Access Traffic (ReadOnly)</a></h3>
      <h3><a href="<?php echo base_url(); ?>report_management/responses" id = '' class="link">Responses Download (ReadOnly)</a></h3>
    
    </div>
</div>
<?php }}?>

</div>

</fieldset>
<div id="pop"></div>
<div id="pop1"></div>
</div>
	<div id="left_content1">
		<fieldset>
			<legend>Disease List</legend>
	<div>
			<p>

				<table  style="margin-left: 0;" id="example" width="100%">
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
						foreach($disease as $row):?>
						<tr>
							<td><?php echo $row -> Acronym; ?></td>
							<td><?php echo $row -> Full_Name; ?></td>
							<td><a  id = '<?php echo $row -> id; ?>' class="filter_maps">View Disease Case Definition</a></td>
							<td><a  id = '<?php echo $row -> id; ?>' class="filter_maps1">View Lab Sample Handling</a></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
						
				</table>
			</p>
		
		
	</div>
	</fieldset>
	</div>
	
	</div>
	
			
 