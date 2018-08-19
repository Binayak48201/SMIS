<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Doctor Name</th>
				<th>Hospital</th>
				<th>Phone</th>
				<?php if($this->general->is_admin('su_admin')){ ?><th>Action</th><?php }?>
			</tr>
		</thead>
		<tbody>
			<?php 
				if( !empty($results) )
				{
					foreach($results as $row){
						?>
						<tr>
							<td><?= $row->doctor_name ?></td>
							<td><?= $row->hospital ?></td>
							<td><?= $row->phone ?></td>
							<?php if($this->general->is_admin('su_admin')){ ?>
							<td><button class="btn btn-danger" id="delete_consultant" type="button" data-id="<?= $row->doctor_id ?>" ><i class="icon-trash"></i></button></td>
							<?php } ?>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>