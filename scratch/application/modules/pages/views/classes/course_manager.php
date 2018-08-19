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
					<a href="#">Classes</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Course Manager</a>
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
							<span class="caption-subject bold uppercase">Course Manager</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">

						<div class="col-md-12">
							<form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/classes/course_manager/add'); ?>' role="form" >
							<?php display_alert(); ?>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Batch:</label>
								<div class="col-md-6">
									<select class="form-control display_section" name='batch' id='batch' required>
										<option value="">Select Batch</option>
										<?php if($batchs!=NULL)
										{ 
											$i=1;
											foreach($batchs as $batch)
											{ ?>
													<option value="<?=$batch->batch_name?>"><?=$batch->batch_name?></option>
												<?php
												$i++;
											}
										} ?>
									</select>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Grade:</label>
								<div class="col-md-6">
									<select class="form-control display_section" id='grade' required>
										<option value="">Select Grade</option>
										<?php if($grades!=NULL)
										{ 
											$i=1;
											foreach($grades as $grade)
											{ ?>
													<option value="<?=$grade->grade_name?>"><?=$grade->grade_name?></option>
												<?php
												$i++;
											}
										} ?>
									</select>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Section:</label>
								<div class="col-md-6">
									<select class="form-control" name='section_id' id="section" required>
										<option value="">Select Section</option>
									</select>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Subject:</label>
								<div class="col-md-6">
									<select class="form-control" name='subject_id' id="subject" required>
										<option value="">Select Subject</option>
									</select>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Subject Teacher:</label>
								<div class="col-md-6">
									<select class="form-control" name='employee_id' required>
										<option value="">Select Teacher</option>
										<?php if($teachers!=NULL)
										{ 
											$i=1;
											foreach($teachers as $teacher)
											{ ?>
													<option value="<?=$teacher->employee_id?>"><?=$teacher->emp_fullname?></option>
												<?php
												$i++;
											}
										} ?>
									</select>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Coures Pointer Updater:</label>
								<div class="col-md-6">
									<select class="form-control" name='updater' required>
										<option value="">Select Updater</option>
										<?php if($teachers!=NULL)
										{ 
											$i=1;
											foreach($teachers as $teacher)
											{ ?>
													<option value="<?=$teacher->employee_id?>"><?=$teacher->emp_fullname?></option>
												<?php
												$i++;
											}
										} ?>
									</select>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Class Time:</label>
								<div class="col-md-6">
									<input class="form-control" name='class_time' placeholder="Class Time" required type="time" />
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Start Date:</label>
								<div class="col-md-6">
									<input class="form-control date-picker" name='start_date' placeholder="Start Date" required type="text" />
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">End Date:</label>
								<div class="col-md-6">
									<input class="form-control date-picker" name='end_date' placeholder="End Date" required type="text" />
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<!-- <div class="form-group form-md-line-input col-md-6">
								<label for="inputPassword12" class="col-md-6 control-label">Pass Mark:</label>
								<div class="col-md-6">
									<input class="form-control" name='pass_mark' placeholder="Pass Mark" required type="number" />
									<div class="form-control-focus">
									</div>
								</div>
							</div> -->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-10">
									<button class="btn default" type='reset'>Cancel</button>
									<button name="add" value="ADD" class="btn blue" type='submit'>Add</button>
								</div>
							</div>
						</form>

						<!-- data-table Start -->
							<div style='padding:15px'>
								<table class="table table-striped table-bordered table-hover simple_table">
								<thead>
									<tr>
										<th>SN</th>
										<th>Batch</th>
										<th>Grade</th>
										<th>Subject Name</th>
										<th>Section</th>
										<th>Teacher</th>
										<th>Subject Type</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if($results!=NULL)
									{ 
										$i=1;
										foreach($results as $row)
										{ ?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row->added_batch?></td>
												<td><?=$row->grade?></td>
												<td><?=$row->subject_name?></td>
												<td><?=$row->section_name?></td>
												<td><?=$row->emp_fullname?></td>
												<td><?=$row->subject_type?></td>
												<td>
													<a class='btn btn-primary' href="<?=site_url('pages/classes/lession_plan/view/'.$row->class_days_id);?>">lesson Plan</a>
													<a class='btn btn-info edit' data-toggle="modal" data-target="#large" data-id="<?= $row->class_days_id?>" >Edit</a>
													<a class='btn btn-danger' href="<?=site_url('pages/classes/course_manager/delete/'.$row->class_days_id);?>" onclick="return confirm('Do you want to Delete?')">Delete</a>
												</td>
											</tr>
											<?php
											$i++;
										}
									} ?>
								</tbody>
							</table>	
							</div>
						</div>
						<!-- data-table END -->
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<div class="caption font-green-haze">
							<i class="icon-settings font-green-haze"></i>
							<span class="caption-subject bold uppercase">Edit Course</span>
						</div>
			</div>
			<form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/classes/course_manager/update'); ?>' role="form" >
				<div class="modal-body" id='modal-body'>
					<input type="hidden" name="id" id='opt_id' value="">
				</div>
				<div class="modal-footer">
					<button class="btn default" data-dismiss="modal" type='reset'>Cancel</button>
					<button name="update" value="UPDATE" class="btn blue" type='submit'>Update</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->