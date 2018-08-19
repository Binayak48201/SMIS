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
              <span class="caption-subject bold uppercase">Course Pointer</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <?= display_alert(); ?>
            <table class="table table-condensed">
            <thead>
              <tr>
                <th>Chapter</th>
                <th>Chapter Name</th>
                <th>Chapter Topic</th>
                 <?php if($this->session->userdata('smis_profile_id') == $info->updater || $this->session->userdata('smis_role') == 'su_admin'){ ?>
                 <th>Topic Covered</th>
                 <?php }?>
                <th>Activities</th>
                <th>Exam</th>
              </tr>
            </thead>
            <?php
            $stack=array();
            if($results!=NULL):
              foreach ($results as $row) :
                $ch=$row->ch_id;
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
                <tr <?php if($row->t_stat==1){ echo 'class="success"'; } ?>>
                  <td><?php if($show)
                      { echo $row->ch_id ;} ?></td>
                        <td><?php if($show)
                      { echo $row->main_topic; } ?>
                  </td>
                  <td><a class="activity " data-toggle="modal" data-target="#activity_info" data-title="Title of Lesson :  <?= $row->sub_topic?>" data-id="<?= $row->id?>" ><?=$row->sub_topic;?></a></td>
                 <?php if($this->session->userdata('smis_profile_id') == $info->updater || $this->session->userdata('smis_role') == 'su_admin'){ ?>
                  <td>
                     <div class="form-group">
                        <!-- <label class="control-label col-md-3"></label> -->
                        <div class="col-md-9">
                          <input type="checkbox" id="checkbox<?=$row->id;?>" <?php if($row->t_stat==1){ echo 'checked="checked"'; } if($this->session->userdata('smis_profile_id') == $info->updater || $this->session->userdata('smis_role') == 'su_admin'){} else{ echo'readonly';} ?> data-id='<?=$row->id;?>' class="lesson_covered make-switch" name='lession_covered' data-on-text="Yes" data-size="small" data-off-text="No">
                        </div>
                      </div>
                  </td>
                  <?php } ?>
                  <td><?php 
                   
                        if(isset($lession_activities) && !empty($lession_activities))
                        {
                          foreach ($lession_activities as $lession_activity) 
                          {
                            if($row->id == $lession_activity->topic_id)
                            { ?>
                              <?= $lession_activity->activity_title?>
                              <?php
                            }
                          }

                        }
                       ?>
                  </td>
                  <td><?=$row->terminal_name;?></td>
                </tr>
                <?php
              endforeach;
             endif;
            ?>
           </table>
          </div>
        </div>
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>

<!-- model start -->
<div class="modal fade bs-modal-md" id="activity_info" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
          <i class="icon-settings font-green-haze"></i>
          <span class="caption-subject bold uppercase" id="activity_title"></span>
        </div>
      </div>
        <div class="modal-body" id='activity_info_body' style="overflow: auto;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->