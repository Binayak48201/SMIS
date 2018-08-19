<div class="portlet-title">
    <div class="caption font-green-haze">
        <i class="icon-settings font-green-haze"></i>
        <span class="caption-subject bold uppercase">CLASS PROGRESS</span>
    </div>
    <div class="clearfix"></div>
    <div class="font-green">
    *C = Completion, *CP = Committed Period, *PT = Periods Taken, *CC = Class covered 
    </div>
</div>
<div style="height: 290px; overflow:auto;" class="portlet-body">
    <div class="portlet-title tabbable-line">
      <div class="caption caption-md">
        <i class="icon-globe theme-font hide"></i>
        <!-- <span class="caption-subject font-blue-madison bold uppercase">Help</span> -->
      </div>
      <ul class="nav nav-pills">
        <?php $j=1;
          foreach ($programs as $program) {
            ?>
             <li class="<?=( $j++==1 ? 'active':'')?>">
              <a href="#tab_2_<?=$program->program_id?>" class="cstm" data-toggle="tab"><?=$program->program_name?></a>
              </li>
            <?php
          }
        ?>  
      </ul>
      <div class='text-center'>
        <span style="height: 15px;width: 15px; display: inline-block; background-color:#f3ad56 "></span> <span class='filter_class cur-point' data-info="tr-under" style="-webkit-user-select: none; -webkit-font-smoothing: antialiased; font-family: Roboto; font-weight: 500;">Undershoot</span>
        <span style="height: 15px;width: 15px; display: inline-block; background-color:#89c4f4 "></span> <span class='filter_class cur-point' data-info="tr-over" style="-webkit-user-select: none; -webkit-font-smoothing: antialiased; font-family: Roboto; font-weight: 500;">Overshoot</span>
      </div>
    </div>
    <div class="portlet-body" style="overflow: auto;">
      <div class="tab-content">
      <?php $j=1;
          foreach ($programs as $program) {
            ?>
              <div class="tab-pane <?=( $j++==1 ? 'active':'')?>" id="tab_2_<?=$program->program_id?>">
                <?php if(isset($class_stats) && $class_stats!=NULL){ ?>
                  
                  <table  id='tblExport' class='table table-bordered table-condensed'>
                    <thead> 
                      <tr> 
                        <th>S.N</th>
                        <th>section</th>
                        <th>Employee</th>
                        <th>Course</th>
                        <th>% C</th>
                        <th>CP</th>
                        <th>PT</th>
                        <th>CC</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; foreach($class_stats as $row)
                      { 
                        if($row->program_id==$program->program_id)
                        {
                            $periods=round($row->total_allocated_hours/1.5,2);
                            $diff_p=$periods-$row->class_days;
                            $shoots= $row->covered-$row->class_days;

                            if($row->covered!=0)
                              $comp=round(($row->covered/$row->studying)*100 ,2);
                            else
                              $comp=0;

                            if($shoots<=(-$theme_option->lession_plan)  ) 
                            {
                             ?>
                            
                                <tr <?php if($shoots<=(-$theme_option->lession_plan)){ echo'class="cstm-warning tr-under"'; }?>>
                                  <td style="vertical-align: middle;"><?=$i++ ?></td>
                                  <td style="vertical-align: middle;"><?=$row->section_name;?></td>
                                  <td><a class='white' href='<?=site_url("report/faculty/faculty_report/profile/$row->employee_id");?>' ><?=$row->emp_fullname?></a></td>
                                  <td><a class='white' href='<?=site_url("pages/course_pointer/lession_plan/view/".$row->class_days_id);?>'><?=$row->course_name?></a></td>
                                  <td><?=$comp?></td>
                                  <td><?=$row->studying?></td>
                                  <td><?= $row->class_days;?></td>
                                  <td><?=$row->covered?></td>
                              <?php 
                            }
                          }
                        } ?>
                        <?php $i=1; foreach($class_stats as $row)
                      { 
                        if($row->program_id==$program->program_id)
                        {
                            $periods=round($row->total_allocated_hours/1.5,2);
                            $diff_p=$periods-$row->class_days;
                            $shoots= $row->covered-$row->class_days;

                            if($row->covered!=0)
                              $comp=round(($row->covered/$row->studying)*100 ,2);
                            else
                              $comp=0;

                            if($shoots>=$theme_option->lession_plan ) 
                            {
                             ?>
                                <tr <?php if ($shoots>=$theme_option->lession_plan) { echo'class="info tr-over"'; }?>>
                                  <td style="vertical-align: middle;"><?=$i++ ?></td>
                                  <td style="vertical-align: middle;"><?=$row->section_name;?></td>
                                  <td><a class='white' href='<?=site_url("report/faculty/faculty_report/profile/$row->employee_id");?>' ><?=$row->emp_fullname?></a></td>
                                  <td><a class='white' href='<?=site_url("pages/course_pointer/lession_plan/view/".$row->class_days_id);?>'><?=$row->course_name?></a></td>
                                  <td><?=$comp?></td>
                                  <td><?=$row->studying?></td>
                                  <td><?= $row->class_days;?></td>
                                  <td><?=$row->covered?></td>
                              <?php 
                            }
                          }
                        } ?>
                    </tbody>
                  </table>
                <?php } ?>
              </div>
            <?php
          }
        ?>  
      
      </div>
    </div>
</div>