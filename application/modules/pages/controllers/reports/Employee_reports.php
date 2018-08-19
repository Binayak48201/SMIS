<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_reports extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('reports/employee_reports_model');
		$this->load->model('profile/employee_model');
	}

	public function Employee_list()
	{
		
    $data['addons']=array(
    	site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
    	site_url('assets')."/global/scripts/jquery.table2excel.min.js",
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
				$('.create_account').click(function(){
						const emp_id = $(this).attr('data-id');
		        const data_info = $(this).attr('data-info');
		        const data_obj = JSON.parse(data_info);
					 	$.post('".site_url('pages/ajax/get_employee_account')."', {emp_id: emp_id})
	         	.done(function(result) {
	            $('#user_account').html(result);
					        for (let key in data_obj) {
					          if (data_obj.hasOwnProperty(key)) { 
					            if($('#opt_'+key).prop('type') == 'checkbox' && $('#opt_'+key).prop('value') == data_obj[key] )
					            { 
					              $('#opt_'+key).attr('checked','checked');
					              $('#opt_'+key).closest('span').addClass('checked');
					            }
					            else if($('#opt_'+key).prop('type') == 'checkbox' && $('#opt_'+key).prop('value') != data_obj[key] )
					            { 
					              $('#opt_'+key).removeAttr('checked');
					              $('#opt_'+key).closest('span').removeClass('checked');
					            }
					            else
					              $('#opt_'+key).val(data_obj[key]);
					          }
					        }
					    
	         	})
	         	.fail(function() {
	            console.log('error');
	         	})
					})",
		
			);			
		$data['script'] = "
		 $('.exportTable').click(function() {
        const table_name = $(this).attr('data-id');
        $('#'+table_name).table2excel({
          exclude: '.noExl',
          name: 'Excel Document Name',
          filename: 'Employee Lists',
          fileext: '.xlsx',
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });
      
		$('.simple_table').DataTable(
			{paging : false});
								";	
		$data['emp_types']=array(
			'1' => 'Faculty',
			'2' => 'Staff'
		);		
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['departments'] = $this->employee_model->get_departments();
		$data['results'] = $this->employee_model->get_employees(); 
		//print_e($data['results']);
		$data['main_content'] = 'reports/employee_list';
		$this->load->view('template',$data);
	}

	public function Employee_list_type()
	{
		
    $data['addons']=array(
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
				$('.create_account').click(function(){
						const emp_id = $(this).attr('data-id');
		        const data_info = $(this).attr('data-info');
		        const data_obj = JSON.parse(data_info);
					 	$.post('".site_url('pages/ajax/get_employee_account')."', {emp_id: emp_id})
	         	.done(function(result) {
	            $('#user_account').html(result);
					        for (let key in data_obj) {
					          if (data_obj.hasOwnProperty(key)) { 
					            if($('#opt_'+key).prop('type') == 'checkbox' && $('#opt_'+key).prop('value') == data_obj[key] )
					            { 
					              $('#opt_'+key).attr('checked','checked');
					              $('#opt_'+key).closest('span').addClass('checked');
					            }
					            else if($('#opt_'+key).prop('type') == 'checkbox' && $('#opt_'+key).prop('value') != data_obj[key] )
					            { 
					              $('#opt_'+key).removeAttr('checked');
					              $('#opt_'+key).closest('span').removeClass('checked');
					            }
					            else
					              $('#opt_'+key).val(data_obj[key]);
					          }
					        }
					    
	         	})
	         	.fail(function() {
	            console.log('error');
	         	})
					})",
		
			);			
		$data['script'] = "
		$('.simple_table').DataTable(
			{paging : false});
								";	
		$data['emp_types']=array(
			'1' => 'Faculty',
			'2' => 'Staff'
		);		
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['departments'] = $this->employee_model->get_departments();
		$data['results'] = $this->employee_model->get_employees(); 
		$data['main_content'] = 'reports/employee_list_type';
		$this->load->view('template',$data);
	}

	public function Employee_list_agreement()
	{
		
    $data['addons']=array(
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
					})"
			);			
		$data['script'] = "
		$('.simple_table').DataTable(
			{paging : false});
								";	
		$data['emp_types']=array(
			'1' => 'Full Time',
			'2' => 'Part Time',
			'3' => 'Hourly Basis'
		);		
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['departments'] = $this->employee_model->get_departments();
		$data['results'] = $this->employee_model->get_employees(); 
		$data['main_content'] = 'reports/employee_list_agreement';
		$this->load->view('template',$data);
	}

	public function employee_list_department()
	{
		
    $data['addons']=array(
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
		
	
			);			
		$data['script'] = "
		$('.simple_table').DataTable(
			{paging : false});
								";	
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['departments'] = $this->employee_model->get_departments();
		$data['results'] = $this->employee_model->get_employees(); 
		$data['main_content'] = 'reports/employee_list_department';
		$this->load->view('template',$data);
	}

	public function class_teachers()
	{
		$data['ajax_script'] = array(
			"0" => "
				$('#batch').change(function(){
						const batch = $(this).val();
						$('#teachers_list').html('<div class=\'alert text-center\'>Loading.</div>');
					 	$.post('".site_url('pages/reports/employee_reports/ajax_class_teachers')."', {batch: batch})
	         	.done(function(result) {
	           $('#teachers_list').html(result);
	         	})
	         	.fail(function() {
	         		$('#teachers_list').html('<div class=\'alert alert-danger text-center\'>Ajax Error.</div>');
	            console.log('error');
	         	})
					})",
			"1" => "
				$(document).on('click','.view_profile',function(){
						const emp_id = $(this).attr('data-id');
					 	$.post('".site_url('pages/ajax/get_employee_profile')."', {emp_id: emp_id})
	         	.done(function(result) {
	            $('#profile_content').html(result);
	         	})
	         	.fail(function() {
	            console.log('error');
	         	})
					})",
		
	
			);		
		$date = explode('-', AD_to_BS());
		$data['results'] = $this->employee_reports_model->get_class_teachers($date[0]);
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'reports/class_teachers_list';
		$this->load->view('template',$data);
	}

	public function ajax_class_teachers()
	{
		$batch = trim_post('batch');
		$data['results'] = $this->employee_reports_model->get_class_teachers($batch);
		$this->load->view('reports/ajax_class_teachers',$data);
	}
}

/* End of file employee_reports.php */
/* Location: ./application/modules/pages/views/reports/employee_reports.php */
