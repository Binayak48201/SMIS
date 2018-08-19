<div class="page-content-wrapper">
			<div class="page-content">
				<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				
				<!-- /.modal -->
				<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<!-- BEGIN STYLE CUSTOMIZER -->
				
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?=site_url('pages/home');?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Manage Menu</a>
						</li>
					</ul>
					<div class="page-toolbar">
		        <a href="javascript:history.go(-1)"><div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left">
		          Back
		        </div></a>
		      </div>
				</div>
				
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="portlet light">
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-12">
								<div class="margin-bottom-10 pull-right" id="nestable_list_menu">
									<button type="button" class="btn" data-action="expand-all">Expand All</button>
									<button type="button" class="btn" data-action="collapse-all">Collapse All</button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<form id="menus" action="<?= site_url('theme_option/manage_menu/update_menu_list'); ?>" method="post">
									<textarea id="nestable_list_1_output" name='menus' class="form-control col-md-12 margin-bottom-10 hidden"></textarea>
								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
									<div class="portlet light">
										<div class="portlet-title">
											<div class="caption font-red-sunglo">
												<i class="icon-settings font-red-sunglo"></i>
												<span class="caption-subject bold uppercase"> Add Menu</span>
											</div>
										</div>
										<div class="portlet-body form">
											<form role="form" action="<?= site_url('theme_option/manage_menu/add_menu_list'); ?>" method="post" role='form'>
												<?php display_alert(); ?>
												<div class="form-body">
													<div class="form-group form-md-line-input">
														<input type="text" class="form-control" name='mtitle' required placeholder="Title">
														<label for="form_control_1">Menu Title</label>
														<!-- <span class="help-block">Some help goes here...</span> -->
													</div>
													<div class="form-group form-md-line-input">
														<input type="text" class="form-control" name='mlink' required placeholder="Link">
														<label for="form_control_1">Menu Link</label>
														<!-- <span class="help-block">Some help goes here...</span> -->
													</div>
													<div class="form-group form-md-line-input">
														<input type="text" class="form-control" name='icon' id='menu-ico' data-toggle="modal" data-target="#large" placeholder="Icon">
														<label for="form_control_1">Icon for Link</label>
														<!-- <span class="help-block">Some help goes here...</span> -->
													</div>
												</div>
												
												<div class="form-group form-md-checkboxes">
													<label>Role Management</label>
													<div class="md-checkbox-inline">
														<?php $i=1;
														foreach ($user_type as $row) 
														{
															?>
															<div class="md-checkbox">
																<input type="checkbox" name='access[]' <?php if($row->ROLE_ID==1){echo'checked="checked"';} ?> value='<?=$row->ROLE_ID?>' id="checkbox<?=$i?>" class="md-check">
																<label for="checkbox<?=$i?>">
																<span></span>
																<span class="check"></span>
																<span class="box"></span>
																<?=$row->ROLE_NAME;?></label>
															</div>
															<?php 
															$i++;
														}
															?>
														
													</div>
												</div>
												<div class="form-actions noborder">
													<button type="submit" name='add' value="ADD" class="btn blue">Submit</button>
													<button type="reset" class="btn default">Cancel</button>
												</div>
											</form>
										</div>
									</div>
									<div class="portlet box blue tabbable">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-gift"></i>Role Assigned Menu
								</div>
							</div>
							<div class="portlet-body">
								<div class=" portlet-tabs">
									<ul class="nav nav-pills">
									<?php 
										$i=1;
														foreach ($user_type as $row) 
														{
															?>
															<li class="<?php if($i===1){echo'active';} ?>">
																<a aria-expanded="<?php if($i===1){echo'false';}else{echo'true';} ?>" href="#portlet_tab<?=$i?>" data-toggle="tab">
																<?=$row->ROLE_NAME;?> </a>
															</li>
															<?php 
															$i++;
														}
										?>
									</ul>
									<div class="tab-content">
									<?php 
										$i=1;
														foreach ($user_type as $row) 
														{
															?>
															<div class="tab-pane <?php if($i===1){echo'active';} ?>" id="portlet_tab<?=$i?>">
																<p>
																	 <div class="dd" id="">
																		<ol class="dd-list">
																			<?php
																					$json = $menus->menu;
																					$ar = json_decode($json);

																					foreach($ar as $menu)
																					{
																						if(!empty(unserialize($menu_list[$menu->id]['access'])) && in_array($row->ROLE_ID,unserialize($menu_list[$menu->id]['access'])))
																						{
																							echo'
																							<li class="dd-item" data-id="'.$menu_list[$menu->id]['id'].'">
																							<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$menu->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																								 <i class="'.$menu_list[$menu->id]['icon'].'"></i> '.$menu_list[$menu->id]['title'].'
																							</div>';
																							if(isset($menu->children))
																							{
																								echo'<ol class="dd-list">';
																								foreach($menu->children as $submenu1)
																								{
																									if(!empty(unserialize($menu_list[$submenu1->id]['access'])) && in_array($row->ROLE_ID,unserialize($menu_list[$submenu1->id]['access'])))
																									{
																										echo'
																												<li class="dd-item" data-id="'.$menu_list[$submenu1->id]['id'].'">
																												<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$submenu1->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																													 <i class="'.$menu_list[$submenu1->id]['icon'].'"></i> '.$menu_list[$submenu1->id]['title'].'
																												</div>';
																										if(isset($submenu1->children))
																										{
																											echo'<ol class="dd-list">';
																											foreach($submenu1->children as $submenu2)
																											{
																												if(!empty(unserialize($menu_list[$submenu2->id]['access'])) && in_array($row->ROLE_ID,unserialize($menu_list[$submenu2->id]['access'])))
																												{
																													echo'
																													<li class="dd-item" data-id="'.$menu_list[$submenu2->id]['id'].'">
																													<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$submenu2->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																														 <i class="'.$menu_list[$submenu2->id]['icon'].'"></i> '.$menu_list[$submenu2->id]['title'].'
																													</div>';
																													if(isset($submenu2->children))
																													{
																														echo'<ol class="dd-list">';
																														foreach($submenu2->children as $submenu3)
																														{
																															if(!empty(unserialize($menu_list[$submenu3->id]['access'])) && in_array($row->ROLE_ID,unserialize($menu_list[$submenu3->id]['access'])))
																															{
																																echo'<li class="dd-item" data-id="'.$menu_list[$submenu3->id]['id'].'">
																																			<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$submenu3->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																																				 <i class="'.$menu_list[$submenu3->id]['icon'].'"></i> '.$menu_list[$submenu3->id]['title'].'
																																			</div>';
																																if(isset($submenu3->children))
																																{
																																	echo'<ol class="dd-list">';
																																	foreach($submenu3->children as $submenu4)
																																	{
																																		if(!empty(unserialize($menu_list[$submenu4->id]['access'])) && in_array($row->ROLE_ID,unserialize($menu_list[$submenu4->id]['access'])))
																																		{
																																			echo'
																																				<li class="dd-item" data-id="'.$menu_list[$submenu4->id]['id'].'">
																																				<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$submenu4->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																																					 <i class="'.$menu_list[$submenu4->id]['icon'].'"></i> '.$menu_list[$submenu4->id]['title'].'
																																				</div></li>';
																																		}
																																	}
																																	echo"</ol>";
																																}
																																echo"</li>";
																															}
																														}
																														echo"</ol>";
																													}
																													echo"</li>";
																												}
																											}
																											echo"</ol>";
																										}
																										echo"</li>";
																									}
																								}
																								echo"</ol>";
																							}
																							echo"</li>";
																						}
																					}
																			?>
																		</ol>
																	</div>
																</p>											
															</div>
															<?php 
															$i++;
														}
										?>
									</div>
								</div>
							</div>
						</div>
							</div>
							<div class="col-md-6">
								<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-comments"></i>Manage Menu List
										</div>
										<div class="caption pull-right">
											<button type="button" class="btn btn-sm default save_menu" style='display:none;' onClick="history.go(0)" >Cancel</button>
											<button type="submit" style='display:none;' name="save_menu" class="btn btn-sm green save_menu" form='menus' onclick="return confirm('Do you want to save Menu?')" value="SAVE">Save Menu</button>
										</div>
									</div>
									<div class="portlet-body ">
										<div class="dd" id="nestable_list_1">
											<ol class="dd-list">
												<?php
														$json = $menus->menu;
														$ar = json_decode($json);
														foreach($ar as $menu)
														{
															echo'
															<li class="dd-item" data-id="'.$menu_list[$menu->id]['id'].'">
															<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$menu->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																 <i class="'.$menu_list[$menu->id]['icon'].'"></i> '.$menu_list[$menu->id]['title'].'
															</div>';
															if(isset($menu->children))
															{
																echo'<ol class="dd-list">';
																foreach($menu->children as $submenu1)
																{
																	echo'
																			<li class="dd-item" data-id="'.$menu_list[$submenu1->id]['id'].'">
																			<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$submenu1->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																				 <i class="'.$menu_list[$submenu1->id]['icon'].'"></i> '.$menu_list[$submenu1->id]['title'].'
																			</div>';
																	if(isset($submenu1->children))
																	{
																		echo'<ol class="dd-list">';
																		foreach($submenu1->children as $submenu2)
																		{
																			echo'
																			<li class="dd-item" data-id="'.$menu_list[$submenu2->id]['id'].'">
																			<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$submenu2->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																				 <i class="'.$menu_list[$submenu2->id]['icon'].'"></i> '.$menu_list[$submenu2->id]['title'].'
																			</div>';
																			if(isset($submenu2->children))
																			{
																				echo'<ol class="dd-list">';
																				foreach($submenu2->children as $submenu3)
																				{
																					echo'<li class="dd-item" data-id="'.$menu_list[$submenu3->id]['id'].'">
																								<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$submenu3->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																									 <i class="'.$menu_list[$submenu3->id]['icon'].'"></i> '.$menu_list[$submenu3->id]['title'].'
																								</div>';
																					if(isset($submenu3->children))
																					{
																						echo'<ol class="dd-list">';
																						foreach($submenu3->children as $submenu4)
																						{
																							echo'
																								<li class="dd-item" data-id="'.$menu_list[$submenu4->id]['id'].'">
																								<a href="'.site_url('theme_option/manage_menu/edit/'.$menu_list[$submenu4->id]['id']).'" class="pull-right"><i class="fa fa-pencil"></i></a><div class="dd-handle">
																									 <i class="'.$menu_list[$submenu4->id]['icon'].'"></i> '.$menu_list[$submenu4->id]['title'].'
																								</div></li>';
																						}
																						echo"</ol>";
																					}
																					echo"</li>";
																				}
																				echo"</ol>";
																			}
																			echo"</li>";
																		}
																		echo"</ol>";
																	}
																	echo"</li>";
																}
																echo"</ol>";
															}
															echo"</li>";
														}
												?>
											</ol>
										</div>
									</div>
								</div>
								<div class="portlet box red">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-trash"></i>Delete Menu
										</div>
									</div>
									<div class="portlet-body">
										<div class="dd" id="nestable_list_2">
											<ol class="dd-list">
												<li class="dd-item" data-id="15">
												</li>
											</ol>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<!-- END PAGE CONTENT-->
				</div>
			</div>
			<!-- END CONTENT -->
			<!-- BEGIN QUICK SIDEBAR -->
			<!--Cooming Soon...-->
			<!-- END QUICK SIDEBAR -->
		</div>

