<?php
  if(isset($students) && !empty($students))
  {
    ?>
    <div class="note note-warning text-center">
      <p>
        LIST OF STUDENTS 
      </p>
    </div>
    <div class='st-list'>
    <?php
    foreach($students as $student)
    { ?>
      <div class="profile-sidebar col-md-4">
        <!-- PORTLET MAIN -->
        <div class="portlet light profile-sidebar-portlet" >
          <!-- SIDEBAR USERPIC -->
            <div class="col-md-4 text-center cstm-profile-pic no-padding">
              <a target="#details" class="a-link" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>">
              <img src="<?= display_pic_path('student_photo/'.$student->USER_NAME.'.jpg'); ?>" class="img-responsive" alt="">
              <b><?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?></b>
            </a>
            </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
              <div class="btn-group-vertical margin-right-10">
                <div class="btn-group dropdown-toggle-cstm">
                  <button  type="button" class=" btn btn-sm btn-info " ><span class="md-click-circle md-click-animate" ></span>
                  Subject Evaluation <i class="fa fa-angle-down"></i>
                  </button>
                  <ul class="dropdown-menu"  role="menu" aria-labelledby="btnGroupVerticalDrop1">
                    <?php if(isset($subjects) && !empty($subjects))
                    { 
                      foreach($subjects as $subject)
                      { ?> 
                        <li class="target_sub_evaluation"  data-subject="<?= $subject->subject_id ?>" data-toggle="modal" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#subject_evaluation">
                          <a data-id="<?= $subject->teacher ?>" href="javascript:void(0);" ><?= $subject->subject_name ?></a>
                        </li>
                        <?php
                      }
                    } ?>
                  </ul>
                </div>
                <div class="btn-group dropdown-toggle-cstm">
                  <button  type="button" class="btn btn-sm btn-info " ><span class="md-click-circle md-click-animate" ></span>
                  Subject Feedback <i class="fa fa-angle-down"></i>
                  </button>
                  <ul class="dropdown-menu"  role="menu" aria-labelledby="btnGroupVerticalDrop1">
                    <?php if(isset($subjects) && !empty($subjects))
                    { 
                      foreach($subjects as $subject)
                      { ?> 
                        <li class="target_feedback"  data-subject="<?= $subject->subject_id ?>" data-toggle="modal" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#subject_feedback">
                          <a data-id="<?= $subject->teacher ?>" href="javascript:void(0);" ><?= $subject->subject_name ?></a>
                        </li>
                        <?php
                      }
                    } ?>
                  </ul>
                </div>
                <button type="button" data-toggle="modal" class="target_evaluation disp_pop btn btn-sm btn-info" data-opt="1" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#evaluation" data-teacher="<?= $class_teacher ?>" >Evaluation</button> 
                <button type="button" data-toggle="modal" class="target_parent_evaluation_model disp_pop btn btn-sm btn-info" data-opt="2" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#parent_evaluation_model" data-teacher="<?= $class_teacher ?>" >Evaluation on Parent</button>
                <button type="button" data-toggle="modal" class="target_appraisal disp_pop btn btn-sm btn-info" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#appraisal" data-teacher="<?= $class_teacher ?>" >Terminal Appraisal</button>
                <button type="button" data-toggle="modal" class="target_comment disp_pop btn btn-sm btn-info" data-for="<?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?>" data-id="<?=$student->student_id?>" data-target="#comment" data-teacher="<?= $class_teacher ?>" >Terminal Feedback</button>
              </div>
            </div>
            <div class="clearfix"></div>
          <!-- END SIDEBAR USER TITLE -->
          <!-- END MENU -->
        </div>
        <!-- END PORTLET MAIN -->
      </div>
      <?php
    }   ?></div> <?php
  }
?>


<!-- model start -->
<div class="modal fade bs-modal-lg" id="evaluation" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Class Evaluation of <span class="st_for"></span> by <span class="class_teacher"></span></h4>
      </div>
        <br/>
        <div class="clearfix"></div>
        <br>
        <div id="class_evaluation_option">
          
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal" data-form="class_evaluation" type='reset'>Cancel</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="parent_evaluation_model" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Parents Evaluation of <span class="st_for"></span> by <span class="class_teacher"></span></h4>
      </div>
        <br/>
        <div class="clearfix"></div>
        <br>
        <div id="parent_evaluation_option">
          
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal" data-form="parent_evaluation" type='reset'>Cancel</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="appraisal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Appraisal of <span class="st_for"></span></h4>
      </div>
        <br/>
        <div class="clearfix"></div>
        <br>
        <div id="appraisal_evaluation_option">
          
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal" data-form="appraisal_evaluation" type='reset'>Cancel</button>
        </div>      
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="subject_evaluation" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Subject Evaluation of <span class="st_for"></span> by <span id="sub_teacher"></span></h4>
      </div>
      <div class="clearfix"></div>
      <br>     
        <div id="subject_evaluation_option"></div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Cancel</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="subject_feedback" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Subject Feedback of <span class="st_for"></span> by <span id="sub_teacher_feedback"></span></h4>
      </div>
      <div class="clearfix"></div>
      <br>     
        <div class="col-md-12" id="subject_feedback_option"></div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Cancel</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="comment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Feedback to <span class="st_for"></span>by <span class="class_teacher"></span></h4>
      </div>
      <div class="clearfix"></div>
      <br>     
        <div id="terminal_comment"></div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Cancel</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->