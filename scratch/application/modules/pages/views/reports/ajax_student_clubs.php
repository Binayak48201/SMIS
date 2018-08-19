<div class="col-md-12">
	<?php if($this->general->is_admin('su_admin')){ ?>
	<form method="post" id="add_clubs">
		<div class="navbar " role="navigation">
			<div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <select class="form-control" name='club_type' id='club_type' required>
	          <option value="">Select Type</option>
	          <?php if($club_types!=NULL)
	          { 
	            $i=1;
	            foreach($club_types as $club_type)
	            { ?>
	                <option value="<?=$club_type->club_type?>"><?=$club_type->club_type?></option>
	              <?php
	              $i++;
	            }
	          } ?>
	        </select>
	        <label>Club Type:</label>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <select class="form-control" name='club' id='clubs' required>
	          <option value="">Select Club</option>
	        </select>
	        <label>Club:</label>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="form-group form-md-line-input">
	        <input type="text" class="form-control" name='designation' required>
	        <label>Designation:</label>
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
				<th>Club Type</th>
				<th>Club</th>
				<th>Designation</th>
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
							<td><?= $row->club_type ?></td>
							<td><?= $row->club ?></td>
							<td><?= $row->designation ?></td>
							<?php if($this->general->is_admin('su_admin')){ ?>
							<td><button class="btn btn-danger" id="delete_clubs" type="button" data-id="<?= $row->st_club_id ?>" ><i class="icon-trash"></i></button></td>
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
