	<div class="clearfix"></div>
	<button class="exportTable btn btn-sm btn-success" data-id="ExportTbl" >Export To Excel</button>
	<table id="ExportTbl" class="table table-bordered table-condensed table-striped simple_table">
		<thead> 
			<tr>
				<th>Sn</th>
				<th>Student Name</th>
				<th>Roll No</th>
				<th>Total Mark</th>
				<th>Total Obtain </th>
				<th>Obtain Percent </th>
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
						?>
								
						<tr>
							<td><?= $i++; ?></td>
							<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id)?>"><?= $student->st_fname; ?> <?= $student->st_mname; ?> <?= $student->st_lname; ?></a></td>
							<td><?= $student->current_roll; ?></td>
							<td class=""><?php echo $student->full_marks ?></td>
							<td class=""><?php echo $student->terminal_marks ?></td>
							<td class=""> <?php 
								if($student->terminal_marks > 0)
								{
									$percent = round(($student->terminal_marks/$student->full_marks)*100,2);
								  echo $percent."%";
							  }
							  else
							  	echo '-'; ?></td>
						</tr>
						<?php 
					
				} 
			} ?>
		</tbody>
	</table>
	<input type="hidden" name="exam" id="exam" value="<?= $exam_id ?>">
