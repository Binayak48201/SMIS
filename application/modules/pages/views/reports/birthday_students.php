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
					<a href="#">General Reports</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Birthday Today</a>
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
							<span class="caption-subject bold uppercase">Birthday Today</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">
						<div class="clearfix"> </div>
					<?php
							if(isset($students) && !empty($students))
							{
								?>
								<div class="note note-primary text-center">
									<p>
										LIST OF Students having birthday today
									</p>
								</div>
								<div class='st-list'>
								<?php
	            	foreach($students as $student)
	            	{ ?>
									<div class="profile-sidebar col-md-2">
										<!-- PORTLET MAIN -->
										<div class="portlet light profile-sidebar-portlet" style="min-height: 210px">
											<!-- SIDEBAR USERPIC -->
											<a target="#details" href='<?= site_url('pages/profile/student/details/'.$student->student_id); ?>'>
												<div class="cstm-profile-pic">
													<img src="<?=site_url('uploads/student_photo/'.$student->USER_NAME);?>.jpg?dump=<?=rand();?>" class="img-responsive" alt="">
												</div>
												<!-- END SIDEBAR USERPIC -->
												<!-- SIDEBAR USER TITLE -->
												<div class="profile-usertitle">
													<ul class="cstm-list text-center">
														<li>
															<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>
														</li>
														<li>
															Roll No: <?=$student->current_roll?>
														</li>
														<li>
															(<?=$student->USER_NAME?>)
														</li>
													</ul>
												</div>
											</a>
											<!-- END SIDEBAR USER TITLE -->
											<!-- END MENU -->
										</div>
										<!-- END PORTLET MAIN -->
									</div>
	            		<?php
	            	}   ?></div> <?php
	            }
	            else
	            {
	            	?>
									<div class="note note-primary text-center">
									<p>
										No Records Available. 
									</p>
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

