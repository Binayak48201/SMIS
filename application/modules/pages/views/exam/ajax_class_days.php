<?php 
if($results != NULL)
{ ?>
	<option value=''>Select Subject</option>
	<?php
	foreach ($results as $row) {
		?>
			<option value="<?= $row->class_days_id ?>"><?= $row->subject_name ?></option>
		<?php
	}
}
else
{
	echo "<option value=''>No Records</option>";
}
?>