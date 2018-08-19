<!-- BEGIN CONTENT --> 
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?=site_url('pages/home');?>">Home</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="<?=site_url('pages/home');?>">Student Profile</a>
					<i class="fa fa-angle-right"></i>
				</li>
				
				<li>
					<a href="#">Student Details</a>
				</li>
			</ul>
			<div class="page-toolbar">
				<a href="javascript:history.go(-1)"><div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left">
					Back
				</div></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN SAMPLE FORM PORTLET-->
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption font-green-haze">
							<i class="icon-settings font-green-haze"></i>
							<span class="caption-subject bold uppercase">Student Info</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<div class=" col-md-3" >
							<div class='div-padding'>
								
							<!-- PORTLET MAIN -->
									<div class="user-card">
								<!-- SIDEBAR USERPIC -->
									<div class="div-top">
										<div class="user-photocont">
											<img class="user-img-pro img-responsive" src='<?= display_pic_path($results->picture_path); ?>' altd='<?=$results->st_fname.' '.$results->st_mname.' '.$results->st_lname?>' alt="<?= $results->picture_path?>" />
											</div>
								<!-- END SIDEBAR USERPIC -->
								<!-- SIDEBAR USER TITLE -->
										<div class="user-cont">
											<div class='studying'>
											<div class="profile-usertitle-name">
												<?=$results->st_fname.' '.$results->st_mname.' '.$results->st_lname?>
											</div>
											<div class="profile-usertitle-job">
												
												<!-- <span class='font-green-haze'>Graduated</span> -->
											
												<!-- <span class='font-red-haze'><?=$results->status?></span> -->
											
											</div>
										</div>	
									</div>
									</div>
									<div class="panel box-s-none">
								<!-- STAT -->
								<ul class="list-group">
									<li class="list-group-item hover class_routine" data-toggle="modal" data-id="<?= $results->section_id ?>" data-target="#routine">
										Class Routine
									</li>
									<li class="list-group-item hover">
									 	<a target="#marksheet" href="<?= site_url('pages/reports/academic_report/view_marksheet/'.$results->student_id); ?>">Academic Details</a>
									</li>
									<li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Clubs')?>">
										Clubs
									</li>
									<li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Medical Conditions')?>">
										Medical Conditions
									</li><li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Medications')?>">
										Medications
									</li>
									<li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Doctor/Regular Consultant')?>">
										Doctor/Regular Consultant
									</li>
									<li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Responsibilities')?>">
										Responsibilities
									</li>
									<li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Interested Games')?>">
										Interested Games
									</li>
									<li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Achievements')?>">
										Achievements
									</li>
									<li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Hobbies')?>">
										Hobbies
									</li>
									<li class="list-group-item hover pop" data-toggle="modal" data-target="#large" data-id="<?= str_replace(' ', '_', 'Siblings')?>">
										Siblings
									</li>
									<!-- <li class="list-group-item">
										<a href="<?=site_url('report/admission/student_summary/attandence/'.$results->student_id)?>"> Attendance </a>
									</li>
									<li class="list-group-item">
										<a href="<?=site_url('report/admission/student_summary/get_sgpa/'.$results->student_id)?>"> SGPA </a>
									</li> -->
									<li class="list-group-item">
										&nbsp;
									</li>
									
								</ul>
								<!-- END STAT -->
								</div>
							
								<!-- END SIDEBAR USER TITLE -->
								<!-- SIDEBAR MENU -->
								<!-- END MENU -->
							</div>
							<!-- END PORTLET MAIN -->
							<!-- PORTLET MAIN -->
							
							<!-- END PORTLET MAIN -->
							</div>
						</div>
						<!-- END BEGIN PROFILE SIDEBAR -->
						<!-- BEGIN PROFILE CONTENT -->
						<div class=" col-md-9">
							<div class="row"> <!-- profile-content -->
							<div class="portlet light">
								<div class="portlet-title tabbable-line">
									<div class="caption caption-md">
										<i class="icon-globe theme-font hide"></i>
										<!-- <span class="caption-subject font-blue-madison bold uppercase">Help</span> -->
									</div>
									<ul class="nav nav-tabs">
										<li class="<?= isset($active) ? : 'active' ?>">
											<a href="#tab_1_1" data-toggle="tab">Profile</a>
										</li>
										<li>
											<a href="#tab_1_2" data-toggle="tab">Exam Reports</a>
										</li>
										<li>
											<a href="#tab_1_3" data-toggle="tab">	Student Evaluation</a>
										</li>
										<li>
											<a href="#tab_1_4" data-toggle="tab">	Parent Evaluation </a>
										</li>
										<li>
											<a href="#tab_1_6" data-toggle="tab">	Evaluation by Subject Teacher</a>
										</li>
										<li>
											<a href="#tab_1_7" data-toggle="tab">	Courses</a>
										</li>
									</ul>
								</div>
								<div class="portlet-body" style="overflow: auto; height: 400px;">
									<div class="tab-content">
										<!-- GENERAL QUESTION TAB -->
										<div class="tab-pane <?= isset($active) ? : 'active' ?>" id="tab_1_1">
											<div class="col-md-12"> 
												<table class="table">
													<tr>
														
														<td title="<?=$results->USER_NAME?>"><strong>Roll No:</strong> </td>														<td><?=$results->current_roll?></td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td><strong>Grade:</strong></td>
														<td><?=$results->grade?></td>
														<td><strong>Section:</strong></td>
														<td><?=$results->section_name?></td>
													</tr>
													<tr>
														<td><strong>House:</strong></td>
														<td><?=$results->house_name?></td>
														<td><strong>Boarding Type:</strong></td>
														<td><?=$results->boarding_type?></td>
													</tr>
													<tr>
														<td>
														<strong>District:</strong></td>
														<td><?=$results->district_name?></td>
														<td><strong>Gender</strong></td>
														<td><?=$results->gender?></td>
													</tr>
													<tr>
														<td><strong>Father's Name: </strong></td>
														<td><?=$results->father_name?> <?= $results->father_cell != '' ? '('.$results->father_cell.')' :'-'?></td>
														<td><strong>Father's Occupation:</strong></td>
														<td><?=$results->father_occupation?></td>
													</tr>
													<tr>
														<td><strong>Guardian's Name:</strong></td>
														<td><?=$results->guardian_name?> <?= $results->guardian_phone != '' ? '('.$results->guardian_phone.')' :'-'?></td>
														<td><strong>Guardian's Occupation: </strong></td>
														<td><?=$results->guardian_occupation?></td>
													</tr>
													<tr>
														<td><strong>Permanent Address:</strong></td>
														<td><?=$results->home_address?></td>
														<td><strong>Phone:</strong></td>
														<td><?=$results->home_phone?></td>
													</tr>
													<tr>
														<td><strong>Birth Place</strong></td>
														<td><?=$results->birth_place?></td>
														<td><strong>Date Of Birth</strong></td>
														<td><?=$results->st_dob?></td>
													</tr>
												</table>
											</div>
											<div class="clearfix"> </div>
										</div>
										<!-- END GENERAL QUESTION TAB -->
										<!-- MEMBERSHIP TAB -->
										<div class="tab-pane" id="tab_1_2">
											
												<div id="accordion2" class="panel-group">
													<?php 

														if(isset($exams))
														{ $i = 1;
															foreach ($exams as $exam) {
																?>
																<div class="panel panel-success">
																	<div class="panel-heading">
																		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_<?=$i;?>">
																		<h4 class="panel-title"><?=$exam->terminal_name?></h4></a>
																	</div>
																	<div id="accordion2_<?php echo $i;?>" class="panel-collapse collapse">
																		<div class="panel-body">
																			<button onclick="printDiv('accordion2_<?php echo $i++;?>')" class='btn btn-success no-print'>print</button>
																			<?= modules::run('pages/ajax/st_marksheet_view',$results->student_id,$results->joined_batch,$exam->numeric_value,$results->grade); ?>
																		</div>
																	</div>
																</div><div class="clearfix"></div>
																<?php
															}
															if($theme_option->final_upscale_marking)
															{
															?>
																<div class="panel panel-success">
																	<div class="panel-heading">
																		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_<?=AGGREGATE_ID;?>">
																		<h4 class="panel-title">Consolidated Result</h4></a>
																	</div>
																	<div id="accordion2_<?= AGGREGATE_ID;?>" class="panel-collapse collapse">
																		<div class="panel-body">
																				<button onclick="printDiv('accordion2_<?php echo AGGREGATE_ID ?>')" class='btn btn-success no-print'>print</button>
																				<?= modules::run('pages/ajax/st_marksheet_view',$results->student_id,$results->joined_batch,AGGREGATE_ID,$results->grade); ?>
																		</div>
																	</div>
																</div><div class="clearfix"></div>
																<?php
															}
														}
														else
														{
															?>
															<div class="note note-info test-center">No Records Available.</div>
														<?php } ?>
											</div>
										</div>
										<!-- END MEMBERSHIP TAB -->
										<!-- TERMS OF USE TAB -->
										<div class="tab-pane" id="tab_1_3">
										
												<?php
												if(isset($st_evaluations)){
													$i=1;
													foreach($st_evaluations as $st_evaluation)
													{
														?>
														<div class="panel panel-success">
															<div class="panel-heading">
																<h4 class="panel-title st_evaluation"  data-caption="Evaluation on <?=$st_evaluation->terminal_name?>" data-toggle="modal" data-target="#st_evaluation" data-section-id="<?= $results->section_id ?>" data-id="<?= $st_evaluation->exam_id ?>" data-term-id="<?= $st_evaluation->numeric_value ?>" >
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_<?=$i;?>">
																<?=$st_evaluation->terminal_name?></a>
																</h4>
															</div>
														</div>
														<?php
														$i=$i+1;
													}
												}else
												{
												?>
													<div class="note note-info text-center">No Records Available.</div>
												<?php } ?>
										</div>
										<div class="tab-pane" id="tab_1_4">
											<?php
												if(isset($pt_evaluations)){
													$i=1;
													foreach($pt_evaluations as $pt_evaluation)
													{
														?>
														<div class="panel panel-success">
															<div class="panel-heading">
																<h4 class="panel-title pt_evaluation"  data-caption="Evaluation on <?=$pt_evaluation->terminal_name?>" data-toggle="modal" data-target="#pt_evaluation" data-section-id="<?= $results->section_id ?>" data-id="<?= $pt_evaluation->exam_id ?>" >
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_<?=$i;?>">
																<?=$pt_evaluation->terminal_name?></a>
																</h4>
															</div>
														</div>
														<?php
														$i=$i+1;
													}
												}
												else
												{
												?>
													<div class="note note-info text-center">No Records Available.</div>
												<?php } ?>
									</div>
									<div class="tab-pane" id="tab_1_6">
										<div id="accordion6" class="panel-group">
											<?php
											if(isset($sst_evaluations))
											{
												$i=1;
												$terms = array();
												foreach($sst_evaluations as $sst_evaluation)
												{
													if(!in_array($sst_evaluation->terminal_name, $terms))
													{
														$terms[] = $sst_evaluation->terminal_name;
														?>
														<div class="panel panel-success">
															<div class="panel-heading">
																<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#accordion6_<?=$i;?>">
																<h4 class="panel-title"><?= $sst_evaluation->terminal_name?></h4></a>
															</div>
															<div id="accordion6_<?php echo $i;?>" class="panel-collapse collapse">
																<div class="panel-body">
																	<?php
																	$subs = array();
																	foreach($sst_evaluations as $sst_evaluation_sub)
																	{ if(!in_array($sst_evaluation_sub->subject_id ,$subs))
																		{ $subs[] = $sst_evaluation_sub->subject_id;
																		?>
																			<h4 class="panel-title sst_evaluation hover"  data-caption="Subject Evaluation of <?=$sst_evaluation_sub->subject_name?> on <?=$sst_evaluation->terminal_name?>" data-toggle="modal" data-target="#sst_evaluation" data-subject-id="<?= $sst_evaluation_sub->subject_id ?>" data-id="<?= $sst_evaluation->exam_id ?>" >
																					<?=$sst_evaluation_sub->subject_name?>
																			</h4>
																			<?php
																		}
																	} ?>
																</div>	
															</div>
														</div>
														<?php
														$i++;
													}
												}
											}
											else
											{ ?>
												<div class="note note-info text-center">No Records Available</div>			
												<?php 
											} ?>
										</div>
									</div>
									<div class="tab-pane" id="tab_1_7">
											<div class='st-list'>
												<?php
												if(isset($courses) && !empty($courses))
												{  ?>
												<table class="table">
													<thead>
														<th>SN</th>
														<th>Subject Name</th>
														<th>Subject Teacher</th>
														<th>Feedback Given</th>
													</thead>
													<tbody>
														<?php
														$i=1;
														foreach($courses as $row)
														{ ?>
														<tr>
															<td><?=$i++?></td>
															<td><a target="#lesson_plan" href="<?= site_url('pages/classes/lession_plan/course_pointer/'.$row->class_days_id); ?>"><?=$row->subject_name?></a></td>
															<td><?=$row->emp_fullname?></td>
															<td><a class="feedback_view" data-caption="Feedback on <?=$row->subject_name?>" data-toggle="modal" data-target="#feedback" data-id="<?= $row->class_days_id ?>" data-st-id="<?= $results->student_id ?>" >view</a></td>
														</tr>
														<?php
														}  ?>
													</tbody>
												</table>
												<?php
												}
												else
												{	?>
												<div class="note note-info text-center">
													<p>
														No Records Available.
													</p>
												</div>
												<?php
												}
												?>
											</div>
										</div>
									<!-- END TERMS OF USE TAB -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- END SAMPLE FORM PORTLET-->
