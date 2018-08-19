<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_info extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
		if(!$this->general->is_logged_in() || !$this->menu_model->is_allowed())			
		{
			redirect(site_url('login'),'refresh');
			exit;
		}
	}

	public function index()
	{
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['main_content']='site_info';
		$this->load->view('template',$data);
	}

	public function update_info()
	{
		$logo='';
		$error=FALSE;
		$fileErrorMessage = '';
		if(isset($_FILES['logo']) && is_uploaded_file($_FILES['logo']['tmp_name']))
		{
			$response=$this->general->upload('logo','gif|jpg|png','logo'); // form->name, ext, fileName, folder
			if($response['status'])
			{
				$logo=$response['result'];
				if($this->input->post('pre_logo')!='')
				{
					unlink(IMG_UPLOAD_PATH."/".$this->input->post('pre_logo'));
				}
			}
			else
			{
				$fileErrorMessage = 'Invalid file: '.$response['result'];
				$error=TRUE;
			}
		}
		if(!$error)
		{
			$result=$this->theme_model->update_info($logo);
		}
		else
		{
			$result=FALSE;
		}

		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Succesfully Updated Information');
			redirect(site_url("theme_option/site_info"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'ERROR Occured while Updating Information<br/>'.$fileErrorMessage);
			redirect(site_url("theme_option/site_info"),'refresh');
		}

	}

}

/* End of file Site_Info.php */
/* Location: ./application/modules/theme_option/controllers/Site_Info.php */