<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Medication</th>
				<th>Remarks</th>
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
							<td><?= $row->medication ?></td>
							<td><?= $row->remarks ?></td>
							<?php if($this->general->is_admin('su_admin')){ ?>
							<td><button class="btn btn-danger" id="delete_medication" type="button" data-id="<?= $row->st_medication_id ?>" ><i class="icon-trash"></i></button></td>
							<?php } ?>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>