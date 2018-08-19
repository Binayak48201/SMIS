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
                    <a href="#">Notification List</a>
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
                            <span class="caption-subject bold uppercase"> Notification List</span>
                        </div>
                    </div><br>
                    <?php display_alert(); ?>
                    <div class="pull-right">
                        <div class="caption font-green-haze">
                            <a href="<?= site_url('pages/notification'); ?>" class='btn btn-info'>Add New Notification</a>
                        </div>
                    </div>
                    <div style="height: auto;" class="portlet-body">
                        <div>
                        <table role="grid" class="table table-striped table-bordered table-hover order-column dataTable simple_table" id="table_id">
                            <thead>
                                <tr><?php
                                if(!empty($results))
                                {
                                $i=1; ?>
                                    <th>S.No</th>
                                    <th>Notification For</th>
                                    <th>Notification Title</th>
                                    <th>Notification Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                foreach ($results as $row) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?php 
                                    $ids=unserialize($row->usertype_id);
                                    foreach ($results1 as $rows)
                                     {
                                        if(in_array($rows->ROLE_ID, $ids))
                                        {
                                            echo $rows->ROLE_NAME;
                                            echo ",";
                                        }
                                        
                                    }?></td>
                                    <td><?= $row->notification_title ?></td>
                                    <td><?= $row->msg ?></td>
                                    <td>
                                        <a href="<?= site_url('pages/notification/edit/'.$row->notification_id); ?>" class='btn btn-info'>Edit</a>
                                        
                                    
                                   
                                    <a href="<?= site_url('pages/notification/delete_notification/'.$row->notification_id); ?>" class='btn btn-danger' onclick="return confirm('Are you sure want to delete a Notification?')">Delete</a>
                                    </td>
                                </tr>
                                <?php $i++; }
                                } else {
                                ?>
                                <tr><td class="text-center" colspan="4"> No Records Available!!</td></tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
</div>