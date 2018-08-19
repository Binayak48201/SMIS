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
					<a href="#">Class</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">List of Student</a>
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
									<div class="profile-sidebar col-md-4">
										<!-- PORTLET MAIN -->
										<div class="portlet light profile-sidebar-portlet" >
											<!-- SIDEBAR USERPIC -->
												<div class="col-md-4 cstm-profile-pic no-padding">
													<a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>">
													<img src="<?= display_pic_path('student_photo/'.$student->USER_NAME.'.jpg'); ?>" class="img-responsive" alt="">
												</a>
												</div>
												<!-- END SIDEBAR USERPIC -->
												<!-- SIDEBAR USER TITLE -->
												<div class="profile-usertitle col-md-6">
													<ul class="cstm-list">
														<li>
															<a data-toggle="modal" class="disp_pop label label-info" data-opt="1" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#evaluation">Evaluation</a>
														</li>
														<li>
															<a data-toggle="modal" class="disp_pop label label-info" data-opt="2" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#parent_evaluation_model">Evaluation on Parent</a>
														</li>
														<li>
															<a data-toggle="modal" class="disp_pop label label-info" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#appraisal">Terminal Appraisal</a>
														</li>
														<li>
															<a data-toggle="modal" class="disp_pop label label-info" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#comment">Terminal Comment</a>
														</li>
													</ul>
												</div>
												<div class="clearfix"></div>
												<a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>"><b><?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?></b></a>
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
				<h4 class="modal-title">Subject Teacher's Remark to <span class="st_for"></span></h4>
			</div>
			<form class="form-horizontal" id="class_evaluation" method="post" action='<?= site_url('pages/profile/evaluation/class_evaluation'); ?>' role="form" >
				<br/>
				<div class="col-md-12">
					<label class="col-md-2">Select Exam</label>
					<div class="col-md-4">
						<select class="col-md- form-control" required name="exam_id" id="exam_id_st_eval">
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
				</div><div class="clearfix"></div>
				<br>
				<div id="class_evaluation_option">
					
				</div>
				<div class="clearfix"></div>
				<input type="hidden" name="st_id" class="st_id" value="">
				<input type="hidden" name="section_id" class="section_id" value="<?= $this->uri->segment(5); ?>">
				<div class="modal-footer">
					<input type="hidden" name="add" value="ADD">
					<button  class="btn blue" type='submit'>Add</button>
					<button class="btn default" data-dismiss="modal" data-form="class_evaluation" type='reset'>Cancel</button>
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="parent_evaluation_model" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Subject Teacher's Remark to <span class="st_for"></span> Parents</h4>
			</div>
			<form class="form-horizontal" id="parent_evaluation" method="post" action='<?= site_url('pages/profile/evaluation/parent_evaluation'); ?>' role="form" >
				<br/>
				<div class="col-md-12">
					<label class="col-md-2">Select Exam</label>
					<div class="col-md-4">
						<select class="col-md- form-control" required name="exam_id" id="exam_id_pt_eval">
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
				</div><div class="clearfix"></div>
				<br>
				<div id="parent_evaluation_option">
					
				</div>
				<div class="clearfix"></div>
				<input type="hidden" name="st_id" class="st_id" value="">
				<input type="hidden" name="section_id" class="section_id" value="<?= $this->uri->segment(5); ?>">
				<div class="modal-footer">
					<input type="hidden" name="add" value="ADD">
					<button  class="btn blue" type='submit'>Add</button>
					<button class="btn default" data-dismiss="modal" data-form="parent_evaluation" type='reset'>Cancel</button>
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="appraisal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Appraisal of <span class="st_for"></span></h4>
			</div>
				<form class="form-horizontal" id="appraisal_evaluation" method="post" action='<?= site_url('pages/profile/evaluation/appraisal_evaluation'); ?>' role="form" >
				<br/>
				<div class="col-md-12">
					<label class="col-md-2">Select Exam</label>
					<div class="col-md-4">
						<select class="col-md- form-control" required name="exam_id" id="exam_id_ap_eval">
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
				</div><div class="clearfix"></div>
				<br>
				<div id="appraisal_evaluation_option">
					
				</div>
				<div class="clearfix"></div>
				<input type="hidden" name="st_id" class="st_id" value="">
				<input type="hidden" name="section_id" class="section_id" value="<?= $this->uri->segment(5); ?>">
				<div class="modal-footer">
					<input type="hidden" name="add" value="ADD">
					<button  class="btn blue" type='submit'>Add</button>
					<button class="btn default" data-dismiss="modal" data-form="appraisal_evaluation" type='reset'>Cancel</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->
<!-- model start -->
<div class="modal fade bs-modal-lg" id="comment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Subject Teacher's Comment to <span class="st_for"></span></h4>
			</div>
			<div id="comment_manage">
				
			</div>
			<form class="form-horizontal" id="terminal_comment" method="post" action='<?= site_url('pages/profile/evaluation/terminal_comment'); ?>' role="form" >
				<br/>
				<div class="col-md-12">
					<label class="col-md-2">Select Exam</label>
					<div class="col-md-4">
						<select class="col-md- form-control" required name="exam_id" id="exam_id_cm_eval">
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
				</div><div class="clearfix"></div>
				<br>
				<div class="col-md-2 pull-left">&nbsp;<br/></div>
				<div class="col-md-8 pull-left form-group form-md-line-input">
					<div id="terminal_comment_option"></div>
					<div class="form-control-focus">
					</div>
				</div>
				<div class="clearfix"></div>
				<input type="hidden" name="st_id" class="st_id" value="">
				<input type="hidden" name="section_id" class="section_id" value="<?= $this->uri->segment(5); ?>">
				<div class="modal-footer">
					<input type="hidden" name="add" value="ADD">
					<button  class="btn blue" type='submit'>Add</button>
					<button class="btn default" data-dismiss="modal" data-form="terminal_comment" type='reset'>Cancel</button>
				</div>
			</form>
			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->