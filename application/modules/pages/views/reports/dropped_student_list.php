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
					<a href="#">Dropped Student List</a>
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
							<span class="caption-subject bold uppercase">Dropped Student List</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">
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
												<th>Home Phone</th>
												<th>Joined Date</th>
												<th>Grade</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; $st_ids = array();
											$batchs = array();
				            	foreach($students as $student)
				            	{ 
				            		if(!in_array($student->joined_batch,$batchs))
				            		{
				            			$batchs[] = $student->joined_batch;
					            		?>
					            		<tr class="info">
														<td colspan="9"><?= $student->joined_batch ?></td>
													</tr>
						            	<?php
						            } ?>
													<tr>
														<td><?= $i++; ?></td>
														<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id);?>"><?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?></a></td>
														<td><?=$student->gender?></td>
														<td><?=$student->home_phone?></td>
														<td><?=$student->joined_date?></td>
														<td><?=$student->grade?></td>
													</tr>
					            		<?php
				            			
				            		
				            	}  

				            	 ?>
				            </tbody>
									</table>
								</div>
	            	 <?php
	            }
	            else
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

