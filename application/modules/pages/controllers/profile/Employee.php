<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
    check_access();   
		$this->load->model('profile/employee_model');
	}

	public function add()
	{
		$data['styles']=array(
            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            );

    $data['addons']=array(
        site_url('assets')."/global/plugins/select2/select2.min.js",
        site_url('assets')."/global/plugins/jquery-validation/js/jquery.validate.min.js",               //required  for datepicker
        site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",       //required  for datepicker
        site_url('assets')."/admin/pages/scripts/form-validation.js",
        );

		$data['ajax_script']=array(
			"0" => ""
			);			
		$data['script']="
										$( '.date-picker' ).datepicker({format: 'yyyy-mm-dd'});
								";				
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['departments']=$this->employee_model->get_departments();
		$data['main_content']='profile/add_employee';
		$this->load->view('template',$data);
	}

	public function edit($emp_id)
	{
		$this->load->model('ajax_model');
		$data['styles']=array(
            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            );

    $data['addons']=array(
        site_url('assets')."/global/plugins/select2/select2.min.js",
        site_url('assets')."/global/plugins/jquery-validation/js/jquery.validate.min.js",               //required  for datepicker
        site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",       //required  for datepicker
        site_url('assets')."/admin/pages/scripts/form-validation.js",
        );

		$data['ajax_script']=array(
			"0" => ""
			);			
		$data['script']="
										$( '.date-picker' ).datepicker({format: 'yyyy-mm-dd'});
								";				
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['departments']=$this->employee_model->get_departments();
		$data['info'] = $this->ajax_model->get_employee_profile($emp_id);
		$data['main_content']='profile/edit_employee';
		$this->load->view('template',$data);
	}

	public function insert()
	{
	 	if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT')
    {
    	$picture='';
    	$biodata='';
    	$upload_error = FALSE;
    	if(isset($_FILES['picture']) && is_uploaded_file($_FILES['picture']['tmp_name']))
	    {
	    	
	      $stat=$this->general->upload('picture','gif|jpg|png','','employee_photo'); // form->name, ext, file name, folder
	      if($stat['status']==TRUE)
	      {
	        $picture=$stat['result'];
	      }
	      else
	      {
	      	set_flash('error', $stat['result']); 
	        redirect(site_url("pages/profile/employee/add"), 'refresh');
	      }
	    }

	    if(isset($_FILES['biodata']) && is_uploaded_file($_FILES['biodata']['tmp_name']))
	    {
	    	
	      $stat=$this->general->upload('biodata','','','bio_data'); // form->name, ext, file name, folder
	      if($stat['status']==TRUE)
	      {
	        $biodata=$stat['result'];
	      }
	      else
	      {
	        set_flash('error', $stat['result']);
	        redirect(site_url("pages/profile/employee/add"), 'refresh');
	      }
	    }

    	$res=$this->employee_model->add_employee($picture, $biodata);
      if($res)
      {
      	set_flash('success', 'Succesfully Added Employee');
      }
      else
      {
      	set_flash('error', 'ERROR Occured while Adding Employee');
      }
      redirect(site_url("pages/profile/employee/add"), 'refresh');
    }
	}

	public function add_leave()
	{
		if($this->input->post('add') != NULL && $this->input->post('add') == 'ADD')
		{
			$res=$this->employee_model->add_leave();
      if($res)
      	set_flash('success','Leave Added Succesfully.'); 
      else
      set_flash('error','Database Error.'); 
    }
    redirect(site_url("pages/profile/employee/manage"), 'refresh');
	}

	public function update($emp_id)
	{
	 	if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
    {
    	$biodata = trim_post('prev_biodata');
    	$picture = trim_post('prev_picture');
    	$upload_error = FALSE;
    	if(isset($_FILES['picture']) && is_uploaded_file($_FILES['picture']['tmp_name']))
	    {
	    	
	      $stat=$this->general->upload('picture','gif|jpg|png','','employee_photo'); // form->name, ext, file name, folder
	      if($stat['status']==TRUE)
	      {
	      	delete_file($picture);
	        $picture=$stat['result'];
	      }
	      else
	      {
	       	set_flash('error', $stat['result']); 
	        redirect(site_url("pages/profile/employee/add"), 'refresh');
	      }
	    }

	    if(isset($_FILES['biodata']) && is_uploaded_file($_FILES['biodata']['tmp_name']))
	    {
	    	
	      $stat=$this->general->upload('biodata','','','bio_data'); // form->name, ext, file name, folder
	      if($stat['status']==TRUE)
	      {
	        delete_file($biodata);
	        $biodata=$stat['result'];
	      }
	      else
	      {
	       	set_flash('error', $stat['result']); 
	        redirect(site_url("pages/profile/employee/edit/".$emp_id), 'refresh');
	      }
	    }
    	$res = $this->employee_model->update_employee($picture, $biodata, $emp_id);
      if($res)
      {
      	set_flash('success', 'Succesfully Updated Employee Profile');
      }
      else
      {
				set_flash('error', 'ERROR Occured while Updating Employee');
      }
    }
    redirect(site_url("pages/profile/employee/edit/".$emp_id), 'refresh');
	}

	public function delete($employee_id)
	{
		$res = $this->employee_model->delete($employee_id);
		if($res)
    {
    	$this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('alert_msg', 'Succesfully Deleted Employee Profile');
    }
    else
    {
			$this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('alert_msg', 'ERROR Occured while Deleting');
    }
    redirect(site_url("pages/profile/employee/manage"), 'refresh');
	}

	public function manage()
	{
		$data['styles'] = array(
            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            );

    $data['addons']=array(
        site_url('assets')."/global/plugins/select2/select2.min.js",
        site_url('assets')."/global/plugins/jquery-validation/js/jquery.validate.min.js",               //required  for datepicker
        site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",       //required  for datepicker
        site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
	    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
        );

		$data['ajax_script'] = array(
			"0" => "
				$('.view_profile').click(function(){
						const emp_id = $(this).attr('data-id');
					 	$.post('".site_url('pages/ajax/get_employee_profile')."', {emp_id: emp_id})
	         	.done(function(result) {
	            $('#profile_content').html(result);
	         	})
	         	.fail(function() {
	            console.log('error');
	         	})
					})",
			"1" => "
				$('div').on('click','.leaveEntry', function(){
						const emp_id = $(this).attr('data-id');
						$('#emp_id').val(emp_id);
					})"
			);			
		$data['script'] = "
										$( '.date-picker' ).datepicker({format: 'yyyy-mm-dd'});
										$('.simple_table').DataTable();
								";				
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['departments'] = $this->employee_model->get_departments();
		$data['results'] = $this->employee_model->get_employees(); 
		$data['main_content'] = 'profile/manage_employees';
		$this->load->view('template',$data);
	}

	public function download($file)
	{
		download('biodata',$file);
	}
}

/* End of file Employee.php */
/* Location: ./application/modules/pages/controllers/profile/Employee.php */