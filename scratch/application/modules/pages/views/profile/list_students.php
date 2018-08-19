<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- /.modal -->
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- BEGIN STYLE CUSTOMIZER -->
		
		<!-- END STYLE CUSTOMIZER -->
		<!-- BEGIN PAGE HEADER-->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?=site_url('pages/home');?>">Home</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Profile</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">List Student for Evaluation/Comment</a>
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
				<div class="portlet light" style="min-height: 60vh;">
					<div class="portlet-title">
						<div class="caption font-green-haze">
							<i class="icon-settings font-green-haze"></i>
							<span class="caption-subject bold uppercase">List Student for Evaluation/Comment</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">						
						<?php
							display_alert();
							if(isset($students) && !empty($students))
							{
								?>
								<div class="note note-warning text-center">
									<p>
										LIST OF STUDENTS for Evaluation/Comment
									</p>
								</div>
								<div class='st-list'>
								<?php
	            	foreach($students as $student)
	            	{ ?>
									<div class="profile-sidebar col-md-2">
										<!-- PORTLET MAIN -->
										<div class="portlet light profile-sidebar-portlet" style="min-height: 200px">
											<!-- SIDEBAR USERPIC -->
												<div class="cstm-profile-pic">
													<a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>">
													<img src="<?= display_pic_path('student_photo/'.$student->USER_NAME.'.jpg'); ?>" class="img-responsive" alt="">
												</div>
												<!-- END SIDEBAR USERPIC -->
												<!-- SIDEBAR USER TITLE -->
												<div class="profile-usertitle">
													<ul class="cstm-list text-center">
														<li>
															<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>
														</li>
														<li>
															Roll No: <?=$student->current_roll?>
														</li>
														<li>
															(<?=$student->USER_NAME?>)
														</li></a>
														<li>
															<a data-toggle="modal" class="disp_pop" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#evaluation">Evaluation</a>
														</li>
														<li>
															<a data-toggle="modal" class="disp_pop feedback" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#generalComment">General&nbsp;Feedback</a>
														</li>
													</ul>
												</div>
											
											<!-- END SIDEBAR USER TITLE -->
											<!-- END MENU -->
										</div>
										<!-- END PORTLET MAIN -->
									</div>
	            		<?php
	            	}   ?></div> <?php
	            }
            ?>
					</div>
				</div>
			</div>
			<!-- END SAMPLE FORM PORTLET-->
		</div>
	</div>
</div>


<!-- model start -->
<div class="modal fade bs-modal-lg" id="evaluation" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Subject Teacher's Evaluation to <span class="st_for"></span></h4>
			</div>
			<form class="form-horizontal" id="sub_evaluation" method="post" action='<?= site_url('pages/profile/evaluation/subject_evaluation'); ?>' role="form" >
				<br/>
				<div class="col-md-12">
					<label class="col-md-2">Select Exam</label>
					<div class="col-md-4">
						<select class="col-md- form-control" name="exam_id" id="exam_id">
							<option value="">Select Exams</option>
							<?php if(isset($exams))
								{ 
									foreach($exams as $exam)
									{  ?>
										<option value="<?= $exam->exam_id ?>" ><?= $exam->terminal_name ?></option>
										<?php
									}	
								}	 ?>
						</select>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="modal-body" id="sub_remark" >
					
				</div>
				<dic class="clearfix"></dic>
				<div class="modal-footer">
					<input type="hidden" name="st_id" class="st_id" value="">
					<input type="hidden" id="class_days_id" value="<?= $this->uri->segment(5); ?>">
					<input type="hidden" name="add" value="ADD">
					<button  class="btn blue" type='submit'>Add</button>
					<button class="btn default" data-dismiss="modal" id='reset_sub_eval' type='reset'>Cancel</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-md" id="generalComment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Feedback to <span class="st_for"></span></h4>
			</div>
			
				<div class="modal-body">
					<form class="form-horizontal" action="<?= site_url('pages/profile/evaluation/add_comment')?>" method="post" >
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Feedback: </label>
								<div class="col-md-6">
									<textarea class="form-control" name='comment' required ></textarea>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Feedback Type: </label>
								<div class="col-md-6">
									<select class="form-control" name='comment_type' required>
										<option value="General">General</option>
										<option value="Academic">Academic</option>
										<option value="Attendance">Attendance</option>
										<option value="Discipline">Discipline</option>
									</select>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Parent Contact Required: </label>
								<div class="col-md-6">
									<input class="form-control" name='paren_contact_req' value="1" required type="checkbox">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Parent Already Contacted: </label>
								<div class="col-md-6">
									<input class="form-control" name='paren_contacted' value="1" required type="checkbox">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<input type="hidden" name="st_id" class="st_id" value="">
							<input type="hidden" name="class_days_id" value="<?= $this->uri->segment(5); ?>">

							<br>
							<div id="feedback-content"></div>
							<div class="col-md-offset-4">
								<div class="form-group form-md-line-input">
									<button type="submit" name="submit" value="SUBMIT" class="btn btn-success">Add</button>
									<button type="reset" data-dismiss="modal" class="btn btn-success">Cancel</button>
								</div>
							</div>
						</form>
							
				</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->