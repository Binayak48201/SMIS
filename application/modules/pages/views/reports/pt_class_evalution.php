<?php

	if(isset($evaluations) && !empty($evaluations))
	{
		foreach ($evaluations as $evaluation) {
			?>
			<div class="col-md-4 no-padding">
				<div class="note note-sm note-success padding-tb-min"><?= $evaluation->evaluation_type_name ?></div>
					<div class="col-md-12 md-radio-list">
						<?php 
							$update = FALSE;
							$options = modules::run("pages/profile/evaluation/get_evaluation_option",2,$evaluation->evaluation_type_id);
							//print_e($evaluation->evaluation_type_id);
							$remarked = modules::run("pages/profile/evaluation/get_st_evaluated",2,$evaluation->evaluation_type_id,$st_id,$exam_id,$section_id);
							if($options != NULL)
							{
								foreach($options as $option)
								{ ?>
									<div class="md-radio <?= $remarked != NULL && $remarked->evaluation_id == $option->evaluation_option_id ? 'has-success' : 'hide'  ?> ">
	                  <input id="radio<?= $option->evaluation_option_id?>"  <?= $remarked != NULL && $remarked->evaluation_id == $option->evaluation_option_id ? 'checked' : 'disabled'  ?> name='type_<?= $evaluation->evaluation_type_id ?>'value="<?= $option->evaluation_option_id ?>" class="md-radiobtn" type="radio">
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
						<div class="col-md-12 form-group form-md-line-input no-padding"><b>Feedback:</b> 
							<textarea class="form-control" placeholder="Remark" readonly="" name='remark_<?= $evaluation->evaluation_type_id ?>' required ><?= $remarked != NULL ? $remarked->remarks : '' ?></textarea>
							<div class="form-control-focus">
							</div>
						</div>
          </div>
			</div>
			<?php
		}
	}
?>