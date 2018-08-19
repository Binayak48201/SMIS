<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Name</th>
				<th>Date Of Birth</th>
				<th>Qualification</th>
				<th>School/Work</th>
				<th>Relation</th>
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
							<td><?= $row->sibling_name ?></td>
							<td><?= $row->sibling_dob ?></td>
							<td><?= $row->sibling_qualification ?></td>
							<td><?= $row->sibling_institution ?></td>
							<td><?= $row->relation ?></td>
							<?php if($this->general->is_admin('su_admin')){ ?>
							<td><button class="btn btn-danger" id="delete_sibling" type="button" data-id="<?= $row->sibling_id ?>" ><i class="icon-trash"></i></button></td>
							<?php } ?>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>