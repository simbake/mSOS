<?php error_reporting(E_ALL ^ E_NOTICE);
//$id = $this -> uri -> segment(3);
$id=$this -> session -> userdata('user_id');
$level=$this -> session -> userdata('user_level');

if (isset($all)) {

	$incident = $all -> p_id;
	$id = $all -> id;
}
?>

<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
		</style>
<?php $current_year = date('Y');
			$earliest_year = $current_year - 10;
		?>
		<script>
		$(function() {
			$(document).ready(function() {
				//$('.accordion').accordion({defaultOpen: ''});
				//custom animation for open/close
			
			$('#date_received').datepicker({
	/*timeFormat: "hh:mm tt"*/
});
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
	<div id="left_content1">
		<fieldset>
			<legend>Specimen received date</legend>
			<?php echo validation_errors(); ?>
<form action="<?php echo base_url().'a_management/specimen_received_submit'?>" method="post" >

<table width="50%" class="data-table table-bordered">
<tr>
<td><label>Incident Id: </label></td>
	<td>
	<input type="text" id="Incidence_id" readonly="readonly" required name="Incidence_id" value="<?php echo $incident ?>"/>
	</td>
	</tr>
	<td><label>Specimen received:</label></td>
	<td>
		<input type="text" id="date_received" name="date_received" required/> 
	</td>
	
<?php
    
/*echo "<tr>
<td>".form_label('Message: ', 'message'). "</td>
<td><textarea name='message'>" . set_value("message") . "</textarea></td>
</tr>";*/

echo "<tr>
<td></td><td>".form_submit('submit', 'Submit Message') . "</td>
</tr>";

?>
</table>
			
		
	</fieldset>
	</div>
	
	</div>
	
			
 