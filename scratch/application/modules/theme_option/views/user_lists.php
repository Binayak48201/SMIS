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
					<i class="fa icon-list"></i>
					<a href="<?=site_url('theme_option/user_account/lists');?>">Manage Users</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">User Lists</a>
				</li>
			</ul>
			<div class="page-toolbar">
        <a href="javascript:history.go(-1)"><div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left">
          Back
        </div></a>
      </div>
		</div>
		
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="portlet light">
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-12">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption font-red-sunglo">
									<i class="icon-settings font-red-sunglo"></i>
									<span class="caption-subject bold uppercase"> User Lists</span>
								</div>
							</div>
							<div class="portlet-body form">
								<?php display_alert(); ?>
								<div class=" portlet-tabs">
									<ul class="nav nav-pills">
										<?php 
											$i=1;
											foreach ($user_type as $row) 
											{
												?>
												<li class="<?php if($i===1){echo'active';} ?>">
													<a aria-expanded="<?php if($i===1){echo'false';}else{echo'true';} ?>" href="#portlet_tab<?=$i?>" data-toggle="tab">
													<?=$row->ROLE_NAME;?> </a>
												</li>
												<?php 
												$i++;
											}
										?>
									</ul>
									<div class="tab-content">
										<?php 
											$i=1;
											foreach ($user_type as $row) 
											{
												?>
												<div class=" tab-pane <?php if($i===1){echo'active';} ?>" id="portlet_tab<?=$i?>">
													<table class='simple_table table'>
														<thead>
															<tr> 
																<th>Sn.</th>
																<th>User Id</th>
																<th>User Name</th>
																<th>Account Status</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
														<?php $j=1; foreach($users as $user)
														{ 
															if($row->ROLE_ID==$user->ROLE_ID)
															{ ?>
																<tr> 
																	<td><?=$j++;?></td>
																	<td><?=$user->USER_NAME?></td>
																	<td><?=$user->FNAME?> <?=$user->LNAME?></td>
																	<td><?=($user->ACC_STATUS=='ON') ? "<span class='label label-success'>ON</span>":"<span class='label label-danger'>Off</span>"?></td>
																	<td>
																		<a href='<?=site_url("theme_option/user_account/edit/$user->USER_ID");?>' class='btn btn-info'>Edit</a>
																		<a href='<?=site_url("theme_option/user_account/delete/$user->USER_ID");?>' onclick="return confirm('Are you sure want to delete a User?')" class='btn btn-danger'>Delete</a>
																	</td>
																</tr>
																<?php 
															}
														} ?>
														</tbody>
													</table>	
												</div>
												<?php 
												$i++;
											}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	<!--Cooming Soon...-->
	<!-- END QUICK SIDEBAR -->
</div>

