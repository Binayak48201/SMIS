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
					<a href="#">Student</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Find Student</a>
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
							<span class="caption-subject bold uppercase">Find Student</span>
						</div>
					</div>
					<div style="overflow: auto;" class="portlet-body">
						<form class="" method='post'>
							<div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class=" " style="padding-top: 12px;">
										<div class="col-md-3">
											<div class="form-group form-md-line-input">
	                      <select class="form-control edited form-selection" required name="find_by" id="find_by">
	                         	<option value="st_fname">First Name</option>
			                      <option value="st_lname	">Last Name</option>
			                      <option value="home_phone">Home Phone No</option>
			                      <option value="email_address">Email Address</option>
			                      <option value="mother_name">Mother Name</option>
			                      <option value="guardian_name">Guardian Name</option>
	                      </select>
	                      <label>Search according to </label>
		                  </div>
										</div>
										<div class="col-md-6">
												<div class="col-md-8">
													<div class="form-group form-md-line-input">
			                      <input class="form-control" autofocus required name="key" type="text" id="key">
				                  	<div class="form-control-focus">
				                  	</div>
                          </div>
												</div>
												<div class="col-md-4 form-group form-md-line-input">
															<button name="search" value="SEARCH" class="btn btn-success" type='submit'>Search</button>
												</div>
										</div>
								</div>
								<!-- /.  -->
							</div>
						</form>
						<div class="clearfix"> </div>
							
						<?php
							if(isset($results) && !empty($results))
							{
								?>
								<div class="note note-warning text-center">
									<p>
										LIST OF STUDENTS
									</p>
								</div>
									<div class='flex-cont'>
										<?php $i=1;
			            	foreach($results as $row)
			            	{ ?>
									<div class="col-md-6 no-padding flex-main">
										<div class="col-md-12 parent-search">
											<div class="std-img">
											<a href="<?=site_url('pages/profile/student/details/'.$row->student_id)?>"><img src="<?= display_pic_path($row->picture_path); ?>" class="img-responsive search-img" alt=""></a>
											</div>
											<div class="std-info">
												<ul>
													<li style='display: inline-block;font-weight: bold'><a href="<?=site_url('pages/profile/student/details/'.$row->student_id)?>"><?=$row->st_fname.' '.$row->st_mname.' '.$row->st_lname?>(<?=$row->current_roll?>) </a></li>  <span class='label label-info'><?=$row->dropped_out == 0 ? $row->passed_out	== 1 ? 'Passed-Out': 'Studying' :'Dropped'?></span>
													<li style='margin-top:7px;'>Grade: <?=$row->grade?></li>
													<li>Section: <?=$row->section_name?></li>
													<li><?=$row->mother_name?></li>
													<li><?=$row->home_phone?>  </li>
													<li>Account-Id : <?=$row->USER_NAME?></li>
													
													
												</ul>
											</div>
										</div>
									</div>											
			            		<?php
			            	}   ?>
			            	</div>
			            		
	            		<?php
	            }
	            else if(isset($searched))
	            {	?>
	          		<div class="alert alert-info text-center"> No Records Found.</div>
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

