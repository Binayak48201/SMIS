<?php 

	$subjects = modules::run("pages/ajax/get_class_subjects",$grade,$batch);

	$assessments = modules::run("pages/ajax/get_assessments",$grade,$batch);

	$st_info =  modules::run("pages/ajax/get_st_info",$st_id);

	if($exam != AGGREGATE_ID)

	{

		$exam_info = modules::run("pages/ajax/get_exam_info",$st_id,$batch,$grade,$exam);

		$st_attendance =  modules::run("pages/ajax/get_st_with_attendance",$st_id,$grade,$batch,$exam);

		$terminal_comment = modules::run("pages/ajax/get_st_terminal_comment",$st_id,$grade,$batch,$exam);	

	}

	else

	{

		$final_exam = modules::run("pages/ajax/get_final_exam",$batch,$grade);

		$exam_info = modules::run("pages/ajax/get_exam_info",$st_id,$batch,$grade,$final_exam->exam_id);

		$st_attendance =  modules::run("pages/ajax/get_st_with_attendance",$st_id,$grade,$batch,$final_exam->exam_id);

		$terminal_comment = modules::run("pages/ajax/get_st_terminal_comment",$st_id,$grade,$batch,$final_exam->exam_id);	



	}

	if(isset($exam_info) && $exam_info != NULL){

		$class_teacher = modules::run("pages/ajax/get_class_teacher",$exam_info->section_id);	

?>

<div class="col-md-12">

	<h4 class="text-center text-up"><?= $exam != AGGREGATE_ID ? $exam_info->terminal_name.' EXAMINATION' : 'CONSOLIDATED RESULT'?>, <?= $exam_info->batch?></h4>

	<div class="col-md-12">

		<div class="" style="float: left; width:25%;">

			<b>Name:</b> <?= $st_info->st_fname ?> <?= $st_info->st_mname ?> <?= $st_info->st_lname ?> 

		</div>

		<div class="" style="float: left; width:25%;">

			<b>Grade:</b> <?= $exam_info->grade ?>

		</div>

		<div class="" style="float: left; width:25%;">

			<b>Section:</b> <?= $exam_info->section_name ?>

		</div>

		<div class="" style="float: left; width:25%;">

			<b>Roll No:</b> <?= $st_info->current_roll ?>

		</div>

	</div>

	<div class="clearfix"></div>

	<p class="spaced"></p>

	<?php if($exam != AGGREGATE_ID){ ?>

		<table class="table table-bordered table-condensed" width="100%" border="1px solid black">

			<thead>

				<tr>

					<th width="200px" rowspan="2">Subjects</th>

					<th class="text-center" rowspan="2">Full Marks</th>

					<th class="text-center" rowspan="2">Pass Marks</th>

					<th colspan="8" class="text-center">Marks Obtained</th>

				</tr>

				<tr>

					<th>Term Exam</th>

					<?php

						if($assessment_module == TRUE && !empty($assessments))

						{

							$a=0;

							foreach ($assessments as $assessment) {

								?>

								<th width="100px" ><?= $assessment->assessment_name ?></th>

								<?php 

								$a++;

							}
						}
					?>

					<th>Total Grade</th>

				</tr>

			</thead>

			<tbody>

				<?php 

					$totaling = TRUE;

					if(isset($subjects) && !empty($subjects) )

					{

						$total_mark = 0;

						$total_obtain = 0;

						foreach($subjects as $subject)

						{

							$final_mark = modules::run("pages/exam/marks_entry/students_final_mark",$st_id,$subject->subject_id,$exam);

							$total_mark += $subject->full_marks;

							if($final_mark != NULL)

							{

								$total_obtain += $final_mark->total_marks;



								$obtain_percent = round(($final_mark->obtain_mark/$subject->full_marks)*100 , 2);

								$sub_grade = modules::run("pages/ajax/get_grade",$obtain_percent);

							}

							else

							{

								//$totaling = FALSE;

							}

							?>

							<tr>

								<td title="<?= $subject->subject_type ?>"><?= $subject->subject_name ?></td>

								<td class="text-center"><?= $subject->full_marks ?></td>

								<td class="text-center"><?= $subject->pass_marks ?></td>

								<td class="text-center"><?= $final_mark != NULL ? $sub_grade : 'NA' ?></td>

								<?php

									if($assessment_module == TRUE && !empty($assessments))

									{

										$final_mark_assments = array();

										if($final_mark != NULL)

										{

											$final_mark_assments = unserialize($final_mark->assessment_marks);

											if(!is_array($final_mark_assments))

												$final_mark_assments = array();

										}

										$a=0;

										foreach ($assessments as $assessment) {

											?>

											<td class="text-center">

												<?php 

												if($final_mark != NULL && array_key_exists($assessment->numeric_value,$final_mark_assments))

												{

													$ass_mark_obtain = $final_mark_assments[$assessment->numeric_value];
													//print_r($assessment);
													//$ass_mark_total = $assessment->assessment_mark;
													$ass_mark_total = modules::run("pages/ajax/get_assessment_mark",$assessment->assessment_id) ;



													$ass_obtain_percent = round(($ass_mark_obtain/$ass_mark_total)*100,2);

													//print_r($final_mark_assments);

													echo modules::run("pages/ajax/get_grade",$ass_obtain_percent) ;

												} 

												else

													//print_r($final_mark_assments);

													echo 'NA'; ?>

													

											</td>

											<?php 

											$a++;

										}



									}

								?>

								<td class="text-center"><?php

								 	if($final_mark != NULL)

								 	{

										$sub_total_percent = get_percent($final_mark->total_marks,$subject->full_marks);

										echo modules::run("pages/ajax/get_grade",$sub_total_percent);

								  }

								  else

							  	echo 'NA';  ?></td>

							  	 

							</tr>

							<?php

						}

					}

				?>

			</tbody>

		</table>

	<?php } else{ ?>

		<table class="table table-bordered table-condensed" border="1px solid black">

			<thead>

				<tr>

					<th rowspan="2">Subjects</th>

					<th class="text-center" rowspan="2">Full Marks</th>

					<th class="text-center" rowspan="2">Pass Marks</th>

					<th colspan="8" class="text-center">Marks Obtained</th>

				</tr>

				<tr>

					<?php

						if($final_grading == TRUE && !empty($exams))

						{

							$a=0;

							foreach ($exams as $exam_list) {

								?>

								<th><?= $exam_list->terminal_name ?> ( <?= $exam_list->average_at ?>% )</th>

								<?php 

								$a++;

							}

						}

					?>

					<th>Total Grade</th>

				</tr>

			</thead>

			<tbody>

				<?php 

					$totaling = TRUE;

					if(isset($subjects) && !empty($subjects))

					{

						$total_mark = 0;

						$total_obtain = 0;

						foreach($subjects as $subject)

						{

							$final_mark = modules::run("pages/exam/marks_entry/students_final_mark",$st_id,$subject->subject_id,$exam);

							$total_mark += $subject->full_marks;

							if($final_mark != NULL)

							{

								$total_obtain += $final_mark->final_mark;



								//$sub_grade_final = modules::run("pages/ajax/get_grade",$final_mark->final_mark);

								//$sub_grade_final = modules::run("pages/ajax/get_grade",$final_mark->final_mark);

							}

							else

							{

								//$totaling = FALSE;

							}

							?>

							<tr>

								<td title="<?= $subject->subject_type ?>"><?= $subject->subject_name ?></td>

								<td class="text-center"><?= $subject->full_marks ?></td>

								<td class="text-center"><?= $subject->pass_marks ?></td>

								<?php

									if($final_grading == TRUE && !empty($exams))

									{

										$a=0;

										foreach ($exams as $exam_list) 

										{

											if($final_mark != NULL)

											{

												$final_exams_mark = unserialize($final_mark->scale_up_mark);

												?>

												<td class="text-center"><?php

													if(array_key_exists($exam_list->numeric_value,$final_exams_mark) )

													{

														$sub_full_mark = round(($exam_list->average_at/100)*$subject->full_marks , 2);

														$sub_percent =  get_percent($final_exams_mark[$exam_list->numeric_value], $sub_full_mark);

														echo modules::run("pages/ajax/get_grade",$sub_percent);

													}

													else

													echo 'NA';

													 ?></td>

												<?php 

												$a++;

											}

											else

											{ ?>

												<td class="text-center">NA</td>

												<?php

											}

										}



									}

							

								?>

								<td class="text-center"><?php 

									if($final_mark != NULL)

								 	{

										$sub_total_percent = get_percent($final_mark->final_mark,$subject->full_marks);

										echo modules::run("pages/ajax/get_grade",$sub_total_percent);

								  }

								  else

								  	echo'NA'; ?></td>

							</tr>

							<?php  

						}

					}

				?>

			</tbody>

		</table>

	<?php }  ?>

	<p class="spaced"></p>

	<table class="table table-bordered table-condensed" width="100%" border="1px solid black">

		<thead>

			<tr>

				<th class="text-center"rowspan="2">Grade Average</th>

				<th class="text-center"colspan="3">Attendance Record</th>

			</tr>

			<tr>

				<th class="text-center">Total</th>

				<th class="text-center">Present</th>

				<th class="text-center">Absent</th>

			</tr>

		</thead>

		<tbody>

			<tr>

				<td class="text-center">

					<?php if(isset($totaling) && isset($total_obtain) && $totaling == TRUE && $total_obtain > 0)

					{

						$final_percent = get_percent($total_obtain,$total_mark) ;

						$avg_grade = modules::run("pages/ajax/get_grade",$final_percent);

						echo $avg_grade;

					}else{

						echo'NA';

					} ?>

						

					</td>

				<td class="text-center"><?= $st_attendance != NULL ? $st_attendance->total_class : 'NA' ?></td>

				<td class="text-center"><?= $st_attendance != NULL ? $st_attendance->present_class : 'NA' ?></td>

				<td class="text-center"><?= $st_attendance != NULL ? $st_attendance->absent_class : 'NA' ?></td>

			</tr>

		</tbody>

	</table>

	<div class="clearfix"></div>

	<p class="spaced"></p>

	<p class="spaced"></p>

	<div class="col-md-6 no-padding">

		<div class="remark-title" style="border: 1px solid black; border-collapse: collapse; margin-bottom: -1px;" ><b>Remark</b></div>

		<div class="remark-body" style="border: 1px solid black; min-height: 75px; border-collapse: collapse; " >

			<?= $terminal_comment != NULL ? $terminal_comment->comment : '' ?>

		</div>

		<div class="clearfix"></div>

		<p class="spaced"></p>

		<div class="border-top"> 

			<div class="post-top"></div>

			<div class="post-bottom"><b><?= $class_teacher ?></b><br/>Class Teacher</div>

		</div>

		<div class="border-top"> 

			<div class="post-top"><?= date('Y-m-d')?></div>

			<div class="post-bottom">Date<br/>&nbsp;</div>

		</div>

		<div class="border-top"> 

			<div class="post-top"></div>

			<div class="post-bottom"><b><?= str_replace(' ', '&nbsp;' , $theme_option->marksheet_post_name) ?></b><br/><?= $theme_option->marksheet_post ?></div>

		</div>

		<div class="clearfix"></div>

		<p class="spaced"></p>

		<table class="table table-condensed table-bordered" width="98%" border="1px solid black">

			<thead>

				<tr>

					<th>Marks Ratio</th>

					<th class="text-center">Grade</th>

					<th>Description</th>

				</tr>

			</thead>

			<tbody>

				<?php 



				$exam_grades = modules::run("pages/ajax/get_exam_grades");

					if(isset($exam_grades))

					{

						$i= 1;

						foreach ($exam_grades as $exam_grade) 

						{

							if(1 == $i++)

							{ ?>

								<tr>

									<td><?= $exam_grade->mark_from ?>% - <?= $exam_grade->mark_to ?>%</td>	

									<td class="text-center"><?= $exam_grade->grade ?></td>	

									<td><?= $exam_grade->description ?></td>	

								</tr>

								<?php

							}

							else

							{

								?>

									<tr>

										<td><?= $exam_grade->mark_from > 0 ? $exam_grade->mark_from.'% -' : '' ?> Below <?= $exam_grade->mark_to+1 ?>%</td>	

										<td class="text-center"><?= $exam_grade->grade ?></td>	

										<td><?= $exam_grade->description ?></td>	

									</tr>

								<?php

							}

						}

					}

				?>

			</tbody>

		</table>

	</div>

	<div class="col-md-6">

		<?php

		if(isset($appraisal_heads) && !empty($appraisal_heads))

		{ $j = 1;

			foreach($appraisal_heads as $appraisal_head)

			{

				$appraisals = modules::run("pages/ajax/get_st_appraisal",$st_id,$grade,$batch,$exam,$appraisal_head->head_id);

				if($appraisals != NULL && !empty($appraisals))

				{

					if($j++ == 1)

					{

						?>

						<h4 class="padding-min">Additional Activity Grading</h4>

						<div class="clearfix"></div>

						<p class="spaced"></p>

						<?php

					} ?>

						<table class="table table-bordered table-condensed" width="98%" style="float: right" border="1px solid black">

							<thead>

								<tr>

									<th colspan="2"><?= $appraisal_head->head_name ?></th>

								</tr>

							</thead>

							<tbody>

								<?php foreach($appraisals as $appraisal){ 

										if($appraisal->grade != '')

										{ ?>

										<tr>

											<td><?= $appraisal->field_name ?></td>	

											<td><?= $appraisal->grade ?></td>	

										</tr>

										<?php

										} } ?>

							</tbody>

						</table>

					<?php 

				}

			}

		} ?>

	</div>	

	<p class="spaced"></p>

</div>

<div class="clearfix"></div>

	<?php }else{?><div class="clearfix"></div><br/>

		<div class="note note-info text-center">No Records Available.</div>

	<?php } ?>