</div>
</div>
</div>
<!-- model start -->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
          <i class="icon-settings font-green-haze"></i>
          <span class="caption-subject bold uppercase" id="caption"></span>
        </div>
      </div>
        <div class="modal-body" id='modal-body' style="overflow: auto; height: 75vh;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="feedback" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
          <i class="icon-settings font-green-haze"></i>
          <span class="caption-subject bold uppercase" id="feedback_caption">Feedback</span>
        </div>
      </div>
        <div class="modal-body" id='feedback-modal-body' style="overflow: auto; height: 75vh;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="st_evaluation" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
          <i class="icon-settings font-green-haze"></i>
          <span class="caption-subject bold uppercase" id="eval_caption"></span>
        </div>
      </div>
        <div class="modal-body" id='st_evaluation_body' style="overflow: auto; height: 75vh;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="pt_evaluation" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
          <i class="icon-settings font-green-haze"></i>
          <span class="caption-subject bold uppercase" id="pt_eval_caption"></span>
        </div>
      </div>
        <div class="modal-body" id='pt_evaluation_body' style="overflow: auto; height: 75vh;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="sst_evaluation" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
          <i class="icon-settings font-green-haze"></i>
          <span class="caption-subject bold uppercase" id="sst_eval_caption"></span>
        </div>
      </div>
        <div class="modal-body" id='sst_evaluation_body' style="overflow: auto; height: 75vh;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="routine" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
          <i class="icon-settings font-green-haze"></i>
          <span class="caption-subject bold uppercase"> Class Routine</span>
        </div>
      </div>
        <div class="modal-body" id='class_Routine' style="overflow: auto; height: 75vh;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->