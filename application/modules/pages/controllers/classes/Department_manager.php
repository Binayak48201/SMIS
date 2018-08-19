<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_manager extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
    check_access(array('su_admin','admin'));  

		$this->load->model('classes/department_manager_model');
	}
	
	public function index()
	{
		$data['addons']=array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/admin/pages/scripts/table-managed.js"			
										    ); 
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
			); 
		$data['script']="
											$('.simple_table').DataTable();
									";
		$data['ajax_script']=array(
			"0" => ""
			);		
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['results']=$this->department_manager_model->get_department();
		$data['main_content']='classes/department_manager';
		$this->load->view('template',$data);
	}

	public function add()
	{
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->department_manager_model->add();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Department successfully Added');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/department_manager"),'refresh');
	}

	public function update()
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->department_manager_model->update(trim_post('id'));
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Department Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/department_manager"),'refresh');
	}
	public function delete($id)
	{
		$result=$this->department_manager_model->delete($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Department Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/department_manager"),'refresh');
	}

}

/* End of file department_manager.php */
/* Location: ./application/modules/pages/controllers/classes/department_manager.php */