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
					<a href="#">Course Pointer Overview</a>
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
							<span class="caption-subject bold uppercase">Course Pointer Overview</span>
						</div>
					</div>
					<div style="overflow: hidden;" class="portlet-body">
						<div class="clearfix"> </div>
					<?php
							if(isset($classes) && !empty($classes))
							{
								?>
								<table id="expTable" class="table table-condensed table-bordered"> 
									<thead>
										<tr>
											<th>Grade</th>
											<th>Section</th>
											<th>Subject</th>
											<th>Teacher</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$grades = array();
										$sections = array();
			            	foreach($classes as $classe)
			            	{ ?>
			            		<tr>
												<td><?php if(!in_array( $classe->grade, $grades )){ echo $classe->grade; $grades[] = $classe->grade; } ?></td>
												<td><?php if(!in_array( $classe->section_name, $sections )){ echo $classe->section_name; $sections[] = $classe->section_name; } ?></td>	
												<td><a target="_blank" href="<?= site_url('pages/classes/lession_plan/course_pointer/'.$classe->class_days_id) ?>"><?= $classe->subject_name; ?></a></td>
												<td><?= $classe->teacher; ?>	</td>
											</tr>
			            		<?php
			            	} ?>
			            	<!-- <script>document.getElementById("<?= $prev_id ?>").setAttribute("rowspan", <?= $count ?>); </script> -->
			            	
									</tbody>
								</table>
	            	<?php
	            }
	            else
	            {
	            		?>
								<div class="note note-info text-center">No Records Available</div>
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

