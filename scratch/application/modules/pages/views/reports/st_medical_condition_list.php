<table class="table table-striped table-condensed" id="editable">
		<thead>
			<tr>
				<th>Condition Name</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Current Status</th>
				<th>Remark</th>
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
							<td><?= $row->condition_name ?></td>
							<td><?= $row->start_date ?></td>
							<td><?= $row->end_date ?></td>
							<td><?= $row->current_status ?></td>
							<td><?= $row->remarks ?></td>
							<?php if($this->general->is_admin('su_admin')){ ?>
							<td><button class="btn btn-info edit_opt" type="button" data-info='{"condition_name":"<?= $row->condition_name ?>","start_date":"<?= $row->start_date ?>","end_date":"<?= $row->end_date ?>","current_status":"<?= $row->current_status ?>","remarks":"<?= $row->remarks ?>","id":"<?= $row->st_condition_id ?>","stat":"Update"}' ><i class="icon-pencil"></i></button>
								<button class="btn btn-danger" id="delete_conditions" type="button" data-id="<?= $row->st_condition_id ?>" ><i class="icon-trash"></i></button></td>
							<?php } ?>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>