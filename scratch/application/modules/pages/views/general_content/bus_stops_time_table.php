<hr/>
<div class="btn btn-success exportTable">Export</div>
<table id="tblExport" class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th>SN</th>
			<th>Bus Name</th>
			<th>Bus Route</th>
			<th>Bus Stop</th>
			<th>Pick-up Time</th>
			<th>Drop Time</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; 
		if(!empty($results)){ 
			foreach($results as $row){ ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $row->bus_name ?></td>
					<td><?= $row->bus_route ?></td>
					<td><?= $row->stop_name ?></td>
					<td><?=  date("h:i A", strtotime($row->pick_time)); ?></td>
					<td><?=  date("h:i A", strtotime($row->drop_time)); ?></td>
				</tr>
		<?php } } ?>
	</tbody>
</table>