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
          <a href="#">Site Map</a>
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
    
        <div class="row">
          <div class="col-md-12">
            <div class="portlet light">
              <div class="portlet-title">
                <div class="caption font-red-sunglo">
                  <i class="icon-settings font-red-sunglo"></i>
                  <span class="caption-subject bold uppercase">Site Menu Map for Your Role</span>
                </div>
              </div>
              <div class="portlet-body form" style="min-height: 55vh;">
                <ul class="menu_list" style="max-height: 100%;">
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
              </div>
            </div>
          </div>
        </div>
      
  </div>
  <!-- END CONTENT -->
  <!-- BEGIN QUICK SIDEBAR -->
  <!--Cooming Soon...-->
  <!-- END QUICK SIDEBAR -->
</div>


        
      