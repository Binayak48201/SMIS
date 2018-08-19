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
          <a href="<?=site_url('pages/home');?>">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Bug Report</a>
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
              <span class="caption-subject bold uppercase">Un-Authorised Access</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <?php display_alert(); ?>
            <?php if(isset($results)): ?>
              <div class='alert alert-danger text-center'> 
                Blocked IP List
              </div>
              <table class='table table-condensed table-bordered'> 
                <thead> 
                  <tr> 
                    <th>SN</th>
                    <th>IP</th>
                    <th>User Id</th>
                    <th>Blocked On</th>
                    <th>Status</th>
                    <th>Action</th>
                    
                  </tr>
                </thead>
                <tbody> 
                  <?php $i=1; foreach($results as $row){?>
                    <tr> 
                      <td><?=$i++;?></td>
                      <td><?=$row->ip?></td>
                      <td><?=$row->user_id?></td>
                      <td><?=date('D M j, Y', strtotime($row->blocked_on))?></td>
                      <td><span class='label <?= ($row->status==1) ? "label-danger" : "label-success"?>'><?= ($row->status==1) ? "Blocked" : ""?></span></td>
                      <td><a href="<?=site_url('theme_option/home/allow_ip/'.$row->id)?>" onclick="return confirm('Are you sure, you want to Un-block this IP');" class="btn btn-success">Remove</a></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php else: ?>
              <div class='alert alert-warning text-center'> No Records Available </div>
            <?php endif; ?>
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
        <h5 class="modal-title">Bug Image</h5>
      </div>
      <img id='pop-img' width="100%" src=''/>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->