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
                    <a href="#">School List</a>
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
                            <span class="caption-subject bold uppercase">School List</span>
                        </div>
                    </div>
                    <div style="height: auto;" class="portlet-body">
                        <div class="col-md-12">
                            <form class="form-horizontal margin-bottom-40" method="post" action='<?= site_url('pages/general_content/school/add_school'); ?>' role="form" enctype="multipart/form-data" >
                            <?php display_alert(); ?>
                            <div class="form-group form-md-line-input">
                                <label for="school_name" class="col-md-2 control-label">School Name</label>
                                <div class="col-md-4">
                                    <input class="form-control" name='school_name' required placeholder="School Name" type="text">
                                    <div class="form-control-focus">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label for="school_name" class="col-md-2 control-label">School Address</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name='school_address' placeholder="School Address"></textarea> 
                                    <div class="form-control-focus">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <button name="submit" value='SUBMIT' class="btn blue" type='submit'>Submit</button>
                                    <button name="reset"  class="btn red" type='reset'>Reset</button>
                                </div>
                            </div>
                        </form><hr>
                        <div class="portlet-title">
                            <div class="caption font-green-haze">
                                <i class="icon-list font-green-haze"></i>
                                <span class="caption-subject bold uppercase"> Program</span>
                            </div>
                        </div><br/>
                        
                        <div style=''>
                            <table role="grid" class="table table-striped table-bordered table-hover order-column dataTable simple_table" id="table_id">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>School</th>
                                    <th>School Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $row->school_name ?></td>
                                        <td><?= $row->school_address ?></td>
                                        <td>
                                            <a href="<?= site_url('pages/general_content/school/edit_school/' . $row->school_id); ?>" class='btn btn-info'> Edit </a>
                                            <a href="<?= site_url('pages/general_content/school/delete_school/' . $row->school_id); ?>"  class='btn btn-danger' onclick="return confirm('Are you sure you want to delete?')"> Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
</div>