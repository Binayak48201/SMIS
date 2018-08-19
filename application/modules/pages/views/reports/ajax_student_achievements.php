<div class="col-md-12">
	<?php if($this->general->is_admin('su_admin')){ ?>
	<form method="post" id="add_achievement">
		<div class="navbar " role="navigation">
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <input type="text" class="form-control" name='achievement' required>
	        <label>Achievement:</label>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <input type="text" class="form-control" name='remarks' required>
	        <label>Remarks:</label>
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
				<th>Achievement</th>
				<th>Remarks</th>
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
							<td><?= $row->achievement ?></td>
							<td><?= $row->remarks ?></td>
							<?php if($this->general->is_admin('su_admin')){ ?>
							<td><button class="btn btn-danger" id="delete_achievement" type="button" data-id="<?= $row->st_achievement_id ?>" ><i class="icon-trash"></i></button></td>
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
