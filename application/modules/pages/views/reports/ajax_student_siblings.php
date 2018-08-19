<div class="col-md-12">
	<?php if($this->general->is_admin('su_admin')){ ?>
	<form method="post" id="add_sibling">
		<div class="navbar " role="navigation">
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <input type="text" class="form-control" name='sibling_name' required>
	        <label>Name:</label>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" name='sibling_dob' required>
	        <label>Date Of Birth:</label>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <input type="text" class="form-control" name='sibling_qualification' required>
	        <label>Qualification:</label>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <input type="text" class="form-control" name='sibling_institution' required>
	        <label>School/Work:</label>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <input type="text" class="form-control" name='relation' required>
	        <label>Relation:</label>
	      </div>
	    </div>
	    <div class="col-md-3">
	    	<input type="hidden" name="st_id" id="st_id" value="<?= $st_id ?>">
	      <input type="submit" value="ADD" class="btn btn-success">
	    </div>
	  </div>
	</form>
	<?php } ?>
	<div id="lists">
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
<div>
</div>	
