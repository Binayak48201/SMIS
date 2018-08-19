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
          <a href="#">Exam Setting</a>
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
              <span class="caption-subject bold uppercase">Add Terminal Exam</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <form class="margin-bottom-40" method="post" action='<?= site_url('pages/exam/exam_setting/add_exam'); ?>' role="form" >
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
                  <input class="form-control" type="text" name="numeric_value" id="numeric_value" placeholder="e.g 1 for First Term" required>
                  <label>Numeric Value of Exam</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" name="exam_name" id="exam_name" placeholder="e.g First Term" required>
                  <label>Terminal Exam Name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" readonly name="full_mark" id="full_mark">
                  <label>Full Marks</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" readonly name="pass_mark" id="pass_mark">
                  <label>Pass Marks</label>
                </div>
              </div> 
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" name="average_at" id="average_at">
                  <label>Final Mark Weightage (%) </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" name="convert_to" id="convert_to">
                  <label>Terminal Marks Conversion</label>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                  <button name="submit" value="SUBMIT" class="btn blue" id="submit_setting" type='submit'>SUBMIT</button>
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
              <span class="caption-subject bold uppercase"> Internal Exam List</span>
            </div>
          </div><br/>
          <div style='padding:15px'>
              <table role="grid" class="table table-striped table-bordered table-hover order-column dataTable simple_table" id="table_id">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Batch</th>
                    <th>Grade</th>
                    <th>Section</th>
                    <th>Subject</th>
                    <th>Exam Name</th>
                    <th>Numeric Value</th>
                    <th>Full Marks</th>
                    <th>Pass Marks</th>
                    <th>Status</th>
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
                        <td><?= $row->batch ?></td>
                        <td><?= $row->grade ?></td>
                        <td><?= $row->section_name ?></td>
                        <td><?= $row->subject_name ?></td>
                        <td><?= $row->terminal_name ?></td>
                        <td><?= $row->numeric_value ?></td>
                        <td><?= $row->full_mark ?></td>
                        <td><?= $row->pass_mark ?></td>
                       <td><?php
                                         $status = $row->status;
                                         if ($status == 1) {
                                           echo'<span class="label label-success">Active</span>';
                                         } else {
                                           echo'<span class="label label-danger">In Active</span>';
                                         }
                                             ?>
                       </td>
                        <td>
                          <a class='btn btn-info edit' data-toggle="modal" data-target="#large" data-id="<?= $row->exam_id?>" > Edit </a>
                         <?php if($this->session->userdata('smis_usertype_id')==1) { ?> <a href="<?= site_url('pages/exam/exam_setting/delete/'.$row->exam_id); ?>"  class='btn btn-danger' onclick="return confirm('Are you sure you want to delete?')"> Delete</a> <?php } ?>
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
              <span class="caption-subject bold uppercase">Edit Exam</span>
            </div>
      </div>
      <form class="form-horizontal margin-bottom-40" method="post" action='<?= site_url('pages/exam/exam_setting/update'); ?>' role="form" >
        <div class="modal-body" id='modal-body'>
          loading..
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