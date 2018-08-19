
	<div class="clearfix"></div>
	<br>
	<table class="table table-bordered table-condensed table-striped simple_table">
		<thead>
			<tr>
				<th>Sn</th>
				<th>Student Name</th>
				<th>Roll No</th>
				<th>Total Days</th>
				<th>Present Days</th>
				<th>Absent Days</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 

			if(isset($students))
			{
				$i=1;
				foreach ($students as $student) 
				{ 
					$total_class = 0;
					$present_class = 0;
					$absent_class = 0;
					$pending_stat = FALSE;
					$pass_stat = TRUE;
					$result =  modules::run("pages/ajax/students_attandance_by_grade",$student->student_id,$section_id,$exam_id);
					?>
							
					<tr>
						<td><?= $i++; ?></td>
						<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>"><?= $student->st_fname; ?> <?= $student->st_mname; ?> <?= $student->st_lname; ?></a></td>
						<td><?= $student->current_roll; ?></td>
						<td class=""><?php if(!empty($result)){ echo $result->total_class; $total_class = $result->total_class; } else{ echo '-'; } ?></td>
						<td class=""><?php if(!empty($result)){ echo $result->present_class; $present_class = $result->present_class; } else{ echo '-'; } ?></td>
						<td class=""><?php if(!empty($result)){ echo $result->absent_class; $absent_class = $result->absent_class; } else{ echo '-'; } ?></td>
						<td><i data-toggle="modal" data-target="#large-chart" data-id="<?= $student->student_id ?>" class="btn icon-bar-chart view_graph"></i></td>
					</tr>
					<?php 
				} 
			} ?>
		</tbody>
	</table>
	<input type="hidden" name="exam" id="exam" value="<?= $exam_id ?>">

<!-- model start -->
<div class="modal fade bs-modal-md" id="large-chart" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true"></button>
        <div class="caption font-green-haze">
              <i class="icon-settings font-green-haze"></i>
              <span class="caption-subject bold uppercase">Attendance Graph View</span>
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