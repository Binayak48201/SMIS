<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_criteria_manager extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('classes/evaluation_criteria_manager_model');
	}

	public function index()
	{
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
			/*$('.simple_table').DataTable({
				paging : false
			});*/
		";

		$data['ajax_script']=array(
			"0" => "$('.manage_head').click(function(){
					const type_id = $(this).attr('data-id');
					const opt_id = $(this).attr('data-opt');
					$('#ap_for').html($(this).attr('data-for'));
					$('#manage_head').html('<p>Loading..</p>');
					$.post('".site_url('pages/classes/evaluation_criteria_manager/get_evaluation_option/')."'+opt_id+'', {type_id: type_id})
         	.done(function(result) {
                $('#manage_head').html(result);
         	})
         	.fail(function() {
            console.log('error');
         	});

				});"
		);	

		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['results']=$this->evaluation_criteria_manager_model->get_evaluation_type(1);
		$data['results2']=$this->evaluation_criteria_manager_model->get_evaluation_type(2);
		$data['results3']=$this->evaluation_criteria_manager_model->get_evaluation_type(3);
		$data['main_content']='classes/evaluation_criteria_manager';
		$this->load->view('template',$data);
	}

	public function add_type($opt)
	{
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->evaluation_criteria_manager_model->add_type($opt);
		}
		
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Evaluation Criteria Type successfully Added');
		
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/evaluation_criteria_manager"),'refresh');
	}

	public function delete_type($opt_id, $id)
	{
		
		$result=$this->evaluation_criteria_manager_model->delete_type($opt_id, $id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Evaluation Criteria Type successfully Deleted');
		
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/evaluation_criteria_manager"),'refresh');
	}

	public function get_evaluation_option($opt_id)
	{
		$data['addons']=array(
    	site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",			
    );
		$data['ajax_script']=array(
			"0" => "$('#ap_title').submit(function(e){
				e.preventDefault();
				$.post('".site_url('pages/classes/evaluation_criteria_manager/add_option/'.$opt_id)."', $('#ap_title').serialize())
         	.done(function(result) {
         		message_display('success','List Updated Succesfully');
           	$.post('".site_url('pages/classes/evaluation_criteria_manager/get_evaluation_option/'.$opt_id)."', {type_id: $('#type_id').val()})
	         	.done(function(result) {
	                $('#manage_head').html(result);
	         	})
	         	.fail(function() {
	            console.log('error');
	         	});
         	})
         	.fail(function() {
            console.log('error');
         	});
			});",
			"1" => "$('.del-title').click(function(){
				if(!confirm('Are you sure?'))
					return false;
				const id = $(this).attr('data-id');
				const type_id = $(this).attr('data-tid');
				$.post('".site_url('pages/classes/evaluation_criteria_manager/delete_option/'.$opt_id)."', {id:id})
         	.done(function(result) {
         		message_display('info','option Deleted Succesfully');
            $.post('".site_url('pages/classes/evaluation_criteria_manager/get_evaluation_option/'.$opt_id)."', {type_id: type_id})
	         	.done(function(result) {
	                $('#manage_head').html(result);
	         	})
	         	.fail(function() {
	            console.log('error');
	         	});
         	})
         	.fail(function() {
            console.log('error');
         	});
			});",
			"2" => "$('.edit-title').click(function(){
			
				const id = $(this).attr('data-id');
				const name = $(this).attr('data-name');
				$('#act-btn').html('Update');
				$('#extra_option').html('<input type=\'hidden\' name=\'update_id\' value='+id+'/>');
				$('#option_name').val(name);
			});"
		);	
		$data['type_id'] = trim_post('type_id');
		$data['opt_id'] = $opt_id;
		$data['results'] = $this->evaluation_criteria_manager_model->get_evaluation_option($opt_id,$data['type_id']);
		$data['main_content']='classes/ajax_evaluation_option';
		$this->load->view('ajax_template',$data);
	}

	public function delete_option($opt_id)
	{
		return $this->evaluation_criteria_manager_model->delete_option($opt_id,trim_post('id'));
	}

	public function add_option($opt_id)
	{
		if(isset_post('update_id') && trim_post('update_id') != '')
		{
			return $this->evaluation_criteria_manager_model->update_option($opt_id, trim_post('update_id'));
		}
		else
		{
			return $this->evaluation_criteria_manager_model->add_option($opt_id);
		}
	}
}

/* End of file Appraisal_manager.php */
/* Location: ./application/modules/pages/controllers/classes/Appraisal_manager.php */
