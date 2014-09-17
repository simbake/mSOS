<?php foreach($case as $row):?>
	<h3>Case Definition: <?php echo $row->Full_Name;?>(<?php echo $row->Acronym;?>) </h3>
	<p style="font-size: 24px; text-align: justify;">
		<?php echo nl2br($row->definition);?>
	</p>
<?php endforeach;?>