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
					<a href="#">Subject Manager</a>
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
							<span class="caption-subject bold uppercase">Subject Manager</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<div class="col-md-12">
							<form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/classes/subject_manager/add'); ?>' role="form" >
							<?php display_alert(); ?>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Batch:</label>
								<div class="col-md-4">
									<select class="form-control" name='batch' required />
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
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Grade:</label>
								<div class="col-md-4">
									<select class="form-control" name='grade' required />
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
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Subject name:</label>
								<div class="col-md-4">
									<input class="form-control" name='subject_name' placeholder="Subject Name" required type="text" />
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Optional:</label>
								<div class="col-md-4">
									<input type="checkbox" id="checkbox1" class="lesson_covered make-switch" name='optional' data-on-text="Yes" data-size="small" data-off-text="No">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Full Mark:</label>
								<div class="col-md-4">
									<input class="form-control" name='full_mark' placeholder="Full Mark" required type="number" />
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Pass Mark:</label>
								<div class="col-md-4">
									<input class="form-control" name='pass_mark' placeholder="Pass Mark" required type="number" />
									<div class="form-control-focus">
									</div>
								</div>
							</div>
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
										<th>Subject Type</th>
										<th>Full Mark</th>
										<th>Pass Mark</th>
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
												<td><?=$row->subject_type?></td>
												<td><?=$row->full_marks?></td>
												<td><?=$row->pass_marks?></td>
												<td>
													<a class='btn btn-info edit_opt' data-toggle="modal" data-target="#large" data-info='{"id":"<?=$row->subject_id?>", "subject_name":"<?=$row->subject_name?>", "batch":"<?=$row->added_batch?>", "grade":"<?=$row->grade?>", "optional":"<?= $row->subject_type == "COMPULSORY" ? 'off' : 'on' ?>", "full_mark":"<?=$row->full_marks?>", "pass_mark":"<?=$row->pass_marks?>"}'>Edit</a>
													<a class='btn btn-danger' href="<?=site_url('pages/classes/subject_manager/delete/'.$row->subject_id);?>" onclick="return confirm('Do you want to Delete?')">Delete</a>
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
<div class="modal fade bs-modal-md" id="large" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Subject</h4>
			</div>
			<form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/classes/subject_manager/update'); ?>' role="form" >
				<div class="modal-body">
					<input type="hidden" name="id" id='opt_id' value="">
					<div class="form-group form-md-line-input">
						<label for="inputPassword12" class="col-md-3 control-label">Batch:</label>
						<div class="col-md-4">
							<select class="form-control" name='batch' id='opt_batch' required />
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
					<div class="form-group form-md-line-input">
						<label for="inputPassword12" class="col-md-3 control-label">Grade:</label>
						<div class="col-md-4">
							<select class="form-control" name='grade' id='opt_grade' required />
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
					<div class="form-group form-md-line-input">
						<label for="inputPassword12" class="col-md-3 control-label">Subject name:</label>
						<div class="col-md-4">
							<input class="form-control" name='subject_name' id='opt_subject_name' placeholder="Subject Name" required type="text" />
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label for="inputPassword12" class="col-md-3 control-label">Optional:</label>
						<div class="col-md-4">
							<input type="checkbox" id="opt_optional" value="on" class='form-control' name='optional'> Yes
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label for="inputPassword12" class="col-md-3 control-label">Full Mark:</label>
						<div class="col-md-4">
							<input class="form-control" name='full_mark' id='opt_full_mark' placeholder="Full Mark" required type="number" />
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label for="inputPassword12" class="col-md-3 control-label">Pass Mark:</label>
						<div class="col-md-4">
							<input class="form-control" name='pass_mark' id='opt_pass_mark' placeholder="Pass Mark" required type="number" />
							<div class="form-control-focus">
							</div>
						</div>
					</div>	
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