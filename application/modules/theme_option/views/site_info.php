<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- /.modal -->
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- BEGIN STYLE CUSTOMIZER -->
		
		<!-- END STYLE CUSTOMIZER -->
		<!-- BEGIN PAGE HEADER-->
		<!-- <h3 class="page-title">
		Dashboard</h3> -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?=site_url('pages/home');?>">Home</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Site Information</a>
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
							<span class="caption-subject bold uppercase">Application Information</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('theme_option/site_info/update_info'); ?>' role="form" enctype="multipart/form-data" >
										<?php display_alert(); ?>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">School Name</label>
								<div class="col-md-4">
									<input class="form-control" name='title' value="<?=$theme_option->title?>" required placeholder="Enter School Name" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">School Logo</label>
								<div class="col-md-4">
									<?php 
									//echo file_exists("/uploads/".$theme_option->logo);
										if(file_exists(IMG_UPLOAD_PATH."/".$theme_option->logo))
										{ ?>
											<img src="<?=site_url('uploads/'.$theme_option->logo);?>" width='175px'>
											<?php
										}
									?>
									<input type="hidden" name="pre_logo" value="<?=$theme_option->logo;?>">
									<input class="" name='logo' type="file">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">School Address</label>
								<div class="col-md-4">
									<input class="form-control" name='address' value="<?=$theme_option->address?>" required placeholder="Enter School Name" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">School Email</label>
								<div class="col-md-4">
									<input class="form-control" name='email' value="<?=$theme_option->email?>" required placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">School Fax</label>
								<div class="col-md-4">
									<input class="form-control" name='fax' value="<?=$theme_option->fax?>"  placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">School Telephone</label>
								<div class="col-md-4">
									<input class="form-control" name='tel' value="<?=$theme_option->tel?>" required placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">School PBO</label>
								<div class="col-md-4">
									<input class="form-control" name='pbo' value="<?=$theme_option->pbo?>"  placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Mark Sheet Display Post </label>
								<div class="col-md-4">
									<input class="form-control" name='marksheet_post' value="<?=$theme_option->marksheet_post?>"  placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Mark Sheet Display Name</label>
								<div class="col-md-4">
									<input class="form-control" name='marksheet_post_name' value="<?=$theme_option->marksheet_post_name?>"  placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Mark Sheet Restrict Message</label>
								<div class="col-md-4">
									<input class="form-control" name='marksheet_restrict' value="<?=$theme_option->marksheet_restrict?>"  placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<!-- <div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Mark Sheet Restrict Message</label>
								<div class="col-md-4">
									<input class="form-control" name='marksheet_restrict' value="<?=$theme_option->marksheet_restrict?>"  placeholder="" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div> -->
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Final Upscale Marking</label>
								<div class="col-md-4">
									<input type="checkbox" class="make-switch" name='final_upscale_marking' <?= $theme_option->final_upscale_marking ==1 ? 'checked' : ''?> value="1" data-on-text="Yes" data-size="small" data-off-text="No">
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Assessment Mark Allocation</label>
								<div class="col-md-4">
									<input type="checkbox" class="make-switch" name='assessment_module' <?= $theme_option->assessment_module ==1 ? 'checked' : ''?> value="1" data-on-text="Yes" data-size="small" data-off-text="No">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-10">
									<button name="update"  class="btn blue" type='submit'>Update Information</button>
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