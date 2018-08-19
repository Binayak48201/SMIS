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
					<a href="#">Student List</a>
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
							<span class="caption-subject bold uppercase">Student List</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">
						<?= display_alert() ?>
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
								<div class=" portlet-tabs">
									<ul class="nav nav-pills">
										<li class="active">
											<a aria-expanded="true" href="#portlet_tab1" data-toggle="tab">
											Personal Info </a>
										</li>
										<li class="">
											<a aria-expanded="false" href="#portlet_tab2" data-toggle="tab">
											Parents Info </a>
										</li>
										<li class="">
											<a aria-expanded="false" href="#portlet_tab3" data-toggle="tab">
											Academic Info </a>
										</li>
										<li class="">
											<a aria-expanded="false" href="#portlet_tab4" data-toggle="tab">
											Student Photo </a>
										</li>
										<!-- <li class=" <?=$this->session->userdata('usertype_id')!=1 ? 'hide' : '' ?>">
											<a aria-expanded="false" href="#portlet_tab6" data-toggle="tab">
											Student Photo(Export)</a>
										</li> -->
									</ul>
									<div class="tab-content">
										<div class="col-md-12 tab-pane active" id="portlet_tab1">
											<button data-id="student_list" class="btn btn-success exportTable pull-left">Export to Excel</button>
											<div class="clearfix"></div>
											<table id="student_list" class="table table-condensed table-bordered table-striped simple_table">
												<thead>
													<tr>
														<th>SN</th>
														<th>Name</th>
														<th>Gender</th>
														<th>DOB (A.D.)</th>
														<th>DOB (B.S.)</th>
														<th>Home Phone</th>
														<th>Home Address</th>
														<th>Birth Place</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1; $st_ids = array();
						            	foreach($students as $student)
						            	{ ?>
														<tr>
															<td><?= $i++; ?></td>
															<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id);?>"><?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?></a></td>
															<td><?=$student->gender?></td>
															<td><?=$student->st_dob?></td>
															<td><?=$student->st_dob_np ?></td>
															<td><?=$student->home_phone?></td>
															<td><?=$student->home_address?></td>
															<td><?=$student->birth_place?></td>
														</tr>
						            		<?php
						            		$st_ids[] = $student->student_id;
						            	}  

						            	 ?>
						            </tbody>
											</table>
										</div>
										<div class="col-md-12 tab-pane" id="portlet_tab2">
											<button data-id="student_pt_list" class="btn btn-success exportTable pull-left">Export to Excel</button>
											<div class="clearfix"></div>
											<table id="student_pt_list" class="table table-condensed table-bordered table-striped simple_table">
												<thead>
													<tr>
														<th>SN</th>
														<th>Name</th>
														<th>Father</th>
														<th>Father contact</th>
														<th>Mother</th>
														<th>Mother contact</th>
														<th>Guardian</th>
														<th>Guardian contact</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1; $st_ids = array();
						            	foreach($students as $student)
						            	{ ?>
														<tr>
															<td><?= $i++; ?></td>
															<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id);?>"><?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?></a></td>
															<td><?=$student->father_name?></td>
															<td><?=$student->father_cell?></td>
															<td><?=$student->mother_name?></td>
															<td><?=$student->mother_cell?></td>
															<td><?=$student->guardian_name?></td>
															<td><?=$student->guardian_phone?></td>
														</tr>
						            		<?php
						            		$st_ids[] = $student->student_id;
						            	}  

						            	 ?>
						            </tbody>
											</table>
										</div>
										<div class="col-md-12 tab-pane" id="portlet_tab3">
											<button data-id="student_ac_list" class="btn btn-success exportTable pull-left">Export to Excel</button>
											<div class="clearfix"></div>
											<table id="student_ac_list" class="table table-condensed table-bordered table-striped simple_table">
												<thead>
													<tr>
														<th>SN</th>
														<th>Name</th>
														<th>Roll No</th>
														<th>Grade</th>
														<th>Section</th>
														<th>House</th>
														<th>Boarding Type</th>
														<th>Bus Route</th>
														<th>Bus Stop</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1; $st_ids = array();
						            	foreach($students as $student)
						            	{ ?>
														<tr>
															<td><?= $i++; ?></td>
															<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id);?>"><?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?></a></td>
															<td><?=$student->current_roll?></td>
															<td><?=$student->grade?></td>
															<td><?=$student->section_name?></td>
															<td><?=$student->house_name?></td>
															<td><?=$student->boarding_type?></td>
															<td><?=$student->bus_name?></td>
															<td><?=$student->stop_name?></td>
														</tr>
						            		<?php
						            		$st_ids[] = $student->student_id;
						            	}  

						            	 ?>
						            </tbody>
											</table>
										</div>
										<div class="col-md-12 tab-pane" id="portlet_tab4">
											<div class='alert alert-info text-center'> 
																	<div class="col-md-offset-4 col-md-1">
																		<div class="md-radio">
																			<input id="radioall" name="report_by" class="gender_by md-radiobtn" required value="all" type="radio">
																			<label for="radioall">
																			<span></span>
																			<span class="check"></span>
																			<span class="box"></span>
																			ALL </label>
																		</div>
																	</div>
																	<div class="col-md-1">
																		<div class="md-radio">
																			<input id="radiof" name="report_by" class="gender_by md-radiobtn" required value="f" type="radio">
																			<label for="radiof">
																			<span></span>
																			<span class="check"></span>
																			<span class="box"></span>
																			Female </label>
																		</div>
																	</div>
																	<div class="col-md-1">
																		<div class="md-radio">
																			<input id="radiom" name="report_by" class="gender_by md-radiobtn" required value="m" type="radio">
																			<label for="radiom">
																			<span></span>
																			<span class="check"></span>
																			<span class="box"></span>
																			Male </label>
																		</div>
																	</div>
																	<div class="clearfix"> </div>
																</div>
																<div class='photo-flex' style='display: flex;flex-flow:row wrap;'>
																	<?php $i=0; 
																	foreach ($students as $row) 
																	{		
																		
																		?>
																		
																			<div class="profile-sidebar col-sm-2 gender-<?=$row->gender?>">
																			<div class="portlet light profile-sidebar-portlet">
																				<div class="text-center cstm-profile-pic">
																				<a class='tbl-a' href="<?=site_url('pages/profile/student/details/'.$row->student_id)?>">
														                <img class="img-responsive" src='<?= display_pic_path($row->picture_path); ?>' alt='<?=$row->st_fname.' '.$row->st_mname.' '.$row->st_lname?>' />
														              
														                <br/>
														                <span><?=$row->st_fname.' '.$row->st_mname.' '.$row->st_lname?></span>
														              </a>
																				</div>
																				
																			</div>
																		</div>
																		
																		<?php 
																	}  ?>
																</div>
										</div>
										<div class="col-md-12 tab-pane" id="portlet_tab5">
										</div>
								</div>
	            	 <?php
	            }
	            else if(isset($ssection))
	            {
	            	?>
									<div class="note note-warning text-center">No Records Available</div>
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

