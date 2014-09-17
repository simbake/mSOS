<?php foreach($case as $row):?>
	<h3>Lab Sample Handling: <?php echo $row->Full_Name;?>(<?php echo $row->Acronym;?>) </h3>
	<p style="font-size: 24px; text-align: justify;">
		<?php echo nl2br($row->sample);?>
	</p>
<?php endforeach;?>