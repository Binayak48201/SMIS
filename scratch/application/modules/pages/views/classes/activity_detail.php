<div class="col-md-12">
	<!-- <div class="col-md-4">Name Of Teacher: </div><div class="col-md-4">Subject: </div><div class="col-md-4">Date: </div>
	<div class="col-md-4">Class: </div><div class="col-md-4">Section: </div><div class="clearfix"></div> -->
	<?php if(isset($activities) && !empty($activities)){ ?>
		<table class="table table-bordered table-condensed">
			<tbody>
				<tr>
					<td>Topic or Main Idea or Key Concepts: <ol><?php foreach ($activities as $activity) { ?>
						<li><?= $activity->activity_key; ?> <?php if($this->general->is_admin('su_admin') ){?><a href="<?= site_url('pages/classes/lession_plan/delete_activity/'.$this->uri->segment(4).'/'.$activity->activity_id); ?>" class="btn btn-danger btn-sm no-padding"  title="Delete"><i class="icon-trash"  onclick="return confirm('Are you Sure?'); "></i></a><?php } ?></li>
				<?php	} ?></ol></td>
				</tr>
				<tr>
					<td >Objectives: <ol><?php foreach ($activities as $activity) { ?>
						<li><?= $activity->activity_objective; ?></li>
				<?php	} ?></ol></td>
				</tr>
				<tr>
					<td>Standards Used:
							<ol><?php foreach ($activities as $activity) { ?>
						<li><?= $activity->standard; ?></li>
				<?php	} ?></ol>
					</td>
				</tr>
				<tr>
					<td>Teaching Materials: <ol><?php foreach ($activities as $activity) { ?>
						<li><?= $activity->teaching_material; ?></li>
				<?php	} ?></ol></td>
				</tr>
				<tr>
					<td>Activities: <ol><?php foreach ($activities as $activity) { ?>
						<li><a class="" href='<?= $activity->activity_file != '' ? site_url('pages/classes/lession_plan/activity')."/$activity->activity_title/".base64_encode($activity->activity_file) : 'javascript:void(0);' ?>'><?= $activity->activity_title?></a>(<?= $activity->activity_date?>)</li>
				<?php	} ?></ol></td>
				</tr>
				<tr>
					<td>Assessments: <ol><?php foreach ($activities as $activity) { ?>
						<li><?= $activity->assignments; ?></li>
				<?php	} ?></ol></td>
				</tr>
				<tr>
					<td>Home Assignments: <ol><?php foreach ($activities as $activity) { ?>
						<li><?= $activity->home_assignments; ?></li>
				<?php	} ?></ol></td>
				</tr>
			</tbody>
		</table>
	<?php } 
	else{
	?>
		<div class="text-center note note-info">No Activities Recorded.</div>
	<?php } ?>
</div> 
                              
                            