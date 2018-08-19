<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test2 extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
//modules::run('dashboard/user_log/log');
		
	}

	public function index()
	{
		echo modules::run("search_bar/by_batch/index/");
		$data['test']['error']='hello';
		$this->session->set_userdata($data);
		$data['main_content']='test';
		$this->load->view('template',$data);
	}

	public function home()
	{
		//exit();
		echo'testing home';
	}

}

/* End of file test.php */
/* Location: ./application/controllers/test.php */