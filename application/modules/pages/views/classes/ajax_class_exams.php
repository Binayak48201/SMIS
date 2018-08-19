<?php 
if($results != NULL)
{
	?>
	<option value=''>Select Exam</option>
	<?php
	foreach ($results as $row) {
		?>
			<option value="<?= $row->exam_id ?>"><?= $row->terminal_name ?></option>
		<?php
	}
}
else
{
	echo "<option value=''>No Records</option>";
}
?>