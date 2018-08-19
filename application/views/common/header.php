<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?=$theme_option->title;?> | SMIS</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="Management Information System For Apex College - Dated(2015-11-1)" name="description"/>
<meta content="Satish Maharjan (satish.maharjan55@gmail.com)" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
 -->
 <link href="<?= site_url('assets'); ?>/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= site_url('assets'); ?>/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= site_url('assets'); ?>/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= site_url('assets'); ?>/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?= site_url('assets'); ?>/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->

<link href="<?= site_url('assets'); ?>/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?= site_url('assets'); ?>/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<!-- <link href="<?= site_url('assets'); ?>/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
 --><link rel="stylesheet" type="text/css" href="<?= site_url('assets'); ?>/global/plugins/jquery-nestable/jquery.nestable.css"/>
<!-- dynamically load required plugin css from contoller -->
<?php
	if(isset($styles))
	{
	  foreach ($styles as $source) 
	  {
	    echo'<link rel="stylesheet" type="text/css" href="'.$source.'"/>'."\r\n";
	  }
	}
?>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="<?= site_url('assets'); ?>/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
<link href="<?= site_url('assets'); ?>/global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?= site_url('assets'); ?>/global/css/plugins-md.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= site_url('assets'); ?>/admin/layout2/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?= site_url('assets'); ?>/admin/layout2/css/themes/<?= $theme_option->theme;?>.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?= site_url('assets'); ?>/admin/layout2/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?= site_url(); ?>/favicon.ico" type="image/x-icon">
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-md page-boxed page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?=site_url('pages/home');?>">
			<img src="<?= site_url('uploads/'.$theme_option->logo);?>" alt="logo" width='75px' class="logo-default"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<?php if($this->session->userdata('smis_usertype_id')!=2 && $this->session->userdata('smis_usertype_id')!=12)
						{ ?> 
				<div class="search-form open" >
            <div class="input-group input-top">
               
                <span class="input-group-btn">
                    <a href="<?=site_url('pages/profile/student/find');?>" class="btn">
                        search student <i class="icon-magnifier"></i>
                    </a>
                </span>

            </div>
        </div>
        <?php } ?>
				<ul class="nav navbar-nav pull-right">
					<li class="dropdown dropdown-extended quick-sidebar-toggler">
						<?php if($this->session->userdata('smis_usertype_id')==0)
						{ ?> 
	            <div class="theme-panel">
								<div class="toggler tooltips" data-container="body" data-placement="left" data-html="true" data-original-title="Click to open advance theme customizer panel">
									<i class="icon-settings"></i>
								</div>
								<div class="toggler-close">
									<i class="icon-close"></i>
								</div>
								<div class="theme-options">
									<div class="theme-option theme-colors clearfix">
										<span>
										THEME COLOR </span>
										<ul>
											<li class="color-default tooltips theamer <?php if($theme_option->theme=='default'){echo'current';} ?>" data-style="default" data-container="body" data-original-title="Default">
											</li>
											<li class="color-grey tooltips theamer <?php if($theme_option->theme=='grey'){echo'current';} ?>" data-style="grey" data-container="body" data-original-title="Grey">
											</li>
											<li class="color-blue tooltips theamer <?php if($theme_option->theme=='blue'){echo'current';} ?>" data-style="blue" data-container="body" data-original-title="Blue">
											</li>
											<li class="color-dark tooltips theamer <?php if($theme_option->theme=='dark'){echo'current';} ?>" data-style="dark" data-container="body" data-original-title="Dark">
											</li>
											<li class="color-light tooltips theamer <?php if($theme_option->theme=='light'){echo'current';} ?>" data-style="light" data-container="body" data-original-title="Light">
											</li>
										</ul>
									</div>
								</div>
							</div>
							<?php 
						}
							?>
        	</li>
					<li class="dropdown dropdown-user z-index">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<img alt="" class="img-circle" src="<?= display_pic_path($this->session->userdata('smis_pic')); ?>"/>
							<span class="username username-hide-on-mobile cap">
							<?php echo $this->session->userdata('smis_username'); ?> </span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-default" >
							<li>
                  <a href="javascript:void(0);" style="text-transform: capitalize;">
                      <i class="icon-user"></i>
                      <?=$this->session->userdata('smis_role')?>
                      <span class="label label-success"><?=$this->session->userdata('smis_login_count')?> Login</span>
                  </a>
              </li>
							<li class="divider">
							</li>
							<li>
								<a href="<?= site_url('theme_option/change_password'); ?>">
								<i class="icon-key"></i> Change Password </a>
							</li>
							<li>
								<a href="<?= site_url('pages/logout'); ?>">
								<i class="icon-lock"></i> Logout </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
	<div class="page-container">