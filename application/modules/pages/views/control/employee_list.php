<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- /.modal -->
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- BEGIN PAGE HEADER-->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?=site_url('pages/home');?>">Home</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">General Content</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Employee Control</a>
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
							<span class="caption-subject bold uppercase">Employee Control</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<div class="col-md-12">
							<?php display_alert(); ?>
						<!-- data-table Start -->
							<div style=''>
								<table class="table table-striped table-bordered table-hover simple_table">
								<thead>
									<tr>
										<th>SN</th>
										<th>Employee</th>
										<th width="350px">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if($employees!=NULL)
									{ 
										$i=1;
										foreach($employees as $employee)
										{ ?>
											<tr>
												<td><?=$i?></td>
												
												<td>
													<div class="col-md-12">
														<div class='col-md-2'>
															<img src="<?= display_pic_path($employee->picture_path) ?>" width='75px'/>
														</div>
														<div class="col-md-10">
															<div class="col-md-12">
																<h4 class="cap tbl-a no-margin"><b><?=$employee->first_name?> <?=$employee->middle_name?> <?=$employee->last_name?></b></h4>
															</div>
															<div class="col-md-6">
																<b>Address:</b> <?=$employee->address?>
															</div>
															<div class="col-md-6">
																<b>Phone:</b> <?=$employee->phone_no?>
															</div>
															<div class="col-md-6">
																<b>Email:</b> <?=$employee->email?>
															</div>
															<div class="col-md-6">
																<b>Status:</b> <?=$employee->status?>
															</div>
															<div class="col-md-6">
																<b>Qualification:</b> <?=$employee->qualification?>
															</div>
															<div class="col-md-6">
																<b>Designation:</b> <?=$employee->designation?>
															</div>
														</div>
														
													</div>
												</td>
												<td>
													<a class='btn btn-sm btn-info edit_opt' data-toggle="modal" data-target="#large" data-info='{"id":"<?=$employee->employee_id?>", "first_name": "<?=$employee->first_name?>", "middle_name": "<?=$employee->middle_name?>", "last_name": "<?=$employee->last_name?>", "phone_no": "<?=$employee->phone_no?>", "email": "<?=$employee->email?>", "address": "<?=$employee->address?>", "birth_date": "<?=$employee->birth_date?>", "qualification": "<?=$employee->qualification?>", "agreement_type": "<?=$employee->agreement_type?>", "dept": "<?=$employee->dept?>", "basic_salary": "<?=$employee->basic_salary?>", "joined_date": "<?=$employee->joined_date?>", "employee_type": "<?=$employee->employee_type?>", "additionals": "<?=$employee->additionals?>", "status": "<?=$employee->status?>", "designation": "<?=$employee->designation?>", "code": "<?=$employee->code?>", "user_id": "<?=$employee->user_id?>", "biodata": "<?=$employee->biodata_path?>", "picture": "<?=$employee->picture_path?>" }'>Edit Info</a>
													<a class='btn btn-sm btn-danger' href="<?=site_url('pages/profile/employee/delete/'.$employee->employee_id);?>" onclick="return confirm('Do you want to Delete?')">Delete</a>
													<a class="btn btn-sm btn-success edit_opt" data-toggle="modal" data-target="#leave" data-info='{"emp_id":"<?=$employee->employee_id?>"}' >Entry Leave</a>
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
				<h4 class="modal-title">Edit Employee</h4>
			</div>
			<form class="margin-bottom-40"  method="post" action='<?= site_url('pages/profile/employee/update'); ?>' role="form" enctype="multipart/form-data" >
				<div class="modal-body">
				
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_first_name" name='first_name' required type="text">
                  <label >Enter First Name </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_middle_name" name='middle_name' type="text">
                  <label >Enter Middle Name </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_last_name" name='last_name' required type="text">
                  <label >Enter Last Name </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_phone_no" name='phone_no' type="text">
                  <label >Enter Phone No. </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_email" name='email' type="text">
                  <label >Enter Email </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_address" name='address' type="text">
                  <label >Enter Address </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control form-control-inline date-picker" data-date-format="yyyy-mm-dd" id="opt_birth_date" name='birth_date' type="text">
                  <label >Enter Birth Date </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_qualification" name='qualification' type="text">
                  <label >Enter Qualification </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <select class="form-control" required id="opt_agreement_type" name='agreement_type'>
                      <option value="">Select Type</option>
                      <option value="Full Time">Full Time</option>
                      <option value="Part Time">Part Time</option>
                      <option value="Hourly Basis">Hourly Basis</option>
                  </select>
                  <label >Agreement Type </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <select class="form-control" id="opt_dept" name='dept'>
                      <option value="">Select Department</option>
                      <?php
                      foreach ($departments as $department) {
                      ?>
                      <option value="<?= $department->dept_id?>"><?= $department->department_name ?></option>
                      <?php }?>
                  </select>
                  <label >Select Department </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_basic_salary" name='basic_salary' type="text">
                  <label >Enter Basic Salary </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control form-control-inline date-picker" data-date-format="yyyy-mm-dd" id="opt_joined_date" name='joined_date' type="text">
                  <label >Enter Joined Date </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <select class="form-control" id="opt_employee_type" name='employee_type'>
                      <option value="">Select Type</option>
                      <option value="Faculty">Faculty</option>
                      <option value="Staff">Staff</option>
                  </select>
                  <label >Employee Type</label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_additionals" name='additionals' type="text">
                  <label >Enter Additionals </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <select class="form-control" id="opt_status" name='status'>
                      <option value="">Select Status</option>
                      <option value="Currently Working">Currently Working</option>
                      <option value="On Leave">On Leave</option>
                      <option value="Left">Left</option>
                  </select>
                  <label >Select Status </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_designation" name='designation' type="text">
                  <label >Designation </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_code" name='code' type="text">
                  <label >Employee Code </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group form-md-line-input">
                  <input class="form-control" id="opt_user_id" name='user_id' type="text">
                  <label >Enter User Id </label>
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group">
                <label>Biodata </label>
                <input class="" name='biodata' type="file">
                <input type="hidden" name="prev_biodata" id="opt_biodata" >
              </div>
          </div>
          <div class="col-md-4">
              <div class="form-group">
                <label >Picture </label>
                <input class="" name='picture' type="file" accept="image/*">
                <span class="label label-danger">NOTE: Allowed format *.jpg only</span>
                <input type="hidden" name="prev_picture" id="opt_picture" >
              </div>
          </div>
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

<!-- model start -->
<div class="modal fade bs-modal-md" id="leave" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Employee Leave</h4>
			</div>
			<form class="margin-bottom-40"  method="post" action='<?= site_url('pages/profile/employee/update'); ?>' role="form" enctype="multipart/form-data" >
				<div class="modal-body">
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Type:</label>
								<div class="col-md-6 no-padding">
									<select class="form-control" name='leave_type' required >
										<option>Sick</option>
										<option>Home</option>
										<option>Substitute</option>
										<option>Other</option>
									</select>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">From: </label>
								<div class="col-md-6 no-padding">
									<input class="form-control date-picker" name='zone' required placeholder="From Date" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Till: </label>
								<div class="col-md-6 no-padding">
									<input class="form-control date-picker" name='region' required placeholder="Till Date" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">No. of Days: </label>
								<div class="col-md-6 no-padding">
									<input class="form-control" name='state' required placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Purpose: </label>
								<div class="col-md-6 no-padding">
									<textarea class="form-control"  name='state' required placeholder="Reason" type="text"></textarea>
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<input type="hidden" name="emp_id" id='opt_emp_id' value="">
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