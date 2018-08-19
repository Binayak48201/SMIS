
    <h4 class="alert alert-info">Profile of <?= $info->first_name?> <?= $info->middle_name?> <?= $info->last_name?></h4>
    <div class="col-md-12">
      <div class="col-md-2">
        <img src="<?= file_exists(IMG_UPLOAD_PATH."/".$info->picture_path) ? site_url('uploads/'.$info->picture_path).'?dump='.rand() : site_url('assets'); ?>/admin/layout2/img/avatar.png ?>" width="150px" alt="">
      </div>
      <div class="col-md-10">
        <div class="col-md-3"><b>Full Name:</b></div>
        <div class="col-md-6"><?= $info->first_name?> <?= $info->middle_name?> <?= $info->last_name?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Date of Birth:</b></div>
        <div class="col-md-6"><?= $info->birth_date?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Qualification:</b></div>
        <div class="col-md-6"><?= $info->qualification?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Phone:</b></div>
        <div class="col-md-6"><?= $info->phone_no?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Agreement Type:</b></div>
        <div class="col-md-6"><?= $info->agreement_type?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Joined Date:</b></div>
        <div class="col-md-6"><?= $info->joined_date?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Basic Salary:</b></div>
        <div class="col-md-6"><?= $info->basic_salary?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Address:</b></div>
        <div class="col-md-6"><?= $info->address?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Department:</b></div>
        <div class="col-md-6"><?= $info->department_name?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Type:</b></div>
        <div class="col-md-6"><?= $info->employee_type?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Status:</b></div>
        <div class="col-md-6"><?= $info->status?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Designation:</b></div>
        <div class="col-md-6"><?= $info->designation?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Code:</b></div>
        <div class="col-md-6"><?= $info->code?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Email:</b></div>
        <div class="col-md-6"><?= $info->email?></div>
        <div class="clearfix"></div>
        <div class="col-md-3"><b>Bio-Data:</b></div>
        <div class="col-md-6"><?php if($info->biodata_path != '' && file_exists(IMG_UPLOAD_PATH.'/'.$info->biodata_path)){ ?><a href="<?= site_url('pages/profile/employee/download/'.base64_encode($info->biodata_path)) ?>">Download</a> <?php } else{ ?><?php } ?></div>
        <div class="clearfix"></div>
      </div>
    </div>
      
  

<div class="clearfix"></div>