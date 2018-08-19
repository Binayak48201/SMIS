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
					<a href="#">Bulk Photo Upload</a>
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
							<span class="caption-subject bold uppercase">Upload Photo of Student</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body col-md-12">
						<div class="note note-warning text-center">
							<p>
								Photo Uploader. The photo that is to be uploaded should be in zip file.
							</p>
						</div>
						<form class="form-horizontal form-bordered navbar navbar-default" action='<?=site_url("pages/profile/student_photo/verify");?>' method='post' enctype="multipart/form-data" style="padding-top: 20px;">
							<?php display_alert(); ?>
							<div class="form-body col-md-offset-2">
								<div class="form-group">
									<label class="control-label col-md-3">Upload File</label>
									<div class="col-md-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="input-group input-large">
												<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
													<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
													</span>
												</div>
												<span class="input-group-addon btn default btn-file">
												<span class="fileinput-new">
												Select file </span>
												<span class="fileinput-exists">
												Change </span>
												<input type="file" required="" name="student_photo" accept='.zip'>
												</span>
												<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
												Remove </a>
											</div>
										</div>
										<div class="clearfix margin-top-10">
											<span class="label label-danger">
											NOTE! </span>
											 &nbsp;Only Zip Files are acepted
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2">
										<button name="verify" value="VERIFY" class="btn blue" type='submit'>Verify</button>
									</div>
								</div>
							</div>
						</form>
						<hr/>
						<div class="col-md-6">
							<?php if(isset($results) && !empty($results))
							{  ?>
							<b>FileName:</b> <?=$fileanme?>
								<table class="table table-striped">
									<tr>
										<th>File</th>
										<th>Status</th>
									</tr>
									<?php
									$total=0;
									$success=0;
									foreach($results as $val)
										{
											?>
											<tr>
												<td><?=($val['name']);?></td>
												<td class='alert <?php if($val["status"]=="Verified"){$success++;echo"alert-success";}else{echo"alert-danger";}?>'><?=($val['status']);?></td>
											</tr>
											<?php 
											$total++;
										} ?>
								</table>
										<?php
										if($total==$success)
										{	?>
									<hr/>
											<form class="form-horizontal form-bordered navbar navbar-default" action='<?=site_url("pages/profile/student_photo/upload");?>' method='post' enctype="multipart/form-data" style="padding-top: 20px;">
													<div class="form-body">
														<div class="form-group">
															<label class="control-label col-md-3">Upload File</label>
															<div class="col-md-9">
																<div class="fileinput fileinput-new" data-provides="fileinput">
																	<div class="input-group input-large">
																		<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
																			<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
																			</span>
																		</div>
																		<span class="input-group-addon btn default btn-file">
																		<span class="fileinput-new">
																		Select file </span>
																		<span class="fileinput-exists">
																		Change </span>
																		<input type="file" required="" name="student_photo" accept='.zip'>
																		</span>
																		<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
																		Remove </a>
																	</div>
																</div>
																<div class="clearfix margin-top-10">
																	<span class="label label-danger">
																	NOTE! </span>
																	 &nbsp;Only Zip Files are accepted
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="col-md-offset-2">
																<button name="upload" value="UPLOAD" class="btn blue" type='submit'>Upload</button>
															</div>
														</div>
													</div>
											</form>
											<?php
										}
										else
										{
											echo'<span class="label label-danger">Please correct the errors to save the file</span>';
										}
								} ?>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- END SAMPLE FORM PORTLET-->
		</div>
	</div>
</div>

