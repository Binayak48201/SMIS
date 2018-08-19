<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
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
					<a href="#">Change Password</a>
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
							<span class="caption-subject bold uppercase"> Change Password</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('theme_option/change_password/update'); ?>' role="form" >
							<?php display_alert(); ?>	
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Old Password</label>
								<div class="col-md-4">
									<input class="form-control" id="oldpass" name='old_pass' required placeholder="Old Password" type="password">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">New Password</label>
								<div class="col-md-4">
									<input class="form-control" id="pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"  name='new_pass' minlength="6" required placeholder="New Password" type="password">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div id='conf-pass' class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Confirm Password</label>
								<div class="col-md-4">
									<input class="form-control" id="repass" name='re_pass' minlength="6" required placeholder="Confirm Password" type="password">
									<div class="form-control-focus"></div>
								</div>
									<span class="error-block label alert-danger" style="display: none;" id='error_pass'>Password doesn't Match</span>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-10">
									<button name="update"  class="btn blue" type='submit'>Update Password</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- END SAMPLE FORM PORTLET-->
		</div>
	</div>
</div>