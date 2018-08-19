		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<h3 class="page-title">
				Dashboard</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?=site_url('pages/home');?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Dashboard</a>
						</li>
					</ul>
					<div class="page-toolbar">
						<div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left" data-original-title="List of New Bug">
            	<a href="<?=site_url('pages/bug/list_bug');?>" style="color: #fff" >
                <i class="icon-wrench"></i><?php if(isset($bug_report) && $bug_report) { ?><span class="badge badge-default"><?=$bug_report?></span><?php } ?>
            	</a>
						</div>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN DASHBOARD STATS -->
				<?php
					if(isset($notification)  &&  !empty($notification))
					{ ?>
					<div class="content">
						<div id="wrapper">
						 	<h4 class="nofify">NOTIFICATION</h4>
								<ul id="ticker">
								<?php
									 foreach ($notification as $row) 
		                {
		                  ?>
		                 <li><?= $row->msg ?></li>
		               <?php } ?>
							</ul>
						</div>
					</div>
				<?php } ?>
				<script src="<?= site_url('assets') . "/global/scripts/loader.js" ?>"></script>

				<div class="row">
		      <div class="col-md-5" >
		        <div class="portlet light" style="min-height: 360px">
		          <div class="portlet-title">
		            <div class="caption">
		              <i class="icon-list font-green"></i>
		              <span class="caption-subject font-green bold uppercase">Current Studying Student</span>
		            </div>
		          </div>
		          <div class="portlet-body" style="overflow:auto">
		          	<?= modules::run('dashboard/board/status_graph'); ?>
		          </div>
		        </div>
		      </div>
		      <div class="col-md-7" >
		        <div class="portlet light" style="min-height: 360px">
		          <div class="portlet-title">
		            <div class="caption">
		              <i class="icon-list font-green"></i>
		              <span class="caption-subject font-green bold uppercase">Student Pass Statistics</span>
		            </div>
		          </div>
		          <div class="portlet-body" style="overflow:auto">
		          	<div  class="col-sm-12 no-padding">
								  <div class="col-xs-2 no-padding"> <!-- required for floating -->
								    <!-- Nav tabs -->
								    <ul class="nav nav-tabs tabs-left no-margin">
								    	<?php 
								    		if(isset($grades) && !empty($grades))
								    		{
								    			$sub_grade = ceil(count($grades)/2);
								    			$i = 1;
								    			foreach($grades as $grade)
								    			{ 
								    				if($i <= $sub_grade){ ?>
									      			<li class="<?= $i++ == 1 ? 'active' : '' ?> "><a href="#<?= $grade->grade_name ?>" class="padding-tb-min" data-toggle="tab"><?= $grade->grade_name ?></a></li>
															<?php
														}
								    			}
								    		}
								    	?>
								    </ul>
								  </div>

								  <div class="col-xs-8">
								    <!-- Tab panes -->
								    <div class="tab-content">
								    	<?php 
								    		if(isset($grades) && !empty($grades))
								    		{
								    			$i = 1;

								    			foreach($grades as $grade)
								    			{ ?>
															<div class="tab-pane <?= $i++ == 1 ? 'active' : '' ?>" id="<?= $grade->grade_name ?>">
																<?php $exam = modules::run('pages/exam/exam_setting/get_active_term', $grade->grade_name);
																 echo modules::run('dashboard/board/grade_progress_status', $grade->grade_name,$exam->numeric_value );
										    				?>
										    				
								    					</div>
														<?php

								    			}
								    		}
								    	?>
								    </div>
								  </div>
									<div class="col-xs-2"> <!-- required for floating -->
								    <!-- Nav tabs -->
								    <ul class="nav nav-tabs tabs-right">
								    	
								    	<?php 
								    		if(isset($grades) && !empty($grades))
								    		{
								    			$i = 1;
								    			foreach($grades as $grade)
								    			{ 
								    				if($i > $sub_grade){ ?>
									      			<li><a href="#<?= $grade->grade_name ?>" class="padding-tb-min" data-toggle="tab"><?= $grade->grade_name ?></a></li>
															<?php
														}
														$i++;
								    			}
								    		}
								    	?>
								    </ul>
								     
								  </div>
								  <div class="clearfix"></div>

								</div>

		          </div>
		        </div>
		      </div>

		   
		      <div class="col-md-12" >
		        <div class="portlet light" style="min-height: 360px">
		          <div class="portlet-title">
		            <div class="caption">
		              <i class="icon-list font-green"></i>
		              <span class="caption-subject font-green bold uppercase">Gender wise Studying Student</span>
		            </div>
		          </div>
		          <div class="portlet-body" style="overflow:auto">
		          	<?= modules::run('dashboard/board/genderwise_classgraph'); ?>
		          </div>
		        </div>
		      </div>
		   
				<hr/>
				<!-- END DASHBOARD STATS -->
				<div class="clearfix">
				</div>
			</div>
		</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!-- END QUICK SIDEBAR -->
	</div><!-- END page-container -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Class Routine of <span id="section_name"></span></h4>
			</div>
			<div class="modal-body" id="routine_display">
						
			</div>
			<div class="modal-footer">
				<!-- <button class="btn default" data-dismiss="modal" type='reset'>Cancel</button>
				<button name="update" value="UPDATE" class="btn blue" type='submit'>Update</button> -->
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->