<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
        modules::run('dashboard/user_log/log');
        check_access();
        $this->load->model('theme_option/manage_menu_model');
        $this->load->model('pages/notification_model');
	}
	public function index()
	{
		$data['theme_option'] = $this->theme_model->get_theme_data();

	    $data['addons'] = array(
            site_url('assets') . "/global/plugins/datatables/media/js/jquery.dataTables.min.js",
            site_url('assets') . "/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
	    );

	    $data['styles'] = array(
	        site_url('assets') . "/global/plugins/select2/select2.css",
	    );
	    $data['addons_load'] = array(

	    );
        $data['script'] = "
                        $('.simple_table').DataTable();
                    ";
	    $data['result1']=$this->manage_menu_model->get_user_type();
	    $data['main_content']='pages/notification';
        $this->load->view('template',$data);
	}	
	public function add_msg()
	{
		if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT') 
		{
            $result=$this->notification_model->add_notification();
            if($result)
               set_flash('success','Notification Added Succesfully.'); 
	        else 
	            set_flash('error','Error Occured while Adding Notification.');
    	}
        	redirect(site_url("pages/notification"),'refresh');
  }
  public function manage_notification()
  {

  	$data['theme_option'] = $this->theme_model->get_theme_data();

        $data['addons'] = array(
            site_url('assets') . "/global/plugins/datatables/media/js/jquery.dataTables.min.js",
            site_url('assets') . "/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
        );
        /*
          required js plugins Functions to run script for the page
         */
        $data['addons_load'] = array(
        );
        $data['script'] = "
                        $('.simple_table').DataTable();
                    ";
            /*
            required js plugins Functions to run script for the page
            */   
        $data['results']=$this->notification_model->show_all();
        $data['results1']=$this->manage_menu_model->get_user_type();
        
        $data['main_content']='pages/manage_notification';
        $this->load->view('template',$data);
    }
    public function edit($notification_id) 
    {
        $data['theme_option']=$this->theme_model->get_theme_data();

        $data['styles']=array(
            );

        $data['addons']=array(
            site_url('assets')."/global/plugins/select2/select2.min.js",
            );
            /*
            required js plugins Functions to run script for the page
            */
        $data['addons_load']=array(
            );
        $data['results']=$this->notification_model->edit($notification_id);
        $data['result1']=$this->manage_menu_model->get_user_type();
        $data['results2']=$this->notification_model->show_all();
        $data['main_content']='pages/edit_notification';
        $this->load->view('template',$data);
    }
    public function update($id)
    {
        $result=$this->notification_model->update($id);
        if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE') 
        {
            if($result)
               set_flash('success','Notification Updated Succesfully.'); 
            else 
                set_flash('error','Error Occured while Updating Notification.');
        }
        redirect(site_url("pages/notification/manage_notification"),'refresh');
    }

    public function delete_notification($id)
    {
        $result=$this->notification_model->delete($id);
        if($result)
           set_flash('success','Notification Deleted Succesfully.'); 
        else 
            set_flash('error','Error Occured while Deleting Notification.');
        redirect(site_url("pages/notification/manage_notification"),'refresh');
    }
 }        