<?php
	if(isset($students) && !empty($students))
	{
		?>
		<div class="note note-warning text-center">
			<p>
				LIST OF STUDENTS
			</p>
		</div>
		<button data-id="student_list" class="btn btn-success exportTable pull-right">Export to Excel</button>
		<div class="clearfix"></div>
		<br>
		<div>
			<table id="student_list" class="table table-condensed table-bordered table-striped">
				<thead>
					<tr>
						<th>SN</th>
						<th>Name</th>
						<th>Home Phone</th>
						<th>Gender</th>
						<th>Grade</th>
						<th>Section</th>
						<th>Bus Name</th>
						<th>Bus Route</th>
						<th>Bus Stop</th>
						<th>Pickup Time</th>
						<th>Drop Time</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; $st_ids = array();
        	foreach($students as $student)
        	{ 
        		?>
						<tr>
							<td><?= $i++; ?></td>
							<td><a target="#details" href="<?= site_url('pages/profile/student/details/'.$student->student_id);?>"><?=$student->st_fname.' '.$student->st_mname.' '.$student->st_lname?></a></td>
							<td><?=$student->home_phone?></td>
							<td><?=$student->gender?></td>
							<td><?=$student->grade?></td>
							<td><?=$student->section_name?></td>
							<td><?=$student->bus_name?></td>
							<td><?=$student->bus_route?></td>
							<td><?=$student->stop_name?></td>
							<td><?=$student->pick_time?></td>
							<td><?=$student->drop_time?></td>
						</tr>
        		<?php
        		$st_ids[] = $student->student_id;
        	}  

        	 ?>
        </tbody>
			</table>
		</div>
  	 <?php
  }
  else
  {
  	?>
  	<div class="note note-info text-center">No Records Available</div>
  	<?php
  }
?>