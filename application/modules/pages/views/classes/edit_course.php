	<input type="hidden" name="id" value="<?= $result->class_days_id ?>">
	<div class="form-group form-md-line-input col-md-6">
		<?php  //print_e($result); ?>
		<label for="inputPassword12" class="col-md-4 control-label">Batch:</label>
		<div class="col-md-6">
			<select class="form-control display_section_opt"  id='opt_batch' required >
				<option value="">Select Batch</option>
				<?php if($batchs!=NULL)
				{ 
					$i=1;
					foreach($batchs as $batch)
					{ ?>
							<option <?= $result->added_batch == $batch->batch_name ? 'selected' :'' ?> value="<?=$batch->batch_name?>"><?=$batch->batch_name?></option>
						<?php
						$i++;
					}
				} ?>
			</select>
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-4 control-label">Grade:</label>
		<div class="col-md-6">
			<select class="form-control display_section_opt" id='opt_grade' required>
				<option value="">Select Grade</option>
				<?php if($grades!=NULL)
				{ 
					$i=1;
					foreach($grades as $grade)
					{ ?>
							<option <?= $result->grade == $grade->grade_name ? 'selected' :'' ?> value="<?=$grade->grade_name?>"><?=$grade->grade_name?></option>
						<?php
						$i++;
					}
				} ?>
			</select>
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-4 control-label">Section:</label>
		<div class="col-md-6">
			<select class="form-control" name='section_id' id="opt_section" required>
				<option value="">Select Section</option>
				<?php if($sections!=NULL)
				{ 
					$i=1;
					foreach($sections as $section)
					{ ?>
							<option <?= $result->section_id == $section->section_id ? 'selected' :'' ?> value="<?=$section->section_id?>"><?=$section->section_name?></option>
						<?php
						$i++;
					}
				} ?>
			</select>
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-4 control-label">Subject:</label>
		<div class="col-md-6">
			<select class="form-control" name='subject_id' id="opt_subject" required>
				<option value="">Select Subject</option>
				<?php if($subjects!=NULL)
				{ 
					$i=1;
					foreach($subjects as $subject)
					{ ?>
							<option <?= $result->subject_id == $subject->subject_id ? 'selected' :'' ?> value="<?=$subject->subject_id?>"><?=$subject->subject_name?></option>
						<?php
						$i++;
					}
				} ?>
			</select>
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-4 control-label">Subject Teacher:</label>
		<div class="col-md-6">
			<select class="form-control" name='employee_id' id='opt_employee_id' required>
				<option value="">Select Teacher</option>
				<?php if($teachers!=NULL)
				{ 
					$i=1;
					foreach($teachers as $teacher)
					{ ?>
							<option <?= $result->employee_id == $teacher->employee_id ? 'selected' :'' ?> value="<?=$teacher->employee_id?>"><?=$teacher->emp_fullname?></option>
						<?php
						$i++;
					}
				} ?>
			</select>
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-4 control-label">Course Pointer Updater:</label>
		<div class="col-md-6">
			<select class="form-control" name='updater' id='opt_updater' required>
				<option value="">Select Updater</option>
				<?php if($teachers!=NULL)
				{ 
					$i=1;
					foreach($teachers as $teacher)
					{ ?>
							<option <?= $result->updater == $teacher->employee_id ? 'selected' :'' ?> value="<?=$teacher->employee_id?>"><?=$teacher->emp_fullname?></option>
						<?php
						$i++;
					}
				} ?>
			</select>
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-4 control-label">Class Time:</label>
		<div class="col-md-6">
			<input class="form-control" name='class_time' value="<?= $result->class_time ?>" id='opt_class_time' placeholder="Class Time" required type="time" />
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-4 control-label">Start Date:</label>
		<div class="col-md-6">
			<input class="form-control date-picker" name='start_date' value="<?= $result->start_date ?>" id='opt_start_date' placeholder="Start Date" required type="text" />
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="form-group form-md-line-input col-md-6">
		<label for="inputPassword12" class="col-md-4 control-label">End Date:</label>
		<div class="col-md-6">
			<input class="form-control date-picker" name='end_date' value="<?= $result->end_date ?>" id='opt_end_date' placeholder="End Date" required type="text" />
			<div class="form-control-focus">
			</div>
		</div>
	</div>
	<div class="clearfix"></div>