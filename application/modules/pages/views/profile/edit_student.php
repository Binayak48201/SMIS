<!-- BEGIN CONTENT -->

<div class="page-content-wrapper">

  <div class="page-content">    

    <div class="page-bar">

      <ul class="page-breadcrumb">

        <li>

          <i class="fa fa-home"></i>

          <a href="<?= site_url('pages/home') ?>">Home</a>

          <i class="fa fa-angle-right"></i>

        </li>

        <li>

            <a href="#">Profile</a>

            <i class="fa fa-angle-right"></i>

        </li>

        <li>

            <a href="#">Edit Student Profile</a>

        </li>

      </ul>

      <div class="page-toolbar">

        <a href="javascript:history.go(-1)"><div id="dashboard-report-range" class="tooltips btn btn-fit-height btn-sm green-haze btn-dashboard-daterange" data-container="body" data-placement="left">

          Back

        </div></a>

      </div>

    </div>

    <div class="row">

      <div class="col-md-12">

          <!-- BEGIN SAMPLE FORM PORTLET-->

        <div class="portlet light">

          <div class="portlet-title">

            <div class="caption font-green-haze">

                <i class="icon-settings font-green-haze"></i>

                <span class="caption-subject bold uppercase">Edit Student</span>

            </div>

          </div>

          <div style="overflow: hidden;" class="portlet-body">

            <?php display_alert(); ?>

            <form class="margin-bottom-40" method="post" action='<?= site_url('pages/profile/student/update/'.$this->uri->segment(5)); ?>' role="form" enctype="multipart/form-data" >

              <div class="portlet box blue tabbable box-s-none">

                <div class="portlet-body">

                    <div class=" portlet-tabs">

                        <ul class="nav nav-pills cus-nav-pills" style="display: flex">

                          

                          <li class="active" style="flex:1;text-align: center">

                            <a aria-expanded="false" href="#portlet_tab1" data-toggle="tab">

                            Current Academic Info</a>

                          </li>

                          <li class="" style="flex:1;text-align: center">

                            <a aria-expanded="false" href="#portlet_tab2" data-toggle="tab">

                            Personal Information</a>

                          </li>

                          <li class="" style="flex:1;text-align: center">

                            <a aria-expanded="false" href="#portlet_tab4" data-toggle="tab">

                            Parents/Guardian Info</a>

                          </li>

                          <li class="" style="flex:1;text-align: center">

                            <a aria-expanded="true" href="#portlet_tab3" data-toggle="tab">

                            Transportation</a>

                          </li>

                          <li class="" style="flex:1;text-align: center">

                            <a aria-expanded="false" href="#portlet_tab5" data-toggle="tab">

                            Emergency Contact Information</a>

                          </li>

                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="portlet_tab1">

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control display_section" id="batch" required name='joined_batch'>

                                            <option value="">Select Batch</option>

                                            <?php if(isset($batchs) && !empty($batchs))

                                            {

                                                foreach ($batchs as $batch) 

                                                {

                                                    ?>

                                                    <option <?= $batch->batch_name == $student->joined_batch ? 'selected' : '' ?> value="<?= $batch->batch_name ?>" ><?= $batch->batch_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <input type="hidden" name="prev_batch" value="<?=$student->joined_batch?>">

                                        <label >Batch</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control display_section" id="grade" required name='joined_grade_id'>

                                            <option value="">Select Grade</option>

                                            <?php if(isset($grades) && !empty($grades))

                                            {

                                                foreach ($grades as $grade) 

                                                {

                                                    ?>

                                                    <option <?= $grade->grade_name == $student->joined_grade_id ? 'selected' : '' ?>  value="<?= $grade->grade_name ?>" ><?= $grade->grade_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >Grade</label>

                                    </div>

                                </div>

                                

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" id="section" required name='class_id'>

                                            <option value="">Select Section</option>

                                            <?php if(isset($sections) && !empty($sections))

                                            {

                                                foreach ($sections as $section) 

                                                {

                                                    ?>

                                                    <option <?= $section->section_id == $student->class_id ? 'selected' : '' ?> value="<?= $section->section_id ?>" ><?= $section->section_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >Section</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" name='last_school_id'>

                                            <option value="">Select School</option>

                                            <?php if(isset($schools) && !empty($schools))

                                            {

                                                foreach ($schools as $school) 

                                                {

                                                    ?>

                                                    <option <?= $school->school_id == $student->last_school_id ? 'selected' : '' ?> value="<?= $school->school_id ?>" ><?= $school->school_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >Last School Attended</label>

                                    </div>

                                </div>

                                 <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" name='house_id'>

                                            <option value="">Select House</option>

                                            <?php if(isset($houses) && !empty($houses))

                                            {

                                                foreach ($houses as $house) 

                                                {

                                                    ?>

                                                    <option <?= $house->house_id == $student->house_id ? 'selected' : '' ?> value="<?= $house->house_id ?>" ><?= $house->house_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >House</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" required name='boarding_type'>

                                            <option value="">Select Status</option>

                                            <option <?= 'Day Scholar' == $student->boarding_type ? 'selected' : '' ?> value="Day Scholar">Day Scholar</option>

                                            <option <?= 'Boarder' == $student->boarding_type ? 'selected' : '' ?> value="Boarder">Boarder</option>

                                            <option <?= 'Day Boarder' == $student->boarding_type ? 'selected' : '' ?> value="Day Boarder">Day Boarder</option>

                                        </select>

                                        <label >Boarding Type</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='current_roll' value="<?= $student->current_roll ?>" type="text">

                                        <label >Current Roll No</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='registration_number' value="<?= $student->registration_number ?>" type="text">

                                        <label >Registration No.</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-radios">

                                    <label>Dropped Out</label>

                                    <div class="md-radio-inline">

                                      <div class="md-radio">

                                        <input id="radio1" name="dropped_out" value="1" class="md-radiobtn" required <?= $student->dropped_out == "1" ? 'checked' : '' ?> type="radio">

                                        <label for="radio1">

                                        <span class="inc"></span>

                                        <span class="check"></span>

                                        <span class="box"></span>

                                        Yes</label>

                                      </div>

                                      <div class="md-radio">

                                        <input id="radio2" name="dropped_out" value="0" class="md-radiobtn" required <?= $student->dropped_out == "0" ? 'checked' : '' ?> type="radio">

                                        <label for="radio2">

                                        <span class="inc"></span>

                                        <span class="check"></span>

                                        <span class="box"></span>

                                        No </label>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                            </div>



                            <div class="tab-pane " id="portlet_tab2">

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='st_fname' value="<?= $student->st_fname ?>" required type="text">
                                        <input class="form-control" name='st_rollno' value="<?= $student->USER_NAME ?>" required type="hidden">

                                        <label >First Name </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='st_mname' value="<?= $student->st_mname ?>" type="text">

                                        <label >Middle Name </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='st_lname' value="<?= $student->st_lname ?>" required type="text">

                                        <label >Last Name </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='email' value="<?= $student->email ?>" type="email">

                                        <label>Email </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" name='district_id'>

                                            <option value="">Select District</option>

                                            <?php if(isset($districts) && !empty($districts))

                                            {

                                                foreach ($districts as $district) 

                                                {

                                                    ?>

                                                    <option <?= $district->district_id == $student->district_id ? 'selected' : '' ?> value="<?= $district->district_id ?>" ><?= $district->district_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >District</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='home_phone' value="<?= $student->home_phone ?>" type="text">

                                        <label >Home Phone No. </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='home_address' value="<?= $student->home_address ?>" type="text">

                                        <label >Home Address </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='family_number' value="<?= $student->family_number ?>" type="text">

                                        <label >Number of Family Members</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='weight' value="<?= $student->weight ?>" type="text">

                                        <label >Weight</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='height' value="<?= $student->height ?>" type="text">

                                        <label >Height</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='special_needs' value="<?= $student->special_needs ?>" type="text">

                                        <label >Special Needs</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control form-control-inline" id="englishDate9" value="<?= $student->st_dob ?>" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" name='st_dob' type="text">

                                        <label >English Birth Date </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control form-control-inline" id="nepaliDate9" value="<?= $student->st_dob_np ?>" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" name='st_dob_np' type="text">

                                        <label >Nepali Birth Date </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control form-control-inline" value="<?= $student->birth_place ?>" name='birth_place' type="text">

                                        <label >Birth Place </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='birth_mark' value="<?= $student->birth_mark ?>" type="text">

                                        <label >Birth Mark</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" name='blood_group'>

                                            <option value="">Select Type</option>

                                            <option <?= $student->blood_group == "N/A" ? 'selected' : '' ?> value="N/A">N/A</option>

                                            <option <?= $student->blood_group == "A +ve" ? 'selected' : '' ?> value="A +ve">A +ve</option>

                                            <option <?= $student->blood_group == "A -ve" ? 'selected' : '' ?> value="A -ve">A -ve</option>

                                            <option <?= $student->blood_group == "B +ve" ? 'selected' : '' ?> value="B +ve">B +ve</option>

                                            <option <?= $student->blood_group == "B -ve" ? 'selected' : '' ?> value="B -ve">B -ve</option>

                                            <option <?= $student->blood_group == "AB +ve" ? 'selected' : '' ?> value="AB +ve">AB +ve</option>

                                            <option <?= $student->blood_group == "AB -ve" ? 'selected' : '' ?> value="AB -ve">AB -ve</option>

                                            <option <?= $student->blood_group == "O +ve" ? 'selected' : '' ?> value="O +ve">O +ve</option>

                                            <option <?= $student->blood_group == "O +ve" ? 'selected' : '' ?> value="O +ve">O +ve</option>

                                        </select>

                                        <label >Blood Group</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-radios">

                                    <label>Sex</label>

                                    <div class="md-radio-inline">

                                      <div class="md-radio">

                                        <input id="radio6" name="gender" value="Female" class="md-radiobtn" required <?= $student->gender == "Female" ? 'checked' : '' ?> type="radio">

                                        <label for="radio6">

                                        <span class="inc"></span>

                                        <span class="check"></span>

                                        <span class="box"></span>

                                        Female</label>

                                      </div>

                                      <div class="md-radio">

                                        <input id="radio7" name="gender" value="Male" class="md-radiobtn" required <?= $student->gender == "Male" ? 'checked' : '' ?> type="radio">

                                        <label for="radio7">

                                        <span class="inc"></span>

                                        <span class="check"></span>

                                        <span class="box"></span>

                                        Male </label>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-4">

                                    <?php if(file_exists(IMG_UPLOAD_PATH.'/'.$student->picture_path)) { ?>

                                        <img src="<?= site_url('uploads/'.$student->picture_path); ?>?dump=<?=rand()?>" width="125px">

                                    <?php } ?>

                                    <div class="form-group">

                                      <label >Picture </label>

                                      <input class="" name='picture_path' type="file" accept="image/*">

                                      <input value="<?= $student->picture_path ?>" name='prev_picture_path' type="hidden" >

                                      <span class="label label-danger">NOTE: Allowed format *.jpg only</span>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane" id="portlet_tab3">

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" id="bus_id" name='bus_id'>

                                            <option value="">Select Type</option>

                                            <?php if(isset($buses) && !empty($buses))

                                            {

                                                foreach ($buses as $bus) 

                                                {

                                                    ?>

                                                    <option <?= $bus->bus_id == $student->bus_id ? 'selected' : '' ?> value="<?= $bus->bus_id ?>" ><?= $bus->bus_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >Bus</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" id="stop_id" name='stop_id'>

                                            <option value="">Select Type</option>

                                            <?php 

                                            if(isset($stops) && !empty($stops))

                                            {

                                                foreach($stops as $stop){ ?>

                                                    <option <?= $stop->stop_id == $student->stop_id ? 'selected' : '' ?> value="<?= $stop->stop_id ?>"> <?= $stop->stop_name ?> </option>

                                           <?php }

                                            } ?>

                                        </select>

                                        <label >Pick Up Point</label>

                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane" id="portlet_tab4">

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" value="<?= $student->father_name ?>" name='father_name' type="text">

                                        <label >Father Name</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" name='father_occupation_id'>

                                            <option value="">Select Type</option>

                                            <?php if(isset($occupations) && !empty($occupations))

                                            {

                                                foreach ($occupations as $occupation) 

                                                {

                                                    ?>

                                                    <option <?= $student->father_occupation_id == $occupation->occupation_id ? 'selected' : '' ?> value="<?= $occupation->occupation_id ?>" ><?= $occupation->occupation_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >Father Occupation</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                      <input class="form-control" name='father_business_add' value="<?= $student->father_business_add ?>" type="text">

                                      <label >Father Business Address</label>

                                  </div>

                                </div>

                                <div class="col-md-4"> 

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='father_education' value="<?= $student->father_education ?>" type="text">

                                    <label >Father Educational Qualification</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='father_cell' value="<?= $student->father_cell ?>" type="text">

                                    <label >Father Phone</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                      <input class="form-control" name='father_email' value="<?= $student->father_email ?>" type="text">

                                      <label >Father Email</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='mother_name' value="<?= $student->mother_name ?>" type="text">

                                        <label >Mother Name</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" name='mother_occupation_id'>

                                            <option value="">Select Type</option>

                                            <?php if(isset($occupations) && !empty($occupations))

                                            {

                                                foreach ($occupations as $occupation) 

                                                {

                                                    ?>

                                                    <option <?= $student->mother_occupation_id == $occupation->occupation_id ? 'selected' : '' ?> value="<?= $occupation->occupation_id ?>" ><?= $occupation->occupation_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >Mother Occupation</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='mother_business_add' value="<?= $student->mother_business_add ?>" type="text">

                                    <label >Mother Business Address</label>

                                  </div>

                                </div> 

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='mother_education' value="<?= $student->mother_education ?>" type="text">

                                    <label >Mother Educational Qualification</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='mother_cell' value="<?= $student->mother_cell ?>" type="text">

                                    <label >Mother Phone</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                      <input class="form-control" name='mother_email' value="<?= $student->mother_email ?>" type="text">

                                      <label >Mother Email</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <input class="form-control" name='guardian_name' value="<?= $student->guardian_name ?>" type="text">

                                        <label >Guardian Name</label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group form-md-line-input">

                                        <select class="form-control" name='guardian_occupation_id'>

                                            <option value="">Select Type</option>

                                            <?php if(isset($occupations) && !empty($occupations))

                                            {

                                                foreach ($occupations as $occupation) 

                                                {

                                                    ?>

                                                    <option <?= $student->guardian_occupation_id == $occupation->occupation_id ? 'selected' : '' ?> value="<?= $occupation->occupation_id ?>" ><?= $occupation->occupation_name ?></option>

                                                    <?php

                                                }

                                            } ?>

                                        </select>

                                        <label >Guardian Occupation</label>

                                    </div>

                                </div>

                               <!--  <div class="col-md-4">

                                 <div class="form-group form-md-line-input">

                                   <input class="form-control" name='guardian_relation' value="<?= $student->guardian_relation ?>" type="text">

                                   <label >Guardian Relation</label>

                                 </div>

                               </div> -->

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='guardian_phone' value="<?= $student->guardian_phone ?>" type="text">

                                    <label >Guardian Phone</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                      <input class="form-control" name='guardian_email' value="<?= $student->guardian_email ?>" type="text">

                                      <label >Guardian Email</label>

                                  </div>

                                </div>

                            </div>

                            <div class="tab-pane" id="portlet_tab5">

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='emergency_contact' value="<?= $student->emergency_contact ?>" type="text">

                                    <label >Name</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='ec_address' value="<?= $student->ec_address ?>" type="text">

                                    <label >Address</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='ec_phone' value="<?= $student->ec_phone ?>" type="text">

                                    <label >Phone</label>

                                  </div>

                                </div>

                                <div class="col-md-4">

                                  <div class="form-group form-md-line-input">

                                    <input class="form-control" name='ec_relation' value="<?= $student->ec_relation ?>" type="text">

                                    <label >Relation</label>

                                  </div>

                                </div>

                            </div>

                            <div class="form-group">

                                <div class="col-md-offset-2 col-md-10">

                                    <button name="update" value='UPDATE' class="btn blue" type='submit'>Update</button>

                                     <button name="reset"  class="btn red" type='reset'>Reset</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            </form>



          </div>

        </div>

      </div>

        <!-- END SAMPLE FORM PORTLET-->

    </div>

  </div>

</div>

