<?php 
if($results != NULL)
{
	?>
	<option value=''>Select Topics</option>
	<?php
	foreach ($results as $row) {
		?>
			<option value="<?= $row->id ?>"><?= $row->sub_topic ?></option>
		<?php
	}
}
else
{
	echo "<option value=''>No Records</option>";
}
?>