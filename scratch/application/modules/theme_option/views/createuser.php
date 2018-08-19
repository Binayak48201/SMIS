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
                    <a href="#">Create User</a>
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
                            <span class="caption-subject bold uppercase">Create User</span>
                        </div>
                    </div>
                    <div style="overflow: hidden;" class="portlet-body">
                        <form class="margin-bottom-40" id='changepass' method="post" action='<?= site_url('theme_option/user_account/insert_user'); ?>' role="form" enctype="multipart/form-data" >
                            <?php display_alert(); ?>
                            <div class="col-md-4">
                                <div class="form-group form-md-line-input">
                                    <input class="form-control" name='fname' required type="text">
                                    <label >Firstname</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-md-line-input">
                                    <input class="form-control" name='lname' required type="text">
                                    <label >Lastname</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-md-line-input">
                                    <input class="form-control" name='username' required type="text">
                                    <label >Username</label>
                                </div></div>
                                <div class="col-md-4">
                                 <div class="form-group form-md-line-input">
                                    
                                    <select class="form-control" name='usertype'  required>                
                                    <option value=""></option>
                                        <?php
                                        foreach ($result as $row) {
                                        ?>
                                        <option value="<?= $row->ROLE_ID?>"><?= $row->ROLE_NAME ?></option>
                                        <?php }?>
                                    </select>
                                    <label >User Type</label>
                                
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-md-line-input">
                                    <input class="form-control" name='password' id="pass" required type="password">
                                    <label >Password</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-md-line-input">
                                    <input class="form-control" name='password' id="repass" type="password">
                                    <label >Re-Type Password</label>
                                   <!--  <div class="form-control-focus"></div> -->
                                </div>
                                <span class="error-block label alert-danger" style="display: none;" id='error_pass'>Password doesn't Match</span>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-md-line-input">
                                    <input class="form-control" name='profile_id' type="text">
                                    <label >Profile Id</label>
                                   <!--  <div class="form-control-focus"></div> -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-md-radios">
                                    <label >Account Status</label>
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio1" name="status" class="md-radiobtn" value="ON">
                                                <label for="radio1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                ON </label>
                                        </div>
                                        <div class="md-radio">
                                           <input type="radio" id="radio2" name="status" class="md-radiobtn" value="OFF">
                                                <label for="radio2">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                OFF </label>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <button name="submit" value='SUBMIT' class="btn blue" type='submit'>Submit</button>

                                    <button name="reset"  class="btn red" type='reset'>Reset</button>
                                
                            </div></div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
</div>