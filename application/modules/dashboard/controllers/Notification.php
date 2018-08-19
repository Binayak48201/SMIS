<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
        //modules::run('dashboard/user_log/log');
        if (!check_access()) {
            redirect(site_url('login'), 'refresh');
            EXIT ;
        }
        $this->load->model('pages/manage_menu_model');
        $this->load->model('dashboard/notification_model');
	}
	public function index()
	{
		$data['theme_option'] = $this->theme_model->get_theme_data();

	    $data['addons'] = array(
	        site_url('assets') . "/admin/pages/scripts/ui-nestable.js",
	        site_url('assets') . "/global/plugins/jquery-nestable/jquery.nestable.js",
            site_url('assets') . "/global/plugins/datatables/media/js/jquery.dataTables.min.js",
            site_url('assets') . "/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
            site_url('assets') . "/admin/pages/scripts/table-managed.js"
	    );

	    $data['addons'] = array(
	        site_url('assets') . "/global/plugins/select2/select2.min.js",
	        site_url('assets') . "/global/plugins/jquery-validation/js/jquery.validate.min.js", //required for date picker
	        site_url('assets') . "/admin/pages/scripts/form-validation.js", //required for date picker
	        site_url('assets') . "/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js", //required for date picker
	    );
	    $data['styles'] = array(
	        site_url('assets') . "/global/plugins/select2/select2.css",
	        site_url('assets') . "/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
	    );
	    $data['addons_load'] = array(
	        "FormValidation.init();", ////required for date picker
	        "TableManaged.init();",

	    );
        $data['script'] = "
                        $('.simple_table').DataTable();
                    ";
	    $data['result1']=$this->manage_menu_model->get_user_type();
	    $data['main_content']='dashboard/notification';
        $this->load->view('template',$data);
	}
	
	public function add_msg()
	{
    		if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT') 
    		{
	            $result=$this->notification_model->add_notification();
	            if($result)
	            {
		                $this->session->set_flashdata('error', FALSE);
		                $this->session->set_flashdata('error_msg', 'Succesfully Added Message!!');
		        } 
		        else 
		            {
		                $this->session->set_flashdata('error', TRUE);
		                $this->session->set_flashdata('error_msg', 'Error Occured while Adding Message!!');
	            	}
        	}
        	redirect(site_url("dashboard/notification"),'refresh');
  }
  public function show_all()
  {

  	$data['theme_option'] = $this->theme_model->get_theme_data();

        $data['addons'] = array(
            site_url('assets') . "/global/plugins/datatables/media/js/jquery.dataTables.min.js",
            site_url('assets') . "/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
            site_url('assets') . "/admin/pages/scripts/table-managed.js"
        );
        /*
          required js plugins Functions to run script for the page
         */
        $data['addons_load'] = array(
            "TableManaged.init();",
        );
        $data['script'] = "
                        $('.simple_table').DataTable();
                    ";
            /*
            required js plugins Functions to run script for the page
            */
        $data['results']=$this->notification_model->show_all();
        $data['results1']=$this->manage_menu_model->get_user_type();
        
        $data['main_content']='dashboard/view_notification';
        $this->load->view('template',$data);
    }
    public function edit($notification_id) 
    {
        $data['theme_option']=$this->theme_model->get_theme_data();

        $data['styles']=array(
            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            );

        $data['addons']=array(
            site_url('assets')."/global/plugins/select2/select2.min.js",
            site_url('assets')."/global/plugins/jquery-validation/js/jquery.validate.min.js",               //required  for datepicker
            site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",       //required  for datepicker
            site_url('assets')."/admin/pages/scripts/form-validation.js",
            );
            /*
            required js plugins Functions to run script for the page
            */
        $data['addons_load']=array(
            "FormValidation.init();", //required for datepicker
            "TableManaged.init();",
            );
        $data['results']=$this->notification_model->edit($notification_id);
        $data['result1']=$this->manage_menu_model->get_user_type();
        $data['results2']=$this->notification_model->show_all();
        
        // $data['results1']=$this->programlevel_model->get_programlevel();
        // $data['results2']=$this->program_model->get_program();
        // $data['results3']=$this->department_model->get();
        $data['main_content']='dashboard/edit_notification';
        $this->load->view('template',$data);
    }
    public function update($id) {
        $result=$this->notification_model->update($id);
        if($result) {
            $this->session->set_flashdata('error', FALSE);
            $this->session->set_flashdata('error_msg', 'Notification Updated Succesfully!!');
        } else {
            $this->session->set_flashdata('error', TRUE);
            $this->session->set_flashdata('error_msg', 'Error!! Updating Notification!!');
        }
        redirect(site_url("dashboard/notification"),'refresh');
    }
    public function delete_notification($id)
    {
        $result=$this->notification_model->delete($id);
        if($result) {
            $this->session->set_flashdata('error', FALSE);
            $this->session->set_flashdata('error_msg', 'Notification Deleted Succesfully!!');
        } else {
            $this->session->set_flashdata('error', TRUE);
            $this->session->set_flashdata('error_msg', 'Error!! Deleting Notification!!');
        }
        redirect(site_url("dashboard/notification/show_all"),'refresh');
    }
 }        