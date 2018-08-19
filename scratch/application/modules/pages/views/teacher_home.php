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
					if(isset($notification) &&  !empty($notification))
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
		               <?php }?>
							</ul>
						</div>
					</div>
				<?php } if(isset($info)){ ?>
				<div class="row">
        
	        <div class="col-md-3">
	          <div class="div-padding">
	            <div class="user-card">
	              <div class="div-top" style='box-shadow: none !important; height: 300px'>
	                <div class="user-photocont">
	                	<img src="<?= file_exists(IMG_UPLOAD_PATH."/".$info->picture_path) ? site_url('uploads/'.$info->picture_path).'?dump='.rand() : site_url('assets'); ?>/admin/layout2/img/avatar.png ?>" class="img-responsive user-img-pro" alt='<?=$info->first_name.' '.$info->middle_name.' '.$info->last_name?>' >
	                   
	                </div>
	                <div class="studying">
	                  <div class="profile-usertitle-name">
	                     <?=$info->first_name.' '.$info->middle_name.' '.$info->last_name?>
	                  </div>
	                  <div class="profile-usertitle-job">
	                     <?=$info->status?>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class=" col-md-9">
                <div class="row"> <!-- profile-content -->
                  <div class="portlet light">
                    <div class="portlet-title tabbable-line">
                      <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <!-- <span class="caption-subject font-blue-madison bold uppercase">Help</span> -->
                      </div>
                      <ul class="nav nav-tabs">
                        <li class="active">
                          <a href="#tab_1_1" data-toggle="tab">Profile Summary</a>
                        </li>
                        <!-- <li>
                          <a href="#tab_1_2" data-toggle="tab">Feedbacks</a>
                        </li> -->
                      </ul>
                    </div>
                    <div class="portlet-body" style="overflow: auto; min-height: 224px;">
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                          <table class="table">
                            <tr>
                              <td><strong>Full Name</strong></td>
                              <td><?=$info->first_name?> <?=$info->middle_name?> <?=$info->last_name?></td>
                              <td><strong>Email:</strong></td>
                              <td><?=$info->email?></td>
                            </tr>
                            <tr>
                              <td><strong>Designation</strong></td>
                              <td><?=$info->designation?></td>
                              <td><strong>Join Date:</strong></td>
                              <td><?=$info->joined_date?></td>
                            </tr>
                            <tr>
                              <td><strong>Phone</strong></td>
                              <td><?=$info->phone_no?></td>
                              <td><strong>Address:</strong></td>
                              <td><?=$info->address?></td>
                            </tr>
                            <tr>
                              <td><strong>Department:</strong></td>
                              <td><?=$info->department_name?></td>
                              <td><strong>Type:</strong></td>
                              <td><?=$info->employee_type?></td>
                            </tr>
                            <tr>
                              <td><strong>Bithday</strong></td>
                              <td><?=$info->birth_date?></td>
                              <td><strong>Qualification</strong></td>
                              <td><?=$info->qualification?></td>
                            </tr>
                            
                          </table>
                          <div class="clearfix"> </div>
                        </div>
                        <!-- <div class="tab-pane" id="tab_1_2">
                          
                          
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
      	</div>
      <div class="clearfix"></div>
				<div class="row">
		      <div class="col-md-12 col-sm-12">
		        <div class="portlet light ">
		          <div class="portlet-title">
		            <div class="caption">
		              <i class="icon-list font-green"></i>
		              <span class="caption-subject font-green bold uppercase">Your Course &amp; Sections</span>
		            </div>
		          </div>
		          <div class="portlet-body" style="overflow:auto">
		            <div class="">
		              <table role="grid" class="table table-striped table-bordered table-hover order-column dataTable " id="table_id">
		                <tbody>
		                	<?php if(isset($classes) && !empty($classes))
		                	{
		                		foreach($classes as $class)
		                		{
		                			?>
				               		<tr>
				                    <td class="caption-subject font-green bold uppercase"><?= $class->grade." ".$class->section_name ?></td>
				                    <td width="250"><?= $class->subject_name ?></td>
				                    <!-- <td><a class="btn btn-sm btn-primary" target="#attendance" href="<?= site_url('/pages/classes/attendance/add/'.$class->class_days_id); ?>">Attendance</a></td> -->
				                    <td><a class="btn btn-sm btn-primary" target="#coursePointer" href="<?= site_url('pages/classes/lession_plan/course_pointer/'.$class->class_days_id); ?>">Course Pointer</a></td>
				                    <td><a class="btn btn-sm btn-primary class_routine" data-for="<?= $class->grade." ".$class->section_name ?>" data-id="<?= $class->section_id ?>" data-toggle="modal" data-target="#large" href="#">Class Schedule</a></td>
				                    <td><a class="btn btn-sm btn-primary" target="#evaluation" href="<?= site_url('/pages/profile/evaluation/list_student/'.$class->class_days_id); ?>">Evaluation/Comment</a></td>
				                    <td><a class="btn btn-sm btn-primary" target="#marks_entry" href="<?= site_url('pages/exam/marks_entry/add/'.$class->class_days_id)?>">Internal Marks</a></td>
				                  </tr>
			                  	 <?php 
			                  }
		                  } ?>
		                </tbody>               
		              </table>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
				<hr/>
				<div class="row">
		      <div class="col-md-12 col-sm-12">
		        <div class="portlet light ">
		          <div class="portlet-title">
		            <div class="caption">
		              <i class="icon-list font-green"></i>
		              <span class="caption-subject font-green bold uppercase">Class Teacher Actions</span>
		            </div>
		          </div>
		          <div class="portlet-body" style="overflow:auto">
		            <div class="">
		              <table role="grid" class="table table-striped table-bordered table-hover order-column dataTable " id="table_id">
		                <tbody>
		                	<?php if(isset($sections) && !empty($sections))
		                	{
		                		foreach($sections as $section)
		                		{
		                			?>
				               		<tr>
				                    <td width="250" class="caption-subject font-green bold uppercase"><?= $section->grade." ".$section->section_name ?></td>
				                    <td><a class="btn btn-sm btn-primary" target="#attendance" href="<?= site_url('/pages/classes/attendance/add/'.$section->class_days_id); ?>">Attendance</a></td>
				                   <!--  <td><a class="btn btn-sm btn-primary" target="#coursePointer" href="<?= site_url('pages/classes/lession_plan/course_pointer/'.$section->class_days_id); ?>">Course Pointer</a></td> -->
				                    <td><a class="btn btn-sm btn-primary class_routine" data-for="<?= $section->grade." ".$section->section_name ?>" data-id="<?= $section->section_id ?>" data-toggle="modal" data-target="#large" href="#">Class Schedule</a></td>
				                    <td><a class="btn btn-sm btn-primary" target="#student_list" href="<?= site_url('/pages/classes/section_manager/list_student/'.$section->section_id); ?>">list Students</a></td>
				                  </tr>
			                  	 <?php 
			                  }
		                  } ?>
		                </tbody>               
		              </table>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
				<hr/>
				<!-- END DASHBOARD STATS -->
				<div class="clearfix">
				</div>
			</div> <?php }else{ ?>
				<div class="note note-info text-center">Invalid Employee Id</div>
			<?php } ?>
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