<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- /.modal -->
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN STYLE CUSTOMIZER -->

    <!-- END STYLE CUSTOMIZER -->
    <!-- BEGIN PAGE HEADER-->
    <!-- <h3 class="page-title">
    Dashboard</h3> -->
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="<?= site_url('pages/home'); ?>">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Classes</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Manage Routine</a>
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
              <span class="caption-subject bold uppercase">Manage Routine</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
              <?php display_alert(); ?>
            <form class="form-horizontal margin-bottom-40" method="post" action='<?= (isset($results) && !empty($results)) ? site_url('pages/classes/class_manager/update_routine') : site_url('pages/classes/class_manager/add_routine') ?>/<?= $this->uri->segment(5)?>' role="form" >
							<div class="form-group form-md-line-input">
								<div class="col-md-12">
									<textarea class="ckeditor form-control" name="class_routine" data-error-container="#editor2_error"><?= (isset($results) && !empty($results)) ? $results->routine : ''?></textarea>
									<div class="form-control-focus">
									</div>

								</div>
							</div>
							<button class="btn default" data-dismiss="modal" type='reset'>Cancel</button>
							<button name="update" value="UPDATE" class="btn blue" type='submit'>Save</button>
						</form>

          </div>
        </div>
       
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>


