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
          <a href="#">Course Pointer</a>
          <i class="fa fa-angle-right"></i>
        </li><li>
          <a href="#">Lesson Plans</a>
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
              <span class="caption-subject bold uppercase">Migrate Lesson Plans</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            
              <form class=" " method="post" action='<?= site_url('pages/classes/lession_plan/migrate'); ?>' style="padding-top: 12px;">
                <?php display_alert(); ?>
                <div class="navbar navbar-default"> 
                  <div class="portlet-title" style="padding: 10px;">
                    <div class="caption font-green-haze">
                      <span class="caption-subject bold uppercase">From</span>
                    </div>
                  </div>
                  <div style='padding:15px'>
                  <div class="col-md-2">
                    <div class="form-group form-md-line-input">
                      <select class="form-control from_display_section" name='from_batch' id='from_batch' required>
                        <option value="">Select Batch</option>
                        <?php if($batchs!=NULL)
                        { 
                          $i=1;
                          foreach($batchs as $batch)
                          { ?>
                              <option value="<?=$batch->batch_name?>"><?=$batch->batch_name?></option>
                            <?php
                            $i++;
                          }
                        } ?>
                      </select>
                      <label>Batch: </label>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group form-md-line-input">
                      <select class="form-control from_display_section" id='from_grade' required>
                        <option value="">Select Grade</option>
                        <?php if($grades!=NULL)
                        { 
                          $i=1;
                          foreach($grades as $grade)
                          { ?>
                              <option value="<?=$grade->grade_name?>"><?=$grade->grade_name?></option>
                            <?php
                            $i++;
                          }
                        } ?>
                      </select>
                      <label>Grade: </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group form-md-line-input from_display_class">
                     <select class="form-control" name='from_section_id' id="from_section" required>
                      <option value="">Select Section</option>
                    </select>
                      <label>Section: </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group form-md-line-input">
                      <select class="form-control" name='from_subject_id' id="from_subject" required>
                        <option value="">Select Subject</option>
                      </select>
                      <label>Subject: </label>
                    </div>
                  </div>
                  <div class='clearfix'></div> 
                  </div>
                </div>
                <hr/>
                <div class="navbar navbar-default"> 
                  <div class="portlet-title" style="padding: 10px;">
                    <div class="caption font-green-haze">
                      <span class="caption-subject bold uppercase">To</span>
                    </div>
                  </div>
                  <div style='padding:15px'>
                  <div class="col-md-2">
                    <div class="form-group form-md-line-input">
                      <select class="form-control to_display_section" name='to_batch' id='to_batch' required>
                        <option value="">Select Batch</option>
                        <?php if($batchs!=NULL)
                        { 
                          $i=1;
                          foreach($batchs as $batch)
                          { ?>
                              <option value="<?=$batch->batch_name?>"><?=$batch->batch_name?></option>
                            <?php
                            $i++;
                          }
                        } ?>
                      </select>
                      <label>Batch: </label>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group form-md-line-input">
                      <select class="form-control to_display_section" id='to_grade' required>
                        <option value="">Select Grade</option>
                        <?php if($grades!=NULL)
                        { 
                          $i=1;
                          foreach($grades as $grade)
                          { ?>
                              <option value="<?=$grade->grade_name?>"><?=$grade->grade_name?></option>
                            <?php
                            $i++;
                          }
                        } ?>
                      </select>
                      <label>Grade: </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group form-md-line-input to_display_class">
                     <select class="form-control" name='to_section_id' id="to_section" required>
                      <option value="">Select Section</option>
                    </select>
                      <label>Section: </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group form-md-line-input">
                      <select class="form-control" name='to_subject_id' id="to_subject" required>
                        <option value="">Select Subject</option>
                      </select>
                      <label>Subject: </label>
                    </div>
                    <div id="ajax_alert" class="label label-danger" style="display: none; position: absolute; margin-top: -20px">Lesson Plan Already Exist.
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group form-md-line-input has-info">
                      <input type="submit" id="migrate" value="MIGRATE" name='migrate' class="btn btn-success">
                    </div><span id="to_migrate_result" class="help-block"></span>
                  </div>
                  <div class='clearfix'></div>
                  </div>    
                </div>          
              </form>
           
          </div>
        </div>
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>