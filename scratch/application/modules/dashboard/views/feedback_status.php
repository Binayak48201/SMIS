<div class="portlet-title">
    <div class="caption font-green-haze">
        <i class="icon-settings font-green-haze"></i>
        <span class="caption-subject bold uppercase">FEEDBACK STATUS</span>
    </div>
    <div class="clearfix"></div>
</div>
<div style="height: 290px; overflow:auto;" class="portlet-body">
    <div class="portlet-title tabbable-line">
      <div class="caption caption-md">
        <i class="icon-globe theme-font hide"></i>
        <!-- <span class="caption-subject font-blue-madison bold uppercase">Help</span> -->
      </div>
      <ul class="nav nav-pills">
        <li class="active">
          <a href="#tab_3_1" class="cstm" data-toggle="tab">Active</a>
        </li>
        <li>
          <a href="#tab_3_2" class="cstm" data-toggle="tab">In-Active</a>
        </li>
      </ul>
    </div>
    <div class="portlet-body" style="overflow: auto;">
      <div class="tab-content">
        <div class="tab-pane active" id="tab_3_1">
          <?php $uid=array(); if(isset($results) && $results!=NULL){ ?>
            
            <table  id='tblExport' class='table table-bordered table-condensed'>
                      <thead> 
                      <tr> 
                        <th>S.N</th>
                        <th>Employee Name</th>
                        <th>comment</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $i=1;  foreach($results as $row)
                      { 
                        if($row->date==date('Y'))
                        {
                          $uid[]=$row->user_id;
                          ?>
                          <tr>
                            <td style="vertical-align: middle;"><?=$i++ ?></td>
                            <td style="vertical-align: middle;"><a href="<?=site_url('pages/student_info/student_feedback/list_feedback/'.$row->user_id)?>"><?=$row->emp_fullname;?></a></td>
                            <td><?=$row->total?></td>
                          </tr>
                          <?php 
                          }
                        } ?>                                    
              </tbody>
            </table>
          <?php } ?>
        </div>
        <div class="tab-pane" id="tab_3_2">
          <?php if(isset($results) && $results!=NULL){ ?>
            
            <table  id='tblExport' class='table table-bordered table-condensed'>
                      <thead> 
                      <tr> 
                        <th>S.N</th>
                        <th>Employee Name</th>
                        <th>comment</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $i=1;$users=array();  
                      foreach($results as $row)
                      { 
                        if($row->date!=date('Y') && !in_array($row->user_id, $uid) && !in_array($row->user_id, $users))
                        {
                          $users[]=$row->user_id;
                          ?>
                            <tr>
                              <td style="vertical-align: middle;"><?=$i++ ?></td>
                              <td style="vertical-align: middle;"><?=$row->emp_fullname;?></td>
                              <td>0</td>
                            </tr>
                          <?php 
                        }
                      } ?>
                        
              </tbody>
            </table>
          <?php } ?>
        </div>
      </div>
    </div>
</div>