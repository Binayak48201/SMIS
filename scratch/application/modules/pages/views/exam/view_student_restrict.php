<form action="<?= site_url('pages/exam/exam_setting/st_restrict'); ?>" method="post">
	<table class="table table-bordered table-condensed table-striped">
		<thead>
			<tr>
				<th>Sn</th>
				<th>Student Name</th>
				<th>Roll No</th>
				<th width="100px">MarkSheet Restrict</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$st_ids = array();
			if(isset($students))
			{
				$i=1;
				foreach ($students as $student) 
				{ 
					$st_ids[] = $student->student_id;
					?>
							
					<tr>
						<td><?= $i++; ?></td>
						<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>"><?= $student->st_fname; ?> <?= $student->st_mname; ?> <?= $student->st_lname; ?></a></td>
						<td><?= $student->current_roll; ?></td>
						<td class="">
							<div class="md-checkbox-inline">
								<div class="md-checkbox has-error">
									<input id="checkbox<?=$student->student_id?>" <?= check_st_restrict($student->student_id,$student->joined_batch,$exam_id,$grade, 'check') === TRUE ? 'checked': '' ?> class="md-check st_check" value='<?=$student->student_id?>' name='abs_std[]' type="checkbox">
									<label for="checkbox<?=$student->student_id?>">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>
									 </label>
								</div>
							</div>
						</td>
					</tr>
					<?php 
				} 
			} ?>
		</tbody>
	</table>
	<input type="hidden" name="exam" value="<?= $exam_id ?>">
	<input type="hidden" name="batch_id" value="<?= $batch_id ?>">
	<input type="hidden" name="section_id" value="<?= $section_id ?>">
	<input type="hidden" name="grade" value="<?= $grade ?>">
	<input type="hidden" value='<?= serialize($st_ids); ?>' name="st_ids">
	<button class="btn btn-success" name="add" value="ADD" type='submit'>Save</button>
</form>