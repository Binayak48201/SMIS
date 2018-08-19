	<input type="hidden" name="id" value="<?= $result->exam_id ?>">
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-6 control-label">Full Mark:</label>
		<div class="col-md-6">
			<input class="form-control" name='full_mark' value="<?= $result->full_mark ?>"  placeholder="Full Mark" required type="number" />
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-6 control-label">Pass Mark:</label>
		<div class="col-md-6">
			<input class="form-control date-picker" name='pass_mark' value="<?= $result->pass_mark ?>"  placeholder="Pass Mark" required type="number" />
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-6 control-label">Final Mark Weightage (%):</label>
		<div class="col-md-6">
			<input class="form-control date-picker" name='average_at' value="<?= $result->average_at ?>"  placeholder="Weightage" required type="number" />
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-6 control-label">Terminal Marks Conversion:</label>
		<div class="col-md-6">
			<input class="form-control date-picker" name='convert_to' value="<?= $result->convert_to ?>"  placeholder="Convert Mark" required type="number" />
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-6 control-label">Status</label>
		<div class="col-md-6">
			<input type="checkbox" class="make-switch" name='status' <?= $result->status ==1 ? 'checked' : ''?> value="1" data-on-text="Yes" data-size="small" data-off-text="No">
		</div>
	</div>
	<div class="clearfix"></div>