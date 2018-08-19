<form class="form-horizontal" method="post" action='<?= site_url('pages/general_content/transportation/update'); ?>' role="form" >
				<div class="modal-body">
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
											$options = modules::run("pages/evaluation/get_evaluation_option",$opt_id,$evaluation->evaluation_type_id);
											if($options != NULL)
											{
												foreach($options as $option)
												{ ?>
													<div class="md-radio">
		                        <input id="radio<?= $option->evaluation_option_id?>"  name='type_<?= $evaluation->evaluation_type_id ?>'value="<?= $option->evaluation_option_id?>" class="md-radiobtn" required=""  type="radio">
		                        <label for="radio<?= $option->evaluation_option_id?>">
		                        <span class="inc"></span>
		                        <span class="check"></span>
		                        <span class="box"></span>
		                        <?= $option->evaluation_option_name ?></label>
		                      </div>
													<?php
												}
											}
										?>
										<div class="col-md-12 form-group form-md-line-input">
											<textarea class="form-control" placeholder="Remark" name='remark_<?= $evaluation->evaluation_type_id ?>' required ></textarea>
											<div class="form-control-focus">
											</div>
										</div>
                  </div>
							</div>
							<?php
						}
					}
					?>
				</div>
				<dic class="clearfix"></dic>
				<div class="modal-footer">
					<input type="hidden" name="opt_eval" value='<?= serialize($opt_eval); ?>'>
					<input type="hidden" name="st_id" class="st_id" value="">
					<input type="hidden" name="section_id" value="<?= $this->uri->segment(5); ?>">
					<button name="update" value="UPDATE" class="btn blue" type='submit'>Add</button>
					<button class="btn default" data-dismiss="modal" type='reset'>Cancel</button>
				</div>
			</form>