<?php 
if($results != NULL)
{
	?>
	<option value=''>Select Section</option>
	<?php if($all == 'all') { ?>
		<option value='all'>All</option>
	<?php } ?>
	<?php
	foreach ($results as $row) {
		?>
			<option value="<?= $row->section_id ?>"><?= $row->section_name ?></option>
		<?php
	}
}
else
{
	echo "<option value=''>No Records</option>";
}
?>