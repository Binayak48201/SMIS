<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_menu extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
		check_access();
		$this->load->model('theme_option/manage_menu_model');
	}

	public function index()
	{
		/*
		required js plugins of script for the page
		 */
		$data['addons']=array(
				site_url('assets')."/admin/pages/scripts/ui-nestable.js",
				site_url('assets')."/global/plugins/jquery-nestable/jquery.nestable.js",
			); 
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
				"UINestable.init();",
			); 

		$data['script']="
											$('#nestable_list_1').nestable({
               					group: 1
            					}).on('change', function(){
              						$('.save_menu').show();
            						});
									";
		$this->load->model('menu/menu_model');
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['menus']=$this->menu_model->get_menu();														//to display menu ie jason value
		$data['menu_list']=$this->menu_model->get_menu_list();									//to display menu list
		$data['user_type']=$this->manage_menu_model->get_user_type();						//pssing value to view to display usrt type checkbox
		$data['main_content']='menu';
		$this->load->view('template',$data);
	}

	public function edit($id)
	{
		/*
		required js plugins of script for the page
		 */
		$data['addons']=array(
				site_url('assets')."/admin/pages/scripts/ui-nestable.js",
				site_url('assets')."/global/plugins/jquery-nestable/jquery.nestable.js",
			); 
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
				"UINestable.init();",
			); 
		
		$this->load->model('menu/menu_model');
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['menus']=$this->menu_model->get_menu();														//to display menu ie jason value
		$data['menu_list']=$this->menu_model->get_menu_list();									//to display menu list
		$data['user_type']=$this->manage_menu_model->get_user_type();						//pssing value to view to display usrt type checkbox
		$data['result']=$this->manage_menu_model->edit_menu($id);								//passidata to the view getting by id
		$data['main_content']='edit_menu';
		$this->load->view('template',$data);
	}

	public function add_menu_list()
	{
		$this->load->model('menu/menu_model');
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$menus=$this->menu_model->get_menu();
			//$this->manage_menu_model->add_menu($menus->menu);
			$result=$this->manage_menu_model->add_menu_list($menus->menu);
		}
		
		redirect(site_url('theme_option/manage_menu'),'refresh');
		exit;
	}

	public function update_menu_list()
	{
		if($this->input->post('save_menu')!=NULL && $this->input->post('save_menu')=='SAVE')
		{
			$result=$this->manage_menu_model->save_menu($this->input->post('menus'));
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Menu List Succesfully Updated!!');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error!! Try Again!!');
		}
		
		redirect(site_url('theme_option/manage_menu'),'refresh');
		exit;
	}
	public function update_menu($id)
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=="UPDATE")
		{
			$result=$this->manage_menu_model->update_menu($id);
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Menu Succesfully Updated!!');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error!! Try Again!!');
		}
		
		redirect(site_url('theme_option/manage_menu/edit/'.$id),'refresh');
		exit;
	}

}

/* End of file menu.php */
/* Location: ./application/modules/theme_option/controllers/menu.php */