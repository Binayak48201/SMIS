<div class="col-md-12">
	<?php if($this->general->is_admin('su_admin')){ ?>
	<form method="post" id="add_condition">
		<div class="navbar row" role="navigation">
	    <div class="col-md-3">
        <div class="form-group form-md-line-input">
          <input class="form-control " required  name='condition_name' id='opt_condition_name' type="text">
          <label >Condition Name</label>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group form-md-line-input">
          <input class="form-control date-picker" required data-date-format="yyyy-mm-dd" name='start_date' id='opt_start_date' type="text">
          <label >Start Date</label>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group form-md-line-input">
          <input class="form-control date-picker" data-date-format="yyyy-mm-dd" name='end_date' id='opt_end_date' type="text">
          <label >End Date</label>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group form-md-line-input">
          <input class="form-control"  name='current_status' id='opt_current_status' type="text">
          <label >Current Statue</label>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group form-md-line-input">
          <input class="form-control" name='remarks' id='opt_remarks' type="text">
          <label >Remarks</label>
        </div>
      </div>
	    <div class="col-md-3 pull-right">
	    	<input type="hidden" name="id" id="opt_id">
	    	<input type="hidden" name="st_id" id='st_id' value="<?= $st_id ?>">
	    	<input type="hidden" name="stat" id="opt_stat" value="">
	      <input type="submit" value="Save" class="btn btn-success">
	      <input type="reset" id="reset" value="Cancel" class="btn">
	    </div>
	  </div>
	</form>
	<?php } ?>
	<div id="lists">
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
<div>
</div>	