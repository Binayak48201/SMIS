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
					<a href="#">General Report</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Bus Route Time Table</a>
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
							<span class="caption-subject bold uppercase">Bus Route Time Table</span>
						</div>
					</div>
					<div style="height: auto;" class="portlet-body">
						<div class="col-md-12">
						
							<div class="form-group form-md-line-input">
								<label for="inputPassword12" class="col-md-2 control-label">Bus: </label>
								<div class="col-md-4">
									<select id="bus_id" class="form-control" >
										<option> Select Bus</option>
										<?php
										if($results!=NULL)
										{ 
											$i=1;
											foreach($results as $row)
											{  ?>
												<option value="<?=$row->bus_id?>"><?=$row->bus_name?></option>
												<?php 
											}
										} ?>
									</select>
								
							
									<div class="form-control-focus">
									</div>
								</div>
							</div>
						
						<div class="clearfix"></div>
			
						<div id="bus_stops_content">
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
