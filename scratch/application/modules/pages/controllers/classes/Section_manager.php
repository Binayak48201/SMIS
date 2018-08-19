<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Section_manager extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('classes/section_manager_model');
		
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
		$data['ajax_script']=array(
			"0" => ""
			);		
		$data['theme_option']=$this->theme_model->get_theme_data();
		$data['batchs']=$this->batch_model->get_batch();
		$data['grades']=$this->grade_manager_model->get_grades();
		$data['results']=$this->section_manager_model->get_sections();
		$data['main_content']='classes/section_manager';
		$this->load->view('template',$data);
	}

	public function add()
	{
		
		if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
		{
			$result=$this->section_manager_model->add();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Section successfully Added');
			redirect(site_url("pages/classes/section_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/section_manager"),'refresh');
		}
	}

	public function update()
	{
		if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
		{
			$result=$this->section_manager_model->update();
		}
		else
		{
			$result=FALSE;
		}
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Section Updated Successfully.');
			redirect(site_url("pages/classes/section_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/section_manager"),'refresh');
		}
	}

	public function delete($id)
	{
		$result=$this->section_manager_model->delete($id);
		if($result)
		{
			$this->session->set_flashdata('error', FALSE);
			$this->session->set_flashdata('alert_msg', 'Section Deleted Successfully.');
			redirect(site_url("pages/classes/section_manager"),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', TRUE);
			$this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
			redirect(site_url("pages/classes/section_manager"),'refresh');
		}
	}

	public function list_student($section_id)
	{
		$this->load->model('profile/evaluation_model');
		$this->load->model('classes/course_manager_model');
		$this->load->model('profile/student_model');
    $this->load->model('classes/evaluation_criteria_manager_model');

    $data['addons']=array(
      site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",     
    );

		$data['script'] = "
		 $('.disp_pop').click(function(){
			const st_for = $(this).attr('data-for');
			const st_id = $(this).attr('data-id');
			$('.st_for').html(st_for);
			$('.st_id').val(st_id);
		});

    $('.modal').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
      $('#class_evaluation_option').html('');
      $('#parent_evaluation_option').html('');
      $('#parent_evaluation_option').html('');
      $('#terminal_comment_option').html('');
      $('#appraisal_evaluation_option').html('');
    });
    ";

    $data['ajax_script']=array(
      '0' => "
        $('#exam_id_st_eval').change(function(){
          if($(this).val() == '')
            return false;
          const st_id = $('.st_id').val();
          const exam_id = $(this).val();
          const section_id = $('.section_id').val();
          $.post('".site_url('pages/profile/evaluation/st_class_evaluation/')."'+section_id+'', {st_id: st_id, exam_id: exam_id})
          .done(function(result) {
            $('#class_evaluation_option').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });",
      '1' => "
        $('#class_evaluation').submit(function(e){
          e.preventDefault();
          $.post('".site_url('pages/profile/evaluation/student_evaluation')."', $('#class_evaluation').serialize())
          .done(function(result) {
            if(result)
              message_display('success','Evaluated Successfully.');
            else
              message_display('danger','Database Error.');
         		$('.modal').modal('hide');
            $('#class_evaluation_option').html('');
            $('#class_evaluation')[0].reset();
          })
          .fail(function() {
            message_display('danger','Ajax Error.');
          });

        });",
       '2' => "
        $('#exam_id_pt_eval').change(function(){
          if($(this).val() == '')
            return false;
          const st_id = $('.st_id').val();
          const exam_id = $(this).val();
          const section_id = $('.section_id').val();
          $.post('".site_url('pages/profile/evaluation/parent_class_evaluation/')."'+section_id+'', {st_id: st_id, exam_id: exam_id})
          .done(function(result) {
            $('#parent_evaluation_option').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });",
      '3' => "
        $('#parent_evaluation').submit(function(e){
          e.preventDefault();
          $.post('".site_url('pages/profile/evaluation/parent_evaluation')."', $('#parent_evaluation').serialize())
          .done(function(result) {
            if(result)
              message_display('success','Evaluated Successfully.');
            else
              message_display('danger','Database Error.');
         		$('.modal').modal('hide');
            $('#parent_evaluation_option').html('');
            $('#parent_evaluation')[0].reset();
          })
          .fail(function() {
            message_display('danger','Ajax Error.');
          });

        });",
      '4' => "
        $('#exam_id_ap_eval').change(function(){
          if($(this).val() == '')
            return false;
          const st_id = $('.st_id').val();
          const exam_id = $(this).val();
          const section_id = $('.section_id').val();
          $.post('".site_url('pages/classes/appraisal_manager/appraisal_evaluation_option/')."'+section_id+'', {st_id: st_id, exam_id: exam_id})
          .done(function(result) {
            $('#appraisal_evaluation_option').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });",
      '5' => "
        $('#appraisal_evaluation').submit(function(e){
          e.preventDefault();
          $.post('".site_url('pages/classes/appraisal_manager/appraisal_evaluation')."', $('#appraisal_evaluation').serialize())
          .done(function(result) {
            if(result)
              message_display('success','Evaluated Successfully.');
            else
              message_display('danger','Database Error.');
         		$('.modal').modal('hide');
            $('#sub_remark').html('');
            $('#appraisal_evaluation')[0].reset();
          })
          .fail(function(result) {
            message_display('danger','Ajax Error.'+result);
          });

        });",
      '6' => "
        $('#exam_id_cm_eval').change(function(){
          if($(this).val() == '')
            return false;
          const st_id = $('.st_id').val();
          const exam_id = $(this).val();
          const section_id = $('.section_id').val();
          $.post('".site_url('pages/profile/evaluation/st_terminal_comment/')."'+section_id+'', {st_id: st_id, exam_id: exam_id})
          .done(function(result) {
            $('#terminal_comment_option').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });",
      '7' => "
        $('#terminal_comment').submit(function(e){
          e.preventDefault();
          $.post('".site_url('pages/profile/evaluation/terminal_comment')."', $('#terminal_comment').serialize())
          .done(function(result) {
            if(result)
              message_display('success','Commented Successfully.');
            else
              message_display('danger','Database Error.');
            $('#terminal_comment_option').html('');
            $('#terminal_comment')[0].reset();
            $('.modal').modal('hide');
            //console.log($('#terminal_comment')[0]);
          })
          .fail(function() {
            message_display('danger','Ajax Error.');
          });

        });"
      );
    $this->load->model('exam/marks_entry_model');
		//$data['info']=$this->course_manager_model->get_courses_by_id($class_days_id);	
		//$data['evaluations'] = $this->evaluation_criteria_manager_model->get_evaluation_type(3);
    $data['students'] = $this->student_model->get_students($section_id);
    $data['exams'] = $this->marks_entry_model->get_section_exams($section_id);
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'classes/list_students';
		$this->load->view('template',$data);
	}
}

/* End of file Section_manager.php */
/* Location: ./application/modules/pages/controllers/classes/Section_manager.php */
