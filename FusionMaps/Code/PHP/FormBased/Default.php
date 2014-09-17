<HTML>
<HEAD>
	<TITLE>FusionMaps PHP sample - Form Based Data Example</TITLE>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.text{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>
</HEAD>
<BODY>

<?
/*
    In this example, we first present a form to the user, to input data.
	For a demo, we present a very simple form with values showing the daily revenue 
	of a company from various continents
	The form is rendered in this page (Default.php). 
	It submits its data to FormSubmit.php. 
	In FormSubmit.php, we retrieve this data, convert into XML and then
	render the map.
	
	So, basically this page is just a form.
*/
?>
<CENTER>
	<h2><a href="http://www.fusioncharts.com" target="_blank">FusionMaps</a> - PHP Samples</h2> 
	<h4>Form-Based Data : Data Entry Page</h4>
	<p class='text'>Please enter Value for eatch Country Value. We'll plot this data on a FusionMaps World. </p>
	<p class='text'>To keep things simple, we're not validating for non-numeric data here. So, please enter valid numeric values only. In your real-world applications, you can put your own validators.</p>
	<FORM NAME='SalesForm' ACTION='FormSubmit.php' METHOD='POST'>
	<table width='50%' align='center' cellpadding='2' cellspacing='1' border='0' class='text'>
		<tr>
			<td width='50%' align='right'>
				<B>Asia:</B>&nbsp;			</td>
			<td width='50%'>
				<input name='AS' type='text' id="AS" value='800' size='5'></td>
		</tr>
		<tr>
			<td width='50%' align='right'>
				<B>Europe:</B>&nbsp;			</td>
			<td width='50%'>
				<input name='EU' type='text' id="EU" value='300' size='5'></td>
		</tr>
		<tr>
			<td width='50%' align='right'>
				<B>Africa:</B>&nbsp;			</td>
			<td width='50%'>
				<input name='AF' type='text' id="AF" value='360' size='5'></td>
		</tr>
		<tr>
			<td width='50%' align='right'>
				<B>North America:</B>&nbsp;			</td>
			<td width='50%'>
				<input name='NA' type='text' id="NA" value='500' size='5'></td>
		</tr>
		<tr>
			<td width='50%' align='right'>
				<B>South America:</B>&nbsp;			</td>
			<td width='50%'>
				<input name='SA' type='text' id="SA" value='200' size='5'></td>
		</tr>
		<tr>
          <td align='right'><B>Central America:</B>&nbsp; </td>
		  <td><input name='CA' type='text' id="CA" value='99' size='5'></td>
	  </tr>
		<tr>
          <td align='right'><B>Oceania:</B>&nbsp; </td>
		  <td><input name='OC' type='text' id="OC" value='75' size='5'></td>
	  </tr>
		<tr>
			<td width='50%' align='right'><B>Middle East:</B> </td>
			<td width='50%'><input name='ME' type='text' id="ME" value='250' size='5'></td>
		</tr>
		<tr>
		  <td align='right'>&nbsp;</td>
		  <td><input name="submit" type='submit' value='Chart it!'></td>
	  </tr>
	</table>
	</FORM>
	
</CENTER>
</BODY>
</HTML>
