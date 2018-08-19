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
          <a href="#">classes</a>
          <i class="fa fa-angle-right"></i>
        </li><li>
          <a href="#">Lesson Activity</a>
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
              <span class="caption-subject bold uppercase">Add Lesson Activity</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <div class="col-md-12">
              <form class="form-horizontal margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/classes/lession_plan/insert_activity'); ?>' role="form" enctype="multipart/form-data" >
                <?php display_alert(); ?>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Batch </label>
                    <div class="col-md-6">
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
                        <div class="form-control-focus">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Grade </label>
                    <div class="col-md-6">
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
                        <div class="form-control-focus">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Section </label>
                    <div class="col-md-6">
                        <select class="form-control display_class" name='section_id' id="section" required>
                          <option value="">Select Section</option>
                        </select>
                        <div class="form-control-focus">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Subject</label>
                    <div class="col-md-6">
                      <select class="form-control" name='subject_id' id="subject" required>
                        <option value="">Select Subject</option>
                      </select>
                        <div class="form-control-focus">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Select Lesson</label>
                    <div class="col-md-6">
                        <select class="form-control" name="lesson_id" id="lesson_id" required>
                          <option value="">Select Lesson</option>
                        </select>
                        <div class="form-control-focus">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Select Topic</label>
                    <div class="col-md-6">
                        <select class="form-control" name="topic_id" id="topic_id" required>
                          <option value="">Select Topic</option>
                        </select>
                        <div class="form-control-focus">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Key Concept</label>
                    <div class="col-md-6">
                      <input type='text' class="form-control" name='activity_key' id="activity_key" required>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Teaching Materials</label>
                    <div class="col-md-6">
                      <input type='text' class="form-control" name='teaching_material' id="teaching_material" required>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Activity</label>
                    <div class="col-md-6">
                      <input type='text' class="form-control" name='activity_title' id="activity_title" required>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Objective</label>
                    <div class="col-md-6">
                      <input type='text' class="form-control" name='activity_objective' id="activity_objective" required>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Date</label>
                    <div class="col-md-6">
                      <input type='text' class="form-control date-picker" name='activity_date' id="activity_date" required>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Assessments</label>
                    <div class="col-md-6">
                      <input type='text' class="form-control" name='assignments' id="assignments" required>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Home Assessments</label>
                    <div class="col-md-6">
                      <input type='text' class="form-control" name='home_assignments' id="home_assignments" required>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Standards Used</label>
                    <div class="col-md-6">
                      <select class="form-control" name="standard">
                        <option>Select Standard</option>
                        <?php if(isset($standards) && !empty($standards)) 
                        {
                          foreach($standards as $standard)
                          { ?>
                            <option value="<?= $standard->standard_name ?>"><?= $standard->standard_name ?></option>
                           <?php
                          }
                        }  ?>
                      </select>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group form-md-line-input">
                    <label for="status" class="col-md-6 control-label">Add File</label>
                    <div class="col-md-6">
                      <input type='checkbox' class="form-control" name='add_file' checked id="add_file" value='1'>
                      <div class="form-control-focus">
                      </div>
                    </div>
                  </div>
                </div><div class="clearfix"></div>
                <div class="col-md-5 form-md-line-input file-adder" >
                  
                    <label class="control-label col-md-6" style='color:#968888'>Upload File</label>
                    <div class="col-md-6">
                      <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                          <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                            <i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
                            </span>
                          </div>
                          <span class="input-group-addon btn default btn-file">
                          <span class="fileinput-new">
                          Select file </span>
                          <span class="fileinput-exists">
                          Change </span>
                          <input type="file" name="activity_file" >
                          </span>
                          <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                          Remove </a>
                        </div>
                      </div>
                     <!--  <div class="clearfix margin-top-10">
                        <span class="label label-danger">
                        NOTE! </span>
                         &nbsp;Only Zip Files are acepted
                      </div> -->
                    </div>
                  
                </div><div class="clearfix"></div><br><br>
                <div class="form-group">
                  <div class="col-md-offset-4 col-md-8">
                    <button name="submit" value="SUBMIT" class="btn blue" type='submit'>SUBMIT</button>
                    <button class="btn red" type='reset'>RESET</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>