<?php 
if($results != NULL)
{ ?>
	<option value=''>Select Exam</option>
	<?php
	foreach ($results as $row) {
		?>
			<option value="<?= $row->exam_id ?>"><?= $row->terminal_name ?></option>
		<?php
	}
	if($opt == 'final' && $theme_option->final_upscale_marking == 1){
		echo'<option value="'.AGGREGATE_ID.'">Aggregate</option>';
	}
}
else
{
	echo "<option value=''>No Records</option>";
}
?>