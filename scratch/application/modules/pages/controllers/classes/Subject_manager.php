<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_manager extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('classes/subject_manager_model');
		
	}

	public function index()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		
		$data['addons']=array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/admin/pages/scripts/table-managed.js"			
										    ); 
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
			); 
		$data['script']="
											$('.simple_table').DataTable();
									";
		$data['styles']=array(
		    site_url('assets')."/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css",               //requires for file input in a form 
		  );
		$data['ajax_script']=array(
			"0" => ""
			);		
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['batchs']=$this->batch_model->get_batch();
		$data['grades']=$this->grade_manager_model->get_grades();
		$data['results']=$this->subject_manager_model->get_subjects();
		$data['main_content']='classes/subject_manager';
		$this->load->view('template',$data);
	}

	public function add()
	{
		//print_e($_POST);
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->subject_manager_model->add();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Subject successfully Added');
			redirect(site_url("pages/classes/subject_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/subject_manager"),'refresh');
		}
	}

	public function update()
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->subject_manager_model->update();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Subject Updated Successfully.');
			redirect(site_url("pages/classes/subject_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/subject_manager"),'refresh');
		}
	}

	public function delete($id)
	{
		$result=$this->subject_manager_model->delete($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Subject Deleted Successfully.');
			redirect(site_url("pages/classes/subject_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/subject_manager"),'refresh');
		}
	}

	public function migrate()
  {
  	$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
         "0" => "
      $('.from_display_section').change(function(){
            const batch = $('#from_batch').val();
            const grade = $('#from_grade').val();

            if(batch != '' && grade != '')
            {
              $.post('".site_url('pages/ajax/check_subjects')."', {batch: batch, grade: grade})
             	.done(function(result) {
               	if(result == 1)
                  $('#frm_ajax_alert').show();
                else 
                  $('#frm_ajax_alert').hide();
          		})
              .fail(function() {
                console.log('error');
              });
            }
          });",
      "3" => "
      $('.to_display_section').change(function(){
            const batch = $('#to_batch').val();
            const grade = $('#to_grade').val();

            if(batch != '' && grade != '')
            {
              $.post('".site_url('pages/ajax/check_subjects')."', {batch: batch, grade: grade})
             	.done(function(result) {
               	if(result == 1)
                  $('#to_ajax_alert').show();
                else 
                  $('#to_ajax_alert').hide();
              })
              .fail(function() {
                console.log('error');
              });
            }
          });",
      "5" => "
        $('#to_section').change(function(){
          const section_id = $(this).val();
          $.post('".site_url('pages/ajax/check_subjects')."', {section_id: section_id})
               .done(function(result) {
                if(result == 1){
                  $('#ajax_alert').show();
                  $('#migrate').attr('disabled','disabled');
                }
                else if(result == 2)
                {
                  $('#ajax_alert').hide();
                  $('#migrate').removeAttr('disabled');
                }
                //$('#to_subject').html(result);
              })
              .fail(function() {
                console.log('error');
              });
        });
      "     
    );
    $data['addons'] = array(
    );
    $data['styles'] = array(
    );
    $data['addons_load'] = array(
       
    );
    if($this->input->post('migrate')!=NULL && $this->input->post('migrate')=='MIGRATE')
    {
      $result = $this->subject_manager_model->migrate();
      if ($result) 
      {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Migrated Subjects');
      } 
      else 
      {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Migrating Subjects');
      }
    }

    $data['batchs'] = $this->batch_model->get_batch();
    $data['grades'] = $this->grade_manager_model->get_grades();  
    $data['main_content'] = 'classes/migrate_subject';
    $this->load->view('template', $data);
  }
}

/* End of file Subject_manager.php */
/* Location: ./application/modules/pages/controllers/classes/Subject_manager.php */
