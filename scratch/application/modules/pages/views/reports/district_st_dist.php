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
					<a href="#">Student List by District</a>
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
							<span class="caption-subject bold uppercase">Student List by District</span>
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
								<button class="btn btn-success exportTable" data-id="expTable">Export</button>
								<table id="expTable" class="table table-condensed table-bordered"> 
									<thead>
										<tr>
											<th>Section</th>
											<th>District</th>
											<th>NO of Student</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$total = 0;
										$section_ids = array();
										$count = 1;
			            	foreach($students as $student)
			            	{ ?>
			            		<tr>
												<td id="<?= $student->section_id ?>">
													<?php  if(!in_array($student->section_id, $section_ids)){  $section_ids[] = $student->section_id;?>
														<?php /*if($count > 1){?> <script>document.getElementById("<?= $prev_id ?>").setAttribute("rowspan", <?= $count ?>); </script> <?php $count = 1; } */ ?>
														<?= $student->grade." ".$student->section_name; ?>
													<?php $prev_id = $student->section_id; }else{ $count++; } ?>
												</td>
													<td>
														<?= $student->district_name?>		 <?= $student->grade." ".$student->section_name; ?>									
													</td>
													<td>
														<?php echo $student->total; $total += $student->total; ?>											
													</td>
												</tr>
			            		<?php
			            	}   ?>
			            	<!-- <script>document.getElementById("<?= $prev_id ?>").setAttribute("rowspan", <?= $count ?>); </script> -->
			            	<tr>
			            		<td colspan="2">Total</td>
			            		<td><?= $total ?></td>
			            	</tr>
									</tbody>
								</table>
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

