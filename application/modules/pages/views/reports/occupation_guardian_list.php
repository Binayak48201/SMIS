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
					<a href="#">Student List By Guardian Occupation</a>
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
							<span class="caption-subject bold uppercase">Student List By Guardian Occupation</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">
						<?= display_alert() ?>
						<form class="" method='post'>
							<div class="navbar navbar-default" role="navigation">
								<!-- Brand and toggle get grouped for better mobile display -->
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class=" " style="padding-top: 12px;">
	                <div class="col-md-3">
	                  <div class="form-group form-md-line-input display_class">
	                   <select class="form-control select2me" name='occupation' id="occupation" required>
	                    <option value="">Select Occupation</option>
	                    <?php if($occupations != NULL)
	                      { 
	                        $i=1;
	                        foreach($occupations as $occupation)
	                        { ?>
	                            <option <?= isset($soccupation) && $soccupation == $occupation->occupation_id ? 'selected' : '' ?> value="<?=$occupation->occupation_id?>"><?=$occupation->occupation_name?></option>
	                          <?php
	                          $i++;
	                        }
	                      } ?>
	                  </select>
	                    <label>Occupation: </label>
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
								<button data-id="student_list" class="btn btn-success exportTable pull-right">Export to Excel</button>
								<div class="clearfix"></div>
								<br>
								<div>
									<table id="student_list" class="table table-condensed table-bordered table-striped">
										<thead>
											<tr>
												<th>SN</th>
												<th>Name</th>
												<th>Gender</th>
												<th>Year</th>
												<th>Grade</th>
												<th>Section</th>
												<th>Guardian Name</th>
												<th>Guardian Occupation</th>
												<th>Guardian Phone</th>
												<th>Guardian Email</th>
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
													<td><?=$student->batch?></td>
													<td><?=$student->grade?></td>
													<td><?=$student->section_name?></td>
													<td><?=$student->guardian_name?></td>
													<td><?=$student->occupation_name?></td>
													<td><?=$student->guardian_phone?></td>
													<td><?=$student->guardian_email?></td>
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

