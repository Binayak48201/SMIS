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
          <a href="#">Exam</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Marks Entry</a>
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
              <span class="caption-subject bold uppercase">Marks Entry</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <form class="margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/exam/marks_entry'); ?>' role="form" >
              <?php display_alert(); ?>
                <div class="navbar " role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class=" " style="padding-top: 12px;">
                  <div class="col-md-2">
                    <div class="form-group form-md-line-input">
                      <select class="form-control display_section" name='batch' id='batch' required>
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
                      <select class="form-control display_section" id='grade' required>
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
                    <div class="form-group form-md-line-input display_class">
                     <select class="form-control" name='section_id' id="section" required>
                      <option value="">Select Section</option>
                    </select>
                      <label>Section: </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group form-md-line-input">
                      <select class="form-control" name='subject_id' id="subject" required>
                        <option value="">Select Subject</option>
                      </select>
                      <label>Subject: </label>
                    </div>
                  </div>
                </div>
                <!-- /.  -->
              </div>
              <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                  <button name="submit" value="SUBMIT" class="btn blue" type='submit'>SUBMIT</button>
                  <button class="btn red" type='reset'>RESET</button>
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
