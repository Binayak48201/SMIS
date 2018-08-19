<?php

	if(isset($evaluations) && !empty($evaluations))
	{
		$opt_eval = array();
		foreach ($evaluations as $evaluation) {
			$opt_eval[] = $evaluation->evaluation_type_id;
			?>
			<div class="col-md-6 no-padding">
				<div class="note note-sm note-success"><?= $evaluation->evaluation_type_name ?></div>
					<div class="col-md-12 md-radio-list">
						<?php 
							$section_id = $this->uri->segment(5);
							$update = FALSE;
							$options = modules::run("pages/evaluation/get_evaluation_option",2,$evaluation->evaluation_type_id);
							$remarked = modules::run("pages/evaluation/get_st_evaluated",2,$evaluation->evaluation_type_id,$st_id,$exam_id,$section_id);
							if($remarked != NULL)
							{
								$update = TRUE;
								echo'<input type="hidden" name="update_opt" value="UPDATE">';
							}
							if($options != NULL)
							{
								foreach($options as $option)
								{ ?>
									<div class="md-radio">
	                  <input id="radio<?= $option->evaluation_option_id?>" <?= $remarked != NULL && $remarked->evaluation_id == $option->evaluation_option_id ? 'checked' : ''  ?> name='type_<?= $evaluation->evaluation_type_id ?>'value="<?= $option->evaluation_option_id ?>" class="md-radiobtn" required=""  type="radio">
	                  <label for="radio<?= $option->evaluation_option_id?>">
	                  <span></span>
	                  <span class="check"></span>
	                  <span class="box"></span>
	                  <?= $option->evaluation_option_name ?></label>
		                </div>
		                <div class="form-control-focus">
								</div>
									<?php
								}
							}
						?>
						<div class="col-md-12 form-group form-md-line-input">
							<textarea class="form-control" placeholder="Remark" name='remark_<?= $evaluation->evaluation_type_id ?>' ><?= $remarked != NULL ? $remarked->remarks : '' ?></textarea>
							<div class="form-control-focus">
							</div>
						</div>
          </div>
			</div>
			<?php
		} ?>
		<input type="hidden" name="exam_id" value="<?= $exam_id ?>">
		<input type="hidden" name="section_id" value="<?= $section_id ?>">
		<input type="hidden" name="opt_eval" value='<?= serialize($opt_eval); ?>'>
		<?php
	}
?>