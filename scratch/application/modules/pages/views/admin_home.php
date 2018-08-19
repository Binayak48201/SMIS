		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Modal title</h4>
							</div>
							<div class="modal-body">
								 Widget settings form goes here
							</div>
							<div class="modal-footer">
								<button type="button" class="btn blue">Save changes</button>
								<button type="button" class="btn default" data-dismiss="modal">Close</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<!-- BEGIN STYLE CUSTOMIZER -->
				
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Dashboard</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?=site_url('pages/home');?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Dashboard</a>
						</li>
					</ul>
					<div class="page-toolbar">
						<!-- <div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left" data-original-title="List of New Bug">
						            	<a href="<?=site_url('pages/bug/list_bug');?>" style="color: #fff" >
						                <i class="icon-wrench"></i><?php if(isset($bug_report) && $bug_report) { ?><span class="badge badge-default"><?=$bug_report?></span><?php } ?>
						            	</a>
						</div> -->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN DASHBOARD STATS -->
				<?php
					/*if($notification)
					{ ?>
					<div class="content">
						<div id="wrapper">
						 	<h4 class="nofify">NOTIFICATION</h4>
								<ul id="ticker">
								<?php
										                foreach ($notification as $row) 
		                {
		                  ?>
		                 <li><?= $row->msg ?></li>
		               <?php }?>
							</ul>
						</div>
					</div>
				<?php }*/ ?>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<!-- BEGIN PORTLET-->
						<div class="portlet light ">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-bar-chart font-green-sharp hide"></i>
									<span class="caption-subject font-green-sharp bold uppercase">Inputs Links</span>
								</div>
							</div>
							<div class="portlet-body">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  blue-soft" href="<?=site_url('pages/profile/student/add')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Add Student
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  red-soft" href="<?=site_url('pages/profile/student/manage')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Manage Student
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  blue-soft" href="<?=site_url('pages/classes/course_manager')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											 Assign Subject Teacher
										</div>
									</div>
									</a>
								</div>
								<!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  green-soft" href="<?=site_url('pages/programs/subjecteacher/view')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											 View Subject Teacher
										</div>
									</div>
									</a>
								</div> -->
								<!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  purple-soft" href="<?=site_url('pages/course_syllabus/course_syllabus')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Syllabus of a Batch
										</div>
									</div>
									</a>
								</div> 
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  green-soft" href="<?=site_url('pages/exam/exam_form')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											 View Exam Form
										</div>
									</div>
									</a>
								</div>-->
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  purple-soft" href="<?=site_url('pages/profile/employee/add')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Add Employee
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  green-soft" href="<?=site_url('pages/profile/employee/manage')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Manage Employee
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  blue-soft" href="<?=site_url('pages/reports/academic_report/exam_summary_report')?>">
									<div class="cstm-details">
										<div class="desc text-center ">
											Student Marks
										</div>
									</div>
									</a>
								</div>
								<!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  red-soft" href="<?=site_url('pages/exam/resultcalculation/add')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Result Calculation
										</div>
									</div>
									</a>
								</div> 
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  blue-soft" href="<?=site_url('pages/survey/survey_session')?>">
									<div class="cstm-details">
										<div class="desc text-center ">
											Survey Session
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  green-soft" href="<?=site_url('pages/student_info/student_attendance')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Add Student Attendance
										</div>
									</div>
									</a>
								</div>-->
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  purple-soft" href="<?=site_url('pages/classes/lession_plan/add')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Add Course Pointer
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  green-soft" href="<?=site_url('pages/profile/student/class_reassign')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Re-assign Class
										</div>
									</div>
									</a>
								</div>
							</div>
						</div>
						<!-- END PORTLET-->
					</div>
					<div class="col-md-12 col-sm-12">
						<!-- BEGIN PORTLET-->
						<div class="portlet light ">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-bar-chart font-green-sharp hide"></i>
									<span class="caption-subject font-green-sharp bold uppercase">Reports Links</span>
								</div>
							</div>
							<div class="portlet-body">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  blue-soft" href="<?=site_url('pages/reports/general_reports/birthday_students')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Student Birthday
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  red-soft" href="<?=site_url('pages/classes/class_manager')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Class Routine
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  blue-soft" href="<?=site_url('pages/reports/class_reports/list_classes')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Course Pointer Overview
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  purple-soft" href="<?=site_url('pages/reports/general_reports/dropped_student_list')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Dropped Student List
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  purple-soft" href="<?=site_url('pages/reports/academic_report/st_attendance_report')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Student Attendance Reports
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  green-soft" href="<?=site_url('pages/reports/general_reports/student_list')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											 Student Lists
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  purple-soft" href="<?=site_url('pages/reports/academic_report/student_evaluation_overall')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Student Overall Evaluation 
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  blue-soft" href="<?=site_url('pages/reports/academic_report/class_rank')?>">
									<div class="cstm-details">
										<div class="desc text-center ">
											Class Ranks
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  blue-soft" href="<?=site_url('pages/profile/student/class_reassign')?>">
									<div class="cstm-details">
										<div class="desc text-center ">
											Student Class Reassign
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  red-soft" href="<?=site_url('pages/reports/class_reports/list_classes')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Course Pointer Overview
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  green-soft" href="<?=site_url('pages/reports/employee_reports/employee_list')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											Employee List
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat  purple-soft" href="<?=site_url('pages/reports/employee_reports/class_teachers')?>">
									<div class="cstm-details">
										<div class="desc text-center">
											CLass Teacher List 
										</div>
									</div>
									</a>
								</div>
								
							</div>
						</div>
						<!-- END PORTLET-->
					</div>
				</div>
				<hr/>
				<!-- END DASHBOARD STATS -->
				<div class="clearfix">
				</div>
			</div>
		</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!-- END QUICK SIDEBAR -->
	</div><!-- END page-container -->

