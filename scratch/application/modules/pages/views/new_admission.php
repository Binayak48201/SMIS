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
          <a href="index.html">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="index.html">Student Info</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#">New Admission</a>
        </li>
      </ul>
      <div class="page-toolbar">
        <a href="javascript:history.go(-1)">
          <div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left">
          Back
          </div>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption font-green-haze">
              <i class="icon-settings font-green-haze"></i>
              <span class="caption-subject bold uppercase">Add Student</span>
            </div>
          </div>
          <div style="overflow: hidden;" class="portlet-body">
            <form class="margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/user_account/add_student'); ?>' role="form" enctype="multipart/form-data" >
              <?php 
                if($this->session->flashdata('error') === TRUE) { 
                  display_alert('alert-danger', $this->session->flashdata('error_message')); 
                } 
                elseif ($this->session->flashdata('error') === FALSE) { 
                  display_alert('alert-success', $this->session->flashdata('error_message')) ;
                }  
                if(isset($mis_con) && $mis_con['stat'] == FALSE )
                {
                  $msg = "ERROR: While connection to MIS Server<br/>{$mis_con['msg']}";
                  display_alert('alert-warning', $msg); 
                } 
              ?>
              <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label ">
                  <input class="form-control" name='fname' required type="text">
                  <label >First name</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label ">
                  <input class="form-control" name='mname' required type="text">
                  <label >Middle name</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label ">
                  <input class="form-control" name='lname' required type="text">
                  <label >Last name</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group form-md-radios">
                  <label >Status</label>
                  <div class="md-radio-inline">
                    <div class="md-radio">
                      <input type="radio" id="radio1" name="sex" class="md-radiobtn" value="male">
                      <label for="radio1">
                      <span></span>
                      <span class="check"></span>
                      <span class="box"></span>
                      Female </label>
                    </div>
                    <div class="md-radio">
                      <input type="radio" id="radio2" name="sex" class="md-radiobtn" value="female">
                      <label for="radio2">
                      <span></span>
                      <span class="check"></span>
                      <span class="box"></span>
                      Male </label>
                    </div>    
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <select name="programlevel_id" required id="programlevel_id" class="form-control">
                        <option value=""></option>
                        <option value="1">Bachelor</option>
                        <option value="2">Master</option>
                    </select>
                    <label>Program Level: </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <select name="program_id" required id="program_id" class="form-control">
                        <option value=""></option>
                    </select>
                    <label>Program: </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <select name="batch_id" required id="batch_id" class="form-control">
                        <option value=""></option>
                    </select>
                    <label>Batch: </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <select name='section_id' required id='section_id' class="form-control">
                        <option value=""></option>
                    </select>
                    <label>Section: </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label ">
                  <input class="form-control" name='roll_no' required type="text">
                  <label >Roll no</label>
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