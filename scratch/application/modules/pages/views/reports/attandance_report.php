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
					<a href="#">Classes</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Add Attendance</a>
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
							<span class="caption-subject bold uppercase">Add Attendance</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<div class="col-md-12">
						<?php display_alert(); 
						if( isset($exams) ) { ?>
						<!-- data-table Start -->
							<div class=" portlet-tabs">
                <ul class="nav nav-pills">
                  <?php $i = 1; 

                  foreach($exams as $exam)
                  { ?>
                    <li <?= $i++ == 1 ? 'class="active"' : '' ?> >
                      <a aria-expanded="true" href="#portlet_tab_<?=$exam->numeric_value?>" data-toggle="tab">
                        <?= $exam->terminal_name ?></a>
                    </li><?php 
                  } 
                 ?>
                </ul>
                <div class="tab-content">
                	<?php $j = 1; 
                  $class_days_id = $this->uri->segment(5);
                  foreach($exams as $exam)
                  { 
                  	$result =  modules::run("pages/classes/attendance/students_with_attendance",$class_days_id,$exam->exam_id);
                    $update_stat = $result['update'];
                    $results = $result['results'];                         
                    ?>
		          	 		<div class="tab-pane <?= $j++ == 1 ? 'active' : '' ?>" id="portlet_tab_<?=$exam->numeric_value?>">
		          	 			<form class="form-horizontal margin-bottom-40" method="post" action='<?php if ($update_stat) {
                              echo site_url('pages/classes/attendance/update/'.$class_days_id);
                              } else {
                              echo site_url('pages/classes/attendance/insert/'.$class_days_id);
                              } ?>' role="form" >
												<table class="table table-striped table-bordered table-hover simple_table arrow-nav">
													<thead>
														<tr>
															<th>SN</th>
															<th>Student Name</th>
															<th>Roll No</th>
															<th>Total Class (before <?= $exam->terminal_name ?>)</th>
															<th>Present Days (before <?= $exam->terminal_name ?>)</th>
														</tr>
													</thead>
													<tbody>
														<?php if($results!=NULL)
														{ //print_e($students);
															$i=1;
															$st_ids = array();
															foreach($results as $student)
															{ ?>
																<tr>
																	<td><?=$i?></td>
																	<td><?=$student->st_fname?> <?=$student->st_mname?> <?=$student->st_lname?></td>
																	<td><?=$student->current_roll?></td>
																	<td><input type="text" <?= $this->session->userdata('smis_usertype_id') == 1 || $exam->status == 1 ? '' : 'readonly' ?> class="form-control total_class" value="<?= $update_stat == 1 ? $student->total_class : 0 ?>" name="<?=$student->student_id?>_total_class"></td>
																	<td><input type="text" <?= $this->session->userdata('smis_usertype_id') == 1 || $exam->status == 1 ? '' : 'readonly' ?> autocomplete="off" class="form-control" value="<?= $update_stat == 1 ? $student->present_class : 0 ?>" name="<?=$student->student_id?>_present_days"></td>
																</tr>
																<?php
																$st_ids[] = $student->student_id;
																$i++;
															}
															$st_ids = serialize($st_ids);
														} ?>
													</tbody>
												</table>	
												
												<div class="col-md-4 col-md-offset-4" >
													<?php 
                          if($this->session->userdata('smis_usertype_id') == 1 || $exam->status == 1 )
                          { ?>
                          	<input type="hidden" name="st_ids" value='<?= $st_ids ?>'>
                          	<input type="hidden" name="terminal_id" value='<?= $exam->exam_id ?>'>
														<button name="submit" value='SUBMIT' class="btn blue" type='submit'><?= $update_stat ? 'Update' : 'Submit' ?></button>
														<button class="btn btn-cancel">Cancel</button>
														<?php 
													} ?>
												</div>
											</form>
		            	 	</div>
		            		<?php 
		            	} ?>
              	</div>
              </div>
             <?php }else{
             	?>
							<div class="alert alert-warning text-center">Exam Not Set</div>
             	<?php
             } ?>
						</div>
						<!-- data-table END -->
					</div>
				</div>
			</div>
			<!-- END SAMPLE FORM PORTLET-->
		</div>
	</div>
</div>

