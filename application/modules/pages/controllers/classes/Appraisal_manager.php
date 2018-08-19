<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Appraisal_manager extends MX_Controller {



	public function __construct()

	{

		parent::__construct();

		modules::run('dashboard/user_log/log');

	  check_access();

	

		$this->load->model('classes/appraisal_manager_model');

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

					const head_id = $(this).attr('data-id');

					$('#ap_for').html($(this).attr('data-for'));

					$('#manage_head').html('<p>Loading..</p>');

					$.post('".site_url('pages/classes/appraisal_manager/get_head_titles')."', {head_id: head_id})

         	.done(function(result) {

                $('#manage_head').html(result);

         	})

         	.fail(function() {

            console.log('error');

         	});



				});"

		);	



		$data['theme_option']=$this->theme_model->get_theme_data();

		$data['results']=$this->appraisal_manager_model->get_appraisals();

		$data['main_content']='classes/appraisal_manager';

		$this->load->view('template',$data);

	}



	public function add_head($value='')

	{

		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')

		{

			$result=$this->appraisal_manager_model->add_head();

		}

		

		if($result)

		{

			$this->session->set_flashdata('error', FALSE);

			$this->session->set_flashdata('alert_msg', 'Appraisal Title successfully Added');

		

		}

		else

		{

			$this->session->set_flashdata('error', TRUE);

			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');

		}

		redirect(site_url("pages/classes/appraisal_manager"),'refresh');

	}



	public function delete_head($id)

	{

		$result=$this->appraisal_manager_model->delete_head($id);

		if($result)

		{

			$this->session->set_flashdata('error', FALSE);

			$this->session->set_flashdata('alert_msg', 'Appraisal Title successfully Deleted');

		

		}

		else

		{

			$this->session->set_flashdata('error', TRUE);

			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');

		}

		redirect(site_url("pages/classes/appraisal_manager"),'refresh');

	}



	public function get_head_titles()

	{

		$data['addons']=array(

    	site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",			

    );

		$data['ajax_script']=array(

			"0" => "$('#ap_title').submit(function(e){

				e.preventDefault();

				$.post('".site_url('pages/classes/appraisal_manager/add_title')."', $('#ap_title').serialize())

         	.done(function(result) {

         		message_display('success','List Updated Succesfully');

           	$.post('".site_url('pages/classes/appraisal_manager/get_head_titles')."', {head_id: $('#head_id').val()})

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

				const head_id = $(this).attr('data-hid');

				$.post('".site_url('pages/classes/appraisal_manager/delete_title')."', {id:id})

         	.done(function(result) {

         		message_display('info','Title Deleted Succesfully');

            $.post('".site_url('pages/classes/appraisal_manager/get_head_titles')."', {head_id: head_id})

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

			});"

		);	

		$data['head_id'] = trim_post('head_id');

		$data['results'] = $this->appraisal_manager_model->get_head_titles($data['head_id']);

		$data['main_content']='classes/ajax_head_titles';

		$this->load->view('ajax_template',$data);

	}



	public function delete_title()

	{

		return $this->appraisal_manager_model->delete_title(trim_post(id));

	}



	public function add_title()

	{

		return $this->appraisal_manager_model->add_title();

	}



	public function appraisal_evaluation_option($section_id)

  {

    $data['st_id'] = trim_post("st_id");

    $data['exam_id'] = trim_post("exam_id");

    $data['ap_heades'] = $this->appraisal_manager_model->get_appraisals();

    $data['grades'] = $this->appraisal_manager_model->get_grades();

    $this->load->view('profile/appraisal_evaluation', $data, FALSE);

  }



  public function get_head_field($head_id)

  {

  	return $this->appraisal_manager_model->get_head_titles($head_id);

  }



  public function get_st_evaluated($field_id,$st_id,$exam_id,$section_id)

  {

  	return $this->appraisal_manager_model->get_st_evaluated($field_id,$st_id,$exam_id,$section_id);

  }



  public function appraisal_evaluation()

  {

  	if($this->input->post('add') != NULL && trim_post('add') == 'ADD')

    {

      if($this->input->post('update_opt') != NULL && trim_post('update_opt') == 'UPDATE')

      {

        echo $this->appraisal_manager_model->update_appraisal_evaluation();

      }

      else

      {

        echo $this->appraisal_manager_model->insert_appraisal_evaluation();

      }

    }

  }

}



/* End of file Appraisal_manager.php */

/* Location: ./application/modules/pages/controllers/classes/Appraisal_manager.php */

