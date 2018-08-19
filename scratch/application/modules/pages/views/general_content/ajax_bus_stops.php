<hr/>
<table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>SN</th>
			<th>Bus Stop</th>
			<th>Pick-up Time</th>
			<th>Drop Time</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; 
		if(!empty($results)){ 
			foreach($results as $row){ ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $row->stop_name ?></td>
					<td><?=  date("h:i A", strtotime($row->pick_time)); ?></td>
					<td><?=  date("h:i A", strtotime($row->drop_time)); ?></td>
					<td>
						<label data-bus-id="<?= $row->bus_id ?>" data-stop-id="<?= $row->stop_id ?>" class="btn btn-danger btn-sm  ajax_delete"><i class="icon-trash"></i></label>
					</td>
				</tr>
		<?php } } ?>
	</tbody>
</table>