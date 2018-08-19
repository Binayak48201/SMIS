<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MX_Controller {

	public function index()
	{
		$this->session->sess_destroy();
		redirect(site_url('login'),'refresh');
	}

}

/* End of file logout.php */
/* Location: ./application/modules/admin/controllers/logout.php */