<!-- model start -->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Menu Icons</h4>
			</div>
			<div class="modal-body">
				<div class="simplelineicons-demo">
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-user"></span>
										&nbsp;icon-user </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-user-female"></span>
										&nbsp;icon-user-female </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-users"></span>
										&nbsp;icon-users </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-user-follow"></span>
										&nbsp;icon-user-follow </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-user-following"></span>
										&nbsp;icon-user-following </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-user-unfollow"></span>
										&nbsp;icon-user-unfollow </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-trophy"></span>
										&nbsp;icon-trophy </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-speedometer"></span>
										&nbsp;icon-speedometer </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-social-youtube"></span>
										&nbsp;icon-social-youtube </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-social-twitter"></span>
										&nbsp;icon-social-twitter </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-social-tumblr"></span>
										&nbsp;icon-social-tumblr </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-social-facebook"></span>
										&nbsp;icon-social-facebook </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-social-dropbox"></span>
										&nbsp;icon-social-dropbox </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-social-dribbble"></span>
										&nbsp;icon-social-dribbble </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-shield"></span>
										&nbsp;icon-shield </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-screen-tablet"></span>
										&nbsp;icon-screen-tablet </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-screen-smartphone"></span>
										&nbsp;icon-screen-smartphone </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-screen-desktop"></span>
										&nbsp;icon-screen-desktop </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-plane"></span>
										&nbsp;icon-plane </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-notebook"></span>
										&nbsp;icon-notebook </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-moustache"></span>
										&nbsp;icon-moustache </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-mouse"></span>
										&nbsp;icon-mouse </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-magnet"></span>
										&nbsp;icon-magnet </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-magic-wand"></span>
										&nbsp;icon-magic-wand </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-hourglass"></span>
										&nbsp;icon-hourglass </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-graduation"></span>
										&nbsp;icon-graduation </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-ghost"></span>
										&nbsp;icon-ghost </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-game-controller"></span>
										&nbsp;icon-game-controller </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-fire"></span>
										&nbsp;icon-fire </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-eyeglasses"></span>
										&nbsp;icon-eyeglasses </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-envelope-open"></span>
										&nbsp;icon-envelope-open </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-envelope-letter"></span>
										&nbsp;icon-envelope-letter </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-energy"></span>
										&nbsp;icon-energy </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-emoticon-smile"></span>
										&nbsp;icon-emoticon-smile </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-disc"></span>
										&nbsp;icon-disc </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-cursor-move"></span>
										&nbsp;icon-cursor-move </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-crop"></span>
										&nbsp;icon-crop </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-credit-card"></span>
										&nbsp;icon-credit-card </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-chemistry"></span>
										&nbsp;icon-chemistry </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-bell"></span>
										&nbsp;icon-bell </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-badge"></span>
										&nbsp;icon-badge </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-anchor"></span>
										&nbsp;icon-anchor </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-action-redo"></span>
										&nbsp;icon-action-redo </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-action-undo"></span>
										&nbsp;icon-action-undo </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-bag"></span>
										&nbsp;icon-bag </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-basket"></span>
										&nbsp;icon-basket </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-basket-loaded"></span>
										&nbsp;icon-basket-loaded </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-book-open"></span>
										&nbsp;icon-book-open </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-briefcase"></span>
										&nbsp;icon-briefcase </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-bubbles"></span>
										&nbsp;icon-bubbles </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-calculator"></span>
										&nbsp;icon-calculator </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-call-end"></span>
										&nbsp;icon-call-end </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-call-in"></span>
										&nbsp;icon-call-in </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-call-out"></span>
										&nbsp;icon-call-out </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-compass"></span>
										&nbsp;icon-compass </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-cup"></span>
										&nbsp;icon-cup </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-diamond"></span>
										&nbsp;icon-diamond </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-direction"></span>
										&nbsp;icon-direction </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-directions"></span>
										&nbsp;icon-directions </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-docs"></span>
										&nbsp;icon-docs </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-drawer"></span>
										&nbsp;icon-drawer </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-drop"></span>
										&nbsp;icon-drop </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-earphones"></span>
										&nbsp;icon-earphones </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-earphones-alt"></span>
										&nbsp;icon-earphones-alt </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-feed"></span>
										&nbsp;icon-feed </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-film"></span>
										&nbsp;icon-film </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-folder-alt"></span>
										&nbsp;icon-folder-alt </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-frame"></span>
										&nbsp;icon-frame </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-globe"></span>
										&nbsp;icon-globe </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-globe-alt"></span>
										&nbsp;icon-globe-alt </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-handbag"></span>
										&nbsp;icon-handbag </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-layers"></span>
										&nbsp;icon-layers </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-map"></span>
										&nbsp;icon-map </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-picture"></span>
										&nbsp;icon-picture </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-pin"></span>
										&nbsp;icon-pin </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-playlist"></span>
										&nbsp;icon-playlist </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-present"></span>
										&nbsp;icon-present </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-printer"></span>
										&nbsp;icon-printer </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-puzzle"></span>
										&nbsp;icon-puzzle </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-speech"></span>
										&nbsp;icon-speech </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-vector"></span>
										&nbsp;icon-vector </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-wallet"></span>
										&nbsp;icon-wallet </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-arrow-down"></span>
										&nbsp;icon-arrow-down </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-arrow-left"></span>
										&nbsp;icon-arrow-left </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-arrow-right"></span>
										&nbsp;icon-arrow-right </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-arrow-up"></span>
										&nbsp;icon-arrow-up </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-bar-chart"></span>
										&nbsp;icon-bar-chart </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-bulb"></span>
										&nbsp;icon-bulb </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-calendar"></span>
										&nbsp;icon-calendar </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-control-end"></span>
										&nbsp;icon-control-end </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-control-forward"></span>
										&nbsp;icon-control-forward </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-control-pause"></span>
										&nbsp;icon-control-pause </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-control-play"></span>
										&nbsp;icon-control-play </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-control-rewind"></span>
										&nbsp;icon-control-rewind </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-control-start"></span>
										&nbsp;icon-control-start </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-cursor"></span>
										&nbsp;icon-cursor </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-dislike"></span>
										&nbsp;icon-dislike </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-equalizer"></span>
										&nbsp;icon-equalizer </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-graph"></span>
										&nbsp;icon-graph </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-grid"></span>
										&nbsp;icon-grid </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-home"></span>
										&nbsp;icon-home </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-like"></span>
										&nbsp;icon-like </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-list"></span>
										&nbsp;icon-list </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-login"></span>
										&nbsp;icon-login </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-logout"></span>
										&nbsp;icon-logout </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-loop"></span>
										&nbsp;icon-loop </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-microphone"></span>
										&nbsp;icon-microphone </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-music-tone"></span>
										&nbsp;icon-music-tone </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-music-tone-alt"></span>
										&nbsp;icon-music-tone-alt </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-note"></span>
										&nbsp;icon-note </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-pencil"></span>
										&nbsp;icon-pencil </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-pie-chart"></span>
										&nbsp;icon-pie-chart </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-question"></span>
										&nbsp;icon-question </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-rocket"></span>
										&nbsp;icon-rocket </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-share"></span>
										&nbsp;icon-share </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-share-alt"></span>
										&nbsp;icon-share-alt </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-shuffle"></span>
										&nbsp;icon-shuffle </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-size-actual"></span>
										&nbsp;icon-size-actual </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-size-fullscreen"></span>
										&nbsp;icon-size-fullscreen </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-support"></span>
										&nbsp;icon-support </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-tag"></span>
										&nbsp;icon-tag </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-trash"></span>
										&nbsp;icon-trash </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-umbrella"></span>
										&nbsp;icon-umbrella </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-wrench"></span>
										&nbsp;icon-wrench </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-ban"></span>
										&nbsp;icon-ban </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-bubble"></span>
										&nbsp;icon-bubble </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-camcorder"></span>
										&nbsp;icon-camcorder </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-camera"></span>
										&nbsp;icon-camera </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-check"></span>
										&nbsp;icon-check </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-clock"></span>
										&nbsp;icon-clock </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-close"></span>
										&nbsp;icon-close </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-cloud-download"></span>
										&nbsp;icon-cloud-download </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-cloud-upload"></span>
										&nbsp;icon-cloud-upload </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-doc"></span>
										&nbsp;icon-doc </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-envelope"></span>
										&nbsp;icon-envelope </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-eye"></span>
										&nbsp;icon-eye </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-flag"></span>
										&nbsp;icon-flag </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-folder"></span>
										&nbsp;icon-folder </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-heart"></span>
										&nbsp;icon-heart </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-info"></span>
										&nbsp;icon-info </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-key"></span>
										&nbsp;icon-key </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-link"></span>
										&nbsp;icon-link </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-lock"></span>
										&nbsp;icon-lock </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-lock-open"></span>
										&nbsp;icon-lock-open </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-magnifier"></span>
										&nbsp;icon-magnifier </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-magnifier-add"></span>
										&nbsp;icon-magnifier-add </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-magnifier-remove"></span>
										&nbsp;icon-magnifier-remove </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-paper-clip"></span>
										&nbsp;icon-paper-clip </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-paper-plane"></span>
										&nbsp;icon-paper-plane </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-plus"></span>
										&nbsp;icon-plus </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-pointer"></span>
										&nbsp;icon-pointer </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-power"></span>
										&nbsp;icon-power </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-refresh"></span>
										&nbsp;icon-refresh </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-reload"></span>
										&nbsp;icon-reload </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-settings"></span>
										&nbsp;icon-settings </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-star"></span>
										&nbsp;icon-star </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-symbol-female"></span>
										&nbsp;icon-symbol-female </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-symbol-male"></span>
										&nbsp;icon-symbol-male </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-target"></span>
										&nbsp;icon-target </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-volume-1"></span>
										&nbsp;icon-volume-1 </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-volume-2"></span>
										&nbsp;icon-volume-2 </span>
										</span>
										<span class="item-box">
										<span class="item item-ico">
										<span aria-hidden="true" class="icon-volume-off"></span>
										&nbsp;icon-volume-off </span>
										</span>
									</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" id='selected_icon' data-dismiss="modal">ok</button>
				<!-- <button type="button" class="btn blue">Save changes</button> -->
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- model end -->