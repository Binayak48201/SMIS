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
                    <a href="#">Edit Message</a>
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
                            <span class="caption-subject bold uppercase">Edit Notification Message</span>
                        </div>
                    </div>
                   
                    <div style="overflow: hidden;" class="portlet-body">
                        <form class="margin-bottom-40" id='changepass' method="post" action='<?= site_url('pages/notification/update/'.$results->notification_id); ?>' role="form" enctype="multipart/form-data" >
                            <?php display_alert(); ?>

                            <div class="col-md-4">
                                 <div class="form-group form-md-line-input ">
                                    <!-- <label for="name">Notification For</label> -->
                                    <select class="form-control" name='usertype[]' multiple=""  required>                
                                    <option value=""></option>
                                        <?php
                                        foreach ($result1 as $row) {
                                        ?>
                                        <option <?=(in_array($row->ROLE_ID, unserialize($results->usertype_id)) ? 'selected="selected"' :'' ) ?>value="<?= $row->ROLE_ID?>"><?= $row->ROLE_NAME ?></option>
                                        <?php }?>
                                    </select>
                                    <label >Notification For  </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group form-md-line-input ">
                                    
                                    <input class="form-control" name='notification_title' required type="text" value="<?= $results->notification_title?>">
                                    <label >Notification Title </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group form-md-line-input ">
                                    <textarea class="form-control" rows="3"  name="msg"><?= $results->msg?></textarea>
                                    <label>You're Message Here</label>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <button name="update" value='UPDATE' class="btn blue" type='submit'>Update</button>

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