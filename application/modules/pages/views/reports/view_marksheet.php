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
          <a href="#">Academic Summary Report</a>
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
              <span class="caption-subject bold uppercase">Academic Summary Report</span>
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
                          <option <?= isset($sbatch) && $sbatch == $batch->batch_name ? 'selected' : '' ?> value="<?=$batch->batch_name?>"><?=$batch->batch_name?></option>
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
                          <option <?= isset($sgrade) && $sgrade == $grade->grade_name ? 'selected' : '' ?> value="<?=$grade->grade_name?>"><?=$grade->grade_name?></option>
                        <?php
                        $i++;
                      }
                    } ?>
                  </select>
                  <label>Grade: </label>
                </div>
              </div>
             <div class="col-md-3">
               <div class="form-group form-md-line-input no-margin-imp">
                 <select class="form-control" name='exam_id' id="exam_id" required>
                   <option value="">Select Exam</option>
                   <?php if(isset($exams) && $exams!=NULL)
                    { 
                      $i=1;
                      foreach($exams as $exam)
                      { ?>
                          <option <?= isset($sexam) && $sexam == $exam->numeric_value ? 'selected' : '' ?> value="<?=$exam->numeric_value?>"><?=$exam->terminal_name?></option>
                        <?php
                        $i++;
                      } 
                      if($theme_option->final_upscale_marking){ ?>
                      <option <?= isset($sexam) && $sexam == AGGREGATE_ID ? 'selected' : '' ?> value="<?= AGGREGATE_ID ?>">Aggregate</option>
                      <?php
                      }
                    } ?>
                 </select>
                 <label>Exams: </label>
               </div>
             </div>
              <div class="col-md-2">
                 <div class="form-group form-md-line-input no-margin-imp">
                 <button class="btn blue" name="view" value="VIEW" type='submit'>View</button>
                </div>
              </div>
            </form>
            <div class="clearfix"></div>
            <hr/>
            <?php if(isset($sbatch)){ ?>
              <div id="panel-body">
                <?php 
                if(!check_st_restrict($sst_id,$sbatch,$sexam,$sgrade))
                { ?>
                  <button onclick="printDiv('panel-body')" class='btn btn-success no-print'>print</button>
                  <?= modules::run('pages/ajax/st_marksheet_view',$sst_id,$sbatch,$sexam,$sgrade); ?>
                  <?php 
                }
                else
                {
                  echo"<div class='note note-primary text-center'>$theme_option->marksheet_restrict</div>";
                } ?>
               
              </div>
            <?php } ?>
          </div>
        </div>
        
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>

