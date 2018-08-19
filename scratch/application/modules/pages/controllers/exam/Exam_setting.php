<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_setting extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('exam/exam_setting_model');
	}

	public function index()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');

		$data['addons']=array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    ); 
		$data['styles']=array(
        );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
			); 
		$data['script']='
		$(".simple_table").DataTable({paging: true});
		';

		$data['ajax_script']=array(
			"0" => "
			$('.display_section').change(function(){
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
					"4" => "
						$('#subject').change(function(){
							const batch = $('#batch').val();
							const grade = $('#grade').val();
							const subject = $('#subject').val();
							
							$.post('".site_url('pages/ajax/get_subject_mark')."', {batch: batch, grade: grade, subject: subject})
               .done(function(result) {
               	let obj = jQuery.parseJSON( result );
                $('#full_mark').val(obj.full_marks);
                $('#pass_mark').val(obj.pass_marks);
             	})
             	.fail(function() {
                console.log('error');
             	});
							
						});",
					"1" => "
						$(document).on('click','.edit', function(){
							const id = $(this).attr('data-id');
							$.post('".site_url('pages/exam/exam_setting/edit')."', {id: id})
		         	.done(function(result) {
		                $('#modal-body').html(result);
		         	})
		         	.fail(function() {
		            console.log('error');
		         	});
						});
					",
					"2" => "
							$('#modal-body').on('change','.display_section_opt', function(){
								const batch = $('#opt_batch').val();
								const grade = $('#opt_grade').val();

								if(batch != '' && grade != '')
								{
									$.post('".site_url('pages/ajax/get_section')."', {batch: batch, grade: grade})
		               .done(function(result) {
		                    $('#opt_section').html(result);
		             	})
		             	.fail(function() {
		                console.log('error');
		             	});

		             	$.post('".site_url('pages/ajax/get_subject')."', {batch: batch, grade: grade})
		               .done(function(result) {
		                    $('#opt_subject').html(result);
		             	})
		             	.fail(function() {
		                console.log('error');
		             	});
								}
								else
								{
									$('#opt_section').html('<option value=\"\">Select Sections</option>');
								}
							});
					",
				 '3' => "$('#numeric_value').keyup(function(){
            const num = parseInt($(this).val());
            if(num == 1)
            {
              $('#exam_name').val('First Term');
              $('#average_at').val(20);
            }
            if(num == 2)
            {
              $('#exam_name').val('Second Term');
              $('#average_at').val(20);
            }
            if(num == 3)
            {
              $('#exam_name').val('Third Term');
              $('#average_at').val(40);
            }
           
        });
        ",
        "5" => '
				$("#numeric_value").keyup(function(){
					
					const section = $("#section").val();
					const subject = $("#subject").val();
					const numeric_value = $("#numeric_value").val();
					$.post("'.site_url('pages/ajax/check_exam_number').'", {section: section, subject: subject, numeric_value: numeric_value })
          .done(function(result) {
						if(result == 1)
						{
							$("#submit_setting").attr("disabled","disabled");
							alert("Numeric Value Already Assigned");
						}
						else
						{
							$("#submit_setting").removeAttr("disabled");
						}
         	})
         	.fail(function() {
            console.log("error");
         	});
		
				});
			'
			);		
		$data['batchs'] = $this->batch_model->get_batch();
		$data['grades'] = $this->grade_manager_model->get_grades();					
		$data['exams'] = $this->exam_setting_model->get_exams();	
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'exam/exam_setting';
		$this->load->view('template',$data);
	}

	public function add_exam()
	{
		if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT')
    {
    	$res=$this->exam_setting_model->add_exam();
      if($res)
      {
      	$this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Added Exam');
      }
      else
      {
				$this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Adding Exam');
      }
    }
    redirect(site_url("pages/exam/exam_setting"), 'refresh');
	}

	public function edit()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('classes/section_manager_model');
		$this->load->model('classes/subject_manager_model');
		$this->load->model('control/employee_control_model');
	
		$data['batchs']=$this->batch_model->get_batch();
		$data['grades']=$this->grade_manager_model->get_grades();
		$data['result']=$this->exam_setting_model->get_exam_by_id(trim_post('id'));
		//print_e($data['result']);
		$data['sections']=$this->section_manager_model->get_sections_opt($data['result']->batch,$data['result']->grade);
		$data['subjects']=$this->subject_manager_model->get_subject_opt($data['result']->batch,$data['result']->grade);
		//$this->load->view('exam/edit_exam',$data);
		$data['addons']=array(
													site_url('assets')."/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
										    );
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['main_content']='exam/edit_exam';
		$this->load->view('ajax_template',$data);
	}

	public function delete($id)
	{
		$result=$this->exam_setting_model->delete($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Exam Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/exam/exam_setting"),'refresh');
	}

	public function update()
	{
		$result=FALSE;
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
			$result=$this->exam_setting_model->update();
		
		if($result)
			set_flash('success','Exam Updated Successfully.'); 
		else
			set_flash('error','Database Error, Try Again.'); 

		redirect(site_url("pages/exam/exam_setting"),'refresh');
	}

	public function exam_grades()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');

		$data['addons']=array(
													//site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	//site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    ); 
		$data['styles']=array(
        );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
			); 
		$data['script']="
									";	
		//$data['batchs']=$this->batch_model->get_batch();
		//$data['grades']=$this->grade_manager_model->get_grades();					
		$data['exam_grades']=$this->exam_setting_model->get_exam_grades();					
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['main_content']='exam/exam_grade_setting';
		$this->load->view('template',$data);
	}

	public function add_exam_grade($value='')
	{
		if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT')
		{
			$result = $this->exam_setting_model->add_exam_grade();
			if($result)
				set_flash('success','Exam Grade Added Successfully.'); 
			else
				set_flash('error','Database Error, Try Again.'); 
		}
		redirect(site_url("pages/exam/exam_setting/exam_grades"),'refresh');
	}

	public function update_exam_grade($value='')
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->exam_setting_model->update_exam_grade(trim_post('id'));
			if($result)
				set_flash('success','Exam Grade Updated Successfully.'); 
			else
				set_flash('error','Database Error, Try Again.');
		}
		redirect(site_url("pages/exam/exam_setting/exam_grades"),'refresh');
	}

	public function delete_exam_grade($id)
	{
		$result=$this->exam_setting_model->delete_exam_grade($id);
		if($result)
			set_flash('success','Exam Grade Deleted Successfully.'); 
		else
			set_flash('error','Database Error, Try Again.');
		redirect(site_url("pages/exam/exam_setting/exam_grades"),'refresh');
	}

	public function marksheet_allow()
	{
		/*if($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT' )
		{
			redirect('pages/exam/marks_entry/add/'.trim_post('subject_id'),'refresh');
		}*/

		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('exam/assessment_setting_model');

		$data['addons'] = array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    ); 
		$data['styles'] = array(
        );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load'] = array(
			); 
		$data['script'] = "
									";

		$data['ajax_script'] = array(
			"0" => "
			$('.display_section').change(function(){
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
							$('#section').html('<option value=\"\">Select Sections</option>');
						}
					});",
			"1" => "
			$('#section').change(function(){
				const section = $('#section').val();
				const batch = $('#batch').val();
				$('#exam_id').html('<option>Loading</option>');
				
					$.post('".site_url('pages/ajax/get_exams/final')."', {section: section, batch: batch})
           .done(function(result) {
            $('#exam_id').html(result);
         	})
         	.fail(function() {
            console.log('error');
         	});
				
			});",
      '2' => "
        $('#terminal_opt').submit(function(e){
          e.preventDefault();
          $('#ajax-content').html('<div class=\'alert\'>Loading.</div>');
          $.post('".site_url('pages/exam/exam_setting/view_student_restrict')."', $('#terminal_opt').serialize())
          .done(function(result) {
             $('#ajax-content').html(result);
          })
          .fail(function() {
            console.log('Ajax Error.');
          });
        });
      "
			);		
		$data['batchs'] = $this->batch_model->get_batch();
		$data['grades'] = $this->grade_manager_model->get_grades();					
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'exam/marksheet_allow';
		$this->load->view('template',$data);
	}

	public function view_student_restrict()
	{
		$this->load->model('classes/subject_manager_model');
		$this->load->model('profile/student_model');
		$data['exam_id'] = trim_post('exam_id');
		$data['grade'] = trim_post('grade_id');
		$data['section_id'] = trim_post('section_id');
		$data['batch_id'] = trim_post('batch_id');
		$data['students'] = $this->student_model->get_students(trim_post('section_id'),trim_post('batch_id'),trim_post('grade_id'));
		$this->load->view('exam/view_student_restrict',$data);
	}

	public function st_restrict()
	{
		$result=FALSE;
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
			$result = $this->exam_setting_model->st_restrict();
		
		if($result)
			set_flash('success','List Updated Successfully.'); 
		else
			set_flash('error','Database Error, Try Again.'); 
		
		redirect(site_url("pages/exam/exam_setting/marksheet_allow"),'refresh');
	}

	public function get_active_term($grade)
	{
		return $this->exam_setting_model->get_active_term($grade);
	}
}

/* End of file exam_setting.php */
/* Location: ./application/modules/pages/controllers/exam/exam_setting.php */
