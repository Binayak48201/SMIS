<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->general->is_logged_in())			
		{
			redirect(site_url('pages/home'),'refresh');
			exit;
		}
	}

	public function index()
	{
		$data['theme_option']=$this->theme_model->get_theme_data();
		$this->load->view('login',$data);
	}

	public function validate()
	{
	//print_e('test');
		$data['theme_option']=$this->theme_model->get_theme_data();
		if($this->input->post('login')!= NULL && $this->input->post('login')=='LOGIN')
		{
			$this->load->model('login/login_model');
			$query=$this->login_model->validate_user();

			if($this->login_model->valid_ip())
			{
				if($query){
					$data=array(
					'smis_username' => $query->USER_NAME,
					'smis_logged_in'=> TRUE,
					'smis_role'=>$query->ROLE_NAME,
					'smis_usertype_id'=>$query->ROLE_ID,
					'smis_user_id'=>$query->USER_ID,
					'smis_profile_id'=>$query->PROFILE_ID,
					'smis_error_login'=>0,
					'smis_reset_pass'=> FALSE,
					'smis_login_count'=>$query->VISITS
					);
					if($query->ROLE_ID == 5)
					{
						$data['smis_pic'] = $query->st_pic;
					}
					else
					{
						$data['smis_pic'] = $query->emp_pic;
					}

					if($query->USER_PASSWORD=='0c7540eb7e65b553ec1ba6b20de79608')
					{
						$data['reset_pass']= TRUE;
					}
					$this->session->set_userdata($data);
					redirect(site_url('pages/home'),'refresh');
				}
				else
				{	
					if($this->session->userdata("smis_error_login")==NULL)
					{
						$data['smis_error_login']='1';
					}
					else
					{
						$data['smis_error_login']=$this->session->userdata("smis_error_login")+1;
					}
					$this->session->set_userdata($data);
					
					if($this->session->userdata("smis_error_login")>=7)
					{
						$this->login_model->block_ip();
					}
					
					$data['invalid']=FALSE;
					$data['error']=TRUE;
					$this->load->view('login', $data);
				}
			}
			else
			{
				$data['invalid']=TRUE;
				$data['error']=TRUE;
				$this->load->view('login', $data);
			}
		}
		else
		{
			redirect(site_url('login'),'refresh');
		}
	}
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */