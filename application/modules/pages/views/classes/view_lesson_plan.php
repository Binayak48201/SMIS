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
              <span class="caption-subject bold uppercase">View Lesson Plan</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <div class="clearfix"></div>
              <?php if(isset($result) && $result!=NULL) 
              { ?>
                <div class='col-md-8 col-md-offset-2' >
                  <table class="table table-bordered table-condensed">
                    <tbody>
                      <tr>
                        <td> Course Teacher: </td>
                        <td><?= $info->emp_fullname ?> </td>
                        <td rowspan='4' colspan=2 class='text-center'><img style="height: 141px; width: 130px; object-fit: contain;" src='<?=site_url('uploads/'.$info->picture);?>' alt='<?= $info->emp_fullname ?>' /></td>
                      </tr>
                      <tr>
                        <td>Course: </td>
                        <td> <?= $info->subject_name?></td>
                      </tr>
                      <tr>
                        <td>Section: </td>
                        <td> <?= $info->section_name?></td>
                      </tr>
                      <tr>
                        <td>Start Date: </td>
                        <td> <?= $info->start_date?></td>
                        <td>End Date: </td>
                        <td> <?= $info->end_date?></td>
                      </tr>
                    </tbody>
                  </table>
                </div><div class='clearfix'> </div><br/>
                <a target="#pointer" href="<?= site_url('pages/classes/lession_plan/course_pointer/'.$info->class_days_id)?>" class="btn btn-primary pull-right">Update Pointer</a>
                <table class="table table-striped table-condensed">
                  <thead>
                    <tr>
                      <th width="10%">Chapter no</th>
                      <th>Chapter Name</th>
                      <th>Topic</th>
                      <th width="10%">Period</th>
                      <th>Activity Topics</th>
                      <th>Activity Docs</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  
                      $stack=array();
                      foreach ($result as $value) {
                        $ch=$value->ch_id;
                        if(!in_array($ch, $stack))
                        {
                          array_push($stack, $ch);
                          $show=TRUE;
                        }
                        else
                        {
                           $show=FALSE;
                        }
                      ?>
                      <tr <?php if($value->t_stat==1){ echo'class="success"'; } ?> >
                        <td><?php if($show) echo $value->ch_id ; ?></td>
                        <td><?php if($show) echo $value->main_topic ; ?></td>
                        <td><?=$value->sub_topic;?></td>
                        <td><?=$value->objective;?></td>
                        <td><?=$value->terminal_name;?></td>
                        <td><?php 
                        if(isset($lession_activities) && !empty($lession_activities))
                        {
                          foreach ($lession_activities as $lession_activity) 
                          {
                            if($value->id == $lession_activity->topic_id)
                            { ?>
                              <a class="" href='<?=site_url('pages/classes/lession_plan/activity')."/$lession_activity->activity_title/".base64_encode($lession_activity->activity_file)?>'><?= $lession_activity->activity_title?></a> 
                              <?php
                            }
                          }

                        }
                        //$titles=explode(', ', $value->activity);
                        //$links=explode(', ', $value->activity_link);
                        //$i=0;
                        /*foreach($titles as $title){
                          if($i>0)echo', ';  ?>
                          <a class="" href='<?=site_url('pages/course_pointer/lession_plan/activity')."/$title/".base64_encode($links[$i])?>'><?=$title?></a> 
                          <?php
                          $i++;}*/ ?></td>
                      </tr> 
                    <?php } ?>
                  </tbody>
                </table>
              <?php } else {  ?>
                <div class='col-md-8 col-md-offset-2' >
                  <table class="table table-bordered table-condensed">
                    <tbody>
                      <tr>
                        <td> Course Teacher: </td>
                        <td><?= $info->emp_fullname ?> </td>
                        <td rowspan='4' class='text-center'><img style="height: 141px; width: 130px; object-fit: contain;" src='<?=site_url('uploads/'.$info->picture);?>' alt='<?= $info->emp_fullname ?>' /></td>
                      </tr>
                      <tr>
                        <td>Semester: </td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Course: </td>
                        <td> <?= $info->subject_name?></td>
                      </tr>
                      <tr>
                        <td>Section: </td>
                        <td> <?= $info->section_name?></td>
                      </tr>
                    </tbody>
                  </table>
                </div><div class='clearfix'> </div>
                <div class="text-center alert alert-info"> No lession plan Recorded. </div>
              <?php } ?>
          </div>
        </div>
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>