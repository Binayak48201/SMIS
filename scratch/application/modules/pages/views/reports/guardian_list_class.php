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
					<a href="#">Guardian List by Class</a>
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
							<span class="caption-subject bold uppercase">Guardian List by Class</span>
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
										LIST OF Guardian
									</p>
								</div>
								<button data-id="student_list" class="btn btn-success exportTable pull-right">Export to Excel</button>
								<div class="clearfix"></div>
								<br>
								<div>
									<table id="student_list" class="table table-condensed table-bordered table-striped">
										<thead>
											<tr>
												<th>SN</th>
												<th>Student Name</th>
												<th>Class</th>
												<th>Guardian</th>
												<th>Guardian Phone</th>
												<th>Guardian Email</th>
												<th>Guardian Occupation</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; $st_ids = array();
				            	foreach($students as $student)
				            	{ ?>
												<tr>
													<td><?= $i++; ?></td>
													<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id);?>"><?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?></a></td>
													<td><?=$student->section_name?></td>
													<td><?=$student->guardian_name?></td>
													<td><?=$student->guardian_phone?></td>
													<td><?=$student->guardian_email?></td>
													<td><?=$student->occupation_name?></td>
												</tr>
				            		<?php
				            		$st_ids[] = $student->student_id;
				            	}  

				            	 ?>
				            </tbody>
									</table>
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

