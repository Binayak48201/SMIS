<form class="form-horizontal margin-bottom-40" id="ap_title" method="post" action='<?= site_url('pages/classes/evaluation_criteria_manager/add_title/1'); ?>' role="form" >
	<div class="form-group form-md-line-input">
		<label for="inputPassword12" class="col-md-4 control-label">Option Name: </label>
		<div class="col-md-6">
			<input class="form-control" name='option_name' id="option_name" required placeholder="Option Name" type="text">
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div id="extra_option"></div>
	<div class="col-md-offset-4">
		<input type="hidden" name="type_id" id="type_id" value="<?= $type_id?>">
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
				<td><?= $row->evaluation_option_name ?></td>
				<td><button class="btn btn-sm btn-info edit-title" data-name="<?= $row->evaluation_option_name ?>" data-id="<?= $row->evaluation_option_id ?>">Edit</button>
					<button class="btn btn-sm btn-danger del-title" data-tid="<?= $row->evaluation_type_id ?>" data-id="<?= $row->evaluation_option_id ?>">Delete</button></td>
			</tr>
			<?php endforeach; endif; ?>
		</tbody>
	</table>
</div>
<div class="clearfix"></div>