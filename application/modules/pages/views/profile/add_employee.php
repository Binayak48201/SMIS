<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
  <div class="page-content">    
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="index.html">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Profile</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Add Employee Profile</a>
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
                <span class="caption-subject bold uppercase">Add Employee</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <form class="margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/profile/employee/insert'); ?>' role="form" enctype="multipart/form-data" >
               <?php display_alert(); ?>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='first_name' required type="text">
                          <label >Enter First Name </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='middle_name' type="text">
                          <label >Enter Middle Name </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='last_name' required type="text">
                          <label >Enter Last Name </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='phone_no' type="text">
                          <label >Enter Phone No. </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='email' type="text">
                          <label >Enter Email </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='address' type="text">
                          <label >Enter Address </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control form-control-inline date-picker" data-date-format="yyyy-mm-dd" name='birth_date' type="text">
                          <label >Enter Birth Date </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='qualification' type="text">
                          <label >Enter Qualification </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <select class="form-control" required name='agreement_type'>
                              <option value="">Select Type</option>
                              <option value="Full Time">Full Time</option>
                              <option value="Part Time">Part Time</option>
                              <option value="Hourly Basis">Hourly Basis</option>
                          </select>
                          <label >Agreement Type </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <select class="form-control" name='dept'>
                              <option value="">Select Department</option>
                              <?php
                              foreach ($departments as $department) {
                              ?>
                              <option value="<?= $department->dept_id?>"><?= $department->department_name ?></option>
                              <?php }?>
                          </select>
                          <label >Select Department </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='basic_salary' type="text">
                          <label >Enter Basic Salary </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control form-control-inline date-picker" data-date-format="yyyy-mm-dd" name='joined_date' type="text">
                          <label >Enter Joined Date </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <select class="form-control" name='employee_type'>
                              <option value="">Select Type</option>
                              <option value="Faculty">Faculty</option>
                              <option value="Staff">Staff</option>
                          </select>
                          <label >Employee Type</label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='additionals' type="text">
                          <label >Enter Additionals </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <select class="form-control" required name='status'>
                              <option value="">Select Status</option>
                              <option value="Currently Working">Currently Working</option>
                              <option value="On Leave">On Leave</option>
                              <option value="Left">Left</option>
                          </select>
                          <label >Select Status </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='designation' type="text">
                          <label >Designation </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='code' type="text">
                          <label >Employee Code </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group form-md-line-input">
                          <input class="form-control" name='user_id' type="text">
                          <label >Enter User Id </label>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                        <label>Biodata </label>
                        <input class="" name='biodata' type="file">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                        <label >Picture </label>
                        <input class="" name='picture' type="file" accept="image/*">
                        <span class="label label-danger">NOTE: Allowed format *.jpg only</span>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-offset-2 col-md-10">
                          <button name="submit" value='SUBMIT' class="btn blue" type='submit'>Submit</button>

                          <button name="reset"  class="btn red" type='reset'>Reset</button>
                      </div>
                  </div>
              </form>

          </div>
        </div>
      </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
  </div>
</div>