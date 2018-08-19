
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Club Type</th>
				<th>Club</th>
				<th>Designation</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if( !empty($results) )
				{
					foreach($results as $row){
						?>
						<tr>
							<td><?= $row->club_type ?></td>
							<td><?= $row->club ?></td>
							<td><?= $row->designation ?></td>
							<td><button class="btn btn-danger" id="delete_clubs" type="button" data-id="<?= $row->st_club_id ?>" ><i class="icon-trash"></i></button></td>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
