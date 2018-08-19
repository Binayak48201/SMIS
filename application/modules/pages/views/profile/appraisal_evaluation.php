<p class="col-md-12">
	<?php foreach($grades as $grade){ ?>
		<?= $grade->grade_name ?>: <?= $grade->grade_description ?>&nbsp;&nbsp;
		<?php
	}?>
</p>
<?php
	if(isset($ap_heades) && !empty($ap_heades))
	{
		$opt_eval = array();
		foreach ($ap_heades as $ap_head) {
			
			?>
			<div class="col-md-6">
				<div class="note note-sm note-success"><?= $ap_head->head_name ?></div>
				
				<div class="col-md-12 form-md-radios">
				<?php 
					$section_id = $this->uri->segment(5);
					$update = FALSE;
					$ap_fields = modules::run("pages/classes/appraisal_manager/get_head_field",$ap_head->head_id);;
							//$options = modules::run("pages/evaluation/get_evaluation_option",3,$evaluation->evaluation_type_id);
					$i = 1;
					foreach ($ap_fields as $ap_field) {
						$opt_eval[] = $ap_field->field_id;
						$remarked = modules::run("pages/classes/appraisal_manager/get_st_evaluated",$ap_field->field_id,$st_id,$exam_id,$section_id);
						if($remarked != NULL)
						{
							$update = TRUE;
							echo'<input type="hidden" name="update_opt" value="UPDATE">';
							echo'<input type="hidden" name="type_'.$ap_field->field_id.'" value="'.$remarked->appraisal_id.'">';
						}
						?>
						<label><b><?= $ap_field->field_name ?></b></label>
						<div class="md-radio-inline">
							<?php 
							if($grades != NULL)
							{
								foreach($grades as $grade)
								{ ?>
									<div class="md-radio">
	                  <input id="grade_<?= $grade->grade_name ?>_<?= $ap_field->field_id ?>" <?= $update && $remarked->grade == $grade->grade_name ? 'checked' : '' ?> name='grade_<?= $ap_field->field_id ?>' value="<?= $grade->grade_name?>" class="md-radiobtn"  type="radio">
	                  <label for="grade_<?= $grade->grade_name ?>_<?= $ap_field->field_id ?>">
	                  <span></span>
	                  <span class="check"></span>
	                  <span class="box"></span>
	                  <?= $grade->grade_name ?></label>
		                </div>
	                  
									<?php
								}
							}
							?>
							<div class="md-radio">
                <input id="grade_resset<?= $i ?><?= $ap_field->field_id ?>" name='grade_<?= $ap_field->field_id ?>' value="" class="md-radiobtn"  type="radio">
                <label for="grade_resset<?= $i++ ?><?= $ap_field->field_id ?>">
                <span></span>
                <span class="check"></span>
                <span class="box"></span>
                </label>
	            </div>
						</div>
						<?php
					}
				?>
					
				</div>		
			</div>
			<?php
		} ?>
		<input type="hidden" name="exam_id" value="<?= $exam_id ?>">
		<input type="hidden" name="opt_eval" value='<?= serialize($opt_eval); ?>'>
		<?php
	}
?>