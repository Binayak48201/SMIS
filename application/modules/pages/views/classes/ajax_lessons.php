<?php 
if($results != NULL)
{
	?>
	<option value=''>Select Lessons</option>
	<?php
	foreach ($results as $row) {
		?>
			<option value="<?= $row->ch_id ?>"><?= $row->main_topic ?></option>
		<?php
	}
}
else
{
	echo "<option value=''>No Records</option>";
}
?>