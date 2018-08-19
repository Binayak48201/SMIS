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
          <a href="#">Classes</a>
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
              <span class="caption-subject bold uppercase">Edit Lesson Plans</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <div class="navbar navbar-default"> 
              <form class=" " method="post" action='<?= site_url('pages/classes/lession_plan/edit'); ?>' style="padding-top: 12px;">
                <?php display_alert() ?>
                <!-- <div class="col-md-3">
                  <div class="form-group form-md-line-input has-info">
                    <select class="form-control" name="programlevel_id" id="programlevel_id">
                      <option value="">Select Program Level</option>
                      <?php
                      if(isset($programlevels) && !empty($programlevels))
                      {
                        foreach ($programlevels as $row) {
                          ?>
                          <option value="<?= $row->programlevel_id ?>" <?php if (isset($slevel) && $row->programlevel_id==$slevel){echo"selected='selected'"; } ?> > <?= $row->programlevel ?></option>
                        <?php } } ?>
                    </select>
                    <label for="form_control_1">Select Program Level</label>
                  </div>
                </div> -->
                <div class="col-md-2">
                  <div class="form-group form-md-line-input">
                    <select class="form-control display_section" name='batch' id='batch' required>
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
                  <div class="form-group form-md-line-input">
                    <select class="form-control display_section" name='grade' id='grade' required>
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
                  <div class="form-group form-md-line-input display_class">
                   <select class="form-control" name='section_id' id="section" required>
                    <option value="">Select Section</option>
                    <?php if($sections!=NULL)
                      { 
                        $i=1;
                        foreach($sections as $section)
                        { ?>
                            <option <?= isset($ssection) && $ssection == $section->section_id ? 'selected' : '' ?> value="<?=$section->section_id?>"><?=$section->section_name?></option>
                          <?php
                          $i++;
                        }
                      } ?>
                  </select>
                    <label>Section: </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group form-md-line-input">
                    <select class="form-control" name='subject_id' id="subject" required>
                      <option value="">Select Subject</option>
                      <?php if($subjects!=NULL)
                      { 
                        $i=1;
                        foreach($subjects as $subject)
                        { ?>
                            <option <?= isset($scourse) && $scourse == $subject->class_days_id ? 'selected' : '' ?> value="<?=$subject->class_days_id?>"><?=$subject->subject_name?></option>
                          <?php
                          $i++;
                        }
                      } ?>
                    </select>
                    <label>Subject: </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group form-md-line-input has-info">
                    <input type="submit" value="EDIT" name='edit' class="btn btn-success">
                  </div>
                </div>
                <div class='clearfix'></div>              
              </form>
            </div>
            <?php if(isset($result) && $result!=NULL)
            {  ?>
              <form method="post" action="<?= site_url('pages/classes/lession_plan/update/'.$scourse); ?>">
                <table class="table table-striped table-condensed">
                  <thead>
                    <tr>
                      <th width="20px" >SN</th>
                      <th width="10%">Chapter no</th>
                      <th>Chapter Name</th>
                      <th>Topic</th>
                      <th>Exam</th>
                    </tr>
                  </thead>
                  <tbody class='frm_body'>
                    <?php $i=1; foreach ($result as $value) {
                      ?>
                      <tr>
                        <td><?=$i++;?></td>
                        <td><input type="text" name="ch_id[]" value="<?=$value->ch_id;?>" class="form-control"></td>
                        <td><input type="text" name="main_topic[]" value="<?=$value->main_topic;?>" class="form-control"></td>
                        <td><input type="text" name="sub_topic[]" value="<?=$value->sub_topic;?>" class="form-control"></td>
                        <td>
                          <select name="exam[]" class="form-control exams">
                            <option value="">Select Exam</option>
                            <?php if(isset($exams) && !empty($exams))
                            { 
                              foreach($exams as $exam)
                              { ?>
                                <option <?= $exam->exam_id == $value->target_exam ? 'selected' : ''?> value="<?=$exam->exam_id;?>"><?=$exam->terminal_name;?></option>
                                <?php
                              }
                            } ?>
                          </select>
                        </td>
                      </tr> 
                    <?php } ?>
                  </tbody>
                </table>
                <table class="pull-right"> 
                  <tr>
                    <td><input type="text" id="row_id" class="form-control" style="width: 50px;"></td></td><td>&nbsp;| &nbsp;</td>
                    <td><button type="button" id="delete_row_no" class="btn btn-danger">Delete Row </button></td><td>&nbsp; &nbsp;</td>
                    <td><button type="button" id="insert_row_no" class="btn btn-success">Insert Row </button>
                  </tr>
                </table><br/>
                <div class="form-group">
                  <div class="col-md-offset-4 col-md-8">
                    <br/><input type="hidden" name="section_id" value="<?=$ssection?>">
                    
                    <button name="update" value="UPDATE" class="btn blue" type='submit'>Update</button>
                    <button class="btn red" type='reset'>RESET</button>
                  </div>
                </div>
                </form>
                <table class="hide" >
                  <tbody id="addditional_row">
                    <tr>
                      <td></td>
                      <td><input type="text" name="ch_id[]" class="form-control"></td>
                      <td><input type="text" name="main_topic[]" class="form-control"></td>
                      <td><input type="text" name="sub_topic[]" class="form-control"></td>
                      <td><select name="exam[]" class="form-control exams">
                            <option value="">Select Exam</option>
                            <?php if(isset($exams) && !empty($exams))
                            { 
                              foreach($exams as $exam)
                              { ?>
                                <option value="<?=$exam->exam_id;?>"><?=$exam->terminal_name;?></option>
                                <?php
                              }
                            } ?>
                          </select></td>
                    </tr>
                  </tbody>
              </table>
            <?php } else if(!isset($result) && isset($scourse)){ ?>
            <div class="text-center alert alert-info"> No Records Available. </div>
           <?php } ?>
          </div>
        </div>
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>