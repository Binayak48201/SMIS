<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- /.modal -->
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN STYLE CUSTOMIZER -->

    <!-- END STYLE CUSTOMIZER -->
    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="<?= site_url('pages/home'); ?>">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Marks Entry</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">Add Marks</a>
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
        <div class="portlet light ovh" >
          <div class="portlet-title">
            <div class="caption font-green-haze">
              <i class="icon-user-follow font-green-haze"></i>
              <span class="caption-subject bold uppercase">Add Marks</span>
            </div>
          </div>
          <div style="height: auto;" class="portlet-body">
            <?php display_alert(); ?>
            <?php
            if (isset($exams) && !empty($exams)) 
            {
              ?>
              <div class="portlet box blue tabbable">
                <div class="portlet-body">
                  <div class=" portlet-tabs">
                    <ul class="nav nav-pills">
                      <?php $i = 1; 
                      foreach($exams as $exam)
                      { ?>
                        <li <?= $i++ == 1 ? 'class="active"' : '' ?> >
                          <a aria-expanded="true" href="#portlet_tab_<?=$exam->numeric_value?>" data-toggle="tab">
                            <?= $exam->terminal_name ?></a>
                        </li><?php 
                      } 
                      if($theme_option->final_upscale_marking == 1)
                      { ?>
                        <li <?= $i++ == 1 ? 'class="active"' : '' ?> >
                          <a aria-expanded="true" href="#portlet_tab_final" data-toggle="tab">Final Marking</a>
                        </li><?php 
                      } ?>
                    </ul>
                    <div class="tab-content">
                      <?php $j = 1; 
                      $class_days_id = $this->uri->segment(5);
                        foreach($exams as $exam)
                        { 
                          $result =  modules::run("pages/exam/marks_entry/students_with_mark",$info->section_id,$info->subject_id,$exam->exam_id);
                          $update_stat = $result['update'];
                          $results = $result['results'];                         
                          ?>
                          <div class="tab-pane <?= $j == 1 ? 'active' : '' ?>" id="portlet_tab_<?=$exam->numeric_value?>">
                            <form method="post" id='frm<?= $j++ ?>' class="form-horizontal" action="<?php if ($update_stat ==1) {
                              echo site_url('pages/exam/marks_entry/update/'.$class_days_id);
                              } else {
                              echo site_url('pages/exam/marks_entry/insert/'.$class_days_id);
                              } ?>">                          
                              <div class="label label-lg label-success text-center col-md-12">
                                Please Use Arrow key to navigate through Inputs.
                              </div>
                              <table class="table table-striped table-condensed"> 
                                <thead>
                                  <tr>
                                    <th>Course Name:</th>
                                    <th><?= $info->subject_name ?></th>
                                    <th>Teacher:</th>
                                    <th><?= $info->emp_fullname ?></th>
                                  </tr>
                                  <tr>
                                    <th>Grade:</th>
                                    <th><?= $info->grade ?></th>
                                    <th>Section:</th>
                                    <th><?= $info->section_name ?></th>
                                  </tr>
                                </thead>
                              </table>
                              <table class="table fixed-header table-striped table-condensed simple_table arrow-nav"> 
                                <thead>
                                  <tr style="display: flex;">
                                    <th>Student Roll No.</th>
                                    <th>Student Name</th>
                                    <th>Exam Obtain Mark (<?= $exam->full_mark ?>)</th>
                                    <?php 
                                    $a = 0;
                                    if(isset($assessments) && $assessments !=NULL)
                                    {
                                      foreach ($assessments as $assessment)
                                      {
                                        $assessment_ids[] = $assessment->numeric_value;
                                        ?>
                                        <th><?= $assessment->assessment_name ?> (<?= $assessment->assessment_mark ?>)</th>
                                        <?php  $a++;
                                      } 
                                      $count = sizeof($assessments);
                                    }?>
                                    <th>Final Obtained Mark</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  if(isset($results) && $results !=NULL)
                                  {
                                    $st_ids = array();
                                    foreach ($results as $student) 
                                    {
                                      $st_ids[] = $student->student_id;
                                      $i = 1;
                                      if($update_stat == 1)
                                      {
                                        $assessment_marks = $student->assessment_marks;
                                        $assessment_marks_arr = array(); 

                                        if($assessment_marks != '')
                                        {
                                          $assessment_marks_arr = unserialize($assessment_marks);
                                        }
                                      }
                                        ?>
                                      <tr>
                                        <td><?= $student->current_roll ?></td>
                                        <td><?= $student->st_fname . ' ' . $student->st_mname . ' ' . $student->st_lname ?></td>
                                        <td><input <?= $this->session->userdata('smis_usertype_id') == 1 || $exam->status == 1 ? '' : 'readonly' ?> max="<?= $exam->full_mark ?>" class="form-control mark_cal" data-full-mark="<?= $exam->full_mark; ?>" data-convert="<?= $exam->convert_to ?>" name="exam_<?= $student->student_id ?>" id="exam_<?= $exam->numeric_value ?>_<?= $student->student_id ?>" data-count='<?= $count ?>' data-id='<?= $student->student_id ?>' data-exam="<?= $exam->numeric_value ?>" type="number" step=any min="0" value='<?= $update_stat == 1 ? $student->obtain_mark : 0 ?>'>
                                        </td>
                                        <?php 
                                        if(isset($assessments) && $assessments !=NULL)
                                        {
                                          foreach ($assessments as $assessment)
                                          { ?>
                                            <td><input <?= $this->session->userdata('smis_usertype_id') == 1 || $exam->status == 1 ? '' : 'readonly' ?> max="<?= $assessment->assessment_mark ?>" class="form-control mark_cal" name="<?=$assessment->numeric_value ?>_<?= $student->student_id ?>" id="<?= $exam->numeric_value ?>_<?=$i ?>_<?= $student->student_id ?>" data-count='<?= $count ?>' data-id='<?= $student->student_id ?>' data-exam="<?= $exam->numeric_value ?>" type="number" step=any min="0" value='<?php if (!empty($assessment_marks_arr) && array_key_exists( $assessment->numeric_value, $assessment_marks_arr) && $update_stat == 1 ) { echo $assessment_marks_arr["$assessment->numeric_value"];} else{ echo '0'; }?>'>
                                            </td>
                                            <?php 
                                            $i++;
                                          }
                                        }?>
                                        <td><input max="<?= $exam->full_mark ?>" class="form-control" readonly name="final_<?= $student->student_id ?>" id="final_<?= $exam->numeric_value ?>_<?= $student->student_id ?>" data-info='cal' data-exam="<?= $exam->numeric_value ?>" data-count='<?= $count ?>' data-id='<?= $student->student_id ?>' type="number" step=any min="0" value='<?= $update_stat == 1 ? $student->total_marks : 0 ?>'>
                                        </td>
                                      </tr>
                                      <?php
                                    }
                                  } ?>

                                </tbody>
                              </table>
                              <?php 
                              if($this->session->userdata('smis_usertype_id') == 1 || $exam->status == 1 )
                              { ?>

                                <input type="hidden" name="assessment_module" id="<?= $exam->numeric_value ?>_cal_assessment" value="<?= $assessment_module ?>">
                                <input type="hidden" name="subject_id" value="<?= $info->subject_id ?>">
                                <input type="hidden" name="exam_id" value="<?= $exam->exam_id ?>">
                                <input type="hidden" name="assessments" value='<?= $assessment_module == 1 && isset($assessment_ids) ? serialize($assessment_ids) : '' ?>'>
                                <input type="hidden" name="st_ids" value='<?= serialize($st_ids); ?>'>
                                <div class="form-group">
                                  <div class="col-md-offset-3">
                                    <button name="submit" value='SUBMIT' class="btn blue" type='submit'><?= $update_stat == 1 ? 'Update' : 'Submit' ?></button>
                                    <button name="reset"  class="btn red" type='reset'>Reset</button>
                                  </div>
                                </div><?php 
                              } ?>
                            </form>
                          </div> 
                          <style>
                            #portlet_tab_<?=$exam->numeric_value?> .fixed-header tbody td,#portlet_tab_<?=$exam->numeric_value?> .fixed-header thead th {
                                  width: <?= 100/(4+$a) ?>%;
                                  float: left;
                              }
                          </style><?php
                        } 
                        if($theme_option->final_upscale_marking == 1)
                        { ?>
                          <div class="tab-pane" id="portlet_tab_final">
                            <button class="btn btn-primary pull-right" data-tab="<?= --$j ?>" id='final_import'>Import Marks</button>
                            <table class="table table-striped table-condensed"> 
                              <thead>
                                <tr>
                                  <th>Course Name:</th>
                                  <th><?= $info->subject_name ?></th>
                                  <th>Teacher:</th>
                                  <th><?= $info->emp_fullname ?></th>
                                </tr>
                                <tr>
                                  <th>Grade:</th>
                                  <th><?= $info->grade ?></th>
                                  <th>Section:</th>
                                  <th><?= $info->section_name ?></th>
                                </tr>
                              </thead>
                            </table>
                            <?php 
                            $results =  modules::run("pages/exam/marks_entry/student_final_mark",$info->section_id,$info->subject_id);
                            $final_update_stat = $results['update'];
                            $final_result = $results['results']; 
                            $st_ids= array();
                            //$i = 1;
                            //$count = sizeof($exams);

                            if(isset($final_result) && !empty($final_result))
                            { ?>
                              <form method="post" id='frm_final' class="form-horizontal" action="<?php if ($final_update_stat ==1) {
                                echo site_url('pages/exam/marks_entry/final_update/'.$class_days_id);
                                } else {
                                echo site_url('pages/exam/marks_entry/final_insert/'.$class_days_id);
                                } ?>">   
                                <table class="table fixed-header table-striped table-condensed simple_table arrow-nav"> 
                                  <thead>
                                    <tr>
                                      <th>Student Roll No.</th>
                                      <th>Student Name</th>
                                      <?php $q2 = 0;
                                      if(isset($exams) && $exams !=NULL)
                                      {
                                        foreach ($exams as $exam)
                                        {
                                          $exam_ids[] = $exam->numeric_value;
                                          ?>
                                          <th><?= $exam->terminal_name ?> (<?= $exam->average_at ?>)</th>
                                          <?php $q2++; 
                                        } 
                                      }?>
                                      <th>Final Obtained Mark</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach ($final_result as $student) 
                                    { 
                                      $st_ids[] = $student->student_id;
                                      if($final_update_stat == 1)
                                      {
                                        $scale_up_mark = $student->scale_up_mark;
                                        $scale_up_mark_arr = array(); 

                                        if($scale_up_mark != '')
                                        {
                                          $scale_up_mark_arr = unserialize($scale_up_mark);
                                        }
                                      }
                                      ?>
                                      <tr>
                                        <td><?= $student->current_roll ?></td>
                                        <td><?= $student->st_fname . ' ' . $student->st_mname . ' ' . $student->st_lname ?></td>
                                        <?php foreach ($exams as $exam)
                                        { 
                                          ?>
                                          <td><input max="<?= $exam->average_at ?>" class="form-control" readonly name="avg_<?= $exam->numeric_value ?>_<?= $student->student_id ?>" id="avg_<?= $exam->numeric_value ?>_<?= $student->student_id ?>" data-average="<?= $exam->average_at ?>" data-full-mark="<?= $exam->full_mark?>" data-id='<?= $student->student_id ?>' type="number" step=any min="0" value='<?php if($final_update_stat == 1 && !empty($scale_up_mark_arr) && array_key_exists( $exam->numeric_value, $scale_up_mark_arr) ) { echo $scale_up_mark_arr["$exam->numeric_value"];} else{ echo '0'; }?>'>
                                          </td>
                                          <?php
                                        } ?>
                                        <td><input max="<?= $exam->average_at ?>" class="form-control" readonly name="avg_final_<?= $student->student_id ?>" id="avg_final_<?= $student->student_id ?>" data-exam="[<?= implode(',',$exam_ids)?>]" data-info='cal' data-id='<?= $student->student_id ?>' type="number" step=any min="0" value='<?= $final_update_stat == 1 ? $student->final_mark : 0 ?>'>
                                            </td>
                                      </tr><?php
                                    } ?>
                                  </tbody>
                                </table>
                                <?php
                                /*if($this->session->userdata('smis_usertype_id') == 1 )
                                {*/ ?>
                                  <input type="hidden" name="subject_id" value="<?= $info->subject_id ?>">
                                  <input type="hidden" name="class_days_id" value="<?= $class_days_id ?>">
                                  <input type="hidden" name="exams" value='<?= serialize($exam_ids) ?>'>
                                  <input type="hidden" name="st_ids" value='<?= serialize($st_ids); ?>'>
                                  <div class="form-group">
                                    <div class="col-md-offset-3">
                                      <button name="submit" value='SUBMIT' class="btn blue" type='submit'><?= $update_stat == 1 ? 'Update' : 'Submit' ?></button>
                                      <button name="reset"  class="btn red" type='reset'>Reset</button>
                                    </div>
                                  </div><?php 
                                /*}*/ ?>
                                <style>
                                  #portlet_tab_final .fixed-header tbody td,#portlet_tab_final .fixed-header thead th {
                                        width: <?= 100/(3+$q2) ?>%;
                                        float: left;
                                    }
                                </style>
                              </form><?php
                            } ?>
                          </div><?php
                        } ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
            else{
              echo"<div class='alert alert-info text-center'>Exam Not Assigned</div>";
            }
            ?>
          </div>
        </div>
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>
