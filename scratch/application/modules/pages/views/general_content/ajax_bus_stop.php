	
	<?php
		if(!empty($results)){ 
			if(isset($opt) && $opt == 'all'){ ?>
				<option value="all"> All </option>
		<?php }
			foreach($results as $row){ ?>
				<option value="<?= $row->stop_id ?>"> <?= $row->stop_name ?> </option>
	<?php } }
		else{ ?>
		 <option value=""> No records </option>
 	<?php } ?>
	