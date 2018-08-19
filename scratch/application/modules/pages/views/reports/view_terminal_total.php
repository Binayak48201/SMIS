	<a href="<?= site_url('pages/reports/academic_report/print_all_marksheet?data='.$post_arr); ?>" target="_printAll" class="btn btn-sm btn-primary pull-right"><i class=" icon-printer print"></i> Print all </a>
	<button class="exportTable btn btn-sm btn-success" data-id="ExportTbl" >Export To Excel</button>
	<div class="clearfix"></div>
	<br>
	<table id="ExportTbl" class="table table-bordered table-condensed table-striped simple_table">
		<thead>
			<tr>
				<th>Sn</th>
				<th>Student Name</th>
				<th>Roll No</th>
				<?php
				if(isset($subjects))
				{
					foreach ($subjects as $subject) 
					{
						?>
						<th><?= $subject->subject_name ?></th>
						<?php
					}
				}
				?>
				<th>Total Marks</th>
				<th>Total Obtain Marks</th>
				<th>Percent</th>
				<th>Status</th>
				<th class="noExl">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if(isset($students))
			{
				$i=1;
				foreach ($students as $student) 
				{ 
					$total_obtain = 0;
					$total_mark = 0;
					$data_diff = FALSE;
					$pending_stat = FALSE;
					$pass_stat = TRUE;
					?>
					<tr>
						<td><?= $i++; ?></td>
						<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>"><?= $student->st_fname; ?> <?= $student->st_mname; ?> <?= $student->st_lname; ?></a></td>
						<td><?= $student->current_roll; ?></td>
						<?php
						if(isset($subjects))
						{ //print_e($subjec);
							foreach ($subjects as $subject) { 
								$final_mark = modules::run("pages/exam/marks_entry/students_final_mark",$student->student_id,$subject->subject_id,$exam_id);
								$total_mark += $subject->full_marks;
								?>
								<td><?php if($final_mark != NULL)
									{
										if($exam_id != AGGREGATE_ID)
										{
											$total_obtain += $final_mark->total_marks;
											//$total_mark += $final_mark->full_mark;
									 		echo $final_mark->total_marks ;
									 		if($final_mark->total_marks < $final_mark->pass_mark)
									 		{
									 			$pass_stat = FALSE;
									 		}
										}
										else
										{
											$total_obtain += $final_mark->final_mark;
											
									 		echo $final_mark->final_mark ;
									 		if($final_mark->final_mark < $final_mark->pass_marks)
									 		{
									 			$pass_stat = FALSE;
									 		}
										}
							 		}
							 		else
							 		{
							 			echo 'N/A';
							 			$pending_stat = TRUE;
							 			//$data_diff = TRUE;
							 		}
								 		 ?></td>
								<?php
							
								
							}
						}
						?>
						<td class=""><?= $total_mark ?></td>
						<td class=""><?= $total_obtain ?></td>
						<td class=""><?= $total_obtain!=0 ? round(($total_obtain/$total_mark)*100,2) : '0' ?>%</td>
						<td class="no-padding"> 
							<?php 
								if($pass_stat == FALSE)
									echo'<span class="label label-sm label-danger">FAIL</span>';
								elseif($pending_stat == TRUE)
								  echo '<span class="label label-sm label-warning">Pending</span>';
								else 
									echo '<span class="label label-sm label-success">Pass</span>'; ?> 
						</td>
						<td class="noExl"><i data-toggle="modal" data-target="#large" data-id="<?= $student->student_id ?>" class="btn icon-printer print"></i> <i data-toggle="modal" data-target="#large-chart" data-id="<?= $student->student_id ?>" class="btn icon-bar-chart view_graph"></i></td>
					</tr>
					<?php 
				} 
			} ?>
		</tbody>
	</table>
	<input type="hidden" name="exam" id="exam" value="<?= $exam_id ?>">
	<input type="hidden" name="grade" id="grade" value="<?= $grade ?>">




<!-- model start -->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
              <i class="icon-settings font-green-haze"></i>
              <span class="caption-subject bold uppercase">Mark Sheet</span>
            </div>
      </div>
        <div class="modal-body" id='modal-body' style="overflow: auto; height: 75vh;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Cancel</button>
          <button class="btn blue" data-dismiss="modal"  onclick="printDiv('modal-body')" type='Button'>Print</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->

<!-- model start -->
<div class="modal fade bs-modal-lg" id="large-chart" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
              <i class="icon-settings font-green-haze"></i>
              <span class="caption-subject bold uppercase">Terminal Marks Graph View</span>
            </div>
      </div>
        <div class="modal-body" id='graph-modal-body' style="overflow: auto; height: 75vh;">
          loading..
        </div>
        <div class="modal-footer">
          <button class="btn default" data-dismiss="modal"  type='reset'>Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- model end -->