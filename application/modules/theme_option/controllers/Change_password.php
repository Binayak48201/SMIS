<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
		if(!$this->general->is_logged_in())			
		{
			redirect(site_url('login'),'refresh');
			exit;
		}
	}

	public function index()
	{
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['main_content']='change_password';
		$this->load->view('template',$data);
	}

	public function update()
	{
		$this->load->model('login/login_model');
		if($this->login_model->check_pass())
		{
			$result=$this->login_model->update_pass();
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Invalid Password');

			redirect(site_url("theme_option/change_password"),'refresh');
		}
		//$data['error']=$this->login_model->validate_user();
		if($result)
		{
			$datap['reset_pass']= FALSE;
					
			$this->session->set_userdata($datap);

			$this->session->set_flashdata('error', False);
			$this->session->set_flashdata('alert_msg', 'Password Changed Successfuly');
			redirect(site_url("theme_option/change_password"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error');
			redirect(site_url("theme_option/change_password"),'refresh');
		}
		
	}

}

/* End of file change_password.php */
/* Location: ./application/modules/theme_option/controllers/change_password.php */