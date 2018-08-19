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
					<a href="#">Reassign Student CLass</a>
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
							<span class="caption-subject bold uppercase">Reassign Student CLass</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">
						<?php display_alert(); ?>
						<form class="" method='post'>
							<div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class=" " style="padding-top: 12px;">
									<div class="col-md-2">
	                  <div class="form-group form-md-line-input">
	                    <select class="form-control display_section" name='batch' id='batch' required>
	                      <option value="">Select Batch</option>
	                      <?php if($batchs!=NULL)
	                      { 
	                        $i=1;
	                        foreach($batchs as $batch)
	                        { ?>
	                            <option <?= isset($sbatch) && $sbatch == $batch->batch_name ? 'selected' : '' ?> value="<?=$batch->batch_name?>"><?=$batch->batch_name?></option>
	                          <?php
	                          $i++;
	                        }
	                      } ?>
	                    </select>
	                    <label>Batch: </label>
	                  </div>
	                </div>
	                <div class="col-md-2">
	                  <div class="form-group form-md-line-input">
	                    <select class="form-control display_section" name='grade' id='grade' required>
	                      <option value="">Select Grade</option>
	                      <?php if($grades!=NULL)
	                      { 
	                        $i=1;
	                        foreach($grades as $grade)
	                        { ?>
	                            <option <?= isset($sgrade) && $sgrade == $grade->grade_name ? 'selected' : '' ?> value="<?=$grade->grade_name?>"><?=$grade->grade_name?></option>
	                          <?php
	                          $i++;
	                        }
	                      } ?>
	                    </select>
	                    <label>Grade: </label>
	                  </div>
	                </div>
	                <div class="col-md-3">
	                  <div class="form-group form-md-line-input display_class">
	                   <select class="form-control" name='section_id' id="section" required>
	                    <option value="">Select Section</option>
	                    <option <?= isset($ssection) && $ssection == 'all' ? 'selected' : '' ?>  value="all">All</option>
	                    <?php if($sections!=NULL)
	                      { 
	                        $i=1;
	                        foreach($sections as $section)
	                        { ?>
	                            <option <?= isset($ssection) && $ssection == $section->section_id ? 'selected' : '' ?> value="<?=$section->section_id?>"><?=$section->section_name?></option>
	                          <?php
	                          $i++;
	                        }
	                      } ?>
	                  </select>
	                    <label>Section: </label>
	                  </div>
	                </div>
	                <div class='col-md-2'>
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
							if(isset($students) && !empty($students))
							{
								?>
								<div class="note note-warning text-center">
									<p>
										LIST OF STUDENTS
									</p>
								</div>
							<form method="post" action="<?= site_url('pages/profile/student/update_class_reassign'); ?>">
								<div class='st-list'>
									<?php
		            	foreach($students as $student)
		            	{ ?>
										<div class="profile-sidebar col-md-2">
											<!-- PORTLET MAIN -->
											<div class="portlet light profile-sidebar-portlet" style="min-height: 200px">
												<!-- SIDEBAR USERPIC -->
												<a href='<?= site_url('pages/profile/student/edit/'.$student->student_id); ?>'>
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
															<li>
																<div class="md-checkbox has-success">
																	<input id="checkbox<?=$student->student_id?>" class="md-check st_check" value='<?=$student->student_id?>' name='student_ids[]' type="checkbox">
																	<label class="no-padding" for="checkbox<?=$student->student_id?>">
																	<span class="inc"></span>
																	<span class="check"></span>
																	<span class="box"></span>
																	Reassign </label>
																</div>
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
		            	}   ?>
		            </div> 
								<div class="clearfix"></div>
								<div class="navbar navbar-default" role="navigation">
									<!-- Brand and toggle get grouped for better mobile display -->
									<!-- Collect the nav links, forms, and other content for toggling -->
									<div class=" " style="padding-top: 12px;">
										<div class="col-md-2">
												<div class="md-checkbox-inline">
													<div class="md-checkbox has-success">
														<input class="md-check" id='assign_all' value='5' type="checkbox">
														<label for="assign_all">
														<span class="inc"></span>
														<span class="check"></span>
														<span class="box"></span>
														Reassign All</label>
													</div>
												</div>
											</div>
										<div class="col-md-2">
		                  <div class="form-group form-md-line-input">
		                    <select class="form-control re_display_section" name='re_batch' id='re_batch' required>
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
		                    <label>Reassign Batch: </label>
		                  </div>
		                </div>
		                <div class="col-md-2">
		                  <div class="form-group form-md-line-input">
		                    <select class="form-control re_display_section" name='re_grade' id='re_grade' required>
		                      <option value="">Select Grade</option>
		                      <?php if($grades!=NULL)
		                      { 
		                        $i=1;
		                        foreach($grades as $grade)
		                        { ?>
		                            <option  value="<?=$grade->grade_name?>"><?=$grade->grade_name?></option>
		                          <?php
		                          $i++;
		                        }
		                      } ?>
		                    </select>
		                    <label>Reassign Grade: </label>
		                  </div>
		                </div>
		                <div class="col-md-3">
		                  <div class="form-group form-md-line-input display_class">
		                   <select class="form-control" name='re_section' id="re_section" required>
		                    <option value="">Select Section</option>
		                    <?php if($sections!=NULL)
		                      { 
		                        $i=1;
		                        foreach($sections as $section)
		                        { ?>
		                            <option value="<?=$section->section_id?>"><?=$section->section_name?></option>
		                          <?php
		                          $i++;
		                        }
		                      } ?>
		                  </select>
		                    <label>Reassign Section: </label>
		                  </div>
		                </div>
		                <div class='col-md-2'>
											<div class="col-md-4 form-group form-md-line-input">
												<button name="reassign" value="REASSIGN" class="btn btn-success" type='submit'>Re-Assign</button>
											</div>
										</div>
									</div>
									<!-- /.  -->
								</div>
							</form>			
	            	<?php
	            }
	            else if(!isset($students) && isset($ssection))
	            {
	            	?>
									<div class="alert alert-info text-center">No Records Available.</div>
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

