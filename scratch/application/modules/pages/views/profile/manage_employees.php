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
					<a href="#">Manage Employee</a>
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
							<span class="caption-subject bold uppercase">Manage Employee</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">
						<?= display_alert() ?>
						<div class="clearfix"> </div>							
						<?php
							if(isset($results) && !empty($results))
							{
								?>
								<div class="col-md-12">
									<table class="table table-stripped table-condensed simple_table">
										<thead>
											<tr>
												<th>SN</th>
												<th>Employee Photo</th>
												<th>Employee Name</th>
												<th>Email</th>
												<th>Agreement Type</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1;
				            	foreach($results as $employee)
				            	{ ?>
												<tr>
													<td><?=$i++;?></td>
													<td>
														<img src="<?= file_exists(IMG_UPLOAD_PATH."/".$employee->picture_path) ? site_url('uploads/'.$employee->picture_path).'?dump='.rand() : site_url('assets'); ?>/admin/layout2/img/avatar.png ?>" width="100px" alt="">
													</td>
													<td>
														<?=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name?>
													</td>
													<td><?=$employee->email?></td>
													<td><?=$employee->agreement_type?></td>
													<td>
														<a class="btn btn-sm btn-success leaveEntry" data-id="<?= $employee->employee_id ?>" data-toggle="modal" data-target="#leaveEntry" >Leave Entry</a>
														<a class="btn btn-sm btn-primary view_profile" data-id="<?= $employee->employee_id ?>" data-toggle="modal" data-target="#large" >View Profile</a>
														<a class="btn btn-sm btn-info" href='<?= site_url('pages/profile/employee/edit/'.$employee->employee_id); ?>'>Edit</a>
														<a class="btn btn-sm btn-danger" onclick="return confirm('Are you Sure?');" href='<?= site_url('pages/profile/employee/delete/'.$employee->employee_id); ?>'>Delete</a></td>
												</tr>
				            		<?php
				            	} ?>
				            </tbody>
				          </table>
				        </div>
	            	 <?php
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
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			</div>
				<div class="modal-body" id="profile_content">
							<div class="alert">Loading..</div>
							
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-md" id="leaveEntry" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Employee Leave</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			</div>
			<form class="form-horizontal margin-bottom-40" method="post" action="<?= site_url('pages/profile/employee/add_leave'); ?>" role="form">
				<div class="modal-body">							
					<input type="hidden" name="emp_id" id="emp_id" value="">
					<div class="form-group form-md-line-input no-margin-imp">
						<label for="inputPassword12" class="col-md-3 control-label">Type:</label>
						<div class="col-md-5">
							<select class="form-control" name="type" required="">
								<option value="Sick">Sick</option>
								<option value="Home">Home</option>
								<option value="Substitute">Substitute</option>
								<option value="Other">Other</option>
							</select>
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input no-margin-imp">
						<label for="inputPassword12" class="col-md-3 control-label">From:</label>
						<div class="col-md-5">
							<input class="form-control date-picker" name="from" required="" type="text">
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input no-margin-imp">
						<label for="inputPassword12" class="col-md-3 control-label">Till:</label>
						<div class="col-md-5">
							<input class="form-control date-picker" name="till" required="" type="text">
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input no-margin-imp">
						<label for="inputPassword12" class="col-md-3 control-label">No. of Days:</label>
						<div class="col-md-5">
							<input class="form-control" name="days_no" required="" type="number">
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input no-margin-imp">
						<label for="inputPassword12" class="col-md-3 control-label">Purpose:</label>
						<div class="col-md-5">
							<textarea class="form-control" name="purpose"></textarea> 
							<div class="form-control-focus">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn default" data-dismiss="modal" type="reset">Cancel</button>
					<button name="add" value="ADD" class="btn blue" type="submit">Add</button>
				</div>
			</form>							
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->