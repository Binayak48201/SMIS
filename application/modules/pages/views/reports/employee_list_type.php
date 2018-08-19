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
					<a href="#">Employee Reports</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Employee List by Type</a>
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
							<span class="caption-subject bold uppercase">Employee List by Type</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">
						<?= display_alert() ?>
						<div class="clearfix"> </div>							
						<?php
							if(isset($results) && !empty($results))
							{
								?>
								
								<div class="portlet-title tabbable-line">
									<ul class="nav nav-tabs">
										<?php 
											foreach ($emp_types as $key => $emp_type) {
												?>
												<li class="<?= $key == 1 ? 'active' : '' ?>">
													<a href="#tab_<?= $key?>" data-toggle="tab"><?= $emp_type ?></a>
												</li>
												<?php
											}
										?>
									</ul>
									<div class="tab-content">
										<!-- GENERAL QUESTION TAB -->
										<?php 
											foreach ($emp_types as $key => $emp_type) {		
												?>
													<div class="tab-pane <?= $key == 1 ? 'active' : '' ?>" id="tab_<?= $key?>">
														<div class="col-md-12">
															<table class="table table-stripped table-condensed simple_table">
																<thead>
																	<tr>
																		<th>SN</th>
																		<th>Employee Photo</th>
																		<th>Employee Name</th>
																		<th>Email</th>
																		<th>Agreement Type</th>
																		<th>Designation</th>
																		<th>Action</th>
																	</tr>
																</thead>
																<tbody>
																	<?php $i = 1;
										            	foreach($results as $employee)
										            	{ 
										            		if($emp_type == $employee->employee_type)
																		{			
																			?>
																		<tr>
																			<td><?=$i++;?></td>
																			<td>
																				<img src="<?= file_exists(IMG_UPLOAD_PATH."/".$employee->picture_path) ? site_url('uploads/'.$employee->picture_path).'?dump='.rand() : site_url('assets'); ?>/admin/layout2/img/avatar.png ?>" width="50px" alt="">
																			</td>
																			<td>
																				<?=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name?>
																			</td>
																			<td><?=$employee->email?></td>
																			<td><?=$employee->agreement_type?></td>
																			<td><?=$employee->designation?></td>
																			<td>
																				<a class="btn btn-sm btn-primary view_profile" data-id="<?= $employee->employee_id ?>" data-toggle="modal" data-target="#large" >View Profile</a>
																			</td>
																		</tr>
										            		<?php
										            		}
										            	} ?>
										            </tbody>
										          </table>
										      </div><div class="clearfix"></div>
										    </div>
							      			<?php
											}
										?>

							    </div>
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

