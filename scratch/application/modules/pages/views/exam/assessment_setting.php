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
          <a href="#">Assessment Setting</a>
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
              <span class="caption-subject bold uppercase">Add Assessment</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <form class="margin-bottom-40"  method="post" action='<?= site_url('pages/exam/assessment_setting/add_assessment'); ?>' role="form" >
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
                    <div class="form-group form-md-line-input">
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
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="number" name="numeric_value" id="numeric_value" placeholder="e.g 1 for First Assessmnent" required>
                  <label>Numeric Value of Assessment</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" name="assessment_name" id="assessment_name" placeholder="e.g HomeWork / Project Work" required>
                  <label>Assessment Name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="number" name="assessment_mark" id="assessment_mark">
                  <label>Assessment Marks</label>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                  <input type="hidden" id='stat'>
                  <button name="submit" value="SUBMIT" class="btn blue" disabled id="submit_setting" type='submit'>SUBMIT</button>
                  <button class="btn red" type='reset'>RESET</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption font-green-haze">
              <i class="icon-list font-green-haze"></i>
              <span class="caption-subject bold uppercase">Assessment List</span>
            </div>
          </div><br/>
          <div style='padding:15px'>
              <table role="grid" class="table table-striped table-bordered table-hover order-column dataTable simple_table" id="table_id">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Section</th>
                    <th>Assessment Name</th>
                    <th>Assessment Marks</th>
                    <th>Numeric Marks</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($exams)) {
                    $i = 1;
                    foreach ($exams as $row) {
                      ?>
                      <tr>
                        <td><?= $i ?></td>
                        <td><?= $row->subject_name ?></td>
                        <td><?= $row->grade ?></td>
                        <td><?= $row->section_name ?></td>
                        <td><?= $row->assessment_name ?></td>
                        <td><?= $row->assessment_mark ?></td>
                        <td><?= $row->numeric_value ?></td>
                        <td>
                          <a class='btn btn-info edit_opt' data-toggle="modal" data-target="#large" data-info='{"id":"<?=$row->assessment_id?>", "assessment_name": "<?=$row->assessment_name?>","assessment_mark" : "<?=$row->assessment_mark?>" }' > Edit </a>
                         <?php if($this->session->userdata('smis_usertype_id')==1) { ?> <a href="<?= site_url('pages/exam/assessment_setting/delete/'.$row->assessment_id); ?>"  class='btn btn-danger' onclick="return confirm('Are you sure you want to delete?')"> Delete</a> <?php } ?>
                        </td>
                      </tr>
                      <?php
                      $i++;
                    }
                  } else {
                    ?>
                    
                    <?php
                  }
                  ?>
                </tbody>
              </table>
          </div>
        </div>
      </div>
      <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>


<!-- model start -->
<div class="modal fade bs-modal-md" id="large" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
              <i class="icon-settings font-green-haze"></i>
              <span class="caption-subject bold uppercase">Edit Assessment</span>
            </div>
      </div>
      <form class="form-horizontal margin-bottom-40" method="post" action='<?= site_url('pages/exam/assessment_setting/update'); ?>' role="form" >
        <div class="modal-body" id='modal-body'>
          <div class="form-group form-md-line-input">
            <label for="inputPassword12" class="col-md-4 control-label">Assessment Name: </label>
            <div class="col-md-6">
              <input class="form-control" id="opt_assessment_name" name='assessment_name' required placeholder="e.g HomeWork / Project Work" type="text">
              <div class="form-control-focus">
              </div>
            </div>
          </div>
          <div class="form-group form-md-line-input">
            <label for="inputPassword12" class="col-md-4 control-label">Assessment Marks: </label>
            <div class="col-md-6">
              <input class="form-control" id="opt_assessment_mark" name='assessment_mark' required placeholder="Assessment Marks" type="number">
              <div class="form-control-focus">
              </div>
            </div>
          </div>
          <input type="hidden" name="id" id='opt_id' value="">
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal" type='reset'>Cancel</button>
          <button name="update" value="UPDATE" class="btn blue" type='submit'>Update</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->