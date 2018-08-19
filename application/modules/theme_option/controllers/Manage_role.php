<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_role extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
        if(!check_access('su_admin'))     
		{
			redirect(site_url('login'),'refresh');
			exit;
		}

		$this->load->model('manage_role_model');
	}
	
	public function index()
	{
		$data['addons'] = array(
										    ); 
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load'] = array(
			); 
		$data['script'] = "
									";

		$data['ajax_script'] = array(
			"0" => "$('.edit_opt').click(function(){
      $('#opt_id').val($(this).attr('data-id'));
      $('#usertype').val($(this).attr('data-info'));
  			});"
			);							
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['results'] = $this->manage_role_model->get_role();
		$data['main_content'] = 'manage_role';
		$this->load->view('template',$data);
	}

	public function add()
	{
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->manage_role_model->add();
		}

		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'New Role successfully Added!!');
			redirect(site_url("theme_option/manage_role"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error!! Try Again!!');
			redirect(site_url("theme_option/manage_role"),'refresh');
		}

	}
	public function update()
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->manage_role_model->update();
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Role Updated Successfully!!');
			redirect(site_url("theme_option/manage_role"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error!! Try Again!!');
			redirect(site_url("theme_option/manage_role"),'refresh');
		}
	}
}

/* End of file manage_role.php */
/* Location: ./application/modules/theme_option/controllers/manage_role.php */