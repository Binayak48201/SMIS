<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Club_manager extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('classes/club_manager_model');
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
			$('.simple_table').DataTable();
		";

		$data['ajax_script']=array(
			"0" => "$('.manage_head').click(function(){
					const club_type = $(this).attr('data-for');
					$('#ap_for').html(club_type);
					$('#manage_head').html('<p>Loading..</p>');
					$.post('".site_url('pages/classes/club_manager/get_club_by_type')."', {club_type: club_type})
         	.done(function(result) {
                $('#manage_head').html(result);
         	})
         	.fail(function() {
            console.log('error');
         	});

				});"
		);	

		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['results']=$this->club_manager_model->get_club_type();
		$data['main_content']='classes/club_manager';
		$this->load->view('template',$data);
	}

	public function add_type($value='')
	{
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->club_manager_model->add_type();
		}
		
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Club Type successfully Added');
		
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/club_manager"),'refresh');
	}

	public function delete_type($id)
	{
		
		$result=$this->club_manager_model->delete_type($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Club Type successfully Deleted');
		
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/classes/club_manager"),'refresh');
	}

	public function get_club_by_type()
	{
		$data['addons']=array(
    	site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",			
    );
		$data['ajax_script']=array(
			"0" => "$('#add_club').submit(function(e){
				e.preventDefault();
				$.post('".site_url('pages/classes/club_manager/add_club')."', $('#add_club').serialize())
         	.done(function(result) {
         		message_display('success','Club Added Succesfully');
           	$.post('".site_url('pages/classes/club_manager/get_club_by_type')."', {club_type: $('#club_type').val()})
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
				const club_type = $(this).attr('data-tid');
				$.post('".site_url('pages/classes/club_manager/delete_club')."', {id:id})
         	.done(function(result) {
         		message_display('info','Club Deleted Succesfully');
            $.post('".site_url('pages/classes/club_manager/get_club_by_type')."', {club_type: club_type})
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
				$('#club').val(name);
			});"
		);	
		$data['club_type'] = trim_post('club_type');
		$data['results'] = $this->club_manager_model->get_club_by_type($data['club_type']);
		$data['main_content']='classes/ajax_clubs';
		$this->load->view('ajax_template',$data);
	}

	public function delete_club()
	{
		return $this->club_manager_model->delete_club(trim_post('id'));
	}

	public function add_club()
	{
		if(isset_post('update_id') && trim_post('update_id') != '')
		{
			return $this->club_manager_model->update_club(trim_post('update_id'));
		}
		else
		{
			return $this->club_manager_model->add_club();
		}
	}
}

/* End of file Appraisal_manager.php */
/* Location: ./application/modules/pages/controllers/classes/Appraisal_manager.php */
