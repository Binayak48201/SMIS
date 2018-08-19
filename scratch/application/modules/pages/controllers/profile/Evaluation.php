<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
		$this->load->model('profile/evaluation_model');
		$this->load->model('classes/course_manager_model');
		$this->load->model('profile/student_model');
    $this->load->model('classes/evaluation_criteria_manager_model');
	}

	public function list_student($class_days_id)
	{
    $data['addons']=array(
      site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",     
    );
		$data['script'] = "
		 $('table').on('click', '.edit_opt', function(){
        const data_info = $(this).attr('data-info');
        const data_obj = JSON.parse(data_info);
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
    });
		$('.disp_pop').click(function(){
			const st_for = $(this).attr('data-for');
			const st_id = $(this).attr('data-id');
			$('.st_for').html(st_for);
			$('.st_id').val(st_id);
		});
    $('#reset_sub_eval').click(function(){ $('#sub_evaluation')[0].reset(); $('#sub_remark').html(''); });
    $('.modal').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
      $('#sub_remark').html('');
    });
    ";
    $data['ajax_script']=array(
      '0' => "
        $('#exam_id').change(function(){
          const st_id = $('.st_id').val();
          const exam_id = $(this).val();
          const class_days_id = $('#class_days_id').val();
          $.post('".site_url('pages/profile/evaluation/sub_evaluation/')."'+class_days_id+'', {st_id: st_id, exam_id: exam_id})
          .done(function(result) {
            $('#sub_remark').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });",
      '1' => "
        $('#sub_evaluation').submit(function(e){
          e.preventDefault();
          $.post('".site_url('pages/profile/evaluation/subject_evaluation')."', $('#sub_evaluation').serialize())
          .done(function(result) {
            if(result)
              message_display('success','Evaluated Successfully.');
            else
              message_display('danger','Database Error.');
            $('#reset_sub_eval').trigger('click');
            $('#sub_remark').html('');
            $('#sub_evaluation')[0].reset();
          })
          .fail(function() {
            message_display('danger','Ajax Error.');
          });

        });",
        '2' => "
        $('.feedback').click(function(){
          const student_id = $(this).attr('data-id');
          $.get('".site_url('pages/ajax/get_st_feedback')."', {class_days_id: '".$this->uri->segment(5)."', student_id: student_id})
          .done(function(result) {
            $('#feedback-content').html(result);
          })
          .fail(function() {
            console.log('error');
          });
              //message_display('success','Evaluated Successfully.');
              //message_display('danger','Database Error.');

        });"

    );

    $this->load->model('exam/marks_entry_model');
    $data['info']=$this->course_manager_model->get_courses_by_id($class_days_id); 
    //$data['exams'] = $this->marks_entry_model->get_exams($data['info']);
    $data['exams'] = $this->marks_entry_model->get_section_exams($data['info']->section_id);
    //print_e($data['exams']);
    $data['students'] = $this->student_model->get_students($data['info']->section_id);
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'profile/list_students';
		$this->load->view('template',$data);
	}
  
	public function add_comment()
	{
		 if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') {
      $result = $this->evaluation_model->add_comment();
      if ($result) {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Added Comment');
      } else {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Adding Comment');
      }
    }
    redirect(site_url("pages/profile/evaluation/list_student/".trim_post('class_days_id')), 'refresh');
	}

  public function get_evaluation_option($opt_id, $type_id)
  {
    return $this->evaluation_criteria_manager_model->get_evaluation_option($opt_id,$type_id);
  }

  public function get_st_evaluated($opt_id, $type_id, $st_id, $exam_id, $sub_section)
  {
    return $this->evaluation_model->get_st_evaluated($opt_id, $type_id, $st_id, $exam_id, $sub_section);
  }

  public function sub_evaluation($class_days_id)
  {
    $data['info']=$this->course_manager_model->get_courses_by_id($class_days_id); 
    $data['st_id'] = trim_post("st_id");
    $data['exam_id'] = trim_post("exam_id");
    $data['evaluations'] = $this->evaluation_criteria_manager_model->get_evaluation_type(3);
    $this->load->view('profile/subject_evalution', $data, FALSE);
  }

  public function subject_evaluation()
  {
    if($this->input->post('add') != NULL && trim_post('add') == 'ADD')
    {
      if($this->input->post('update_opt') != NULL && trim_post('update_opt') == 'UPDATE')
      {
        return $this->evaluation_model->update_subject_evaluation();
      }
      else
      {
        return $this->evaluation_model->insert_subject_evaluation();
      }
    }
    //redirect(site_url("pages/profile/evaluation/list_student/".trim_post('class_days_id')), 'refresh');
  }

  public function st_class_evaluation($section_id)
  {
   // $data['info']=$this->course_manager_model->get_courses_by_id($class_days_id); 
    $data['st_id'] = trim_post("st_id");
    $data['exam_id'] = trim_post("exam_id");
    $data['evaluations'] = $this->evaluation_criteria_manager_model->get_evaluation_type(1);
    $this->load->view('profile/st_class_evalution', $data, FALSE);
  }

  public function student_evaluation()
  {
    if($this->input->post('add') != NULL && trim_post('add') == 'ADD')
    {
      if($this->input->post('update_opt') != NULL && trim_post('update_opt') == 'UPDATE')
      {
        return $this->evaluation_model->update_student_evaluation();
      }
      else
      {
        return $this->evaluation_model->insert_student_evaluation();
      }
    }
    //redirect(site_url("pages/profile/evaluation/list_student/".trim_post('class_days_id')), 'refresh');
  }

  public function parent_class_evaluation($section_id)
  {
    //$data['info']=$this->course_manager_model->get_courses_by_id($class_days_id); 
    $data['st_id'] = trim_post("st_id");
    $data['exam_id'] = trim_post("exam_id");
    $data['evaluations'] = $this->evaluation_criteria_manager_model->get_evaluation_type(2);
    $this->load->view('profile/parent_class_evalution', $data, FALSE);
  }

  public function parent_evaluation()
  {
    if($this->input->post('add') != NULL && trim_post('add') == 'ADD')
    {
      if($this->input->post('update_opt') != NULL && trim_post('update_opt') == 'UPDATE')
      {
        return $this->evaluation_model->update_parent_evaluation();
      }
      else
      {
        return $this->evaluation_model->insert_parent_evaluation();
      }
    }
    //redirect(site_url("pages/profile/evaluation/list_student/".trim_post('class_days_id')), 'refresh');
  }

  public function st_terminal_comment($section_id)
  {
    $data['st_id'] = trim_post("st_id");
    $data['exam_id'] = trim_post("exam_id");
    $result = $this->evaluation_model->st_terminal_comment( $data['st_id'],$data['exam_id'],$section_id);
    if($result != NULL)
    {
      echo'<input type="hidden" name="update_opt" value="UPDATE">';
      echo'<textarea class="form-control" placeholder="Remark" name="comment" id="terminal_comment_option" placeholder="Terminal Comment"required >'.$result.'</textarea>';
    }
    else
    {
      echo'<textarea class="form-control" placeholder="Remark" name="comment" id="terminal_comment_option" placeholder="Terminal Comment"required ></textarea>'; 
    }
  }

  public function terminal_comment()
  {
    if($this->input->post('add') != NULL && trim_post('add') == 'ADD')
    {
      if($this->input->post('update_opt') != NULL && trim_post('update_opt') == 'UPDATE')
      {
        return $this->evaluation_model->update_terminal_comment();
      }
      else
      {
        return $this->evaluation_model->insert_terminal_comment();
      }
    }
    //redirect(site_url("pages/profile/evaluation/list_student/".trim_post('class_days_id')), 'refresh');
  }

  /*public function add_evaluation()
  {
    $data['opt_id'] = trim_post('opt_id');
    $data['st_id'] = trim_post('st_id');
    $data['section_id'] = trim_post('section_id');
    $data['evaluations'] = $this->evaluation_criteria_manager_model->get_evaluation_type(trim_post('opt_id'));
    $this->load->view('classes/ajax_st_evaluation', $data);
    //$data['main_content'] = 'profile/list_students';
    //$this->load->view('ajax_template',$data);
  } */


}

/* End of file Evaluation.php */
/* Location: ./application/modules/pages/controllers/profile/Evaluation.php */
