<form class="form-horizontal margin-bottom-40" id="ap_title" method="post" action='<?= site_url('pages/classes/appraisal_manager/get_head_titles/with_add'); ?>' role="form" >
	<div class="form-group form-md-line-input">
		<label for="inputPassword12" class="col-md-4 control-label">Title: </label>
		<div class="col-md-6">
			<input class="form-control" name='title' required placeholder="Title" type="text">
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="col-md-offset-4">
		<input type="hidden" name="head_id" id="head_id" value="<?= $head_id?>">
		<button name="add" value="ADD" class="btn blue" type='submit'>Add</button>
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
				<td><?= $row->field_name ?></td>
				<td><button class="btn btn-sm btn-danger del-title" data-hid="<?= $row->head_id ?>" data-id="<?= $row->field_id ?>">Delete</button></td>
			</tr>
			<?php endforeach; endif; ?>
		</tbody>
	</table>
</div>
<div class="clearfix"></div>