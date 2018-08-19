<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Student extends MX_Controller {



	public function __construct()

	{

		parent::__construct();

		modules::run('dashboard/user_log/log');

    check_access();   

		$this->load->model('profile/student_model');

	}



	public function add()

	{

		$this->load->model('general_content/district_model');

		$this->load->model('general_content/occupation_model');

		$this->load->model('general_content/school_model');

		$this->load->model('general_content/transportation_model');

		$this->load->model('classes/batch_model');

		$this->load->model('classes/grade_manager_model');

		$this->load->model('classes/section_manager_model');

		$this->load->model('classes/house_manager_model');



		$data['styles'] = array(

            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",

            );



    $data['addons'] = array(

        site_url('assets')."/global/plugins/select2/select2.min.js",

        site_url('assets')."/global/plugins/jquery-validation/js/jquery.validate.min.js",               //required  for datepicker

        site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",       //required  for datepicker

        site_url('assets')."/admin/pages/scripts/form-validation.js",

        site_url('assets')."/global/plugins/nepali-datepicker/nepali.datepicker.v2.min.js" 

        );



		$data['ajax_script'] = array(

			"0" => "

					$('#bus_id').change(function(){

						const bus_id = $(this).val();



						 $.post('".site_url('pages/ajax/get_bus_stop')."', {bus_id: bus_id})

             .done(function(result) {

                  $('#stop_id').html(result);

             })

             .fail(function() {

                console.log('error');

             })

					});

			",

			"1" => "$('.display_section').change(function(){

						const batch = $('#batch').val();

						const grade = $('#grade').val();



						if(batch != '' && grade != '')

						{

							$.post('".site_url('pages/ajax/get_section')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#section').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});



             	$.post('".site_url('pages/ajax/get_subject')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#subject').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});

						}

						else

						{

							$('#section').html('<option value=\"\">Select Sections</option>');

						}

					});",

					'2' => "$('#englishDate9').change(function(){

                    $('#nepaliDate9').val(AD2BS($('#englishDate9').val()));

                });",



          '3' => "$('#nepaliDate9').change(function(){

                $('#englishDate9').val(BS2AD($('#nepaliDate9').val()));

            });",

          '4' => "$('#joined_date').change(function(){

                    $('#joined_date_np').val(AD2BS($('#joined_date').val()));

                });",

          '5' => "$('#joined_date_np').change(function(){

                $('#joined_date').val(BS2AD($('#joined_date_np').val()));

            });"

			);			

		$data['script'] = "

										$( '.date-picker' ).datepicker({format: 'yyyy-mm-dd'});

								";	





		$data['theme_option'] = $this->theme_model->get_theme_data();

		$data['districts'] = $this->district_model->get_district();

		$data['grades'] = $this->grade_manager_model->get_grades();

		//$data['sections'] = $this->section_manager_model->get_session_sections();

		$data['batchs'] = $this->batch_model->get_batch();

		$data['schools'] = $this->school_model->get_school();

		$data['houses'] = $this->house_manager_model->get_house();

		$data['buses'] = $this->transportation_model->transportation_list();

		$data['occupations'] = $this->occupation_model->get_occupation();

		$data['main_content'] = 'profile/add_student';

		$this->load->view('template',$data);

	}



	public function insert()

	{

	 	if(trim_post('submit')!=NULL && trim_post('submit')=='SUBMIT')

    {

    	

    	$res=$this->student_model->add_student();

      if($res)

      	set_flash('success','Succesfully Added Student');

      else

      	set_flash('error','ERROR Occured while Adding Student');

      redirect(site_url("pages/profile/student/add"), 'refresh');

    }

	}



	public function update($st_id)

	{

	 	if(trim_post('update')!=NULL && trim_post('update')=='UPDATE')

    {

    	$upload_error = FALSE;

    	$prev = trim_post('prev_picture_path');

    	$picture = $prev;

    	if(isset($_FILES['picture_path']) && is_uploaded_file($_FILES['picture_path']['tmp_name']))

	    {

	    	$pic_name = trim_post('st_rollno');	

	    	delete_file($prev);

	      $stat=$this->general->upload('picture_path','gif|jpg|png',$pic_name,'student_photo'); // form->name, ext, file name, folder

	      if($stat['status']==TRUE)

	      {

	        $picture=$stat['result'];

	      }

	      else

	      {

	        set_flash('error',$stat['result']);

	        redirect(site_url("pages/profile/student/edit/".$st_id), 'refresh');

	      }

	    }

	    //print_e($picture);

    	$res = $this->student_model->update_student($st_id, $picture);

      if($res)

      	set_flash('success','Succesfully Updated Student Profile');

      else

      	set_flash('error','ERROR Occured while Updating');

    }

    redirect(site_url("pages/profile/student/edit/".$st_id), 'refresh');

	}



	public function delete($employee_id)

	{

		$res = $this->student_model->delete($employee_id);

		if($res)

    	set_flash('success','Succesfully Deleted Student Profile.'); 

    else

    	set_flash('error','ERROR Occured while Deleting.');

    redirect(site_url("pages/control/employee_control"), 'refresh');

	}





	public function manage()

  {

		$this->load->model('classes/batch_model');

		$this->load->model('classes/grade_manager_model');

		$this->load->model('classes/section_manager_model');



		



    $data['addons'] = array(

       site_url('assets')."/global/plugins/select2/select2.min.js",

      ); 

    /*

    required js plugins Functions to run script for the page

     */

    $data['addons_load'] = array(

      ); 

    

   $data['ajax_script'] = array(			

			"0" => "$('.display_section').change(function(){

						const batch = $('#batch').val();

						const grade = $('#grade').val();



						if(batch != '' && grade != '')

						{

							$.post('".site_url('pages/ajax/get_section')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#section').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});



             	$.post('".site_url('pages/ajax/get_subject')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#subject').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});

						}

						else

						{

							$('#section').html('<option value=\"\">Select Section</option>');

						}

					});"

			);			

		$data['script'] = "";		



    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')

    {



      $data['sbatch'] = trim_post('batch');

      $data['sgrade'] = trim_post('grade');

      $data['ssection'] = trim_post('section_id');

			$data['sections'] = $this->section_manager_model->get_sections_opt($data['sbatch'], $data['sgrade']);

			$data['students'] = $this->student_model->get_all_students($data['ssection']);

    }

		$data['grades'] = $this->grade_manager_model->get_grades();

		$data['batchs'] = $this->batch_model->get_batch();

    $data['theme_option'] = $this->theme_model->get_theme_data();

    $data['main_content'] = 'profile/manage_student';

    $this->load->view('template',$data);

  }

	

	public function edit($st_id = '')

	{

		$this->load->model('general_content/district_model');

		$this->load->model('general_content/occupation_model');

		$this->load->model('general_content/school_model');

		$this->load->model('general_content/transportation_model');

		$this->load->model('classes/batch_model');

		$this->load->model('classes/grade_manager_model');

		$this->load->model('classes/section_manager_model');

		$this->load->model('classes/house_manager_model');

		$this->load->model('ajax_model');



		$data['styles'] = array(

            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",

            );



    $data['addons'] = array(

        site_url('assets')."/global/plugins/select2/select2.min.js",

        site_url('assets')."/global/plugins/jquery-validation/js/jquery.validate.min.js",               //required  for datepicker

        site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",       //required  for datepicker

        site_url('assets')."/admin/pages/scripts/form-validation.js",
        site_url('assets')."/global/plugins/nepali-datepicker/nepali.datepicker.v2.min.js" 

        );



		$data['ajax_script'] = array(

			"0" => "

					$('#bus_id').change(function(){

						const bus_id = $(this).val();



						 $.post('".site_url('pages/ajax/get_bus_stop')."', {bus_id: bus_id})

             .done(function(result) {

                  $('#stop_id').html(result);

             })

             .fail(function() {

                console.log('error');

             })

					});

			",

			"1" => "$('.display_section').change(function(){

						const batch = $('#batch').val();

						const grade = $('#grade').val();



						if(batch != '' && grade != '')

						{

							$.post('".site_url('pages/ajax/get_section')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#section').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});



             	$.post('".site_url('pages/ajax/get_subject')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#subject').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});

						}

						else

						{

							$('#section').html('<option value=\"\">Select Sections</option>');

						}

					});",
			'2' => "$('#englishDate9').change(function(){

                $('#nepaliDate9').val(AD2BS($('#englishDate9').val()));

            });",



      '3' => "$('#nepaliDate9').change(function(){

            $('#englishDate9').val(BS2AD($('#nepaliDate9').val()));

        });",

      '4' => "$('#joined_date').change(function(){

                $('#joined_date_np').val(AD2BS($('#joined_date').val()));

            });",

      '5' => "$('#joined_date_np').change(function(){

            $('#joined_date').val(BS2AD($('#joined_date_np').val()));

        });"

			);			

		$data['script']="

										$( '.date-picker' ).datepicker({format: 'yyyy-mm-dd'});

								";				

		$data['student'] = $this->student_model->get_st_id($st_id);

		$data['theme_option'] = $this->theme_model->get_theme_data();

		$data['districts'] = $this->district_model->get_district();

		$data['grades'] = $this->grade_manager_model->get_grades();

		$data['sections'] = $this->section_manager_model->get_sections_opt($data['student']->joined_batch, $data['student']->joined_grade_id);

		$data['batchs'] = $this->batch_model->get_batch();

		$data['schools'] = $this->school_model->get_school();

		$data['houses'] = $this->house_manager_model->get_house();

		$data['buses'] = $this->transportation_model->transportation_list();

		$data['stops'] =  $this->ajax_model->get_bus_stop($data['student']->bus_id);

		$data['occupations'] = $this->occupation_model->get_occupation();

		$data['main_content'] = 'profile/edit_student';

		$this->load->view('template',$data);

	}



	public function class_reassign()

  {

		$this->load->model('classes/batch_model');

		$this->load->model('classes/grade_manager_model');

		$this->load->model('classes/section_manager_model');



		



    $data['addons'] = array(

       site_url('assets')."/global/plugins/select2/select2.min.js",

      ); 

    /*

    required js plugins Functions to run script for the page

     */

    $data['script'] = "";

    

   $data['ajax_script'] = array(			

			"0" => "$('.display_section').change(function(){

						const batch = $('#batch').val();

						const grade = $('#grade').val();



						if(batch != '' && grade != '')

						{

							$.post('".site_url('pages/ajax/get_section/all')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#section').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});

						}

						else

						{

							$('#section').html('<option value=\"\">Select Section</option>');

						}

					});",

			"1" => "$('#assign_all').change(function()

          { 

           if($(this).prop('checked') == true)

           {

              $('.st_check').prop('checked', true);

           }

           else

           {

              $('.st_check').prop('checked', false);

           }

          });",

      "2" => "$('.re_display_section').change(function(){

						const batch = $('#re_batch').val();

						const grade = $('#re_grade').val();



						if(batch != '' && grade != '')

						{

							$.post('".site_url('pages/ajax/get_section/')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#re_section').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});

						}

						else

						{

							$('#re_section').html('<option value=\"\">Select Section</option>');

						}

					});",

			);			



    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')

    {



      $data['sbatch'] = trim_post('batch');

      $data['sgrade'] = trim_post('grade');

      $data['ssection'] = trim_post('section_id');

			$data['sections'] = $this->section_manager_model->get_sections_opt($data['sbatch'], $data['sgrade']);

			$data['students'] = $this->student_model->get_students($data['ssection'],$data['sbatch'],$data['sgrade']);

    }

		$data['grades'] = $this->grade_manager_model->get_grades();

		$data['batchs'] = $this->batch_model->get_batch();

    $data['theme_option'] = $this->theme_model->get_theme_data();

    $data['main_content'] = 'profile/reassign_student';

    $this->load->view('template',$data);

  }



	public function update_class_reassign()

  {

  	if(trim_post('reassign')!=NULL && trim_post('reassign')=='REASSIGN')

    {

	  	$res = $this->student_model->class_reassign();

			if($res)

	    	set_flash('success','Succesfully Reassigned Student Class.'); 

	    else

	    	set_flash('error','ERROR Occured while Updating.'); 

	  }

    redirect(site_url("pages/profile/student/class_reassign"), 'refresh');

  }



	public function roll_no_reassign()

  {

		$this->load->model('classes/batch_model');

		$this->load->model('classes/grade_manager_model');

		$this->load->model('classes/section_manager_model');



		



    $data['addons'] = array(

       site_url('assets')."/global/plugins/select2/select2.min.js",

      ); 

    /*

    required js plugins Functions to run script for the page

     */

    $data['addons_load'] = array(

      ); 

    

   $data['ajax_script'] = array(			

			"0" => "$('.display_section').change(function(){

						const batch = $('#batch').val();

						const grade = $('#grade').val();



						if(batch != '' && grade != '')

						{

							$.post('".site_url('pages/ajax/get_section/all')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#section').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});



             	$.post('".site_url('pages/ajax/get_subject')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#subject').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});

						}

						else

						{

							$('#section').html('<option value=\"\">Select Section</option>');

						}

					});"

			);			

		$data['script'] = "";		



    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')

    {



      $data['sbatch'] = trim_post('batch');

      $data['sgrade'] = trim_post('grade');

      $data['ssection'] = trim_post('section_id');

			$data['sections'] = $this->section_manager_model->get_sections_opt($data['sbatch'], $data['sgrade']);

			$data['students'] = $this->student_model->get_students($data['ssection'],$data['sbatch'],$data['sgrade']);

    }

		$data['grades'] = $this->grade_manager_model->get_grades();

		$data['batchs'] = $this->batch_model->get_batch();

    $data['theme_option'] = $this->theme_model->get_theme_data();

    $data['main_content'] = 'profile/roll_no_reassign';

    $this->load->view('template',$data);

  }



  public function update_st_roll()

  {

  	if(trim_post('update')!=NULL && trim_post('update')=='Update')

    {

	  	$res = $this->student_model->update_st_roll();

			if($res)

	    	set_flash('success','Succesfully Updated Student Roll Number.'); 

	    else

	    	set_flash('error','ERROR Occured while Updating.'); 

	  }

    redirect(site_url("pages/profile/student/roll_no_reassign"), 'refresh');

  }



  public function bulk_edit()

  {

		$this->load->model('classes/batch_model');

		$this->load->model('classes/grade_manager_model');

		$this->load->model('classes/section_manager_model');



		



    $data['addons'] = array(

       site_url('assets')."/global/plugins/select2/select2.min.js",

      ); 

    /*

    required js plugins Functions to run script for the page

     */

    $data['addons_load'] = array(

      ); 

    

   $data['ajax_script'] = array(			

			"0" => "$('.display_section').change(function(){

						const batch = $('#batch').val();

						const grade = $('#grade').val();



						if(batch != '' && grade != '')

						{

							$.post('".site_url('pages/ajax/get_section/all')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#section').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});



             	$.post('".site_url('pages/ajax/get_subject')."', {batch: batch, grade: grade})

               .done(function(result) {

                    $('#subject').html(result);

             	})

             	.fail(function() {

                console.log('error');

             	});

						}

						else

						{

							$('#section').html('<option value=\"\">Select Section</option>');

						}

					});"

			);			

		$data['script'] = "";		



    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')

    {



      $data['sbatch'] = trim_post('batch');

      $data['sgrade'] = trim_post('grade');

      $data['ssection'] = trim_post('section_id');

			$data['sections'] = $this->section_manager_model->get_sections_opt($data['sbatch'], $data['sgrade']);

			$data['students'] = $this->student_model->get_students($data['ssection'],$data['sbatch'],$data['sgrade']);

    }

		$data['grades'] = $this->grade_manager_model->get_grades();

		$data['batchs'] = $this->batch_model->get_batch();

    $data['theme_option'] = $this->theme_model->get_theme_data();

    $data['main_content'] = 'profile/st_bulk_edit';

    $this->load->view('template',$data);

  }



  public function update_bulk_st()

  {

  	if(trim_post('update')!=NULL && trim_post('update')=='Update')

    {

	  	$res = $this->student_model->update_bulk_st();

			if($res)

	    	set_flash('success','Succesfully Updated Information.'); 

	    else

	    	set_flash('error','ERROR Occured while Updating.');

	  }

    redirect(site_url("pages/profile/student/bulk_edit"), 'refresh');

  }



  public function details($st_id)

  {

  	$data['styles'] = array(

                          site_url('assets') . "/global/plugins/simple-line-icons/simple-line-icons.min.css",   

                          site_url('assets') . "/admin/layout2/css/print.css",   

                           

                        );

  	$this->load->model('ajax_model');

  	$this->load->model('profile/evaluation_model');

  	$this->load->model('classes/course_manager_model');

  	$data['results'] = $this->student_model->get_st_details($st_id);

  		$data['ajax_script'] = array(

			"0" => "

					$('.pop').click(function(){

						const text = $(this).attr('data-id');

						const st_id = ".$st_id.";

						$('#caption').text(text);

						 $.post('".site_url('pages/ajax/profile_data')."', {text: text,st_id: st_id})

             .done(function(result) {

                  $('#modal-body').html(result);

             })

             .fail(function() {

                console.log('error');

             })

					});

			",

			"1" => "

					$('.st_evaluation').click(function(){

						const exam_id = $(this).attr('data-id');

						const section_id = $(this).attr('data-section-id');

						const caption = $(this).attr('data-caption');

						const st_id = ".$st_id.";

						$('#eval_caption').text(caption);

						$.get('".site_url('pages/ajax/st_evaluation')."', {exam_id: exam_id,st_id: st_id,section_id:section_id})

             .done(function(result) {

                  $('#st_evaluation_body').html(result);

             })

             .fail(function() {

                console.log('error');

             })

					});

			",

			"2" => "

					$('.pt_evaluation').click(function(){

						const exam_id = $(this).attr('data-id');

						const section_id = $(this).attr('data-section-id');

						const caption = $(this).attr('data-caption');

						const st_id = ".$st_id.";

						$('#pt_eval_caption').text(caption);

						$.get('".site_url('pages/ajax/pt_evaluation')."', {exam_id: exam_id,st_id: st_id,section_id:section_id})

             .done(function(result) {

                  $('#pt_evaluation_body').html(result);

             })

             .fail(function() {

                console.log('error');

             })

					});

			",

			"3" => "

					$('.sst_evaluation').click(function(){

						const exam_id = $(this).attr('data-id');

						const subject_id = $(this).attr('data-subject-id');

						const caption = $(this).attr('data-caption');

						const st_id = ".$st_id.";

						$('#sst_eval_caption').text(caption);

						$.get('".site_url('pages/ajax/sst_evaluation')."', {exam_id: exam_id,st_id: st_id,subject_id:subject_id})

             .done(function(result) {

                  $('#sst_evaluation_body').html(result);

             })

             .fail(function() {

                console.log('error');

             })

					});

			",

			 '4' => "$('.class_routine').click(function(){

	        const section_id = $(this).attr('data-id');

	        $.post('".site_url('pages/ajax/get_class_routine')."', {section_id: section_id})

	        .done(function(result) {

	          $('#class_Routine').html(result);

	        })

	        .fail(function() {

	          console.log('error');

	        });

	      });",

     '5' => "$('.feedback_view').click(function(){

	        const class_days_id = $(this).attr('data-id');

	        const student_id = $(this).attr('data-st-id');

	        const caption = $(this).attr('data-caption');

					$('#feedback_caption').text(caption);

	        $.get('".site_url('pages/ajax/get_st_feedback')."', {class_days_id: class_days_id, student_id: student_id})

	        .done(function(result) {

	          $('#feedback-modal-body').html(result);

	        })

	        .fail(function() {

	          console.log('error');

	        });

	      });"

     

			);

		

			$data['jscript']="



        function printDiv(divID) {

        var mywindow = window.open('', 'PRINT', 'height=700,width=900');



        mywindow.document.write('<html><head><title>' + document.title  + '</title>');

        //mywindow.document.write('<link href=\"".site_url('assets')."/global/plugins/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\"/>'); 

        mywindow.document.write('<link href=\"".site_url('assets')."/admin/layout2/css/print.css\" rel=\"stylesheet\" type=\"text/css\"/>');

        mywindow.document.write('</head><body >');

        mywindow.document.write(document.getElementById(divID).innerHTML);

        mywindow.document.write('</body></html>');



        mywindow.document.close(); // necessary for IE >= 10

        mywindow.focus(); // necessary for IE >= 10*/



        mywindow.print();

       	//mywindow.close();



        return true;

        }

      ";

						

		$data['theme_option'] = $this->theme_model->get_theme_data();

		$data['exams'] = $this->ajax_model->get_exams($data['results']->section_id);

		$data['st_evaluations'] = $this->evaluation_model->get_st_evaluation_head($data['results']);

		$data['pt_evaluations'] = $this->evaluation_model->get_pt_evaluation_head($data['results']);

		$data['courses'] = $this->course_manager_model->get_st_classes($data['results']);

		$data['sst_evaluations'] = $this->evaluation_model->get_sst_evaluation_head($data['results']);

		$data['main_content'] = 'profile/student_detail';

		$this->load->view('template',$data);

  }



  public function find()

	{

    if(trim_post('search')!=NULL && trim_post('search')=='SEARCH')

    {

    	$key = preg_replace('/[^A-Za-z0-9\-]\s+/', '', trim_post('key'));

      $data['results']=$this->student_model->find_student(trim_post('find_by'),$key);

      $data['searched']=TRUE;

    }

    $data['theme_option']=$this->theme_model->get_theme_data();

    $data['main_content']='profile/find_student';

    $this->load->view('template',$data);

	}



}



/* End of file Student.php */

/* Location: ./application/modules/pages/controllers/profile/Student.php */