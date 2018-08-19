<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_manager extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('classes/class_manager_model');
		$this->load->model('classes/section_manager_model');
	}

	public function index()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('control/employee_control_model');
		$data['addons']=array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",		
										    	site_url('assets')."/global/plugins/ckeditor/ckeditor.js",	
										    ); 
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(

			); 
		$data['script']="
											//$('.simple_table').DataTable();
									";
		$data['ajax_script']=array(
			"0" => "$('.manage_routine').click(function(){
					const section_id = $(this).attr('data-info');
					$('#manage_routine').html('<p>Loading..</p>');
					$.post('".site_url('pages/classes/class_manager/get_routine')."', {section_id: section_id})
         	.done(function(result) {
                $('#manage_routine').html(result);
         	})
         	.fail(function() {
            console.log('error');
         	});

				});
				"
			);	

		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['batchs']=$this->batch_model->get_batch();
		$data['grades']=$this->grade_manager_model->get_grades();
		$data['teachers']=$this->employee_control_model->get_teachers();
		$data['results']=$this->section_manager_model->get_sections_with_teacher();
		$data['main_content']='classes/class_manager';
		$this->load->view('template',$data);
	}

	public function update()
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->class_manager_model->update();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Class Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/class_manager"),'refresh');
	}

	public function manage_routine($section_id)
  {
    //$data['results'] = $this->ajax_model->get_topics(trim_post('class_days_id'), trim_post('ch_id'));
    $data['theme_option']=$this->theme_model->get_theme_data();
    $data['addons']=array(
													site_url('assets')."/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
													 site_url('assets')."/global/plugins/ckeditor/ckeditor.js",  
										    );
    $data['main_content']='classes/manage_routine';
    $data['results'] = $this->class_manager_model->get_routine($section_id);
    $this->load->view('template',$data);
  }

	public function add_routine($section_id)
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->class_manager_model->add_routine($section_id);
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Class Routine saved Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/class_manager"),'refresh');
	}

	public function update_routine($section_id)
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->class_manager_model->update_routine($section_id);
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Class Routine saved Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/class_manager"),'refresh');
	}

}

/* End of file Class_manager.php */
/* Location: ./application/modules/pages/controllers/classes/Class_manager.php */