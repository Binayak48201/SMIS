<?php
if(isset($results) && !empty($results))
{
	?>
	<table class="table table-stripped table-condensed simple_table">
		<thead>
			<tr>
				<th>SN</th>
				<th>Employee Photo</th>
				<th>Employee Name</th>
				<th>Email</th>
				<th>Agreement Type</th>
				<th>Designation</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1;
    	foreach($results as $employee)
    	{ 
    					
					?>
				<tr>
					<td><?=$i++;?></td>
					<td>
						<img src="<?= file_exists(IMG_UPLOAD_PATH."/".$employee->picture_path) ? site_url('uploads/'.$employee->picture_path).'?dump='.rand() : site_url('assets'); ?>/admin/layout2/img/avatar.png ?>" width="50px" alt="">
					</td>
					<td>
						<?=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name?>
					</td>
					<td><?=$employee->email?></td>
					<td><?=$employee->agreement_type?></td>
					<td><?=$employee->designation?></td>
					<td>
						<a class="btn btn-sm btn-primary view_profile" data-id="<?= $employee->employee_id ?>" data-toggle="modal" data-target="#large" >View Profile</a>
					</td>
				</tr>
    		<?php
    		
    	} ?>
    </tbody>
  </table>
			   
    <?php
}
else{
?>
<div class="alert alert-danger text-center"> No Records Available</div>
<?php } ?>