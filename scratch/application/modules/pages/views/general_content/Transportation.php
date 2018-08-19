<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- /.modal -->
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- BEGIN PAGE HEADER-->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?=site_url('pages/home');?>">Home</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">General Content</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Transportation</a>
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
							<span class="caption-subject bold uppercase">Transportation</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<div class="col-md-12">
							<?php display_alert(); ?>
							<form class="form-horizontal navbar navbar-default margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/general_content/transportation/add'); ?>' role="form" >
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Bus: </label>
								<div class="col-md-4">
									<input class="form-control" name='bus_name' required placeholder="Bus Name" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Route: </label>
								<div class="col-md-4">
									<input class="form-control" name='bus_route' required placeholder="Bus Route" type="text">
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
							<div style=''>
								<table class="table table-striped table-bordered table-hover simple_table">
								<thead>
									<tr>
										<th>SN</th>
										<th>Bus </th>
										<th>Bus Route</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if($results!=NULL)
									{ 
										$i=1;
										foreach($results as $row)
										{ ?>
											<tr>
												<td><?=$i?></td>
												<td><?=$row->bus_name?></td>
												<td><?=$row->bus_route?></td>
												<td>
													<a class='btn btn-primary add_stops' data-toggle="modal" data-target="#medium" data-id='<?=$row->bus_id?>'>Add Stops</a>
													<a class='btn btn-info edit_opt' data-toggle="modal" data-target="#large" data-info='{"bus_id":"<?=$row->bus_id?>", "bus_name":"<?=$row->bus_name?>","bus_route":"<?=$row->bus_route?>"}' >Edit</a>
													<a class='btn btn-danger' href="<?=site_url('pages/general_content/transportation/delete/'.$row->bus_id);?>" onclick="return confirm('Do you want to Delete?')">Delete</a>
												</td>
											</tr>
											<?php
											$i++;
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
				<h4 class="modal-title">Edit Transportation</h4>
			</div>
			<form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/general_content/transportation/update'); ?>' role="form" >
				<div class="modal-body">
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Bus Name: </label>
								<div class="col-md-6">
									<input class="form-control" id="opt_bus_name" name='bus_name' required placeholder="Bus Name" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Bus Route: </label>
								<div class="col-md-6">
									<input class="form-control" id="opt_bus_route" name='bus_route' required placeholder="Bus Route" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<input type="hidden" name="bus_id" id='opt_bus_id' value="">
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

<!-- model start -->
<div class="modal fade bs-modal-md" id="medium" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Bus Stop Manager</h4>
			</div>
			
				<div class="modal-body">
					<form method="post" id='ajax_bus_stop'>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Stop Name: </label>
								<div class="col-md-6">
									<input class="form-control" name='stop_name' required placeholder="Stop Name" type="text">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Pick-up Time: </label>
								<div class="col-md-6">
									<input class="form-control" name='pickup_time' required step="300" type="time">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-4 control-label">Drop Time: </label>
								<div class="col-md-6">
									<input class="form-control" name='drop_time' required step="300" type="time">
									<div class="form-control-focus">
									</div>
								</div>
							</div>
							<input type="hidden" name="bus_id" id="bus_id" value="">
							<div class="col-md-offset-4">
								<div class="form-group form-md-line-input">
									<button type="submit" class="btn btn-success ajax_add_stop">Add</button>
								</div>
							</div>
						</form>
							<div id="bus_stops_content">
							</div>
				</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->