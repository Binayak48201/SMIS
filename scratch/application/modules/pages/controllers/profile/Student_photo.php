<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_photo extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
    check_access(array('su_admin','admin'));     
		
		$this->load->model('profile/student_photo_model');
	}

	public function index()
	{
	 	$data['styles']=array(
    site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css",               //requires for file input in a form 
      );

	  $data['addons']=array(
		  	// site_url('assets')."/global/plugins/select2/select2.min.js",
        site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js",                //required to load custom functions
      );

		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['main_content']='profile/student_photo';
		$this->load->view('template',$data);
	}

	public function verify()
	{
		$data['styles']=array(
    site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css",               //requires for file input in a form 
      );

	  $data['addons']=array(
		  	 site_url('assets')."/global/plugins/select2/select2.min.js",
        site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js",                //required to load custom functions
      );

	  if($this->input->post('verify')!=NULL && $this->input->post('verify')=='VERIFY')
	  {
	  	$data['results']=$this->student_photo_model->verify();
	  	$data['fileanme']=$_FILES['student_photo']['name'];
	  }
	  else
	  {
	  	redirect(site_url("pages/profile/student_photo"),'refresh');
	  }
	  
		
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['main_content']='profile/student_photo';
		$this->load->view('template',$data);
	}

	public function upload()
	{
		if($this->input->post('upload')!=NULL && $this->input->post('upload')=='UPLOAD')
	  {
	  	$ext=$this->general->extract_zip('student_photo','student');
			$this->session->set_flashdata('error', $ext['error']);
			$this->session->set_flashdata('alert_msg', $ext['message']);
	  }
	  redirect(site_url("pages/profile/student_photo"),'refresh');
	}

}

/* End of file student_photo.php */
/* Location: ./application/modules/pages/controllers/profile/student_photo.php */