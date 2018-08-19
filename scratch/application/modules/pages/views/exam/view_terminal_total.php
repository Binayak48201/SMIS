<form action="<?= site_url('pages/exam/marks_entry/add_terminal_total'); ?>" method="post">
	<table class="table table-bordered table-condensed table-striped simple_table">
		<thead>
			<tr>
				<th>Sn</th>
				<th>Student Name</th>
				<th>Roll No</th>
				<?php
				if(isset($subjects))
				{
					foreach ($subjects as $subject) 
					{
						?>
						<th><?= $subject->subject_name ?></th>
						<?php
					}
				}
				?>
				<th>Total Marks</th>
				<th>Total Obtain Marks</th>
				<th width="100px">Status</th>
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
					$total_obtain = 0;
					$total_mark = 0;
					$data_diff = FALSE;
					$pending_stat = FALSE;
					$pass_stat = TRUE;
					$st_ids[] = $student->student_id;
					?>
							
					<tr>
						<td><?= $i++; ?></td>
						<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>"><?= $student->st_fname; ?> <?= $student->st_mname; ?> <?= $student->st_lname; ?></a></td>
						<td><?= $student->current_roll; ?></td>
						<?php
						if(isset($subjects))
						{ //print_e($subjec);
							foreach ($subjects as $subject) { 
								$final_mark = modules::run("pages/exam/marks_entry/students_final_mark",$student->student_id,$subject->subject_id,$exam_id);
								$total_mark += $subject->full_marks;
								//print_e($subject);
								?>
								<td><?php if($final_mark != NULL)
									{
										if($exam_id != AGGREGATE_ID)
										{
											$total_obtain += $final_mark->total_marks;
											//$total_mark += $final_mark->full_mark;
									 		echo $final_mark->total_marks ;
									 		if($final_mark->total_marks < $final_mark->pass_mark)
									 		{
									 			$pass_stat = FALSE;
									 		}
										}
										else
										{
											$total_obtain += $final_mark->final_mark;
											
									 		echo $final_mark->final_mark ;
									 		if($final_mark->final_mark < $final_mark->pass_marks)
									 		{
									 			$pass_stat = FALSE;
									 		}
										}
							 		}
							 		else
							 		{
							 			echo 'N/A';
							 			$pending_stat = TRUE;
							 			//$data_diff = TRUE;
							 		}
								 		 ?></td></td>
								<?php
							
								
							}
						}
						?>
						<td class="no-padding"><input type="text" class="form-control padding-min" name="total_mark_<?= $student->student_id ?>" value="<?= $total_mark ?>" ></td>
						<td class="no-padding"><input type="text" class="form-control padding-min" name="obtain_mark_<?= $student->student_id ?>" value="<?= $total_obtain ?>" ></td>
						<td class="no-padding">
							<select name="status_<?= $student->student_id ?>" class="form-control padding-min" >
								<option <?= $pass_stat == FALSE ? 'selected' : '' ?> value="FAIL">Fail</option>
								<option <?= $pass_stat == TRUE && $pending_stat == FALSE ? 'selected' : '' ?> value="PASS">Pass</option>
								<option <?= $pass_stat == TRUE && $pending_stat == TRUE ? 'selected' : '' ?> value="PENDING">Pending</option>
							</select>
						</td>
					</tr>
					<?php 
				} 
			} ?>
		</tbody>
	</table>
	<input type="hidden" name="exam" value="<?= $exam_id ?>">
	<input type="hidden" name="grade" value="<?= $grade ?>">
	<input type="hidden" value='<?= serialize($st_ids); ?>' name="st_ids">
	<button class="btn btn-success" name="action" value="ADD" type='submit'>Save</button>
</form>