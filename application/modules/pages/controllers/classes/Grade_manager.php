<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_manager extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('classes/grade_manager_model');
	}

	public function index()
	{
		$data['addons']=array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/admin/pages/scripts/table-managed.js"	,
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
			"0" => "
   		 	$('.up,.down').click(function(){
	        const row = $(this).parents('tr:first');
        	const currentPosition = $(this).parents('tr').attr('data-recoder');
        	const currentId = $(this).parents('tr').attr('data-id');
        	let nextPosition,nextId;
					const point = $(this);
	        if ($(this).is('.up')) 
	        {
	        	nextPosition = row.prev().attr('data-recoder');
	        	nextId = row.prev().attr('data-id');
	          data = {currentPosition: currentPosition, currentId:currentId, nextPosition: nextPosition, nextId:nextId};
	        } 
	        else if ($(this).is('.down')) 
	        {
	        	nextPosition = row.next().attr('data-recoder')
	          nextId = row.next().attr('data-id');
						data = {currentPosition: currentPosition, currentId:currentId, nextPosition: nextPosition, nextId:nextId};
	        } 
					if(nextId > 0)
					{
						$('tr[data-recoder=\"'+nextPosition+'\"]').attr('data-recoder','0');
		        $('tr[data-recoder=\"'+currentPosition+'\"]').attr('data-recoder',nextPosition);
		        $('tr[data-recoder=\"0\"]').attr('data-recoder',currentPosition);
		          
	          $.post('".site_url('pages/ajax/grade_table_recoder')."', data)
	         		.done(function(result) {
	         			if(result)
	         			{
		           		message_display('success','Grade Re-Arranged Succesfully');
		           		if (point.is('.up')) 
		           			row.insertBefore(row.prev());
		           		else
		           			row.insertAfter(row.next());
				          $('tr[data-recoder=\"'+nextPosition+'\"] td:first').html(nextPosition);
				        	$('tr[data-recoder=\"'+currentPosition+'\"] td:first').html(currentPosition);
				        	return;
	         			}
	         			message_display('danger','Request failed: Database Error');
	           	})
		          .fail(function(jqXHR, textStatus, errorThrown) {
		            message_display('danger','Request failed:'+errorThrown);
		          })
		      }

	        //else if ($(this).is('.top')) {
	        //	row.insertAfter($('table tr:first'));
	        //  row.insertBefore($('table tr:first'));
	        //}else {
	        //  row.insertAfter($('table tr:last'));
	        //}
    		});
			"
			);		
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['results']=$this->grade_manager_model->get_grades();
		$data['main_content']='classes/grade_manager';
		$this->load->view('template',$data);
	}

	public function add()
	{
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->grade_manager_model->add();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Grade Added Successfully.');
			redirect(site_url("pages/classes/grade_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/grade_manager"),'refresh');
		}
	}

	public function update()
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->grade_manager_model->update();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Grade Updated Successfully.');
			redirect(site_url("pages/classes/grade_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/grade_manager"),'refresh');
		}
	}

	public function delete($id)
	{
		$result=$this->grade_manager_model->delete($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Grade Deleted Successfully.');
			redirect(site_url("pages/classes/grade_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/grade_manager"),'refresh');
		}
	}

}

/* End of file Grade_manager.php */
/* Location: ./application/modules/pages/controllers/classes/Grade_manager.php */