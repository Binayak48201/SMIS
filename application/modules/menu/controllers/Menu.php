<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MX_Controller {

	public function index()
	{
		$this->load->model('menu/menu_model');
		$data['main_content']='menu';
		$data['menus']=$this->menu_model->get_menu();
		$data['menu_list']=$this->menu_model->get_menu_list();
		$this->load->view('template',$data);
	}

}

/* End of file menu.php */
/* Location: ./application/modules/menu/controllers/menu.php */