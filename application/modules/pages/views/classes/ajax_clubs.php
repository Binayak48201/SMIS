<form class="form-horizontal margin-bottom-40" id="add_club" method="post" action='<?= site_url('pages/classes/club_manager/add_club'); ?>' role="form" >
	<div class="form-group form-md-line-input">
		<label for="inputPassword12" class="col-md-4 control-label">Club Name: </label>
		<div class="col-md-6">
			<input class="form-control" name='club' id="club" required placeholder="Club Name" type="text">
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div id="extra_option"></div>
	<div class="col-md-offset-4">
		<input type="hidden" name="club_type" id="club_type" value="<?= $club_type?>">
		<button name="add" value="ADD" class="btn blue" id='act-btn' type='submit'>Add</button>
		<button class="btn default" data-dismiss="modal" type='reset'>Cancel</button>
	</div>
</form>
<div class="col-md-12" id="title_lists">
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Sn</th>
				<th>Field</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($results)): $i=1;
				foreach($results as $row): ?>
			<tr>
				<td><?= $i++ ?></td>
				<td><?= $row->club_name ?></td>
				<td><button class="btn btn-sm btn-info edit-title" data-name="<?= $row->club_name ?>" data-id="<?= $row->club_id ?>">Edit</button>
					<button class="btn btn-sm btn-danger del-title" data-tid="<?= $row->club_type ?>" data-id="<?= $row->club_id ?>">Delete</button></td>
			</tr>
			<?php endforeach; endif; ?>
		</tbody>
	</table>
</div>
<div class="clearfix"></div>