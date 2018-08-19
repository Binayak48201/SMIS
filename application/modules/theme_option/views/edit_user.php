<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		
		<!-- modal -->
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- BEGIN STYLE CUSTOMIZER -->
		
		<!-- END STYLE CUSTOMIZER -->
		<!-- BEGIN PAGE HEADER-->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?=site_url('theme_option/home');?>">Home</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<i class="fa icon-list"></i>
					<a href="<?=site_url('theme_option/user_account/lists');?>">Manage Users</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Edit User Account</a>
				</li>
			</ul>
			<div class="page-toolbar">
		        <a href="javascript:history.go(-1)"><div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left">
		          Back
		        </div></a>
		      </div>
		</div>
		
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="portlet light">
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption font-red-sunglo">
									<i class="icon-settings font-red-sunglo"></i>
									<span class="caption-subject bold uppercase">Edit User Account</span>
								</div>
							</div>
							<div class="portlet-body form">
								<div class=" portlet-tabs">
									<form method="post" id='changepass' action="<?=site_url('theme_option/user_account/update/'.$user->USER_ID);?>">
										<?php display_alert(); ?>
										<div class="col-md-6">
											<div class="form-group form-md-line-input ">
												<input name="user_name" class="form-control" required value="<?=$user->USER_NAME?>" type="text">
												<label>User Name: </label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="">
												<input  name="change_password" id='chng-pass' class="md-check" value="1" type="checkbox">
												<label for="checkbox30">
												Change Password</label>
											</div>
										</div>
										<div class='clearfix'> </div><br>
										<div class="col-md-6">
											<div class="form-group form-md-line-input ">
												<input class="form-control chng-pass" disabled id="pass" name='new_pass' required patterns="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="New Password" type="password">
												<label>New Password: </label>
											</div>
										</div>
										<div class="col-md-6" >
											<div class="form-group form-md-line-input ">
												<input class="form-control chng-pass" disabled id="repass" name='re_pass' required placeholder="Confirm Password" type="password">
												<label>Confirm Password: </label>
											</div>
											<span class="error-block label alert-danger" style="display: none;" id='error_pass'>Password doesn't Match</span>
										</div>
										<div class="col-md-4">
                      <div class="form-group form-md-line-input">
                        <input class="form-control" name='profile_id' value="<?=$user->PROFILE_ID?>"  type="text">
                        <label >Profile Id</label>
                         <!--  <div class="form-control-focus"></div> -->
                      </div>
                  	</div>
										<div class="col-md-8">
										<label>Account Status</label>
                      <input type="checkbox" id="checkbox12" <?php if($user->ACC_STATUS=='ON'){ echo 'checked="checked"'; } ?> data-id='12' class="make-switch" name='acc_status' data-on-text="ON" data-size="small" data-off-text="OFF">
                    </div>
                    <div class='clearfix'> </div><br>
										<div class="col-md-12" >
											<div class="form-group form-md-radios">
												<label>User Type</label>
												<div class="md-radio-inline">
													<?php 
														$i=1;
														foreach ($user_type as $row) 
														{
															?>
															<div class="md-radio">
																<input <?=($user->ROLE_ID==$row->ROLE_ID) ? 'checked':'' ?> id="radio<?=$row->ROLE_ID?>" name="user_type" value="<?=$row->ROLE_ID?>" class="md-radiobtn" type="radio">
																<label for="radio<?=$row->ROLE_ID?>">
																<span class="inc"></span>
																<span class="check"></span>
																<span class="box"></span>
																<?=$row->ROLE_NAME;?></label>
															</div>
															<?php 
															$i++;
														}
													?>
												</div>
											</div>	
										</div>
										<button type="submit" name='update' value="UPDATE" class="btn btn-info">Update </button>
									</form>		
									<div class='clearfix'> </div>					
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	<!--Cooming Soon...-->
	<!-- END QUICK SIDEBAR -->
</div>

