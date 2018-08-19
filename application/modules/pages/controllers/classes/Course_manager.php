<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_manager extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('classes/course_manager_model');
		
	}

	public function index()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		//$this->load->model('classes/section_manager_model');
		$this->load->model('control/employee_control_model');
		
		$data['addons']=array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/admin/pages/scripts/table-managed.js",
										    	site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"		
										    ); 
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
			); 
		$data['script']="
				$( '.date-picker' ).datepicker({format: 'yyyy-mm-dd'});
				$('.simple_table').DataTable();
									";
		$data['styles']=array(
		    site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
		    site_url('assets')."/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css",               //requires for file input in a form 
		  );
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
					});
			",
			"1" => "
				$('table').on('click','.edit', function(){
					const id = $(this).attr('data-id');
					$.post('".site_url('pages/classes/course_manager/edit')."', {id: id})
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
			);		
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['batchs']=$this->batch_model->get_batch();
		$data['grades']=$this->grade_manager_model->get_grades();
		$data['teachers']=$this->employee_control_model->get_teachers();
		$data['results']=$this->course_manager_model->get_courses();			
		
		$data['main_content']='classes/course_manager';
		$this->load->view('template',$data);
	}

	public function edit()
	{
		$data['addons']=array(
    	site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"		
    ); 
		$data['script']="
				$( '.date-picker' ).datepicker({format: 'yyyy-mm-dd'});
									";
		$data['styles']=array(
		    site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
		  );

		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('classes/section_manager_model');
		$this->load->model('classes/subject_manager_model');
		$this->load->model('control/employee_control_model');
		
		$class_days_id = trim_post('id');
		
		$data['batchs']=$this->batch_model->get_batch();
		$data['grades']=$this->grade_manager_model->get_grades();
		$data['teachers']=$this->employee_control_model->get_teachers();
		$data['result']=$this->course_manager_model->get_courses_by_id($class_days_id);
		$data['sections']=$this->section_manager_model->get_sections_opt($data['result']->added_batch,$data['result']->grade);
		$data['subjects']=$this->subject_manager_model->get_subject_opt($data['result']->added_batch,$data['result']->grade);
		$data['main_content']='classes/edit_course';
		$this->load->view('ajax_template',$data);
		//$this->load->view('classes/edit_course',$data);
	}

	public function add()
	{
		//print_e($_POST);
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->course_manager_model->add();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Course successfully Added');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/course_manager"),'refresh');
	}

	public function update()
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->course_manager_model->update();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Course Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/course_manager"),'refresh');
	}

	public function delete($id)
	{
		$result=$this->course_manager_model->delete($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Course Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/course_manager"),'refresh');
	}

}

/* End of file Course_manager.php */
/* Location: ./application/modules/pages/controllers/classes/Course_manager.php */
