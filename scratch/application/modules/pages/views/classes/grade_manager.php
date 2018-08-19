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
					<a href="#">Grade Manager</a>
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
							<span class="caption-subject bold uppercase">Grade Manager</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<div class="col-md-12">
							<form class="form-horizontal margin-bottom-40" method="post" action='<?= site_url('pages/classes/grade_manager/add'); ?>' role="form" >
							<?php display_alert(); ?>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Grade Name: </label>
								<div class="col-md-4">
									<input class="form-control" name='grade_name' required placeholder="Grade Name" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-10">
									<button class="btn default" type='reset'>Cancel</button>
									<button name="add" value="ADD" class="btn blue" type='submit'>Add</button>
								</div>
							</div>
						</form>

						<!-- data-table Start -->
							<div style='padding:15px'>

								<table class="table table-striped table-bordered table-hover simple_table">
								<thead>
									<tr>
										<th>Order</th>
										<th>Grade</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if($results!=NULL)
									{ 
										foreach($results as $row)
										{ ?>
											<tr data-recoder='<?=$row->grade_order?>' data-id='<?=$row->grade_id?>'>
												<td><?=$row->grade_order?></td>
												<td><?=$row->grade_name?></td>
												<td>
													<i class='up btn icon-arrow-up font-green-haze'></i>
													<i class='down btn icon-arrow-down font-green-haze'></i>
													<a class='btn btn-info edit_opt' data-toggle="modal" data-target="#large" data-info='{"id":"<?=$row->grade_id?>", "grade":"<?=$row->grade_name?>"}'>Edit</a>
													<a class='btn btn-danger' href="<?=site_url('pages/classes/grade_manager/delete/'.$row->grade_id);?>" onclick="return confirm('Do you want to Delete?')">Delete</a>
												</td>
											</tr>
											<?php
										}
									} ?>
								</tbody>
							</table>	
							</div>
						</div>
						<!-- data-table END -->
					</div>
				</div>
			</div>
			<!-- END SAMPLE FORM PORTLET-->
		</div>
	</div>
</div>

<!-- model start -->
<div class="modal fade bs-modal-md" id="large" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Grade</h4>
			</div>
			<form class="form-horizontal margin-bottom-40" method="post" action='<?= site_url('pages/classes/grade_manager/update'); ?>' role="form" >
				<div class="modal-body">
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Grade Name: </label>
								<div class="col-md-6">
									<input class="form-control" id="opt_grade" name='grade_name' required placeholder="Grade Name" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<input type="hidden" name="id" id='opt_id' value="">
				</div>
				<div class="modal-footer">
					<button class="btn default" data-dismiss="modal" type='reset'>Cancel</button>
					<button name="update" value="UPDATE" class="btn blue" type='submit'>Update</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->