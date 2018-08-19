<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transportation extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
    check_access(array('su_admin','admin'));   
    $this->load->model('general_content/transportation_model'); 
	}

	public function index()
	{
		$data['addons']=array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",			
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
			"0" => "$('table').on('click', '.add_stops', function(){
		      const bus_id = $(this).attr('data-id');
		      $('#bus_id').val(bus_id);
		       $.post('".site_url('pages/ajax/get_bus_stops')."', {bus_id: bus_id})
                 .done(function(result) {
                      $('#bus_stops_content').html(result);
                 })
                 .fail(function() {
                    console.log('error');
                 })
  			});",
  			"1" => "
					$('body').on('click', '.ajax_delete', function(){
						if(confirm('Do you want to delete?'))
						{
							const bus_id = $(this).attr('data-bus-id');
							const stop_id = $(this).attr('data-stop-id');
							$.post('".site_url('pages/ajax/delete_bus_stops')."', {stop_id: stop_id, bus_id:bus_id})
                 .done(function(result) {
                 		message_display('success','Deleted Succesfully');
                    $('#bus_stops_content').html(result);
                 })
                 .fail(function(jqXHR, textStatus, errorThrown) {
                    message_display('danger','Request failed:'+errorThrown);
                 })
						}
					}); ",
  			"2" => "
					$('body').on('submit', '#ajax_bus_stop', function(event){
						event.preventDefault();
							$.post('".site_url('pages/ajax/add_bus_stops')."', $('#ajax_bus_stop').serialize())
                 .done(function(result) {
										message_display('success','List Updated Succesfully');
                    $('#bus_stops_content').html(result);
                 })
                 .fail(function(jqXHR, textStatus, errorThrown) {
                    message_display('danger','Request failed:'+errorThrown);
                 })
					});
  			"
			);							
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['results']=$this->transportation_model->transportation_list();
		$data['main_content']='general_content/transportation';
		$this->load->view('template',$data);
	}

	public function add()
	{
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->transportation_model->add();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Transport Information Added Successfully.');
			redirect(site_url("pages/general_content/transportation"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/general_content/transportation"),'refresh');
		}
	}

	public function update()
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->transportation_model->update();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Transport Information Updated Successfully.');
			redirect(site_url("pages/general_content/transportation"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/general_content/transportation"),'refresh');
		}
	}

	public function delete($id)
	{
		$result=$this->transportation_model->delete($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Transport Information Deleted Successfully.');
			redirect(site_url("pages/general_content/transportation"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/general_content/transportation"),'refresh');
		}
	}

}

/* End of file Transportation.php */
/* Location: ./application/modules/pages/controllers/general_content/Transportation.php */