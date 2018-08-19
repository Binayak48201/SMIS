<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_account extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
		if(!check_access())			
		{
			redirect(site_url('login'),'refresh');
			exit;
		}
		$this->load->model('theme_option/user_account_model');
	}

	public function lists()
	{
		$this->load->model('theme_option/manage_menu_model');
		/*
		required js plugins of script for the page
		 */
		$data['addons']=array(
				site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
    		site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",	
			); 
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
				
			); 

		$data['script']="
										$('.simple_table').DataTable({
								    'paging': false,
								    //'iDisplayLength': 100
										});
									";
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['user_type']=$this->manage_menu_model->get_user_type();						//passing value to view to display usrt type checkbox
		$data['users']=$this->user_account_model->get_users();	
		$data['main_content']='user_lists';
		$this->load->view('template',$data);
	}

	public function edit($uid)
	{
		$this->load->model('theme_option/manage_menu_model');
		/*
		required js plugins of script for the page
		 */
		$data['styles']=array(
        site_url('assets')."/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css",               //requires for file input in a form 
      );

      $data['addons'] = array(
       // site_url('assets') . "/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
        //site_url('assets') . "/admin/pages/scripts/components-form-tools.js",
        site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",

      );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
				
			); 

		$data['script']="
										
									";
			$data['ajax_script']=array(
			"0" => "$('#chng-pass').click(function(){
		      if($(this).prop('checked')){
		      	$('.chng-pass').removeAttr('disabled');
		      }
		      else
		      {
		      	$('.chng-pass').attr('disabled','disabled');
		      	$('.chng-pass').val('');
		      }
  			});"
			);		
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['user_type']=$this->manage_menu_model->get_user_type();						//passing value to view to display usrt type checkbox
		$data['user']=$this->user_account_model->user_info($uid);	
		$data['main_content']='edit_user';
		$this->load->view('template',$data);
	}

	public function update($uid)
	{check_access('su_admin');
		if(NULL!=$this->input->post('update') && $this->input->post('update')=='UPDATE')
		{
			$result=$this->user_account_model->update($uid);
		 	if($result)
	    {
	      $this->session->set_flashdata('error', FALSE);
	      $this->session->set_flashdata('alert_msg', 'User Account Updated Succesfully.');
	    }
	    else
	    {
	      $this->session->set_flashdata('error', TRUE);
	      $this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
	    }
		}
		
    redirect(site_url("theme_option/user_account/edit/$uid"),'refresh');
	}
	public function delete($id)
	{
		check_access('su_admin');
			$result=$this->user_account_model->delete($id);
		 	if($result)
	    {
	      $this->session->set_flashdata('error', FALSE);
	      $this->session->set_flashdata('alert_msg', 'User Account Deleted Succesfully.');
	    }
	    else
	    {
	      $this->session->set_flashdata('error', TRUE);
	      $this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
	    }
    redirect(site_url("theme_option/user_account/lists/"),'refresh');
	}

	public function add_user()
  {
  	$this->load->model('theme_option/manage_menu_model');
    $data['theme_option'] = $this->theme_model->get_theme_data();

      $data['addons'] = array(
          site_url('assets') . "/admin/pages/scripts/ui-nestable.js",
          site_url('assets') . "/global/plugins/jquery-nestable/jquery.nestable.js",
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
      $data['result']=$this->manage_menu_model->get_user_type();
      $data['main_content']='createuser';
        $this->load->view('template',$data);
  }
  public function insert_user()
  {
    if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT') 
    {
      $result=$this->user_account_model->insert_user();
      if($result)
      {
            $this->session->set_flashdata('error', FALSE);
            $this->session->set_flashdata('alert_msg', 'Succesfully Added User!!');
      } 
      else 
      {
          $this->session->set_flashdata('error', TRUE);
          $this->session->set_flashdata('alert_msg', 'Error Occured while Adding Message!!');
      }
    }
      redirect(site_url("theme_option/user_account/add_user"),'refresh');
  }

  public function new_admission()
  {
    $data['theme_option'] = $this->theme_model->get_theme_data();

      $data['addons'] = array(
          site_url('assets') . "/global/plugins/select2/select2.min.js",
      );
       $data['ajax_script']=array(
          '0' => "$('#programlevel_id').change(function()
         	{
            var option=$(this).val();
            $('#program_id').html('<option> Loading... </option>');
            $('#program_id').addClass('edited');

            $.ajax({
                url: '".site_url('ajax/ajax_for_program')."',
                type: 'POST',
                data: {option: option}
            })
            .done(function(result) {
                  $('#program_id').html(result);
            })
            .fail(function() {
                console.log('error');
            })
         	});",
            
          '1' => "$('#program_id').change(function()
          {
            var option=$(this).val();
            $('#batch_id').html('<option> Loading... </option>');
            $('#section_id').html('<option> Loading... </option>');
            $('#batch_id').addClass('edited');
            $('#section_id').addClass('edited');
              //ajax for batch
            $.ajax({
               url: '".site_url('ajax/ajax_for_batch')."',
               type: 'POST',
               data: {option: option}
            })
            .done(function(result) {
                 $('#batch_id').html(result);
            })
            .fail(function() {
               console.log('error');
            }); 
            //ajax for section
            $.ajax({
               url: '".site_url('ajax/ajax_for_section')."',
               type: 'POST',
               data: {option: option}
            })
            .done(function(result) {
                 $('#section_id').html(result);
            })
            .fail(function() {
               console.log('error');
            });             
          });"
        );
    if($data['theme_option']->mis_module)
    {
      $con_stat = check_connection('mis');
      $data['mis_con'] = $con_stat;
    }
    $data['styles'] = array(
        site_url('assets') . "/global/plugins/select2/select2.css",
    );
    $data['main_content']='new_admission';
    $this->load->view('template',$data);
  }

  public function add_student($value='')
  {

  	/*$data['theme_option'] = $this->theme_model->get_theme_data();
    if($data['theme_option']->mis_module)
    {
      $con_stat = check_connection('mis');
    }
    else
    {
      $con_stat['stat'] = FALSE;
    }
    if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT')
		{
	    $result=$this->user_account_model->add_student($data['theme_option']->mis_module,$con_stat['stat']);
	  }*/
  	if(FALSE)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('error_message', 'Menu List Succesfully Updated!!');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('error_message', 'Database Error!! Try Again!!');
		}
		
		redirect(site_url('theme_option/user_account/new_admission'),'refresh');
		exit;
  }
}

/* End of file user_account.php */
/* Location: ./application/modules/theme_option/controllers/user_account.php */