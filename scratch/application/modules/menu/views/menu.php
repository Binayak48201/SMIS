	<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar-wrapper">
			<div class="page-sidebar navbar-collapse collapse">
				<!-- BEGIN SIDEBAR MENU -->
				<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu page-sidebar-menu-compact" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<?php
						$json = $menus->menu;
						$ar = json_decode($json);
						foreach($ar as $menu)
						{
							if(!empty(unserialize($menu_list[$menu->id]['access'])) && in_array($this->session->userdata('smis_usertype_id'),unserialize($menu_list[$menu->id]['access'])))
							{
								echo'
								<li>
								<a href="';
									if($menu_list[$menu->id]['link']=='#')
									{ 
										echo'javascript:void(0);'; 
									}
									else
									{ 
										echo site_url($menu_list[$menu->id]['link']); 
									} 
								echo'">
								<i class="'.$menu_list[$menu->id]['icon'].'"></i>
									 <span class="title">  '.$menu_list[$menu->id]['title'].'</span><span class="arrow"></span>
								</a>';
								if(isset($menu->children))
								{
									echo'<ul class="sub-menu">';
									foreach($menu->children as $submenu1)
									{
										if(!empty(unserialize($menu_list[$submenu1->id]['access'])) && in_array($this->session->userdata('smis_usertype_id'),unserialize($menu_list[$submenu1->id]['access'])))
										{
											echo'
													<li>
													<a href="';
														if($menu_list[$submenu1->id]['link']=='#')
														{ 
															echo'javascript:void(0);'; 
														}
														else
														{ 
															echo site_url($menu_list[$submenu1->id]['link']); 
														} 
													echo'">
													<i class="'.$menu_list[$submenu1->id]['icon'].'"></i><span class="arrow"></span>
														 '.$menu_list[$submenu1->id]['title'].'
													</a>';
											if(isset($submenu1->children))
											{
												echo'<ul class="sub-menu">';
												foreach($submenu1->children as $submenu2)
												{
													if(!empty(unserialize($menu_list[$submenu2->id]['access'])) && in_array($this->session->userdata('smis_usertype_id'),unserialize($menu_list[$submenu2->id]['access'])))
													{
														echo'
														<li>
														<a href="';
															if($menu_list[$submenu2->id]['link']=='#')
															{ 
																echo'javascript:void(0);'; 
															}
															else
															{ 
																echo site_url($menu_list[$submenu2->id]['link']); 
															} 
														echo'">
														<i class="'.$menu_list[$submenu2->id]['icon'].'"></i><span class="arrow"></span>
															 '.$menu_list[$submenu2->id]['title'].'
														</a>';
														if(isset($submenu2->children))
														{
															echo'<ul class="sub-menu">';
															foreach($submenu2->children as $submenu3)
															{
																if(!empty(unserialize($menu_list[$submenu3->id]['access'])) && in_array($this->session->userdata('smis_usertype_id'),unserialize($menu_list[$submenu3->id]['access'])))
																{
																	echo'<li>
																				<a href="';
																					if($menu_list[$submenu3->id]['link']=='#')
																					{ 
																						echo'javascript:void(0);'; 
																					}
																					else
																					{ 
																						echo site_url($menu_list[$submenu3->id]['link']); 
																					} 
																				echo'">
																				<i class="'.$menu_list[$submenu3->id]['icon'].'"></i><span class="arrow"></span>
																					 '.$menu_list[$submenu3->id]['title'].'
																				</a>';
																	if(isset($submenu3->children))
																	{
																		echo'<ul class="sub-menu">';
																		foreach($submenu3->children as $submenu4)
																		{
																			if(!empty(unserialize($menu_list[$submenu4->id]['access'])) && in_array($this->session->userdata('smis_usertype_id'),unserialize($menu_list[$submenu4->id]['access'])))
																			{
																				echo'
																					<li>
																					<a href="';
																						if($menu_list[$submenu4->id]['link']=='#')
																						{ 
																							echo'javascript:void(0);'; 
																						}
																						else
																						{ 
																							echo site_url($menu_list[$submenu4->id]['link']); 
																						} 
																					echo'">
																					<i class="'.$menu_list[$submenu4->id]['icon'].'"></i><span class="arrow"></span>
																						 '.$menu_list[$submenu4->id]['title'].'
																					</a></li>';
																			}
																		}
																		echo"</ul>";
																	}
																	echo"</li>";
																}
															}
															echo"</ul>";
														}
														echo"</li>";
													}
												}
												echo"</ul>";
											}
											echo"</li>";
										}
									}
									echo"</ul>";
								}
								echo"</li>";
							}
						}
				?>
				</ul>
				<!-- END SIDEBAR MENU -->
			</div>
		</div>
		<!-- END SIDEBAR -->

