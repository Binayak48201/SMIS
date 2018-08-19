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
          <a href="#">Terminal Totaling</a>
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
              <span class="caption-subject bold uppercase">Terminal Totaling</span>
            </div>
          </div>
          <div style="overflow: hidden; min-height: 60vh;" class="portlet-body">
            <?php display_alert(); ?>
            <form class="" id="terminal_opt" method="post" action='' role="form" >
              <div class="col-md-2">
                <div class="form-group form-md-line-input no-margin-imp">
                  <select class="form-control display_section" name='batch_id' id='batch' required>
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
                <div class="form-group form-md-line-input no-margin-imp">
                  <select class="form-control display_section" name="grade_id" id='grade' required>
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
                <div class="form-group form-md-line-input no-margin-imp display_class">
                 <select class="form-control" name='section_id' id="section" required>
                  <option value="">Select Section</option>
                </select>
                  <label>Section: </label>
                </div>
              </div>
             <div class="col-md-3">
               <div class="form-group form-md-line-input no-margin-imp">
                 <select class="form-control" name='exam_id' id="exam_id" required>
                   <option value="">Select Exam</option>
                   <?php if($exams!=NULL)
                    { 
                      $i=1;
                      foreach($exams as $exam)
                      { ?>
                          <option value="<?=$exam->numeric_value?>"><?=$exam->Terminal_name?></option>
                        <?php
                        $i++;
                      }
                    } ?>
                 </select>
                 <label>Exams: </label>
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
