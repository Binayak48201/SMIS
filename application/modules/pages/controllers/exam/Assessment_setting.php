<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_setting extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('exam/assessment_setting_model');
	}

	public function index()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');

		$data['addons']=array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    ); 
		$data['styles']=array(
        );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load']=array(
			); 
		$data['script']="
									";

		$data['ajax_script']=array(
			"0" => "
			$('.display_section').change(function(){
						const batch = $('#batch').val();
						const grade = $('#grade').val();

						if(batch != '' && grade != '')
						{
							$.post('".site_url('pages/ajax/get_section')."', {batch: batch, grade: grade})
               .done(function(result) {
                    $('#section').html(result);
             	})
             	.fail(function() {
                console.log('error');
             	});

             	$.post('".site_url('pages/ajax/get_subject')."', {batch: batch, grade: grade})
               .done(function(result) {
                    $('#subject').html(result);
             	})
             	.fail(function() {
                console.log('error');
             	});
						}
						else
						{
							$('#section').html('<option value=\"\">Select Sections</option>');
						}
					});",
			"1" => '
				$("#numeric_value").keyup(function(){
					
					const section = $("#section").val();
					const subject = $("#subject").val();
					const numeric_value = $("#numeric_value").val();
					$.post("'.site_url('pages/ajax/check_assesment_number').'", {section: section, subject: subject, numeric_value: numeric_value })
          .done(function(result) {
						if(result == 1)
						{
							$("#submit_setting").attr("disabled","disabled");
							alert("Numeric Value Already Assigned");
						}
						else
						{
							$("#submit_setting").removeAttr("disabled");
						}
         	})
         	.fail(function() {
            console.log("error");
         	});
		
				});
			'
			);		
		$data['batchs']=$this->batch_model->get_batch();
		$data['grades']=$this->grade_manager_model->get_grades();					
		$data['exams']=$this->assessment_setting_model->get_assessments();					
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['main_content']='exam/assessment_setting';
		$this->load->view('template',$data);
	}

	public function add_assessment()
	{
		if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT')
    {
    	$res=$this->assessment_setting_model->add_assessment();
      if($res)
      {
      	$this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Added Assessment');
      }
      else
      {
				$this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Adding Assessment');
      }
    }
    redirect(site_url("pages/exam/assessment_setting"), 'refresh');
	}

	public function delete($id)
	{
		$result=$this->assessment_setting_model->delete($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Assessment Deleted Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/exam/assessment_setting"),'refresh');
	}

	public function update()
	{
		$result=FALSE;
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->assessment_setting_model->update();
		}
		
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Assessment Updated Successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
		}
		redirect(site_url("pages/exam/assessment_setting"),'refresh');
	}

}

/* End of file assessment_setting.php */
/* Location: ./application/modules/pages/controllers/exam/assessment_setting.php */
