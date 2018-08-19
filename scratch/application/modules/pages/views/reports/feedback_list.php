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
          <a href="#">Reports</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Student feedback List</a>
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
              <span class="caption-subject bold uppercase">Student feedback List</span>
            </div>
          </div>
          <div style="overflow: hidden; min-height: 60vh;" class="portlet-body">
            <?php display_alert(); ?>
            <form class="" id="terminal_opt" method="post" action='' role="form" >
              <div class="col-md-2">
                <div class="form-group form-md-line-input no-margin-imp">
                  <input type="text" class="form-control date-picker" name='from_date' required>
                  <label>From Date: </label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group form-md-line-input no-margin-imp">
                  <input type="text" class="form-control date-picker" name='to_date' required>
                  <label>To Date: </label>
                </div>
              </div>
             <div class="col-md-3">
               <div class="form-group form-md-line-input no-margin-imp">
                 <select class="form-control select2me" name='employee_id' id="employee_id" required>
                   <option value="">Select Teacher</option>
                   <?php if($teachers!=NULL)
                    { 
                      $i=1;
                      foreach($teachers as $teacher)
                      { ?>
                          <option value="<?=$teacher->employee_id?>"><?=$teacher->emp_fullname?></option>
                        <?php
                        $i++;
                      }
                    } ?>
                 </select>
                 <label>Teacher: </label>
               </div>
             </div>
              <div class="col-md-2">
                 <div class="form-group form-md-line-input no-margin-imp">
                 <button name="submit" class="btn blue" type='submit'>View</button>
                </div>
              </div>
            </form>
            <div class="clearfix"></div>
            <hr/>
            <div id="ajax-content">
              
            </div>

          </div>
        </div>
        
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>

