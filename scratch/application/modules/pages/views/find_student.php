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
					<a href="#">Search</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Find Student</a>
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
							<span class="caption-subject bold uppercase">Find Student</span>
						</div>
					</div>
					<div style="overflow: auto;" class="col-md-12 portlet-body no-padding">
								<form class="" method='post'>
									<div class="navbar navbar-default" role="navigation">
										<!-- Brand and toggle get grouped for better mobile display -->
										<!-- Collect the nav links, forms, and other content for toggling -->
										<div class=" " style="padding-top: 12px;">
												<div class="col-md-3">
													<div class="form-group form-md-line-input form-md-floating-label">
			                      <select class="form-control edited" required name="find_by" id="find_by" >
			                         	<option value="st_fname">First Name</option>
					                      <option value="st_lname	">Last Name</option>
					                      <option value="st_roll_no">Roll No</option>
					                      <option value="current_phone">Phone No</option>
					                      <option value="pu_regno">PU reg.No</option>
					                      <option value="email_address">Email Address</option>
					                      <option value="parent_name">Parent Name</option>
					                      <option value="st_guardian_name">Guardian Name</option>
										 				 		<option value="exam_rollno">PU Exam Roll No.</option>
			                      </select>
			                      <label>Search according to </label>
				                  </div>
												</div>
												<div class="col-md-6">
														<div class="col-md-8">
															<div class="form-group form-md-line-input form-md-floating-label">
					                      <input class="form-control edited" required name="key" autofocus="" type="text" id="key">
						                  </div>
														</div>
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
									if(isset($results) && !empty($results))
									{
										?>
										<div class="note note-warning text-center">
											<p>
												LIST OF STUDENTS
											</p>
										</div>
										<div class="flex-main flex-row">
												<?php $i=1;
					            	foreach($results as $row)
					            	{ ?>
					            <div class="col-md-6 no-padding flex-main"> 
						            <div class="col-md-12 dashboard-stat2 flex-main card-main"> 
							            <div class="col-xs-3 card-pic">
															<a href="<?=site_url('pages/administration/student_payment/view/'.$row->st_id);?>">
																<img src="<?= MIS.'uploads/student_photo/'.$row->st_roll_no;?>.jpg" alt=""></a>
							            </div>
							            <div class="col-xs-9 flex-main no-padding">
								            <div class="col-xs-8 card-content"> 
									            <ul class="">
									            	<li class='card-list'><i class="icon-user"></i><b>&nbsp;<a class="font-green-haze" href="<?= site_url('pages/administration/student_payment/view/'.$row->st_id);?>"><?=$row->st_fname.' '.$row->st_mname.' '.$row->st_lname?> - <span class="label label-primary label-lg"><?=$row->section_name?></span> </a></b></li>
									            	<!-- <li class="card-list label label-primary"><i class="icon-drawer"></i>&nbsp;</li> -->
									            	<li class='card-list'><i class="icon-users"></i>&nbsp;<?=$row->parent_name?></li>
									            	<li class='card-list'><i class="icon-call-out"></i>&nbsp;<?=$row->current_phone?></li>
									            	<li><i class="icon-envelope"></i>&nbsp;<?=$row->email_address?></li>
									            </ul>
									            <div data-id='<?=$row->st_id?>' class="btn btn-xs btn-danger more-action">More Option</div>
								            </div>
								            <div id='<?=$row->st_id?>' class="hide col-xs-4 card-action"> 
								            <a target='_blank' href="<?= site_url('pages/payments/miscellaneous_payment/index/'.$row->st_id);?>" class="btn btn-success">Miscellaneous</a>
								            <a target='_blank' href="<?= site_url('pages/reports/payments/student_bills/'.$row->st_id);?>" class="btn btn-info">View Receipts</a>
								            <a target="_blank" href="<?= site_url('pages/payments/student_accounts/due_balance/'.$row->st_id);?>" class="btn btn-primary">Due Balance</a>
								            <a target="_blank" href="<?= site_url('pages/payments/student_accounts/refund_balance/'.$row->st_id);?>" class="btn btn-info">Sch-Refund</a>
								            </div>
							            </div>
						            </div>
					            </div>
					            		<?php
					            	}   ?>
					            	</div>
			            		<?php
			            }
			            else if(isset($searched))
			            {	?>
			          		<div class="alert alert-info text-center"> No Records Found.</div>
			          		<?php
			            }
		            ?>
							</div>

            <div class="clearfix"> </div>
				</div>
			</div>
			<!-- END SAMPLE FORM PORTLET-->
		</div>
	</div>
</div>

