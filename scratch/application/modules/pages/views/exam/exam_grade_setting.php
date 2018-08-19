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
          <a href="#">Exam Grade Setting</a>
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
            <form class="margin-bottom-40" method="post" action='<?= site_url('pages/exam/exam_setting/add_exam_grade'); ?>' role="form" >
              <?php display_alert(); ?>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" name="mark_from" required>
                  <label>Mark From</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" name="mark_to" required>
                  <label>Mark To</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control cap" type="text" name="grade_name" required>
                  <label>Grade</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group form-md-line-input ">
                  <input class="form-control" type="text" name="description" required>
                  <label>Grade</label>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                  <button name="submit" value="SUBMIT" class="btn blue" type='submit'>SUBMIT</button>
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
                    <th>Mark from</th>
                    <th>Mark To</th>
                    <th>Grade</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($exam_grades)) {
                    $i = 1;
                    foreach ($exam_grades as $exam_grade) {
                      ?>
                      <tr>
                        <td><?= $i ?></td>
                        <td><?= $exam_grade->mark_from ?></td>
                        <td><?= $exam_grade->mark_to ?></td>
                        <td><?= $exam_grade->grade ?></td>
                        <td><?= $exam_grade->description ?></td>
                        <td>
                          <a class='btn btn-info edit_opt' data-toggle="modal" data-target="#large" data-info='{"id":"<?= $exam_grade->id ?>", "mark_from":"<?= $exam_grade->mark_from ?>", "mark_to":"<?= $exam_grade->mark_to ?>", "grade":"<?= $exam_grade->grade ?>", "description": "<?= $exam_grade->description ?>"}' > Edit </a>
                         <?php if($this->session->userdata('smis_usertype_id')==1) { ?> <a href="<?= site_url('pages/exam/exam_setting/delete_exam_grade/'.$exam_grade->id); ?>"  class='btn btn-danger' onclick="return confirm('Are you sure you want to delete?')"> Delete</a> <?php } ?>
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
     <form class="form-horizontal margin-bottom-40"  method="post" action='<?= site_url('pages/exam/exam_setting/update_exam_grade'); ?>' role="form" >
        <div class="modal-body">
              <div class="form-group form-md-line-input">
                <label for="inputPassword12" class="col-md-4 control-label">Mark From: </label>
                <div class="col-md-6">
                  <input class="form-control" id="opt_mark_from" name='mark_from' required type="text">
                  <div class="form-control-focus">
                  </div>
                </div>
              </div>
              <div class="form-group form-md-line-input">
                <label for="inputPassword12" class="col-md-4 control-label">Mark To: </label>
                <div class="col-md-6">
                  <input class="form-control" id="opt_mark_to" name='mark_to' required type="text">
                  <div class="form-control-focus">
                  </div>
                </div>
              </div>
              <div class="form-group form-md-line-input">
                <label for="inputPassword12" class="col-md-4 control-label">Grade: </label>
                <div class="col-md-6">
                  <input class="form-control cap" id="opt_grade" name='grade_name' required  type="text">
                  <div class="form-control-focus">
                  </div>
                </div>
              </div>
              <div class="form-group form-md-line-input">
                <label for="inputPassword12" class="col-md-4 control-label">Description: </label>
                <div class="col-md-6">
                  <input class="form-control" id="opt_description" name='description' required  type="text">
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