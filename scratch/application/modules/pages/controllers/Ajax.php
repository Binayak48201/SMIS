<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MX_Controller {

 	public function __construct() {
    parent::__construct();
    //modules::run('dashboard/user_log/log');
   /* if (!check_access() || $this->input->get_request_header('x-my-custom-header', TRUE) != 'ajax-head') {
      redirect(site_url('login'), 'refresh');
      exit();
    }*/
   
    $this->load->model('ajax_model');
  }

	public function get_bus_stops()
  {
    $data['results'] = $this->ajax_model->get_bus_stops(trim_post('bus_id'));
    $this->load->view('general_content/ajax_bus_stops', $data);
  }

  public function bus_stops_time_table()
  {
    $data['results'] = $this->ajax_model->bus_stops_time_table(trim_post('bus_id'));
    $this->load->view('general_content/bus_stops_time_table', $data);
  }

  public function get_bus_stop($opt = '')
  {
    $data['opt'] = $opt;
    $data['results'] = $this->ajax_model->get_bus_stop(trim_post('bus_id'));
    $this->load->view('general_content/ajax_bus_stop', $data);
  }

  public function delete_bus_stops()
  {
    $this->ajax_model->delete_bus_stops(trim_post('stop_id'));
    $this->get_bus_stops();
  }
  
  public function add_bus_stops()
	{
    $this->ajax_model->add_bus_stops();
    $this->get_bus_stops();
	}

  public function student_by_bus()
  {
    $this->load->model('reports/general_reports_model');
    $data['students'] = $this->general_reports_model->student_by_bus(trim_get('bus_id'),trim_get('stop_id'));
    $this->load->view('general_content/ajax_bus_student_list', $data);
  }

  public function grade_table_recoder()
  {
    if($this->ajax_model->grade_table_recoder())
      echo TRUE;
    echo FALSE;
  }

  public function get_section($all = '')
  {
    $data['all'] = $all;
    $data['results'] = $this->ajax_model->get_section();
    $this->load->view('classes/ajax_section', $data);
  }
  
  public function get_subject()
  {
    $data['results'] = $this->ajax_model->get_subject();
    $this->load->view('classes/ajax_subject', $data);
  }

  public function get_subject_mark()
  {
    echo json_encode($this->ajax_model->get_subject_mark());
  }

  public function get_class_days()
  {
    $data['results'] = $this->ajax_model->get_class_days(trim_post('section'));
    $this->load->view('exam/ajax_class_days', $data);
  }

  public function get_teacher_class()
  {
    $data['results'] = $this->ajax_model->get_teacher_class(trim_post('section'));
    $this->load->view('exam/ajax_class_days', $data);
  }

  public function check_lession_plan()
  {
    $result = $this->ajax_model->check_lession_plan(trim_post('class_days_id'));
    if($result)
    {
      echo 1;
    }
    else{
      echo 2;
    }
  }

  public function get_class_exams()
  {
    $this->load->model('classes/course_manager_model');
    $info = $this->course_manager_model->get_courses_by_id(trim_post('class_days_id'));
    $data['results'] = $this->ajax_model->get_class_exams($info);
    $this->load->view('classes/ajax_class_exams', $data);
  }

  public function get_lessons()
  {
    $data['results'] = $this->ajax_model->get_lessons(trim_post('class_days_id'));
    $this->load->view('classes/ajax_lessons', $data);
  }

  public function get_topics()
  {
    $data['results'] = $this->ajax_model->get_topics(trim_post('class_days_id'), trim_post('ch_id'));
    $this->load->view('classes/ajax_topics', $data);
  }

  public function update_course_pointer()
  {
    $opt=$this->input->post('option');
    $id=$this->input->post('id');
    echo $this->ajax_model->update_lession($id,$opt);
  }

  public function get_routine()
  {
    //$data['results'] = $this->ajax_model->get_topics(trim_post('class_days_id'), trim_post('ch_id'));
    $data['addons'] = array(
                          site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",   
                          site_url('assets')."/global/plugins/ckeditor/ckeditor.js",  
                        );
    
    $data['main_content'] = 'exam/edit_exam';
    $this->load->view('ajax_template',$data);
  }

  public function check_subjects()
  {
    $result = $this->ajax_model->check_subjects(trim_post('batch'), trim_post('grade'));
    if($result)
    {
      echo 1;
    }
    else{
      echo 2;
    }
  }

  public function get_employee_profile()
  {
    $data['main_content'] = 'profile/employee_profile';
    $data['info'] = $this->ajax_model->get_employee_profile(trim_post('emp_id'));
    $this->load->view('ajax_template',$data);
  }

  public function get_class_routine()
  {
    $result = $this->ajax_model->get_class_routine(trim_post('section_id'));
    if($result != NULL)
      echo $result->routine;
    else
      echo "<div class='note note-info text-center'>Routine Not Added.</div>";
  }

  public function get_exams($opt='')
  {
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['opt'] = $opt;
    $data['results'] = $this->ajax_model->get_exams(trim_post('section'),trim_post('batch'));
    $this->load->view('exam/ajax_exams',$data);
  }

  public function get_id_exams($opt='')
  {
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['opt'] = $opt;
    $data['results'] = $this->ajax_model->get_exams(trim_post('section'),trim_post('batch'));
    $this->load->view('exam/ajax_id_exams',$data);
  }

  public function get_exam_grades()
  {
    $this->load->model('exam/exam_setting_model');
    return $this->exam_setting_model->get_exam_grades(); 
  }

  public function get_exam_info($st_id,$batch,$grade,$exam)
  {
    $this->load->model('exam/exam_setting_model');
    return $this->exam_setting_model->get_exam_info($grade,$batch,$exam); 
  }

  public function get_class_subjects($grade,$batch)
  {
    $this->load->model('exam/exam_setting_model');
    return $this->exam_setting_model->get_class_subjects($grade,$batch); 
  }

  public function get_assessments($grade,$batch)
  {
    $this->load->model('exam/exam_setting_model');
    return $this->exam_setting_model->get_assessments($grade,$batch); 
  }
  
  public function get_st_info($st_id)
  {
    return $this->ajax_model->get_st_info($st_id); 
  }

  public function get_st_with_attendance($st_id,$grade,$batch,$exam)
  {
    return $this->ajax_model->get_st_with_attendance($st_id,$grade,$batch,$exam); 
  }

  public function get_final_exam($batch,$grade)
  {
    return $this->ajax_model->get_final_exam($batch,$grade); 
  }

  public function get_grade($percent)
  {
    return $this->ajax_model->get_grade($percent); 
  }

  public function get_st_terminal_comment($st_id,$grade,$batch,$exam)
  {
    return $this->ajax_model->get_st_terminal_comment($st_id,$grade,$batch,$exam); 
  }

  public function get_st_appraisal($st_id,$grade,$batch,$exam,$head_id)
  {
    return $this->ajax_model->get_st_appraisal($st_id,$grade,$batch,$exam,$head_id); 
  }

  public function marksheet_view()
  {
    $data['styles'] = array(
                          /*site_url('assets') . "/global/plugins/bootstrap/css/bootstrap.min.css",   
                          site_url('assets') . "/global/css/components-md.css",   
                          site_url('assets') . "/admin/layout2/css/layout.css",   */
                          site_url('assets') . "/admin/layout2/css/print.css",   
                           
                        );
    $this->load->model('exam/exam_setting_model');
    $this->load->model('classes/appraisal_manager_model');
    $data['jscript']="

        function printDiv(divID) {

        var mywindow = window.open('', 'PRINT', 'height=700,width=900');

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write('<link href=\"".site_url('assets')."/admin/layout2/css/print.css\" rel=\"stylesheet\" type=\"text/css\"/>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById(divID).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
        }
      ";
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['st_id'] = trim_post('st_id');
    $data['batch'] = trim_post('batch');
    $data['exam'] = trim_post('exam');
    $data['grade'] = trim_post('grade');
    $data['assessment_module'] = 0;
    $data['final_grading'] = 0;
    if($data['theme_option']->assessment_module)
    {
      $data['assessment_module'] = 1;
    }
    if($data['theme_option']->final_upscale_marking)
    {
      $data['final_grading'] = 1;
      $data['exams'] = $this->ajax_model->get_all_exams(trim_post('grade'),trim_post('batch'));
    }

    $data['appraisal_heads'] = $this->appraisal_manager_model->get_appraisals();
    $data['main_content'] = 'reports/marksheet_view';
    $this->load->view('ajax_template',$data);
   // $data['info'] = $this->ajax_model->get_employee_profile(trim_post('emp_id'));
  }

  public function st_marksheet_view($st_id,$batch,$exam,$grade)
  {
      $this->load->model('exam/exam_setting_model');
      $this->load->model('classes/appraisal_manager_model');
      
      $data['theme_option'] = $this->theme_model->get_theme_data();
      $data['st_id'] = $st_id;
      $data['batch'] = $batch;
      $data['exam'] = $exam;
      $data['grade'] = $grade;
      $data['assessment_module'] = 0;
      $data['final_grading'] = 0;
      if($data['theme_option']->assessment_module)
      {
        $data['assessment_module'] = 1;
      }
      if($data['theme_option']->final_upscale_marking)
      {
        $data['final_grading'] = 1;
        $data['exams'] = $this->ajax_model->get_all_exams($grade,$batch);
      }

      $data['appraisal_heads'] = $this->appraisal_manager_model->get_appraisals();
      $data['main_content'] = 'reports/marksheet_view';
      //$this->load->view('ajax_template',$data);
      $this->load->view('reports/marksheet_view',$data);
     // $data['info'] = $this->ajax_model->get_employee_profile(trim_post('emp_id'));
  }

  public function marksheet_graph_view()
  {
    $data['st_id'] = trim_post('st_id');
    $data['batch'] = trim_post('batch');
    $data['exam'] = trim_post('exam');
    $data['grade'] = trim_post('grade');
    $data['main_content'] = 'reports/marksheet_graph_view';
    $this->load->view('ajax_template',$data);
  }

  public function check_assesment_number()
  {
    $result = $this->ajax_model->check_assesment_number(trim_post("section"),trim_post("subject"),trim_post("numeric_value"));
    if($result)
      echo 1;
    else
      echo 0;
  }

  public function check_exam_number()
  {
    $result = $this->ajax_model->check_exam_number(trim_post("section"),trim_post("subject"),trim_post("numeric_value"));
    if($result)
      echo 1;
    else
      echo 0;
  }

  public function students_attandance_by_grade($st_id,$section_id,$exam_id)
  {
    return $this->ajax_model->students_attandance_by_grade($st_id,$section_id,$exam_id);
  }

  public function attendance_graph_view()
  {
    $data['st_id'] = trim_post('st_id');
    $data['batch'] = trim_post('batch');
    $data['exam'] = trim_post('exam');
    $data['grade'] = trim_post('grade');
    $data['section'] = trim_post('section');
    $data['result'] =  $this->ajax_model->students_attandance_by_grade($data['st_id'],$data['section'],$data['exam']);
    $data['main_content'] = 'reports/attendance_graph_view';
    $this->load->view('ajax_template',$data);
  }

  public function get_clubs()
  {
    $this->load->model('classes/club_manager_model');
    $data['results'] = $this->club_manager_model->get_club_by_type(trim_post('club_id'));
    $this->load->view('ajax_get_clubs',$data);
  }
  public function add_st_club()
  {
    check_access('su_admin');
    if($this->ajax_model->add_st_club())
    {
      echo"<script>message_display('success','Club Added Succesfully.');</script>";
    }
    else
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_clubs(trim_post('st_id'));
    $this->load->view('reports/ajax_add_st_club',$data);
  }

  public function delete_st_club()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_club())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_clubs(trim_post('st_id'));
    $this->load->view('reports/ajax_add_st_club',$data);
  }

  public function add_st_medication()
  {
    check_access('su_admin');
    if($this->ajax_model->add_st_medication())
    {
      echo"<script>message_display('success','Medication Added Succesfully.');</script>";
    }
    else
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_medications(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_medications',$data);
  }

  public function delete_st_medication()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_medication())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_medications(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_medications',$data);
  }

  public function add_st_consultant()
  {
    check_access('su_admin');
    if($this->ajax_model->add_st_doctor())
    {
      echo"<script>message_display('success','Doctor Added Succesfully.');</script>";
    }
    else
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_consultants(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_consultants',$data);
  }

  public function delete_st_consultant()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_doctor())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_consultants(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_consultants',$data);
  }

  public function add_st_responsibility()
  {
    check_access('su_admin');
    if($this->ajax_model->add_st_responsibility())
    {
      echo"<script>message_display('success','Responsibility Added Succesfully.');</script>";
    }
    else
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_responsibilities(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_responsibilities',$data);
  }

  public function delete_st_responsibility()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_responsibility())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_responsibilities(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_responsibilities',$data);
  }
  public function add_st_game()
  {
    check_access('su_admin');
    if($this->ajax_model->add_st_game())
    {
      echo"<script>message_display('success','Game Added Succesfully.');</script>";
    }
    else
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_games(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_games',$data);
  }

  public function delete_st_game()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_game())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_games(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_games',$data);
  }

  public function add_st_hobby()
  {
    check_access('su_admin');
    if($this->ajax_model->add_st_hobby())
    {
      echo"<script>message_display('success','Hobby Added Succesfully.');</script>";
    }
    else
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_hobbies(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_hobbies',$data);
  }

  public function delete_st_hobby()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_hobby())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_hobbies(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_hobbies',$data);
  }

  public function add_st_achievement()
  {
    check_access('su_admin');
    if($this->ajax_model->add_st_achievement())
    {
      echo"<script>message_display('success','Achievement Added Succesfully.');</script>";
    }
    else
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_achievements(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_achievements',$data);
  }

  public function delete_st_achievement()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_achievement())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_achievements(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_achievements',$data);
  }

  public function add_st_sibling()
  {
    check_access('su_admin');
    if($this->ajax_model->add_st_sibling())
    {
      echo"<script>message_display('success','Sibling Added Succesfully.');</script>";
    }
    else
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_siblings(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_siblings',$data);
  }

  public function delete_st_sibling()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_sibling())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_siblings(trim_post('st_id'));
    $this->load->view('reports/ajax_list_st_siblings',$data);
  }

  public function profile_data($value='')
  {
    $data['addons']=array(
      site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js", 
      site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",      
    );
    $st_id = trim_post('st_id');
    $data['st_id'] = $st_id;
    if(trim_post('text') == 'Clubs')
    {
      $this->load->model('classes/club_manager_model');
      $data['club_types'] = $this->club_manager_model->get_club_type();
      $data['results'] = $this->ajax_model->st_clubs($st_id);
      $data['ajax_script'] = array(
        "0" => "
          $('#club_type').change(function(){
            $('#clubs').html('<option>loading.</option>');
            const club_id = $(this).val();
            $.post('".site_url('pages/ajax/get_clubs')."', {club_id: club_id})
            .done(function(result) {
                  $('#clubs').html(result);
            })
            .fail(function() {
              console.log('error');
            });


          });
        ",
        "1" =>"
          $('#add_clubs').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_club')."', $('#add_clubs').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#add_clubs')[0].reset();
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_clubs',function(e){
             if(!confirm('Are you sure?'))
              return false;
            const st_club_id = $(this).attr('data-id');
            const st_id = $('#st_id').val();
            $.post('".site_url('pages/ajax/delete_st_club')."', {st_club_id:st_club_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        "
      );
      $data['main_content'] = 'reports/ajax_student_clubs';
    }
    else if(trim_post('text') == 'Medical_Conditions')
    {
      $data['styles'] = array(
            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            );
      $data['script'] = "
                    $( '.date-picker' ).datepicker();
                ";
      $data['results'] = $this->ajax_model->st_medical_condition($st_id);
      $data['ajax_script'] = array(
        "1" =>"
          $('#add_condition').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_medical_condition')."', $('#add_condition').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#reset').trigger('click');
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_conditions',function(){
            if(!confirm('Are you sure?'))
              return false;
            const st_id = $('#st_id').val();
            const st_condition_id = $(this).attr('data-id');
            $.post('".site_url('pages/ajax/delete_st_medical_condition')."', {st_condition_id:st_condition_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
         "0" =>"
          $('div').on('click','#reset',function(){
            $('#opt_stat').val('Add');
          });
        "
      );
      $data['main_content'] = 'reports/ajax_student_medical_conditions';
    }
    else if(trim_post('text') == 'Medications')
    {
      $data['results'] = $this->ajax_model->st_medications($st_id);
      $data['ajax_script'] = array(
        "1" =>"
          $('#add_medication').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_medication')."', $('#add_medication').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#add_medication')[0].reset();
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_medication',function(e){
            if(!confirm('Are you sure?'))
              return false;
            const st_medication_id = $(this).attr('data-id');
            const st_id = $('#st_id').val();
            $.post('".site_url('pages/ajax/delete_st_medication')."', {st_medication_id:st_medication_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        "
      );
      $data['main_content'] = 'reports/ajax_student_medications';
    }
    else if(trim_post('text') == 'Doctor/Regular_Consultant')
    {
      $data['results'] = $this->ajax_model->st_consultants($st_id);
      $data['ajax_script'] = array(
        "1" =>"
          $('#add_consultant').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_consultant')."', $('#add_consultant').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#add_consultant')[0].reset();
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_consultant',function(e){
            if(!confirm('Are you sure?'))
              return false;
            const doctor_id = $(this).attr('data-id');
            const st_id = $('#st_id').val();
            $.post('".site_url('pages/ajax/delete_st_consultant')."', {doctor_id:doctor_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        "
      );
      $data['main_content'] = 'reports/ajax_student_consultants';
    }
    else if(trim_post('text') == 'Achievements')
    {
      $data['results'] = $this->ajax_model->st_achievements($st_id);
      $data['ajax_script'] = array(
        "1" =>"
          $('#add_achievement').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_achievement')."', $('#add_achievement').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#add_achievement')[0].reset();
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_achievement',function(e){
            if(!confirm('Are you sure?'))
              return false;
            const st_achievement_id = $(this).attr('data-id');
            const st_id = $('#st_id').val();
            $.post('".site_url('pages/ajax/delete_st_achievement')."', {st_achievement_id:st_achievement_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        "
      );
      $data['main_content'] = 'reports/ajax_student_achievements';
    }
    else if(trim_post('text') == 'Responsibilities')
    {
      $data['results'] = $this->ajax_model->st_responsibilities($st_id);
      $data['ajax_script'] = array(
        "1" =>"
          $('#add_responsibility').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_responsibility')."', $('#add_responsibility').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#add_responsibility')[0].reset();
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_responsibility',function(){
            console.log('error');
            if(!confirm('Are you sure?'))
              return false;
            const st_responsibilities_id = $(this).attr('data-id');
            const st_id = $('#st_id').val();
            $.post('".site_url('pages/ajax/delete_st_responsibility')."', {st_responsibilities_id:st_responsibilities_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        "
      );
      $data['main_content'] = 'reports/ajax_student_responsibilities';
    }
    else if(trim_post('text') == 'Interested_Games')
    {
      $data['results'] = $this->ajax_model->st_games($st_id);
      $data['ajax_script'] = array(
        "1" =>"
          $('#add_game').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_game')."', $('#add_game').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#add_game')[0].reset();
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_game',function(){
            console.log('error');
            if(!confirm('Are you sure?'))
              return false;
            const st_game_id = $(this).attr('data-id');
            const st_id = $('#st_id').val();
            $.post('".site_url('pages/ajax/delete_st_game')."', {st_game_id:st_game_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        "
      );
      $data['main_content'] = 'reports/ajax_student_interested_games';
    }
    else if(trim_post('text') == 'Hobbies')
    {
      $data['results'] = $this->ajax_model->st_hobbies($st_id);
      $data['ajax_script'] = array(
        "1" =>"
          $('#add_hobby').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_hobby')."', $('#add_hobby').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#add_hobby')[0].reset();
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_hobby',function(){
            console.log('error');
            if(!confirm('Are you sure?'))
              return false;
            const st_hobby_id = $(this).attr('data-id');
            const st_id = $('#st_id').val();
            $.post('".site_url('pages/ajax/delete_st_hobby')."', {st_hobby_id:st_hobby_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        "
      );
      $data['main_content'] = 'reports/ajax_student_hobbies';
    }
    else if(trim_post('text') == 'Siblings')
    {
      $data['styles'] = array(
            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            );
      $data['script'] = "
                    $( '.date-picker' ).datepicker();
                ";
      $data['results'] = $this->ajax_model->st_siblings($st_id);
      $data['ajax_script'] = array(
        "1" =>"
          $('#add_sibling').submit(function(e){
            e.preventDefault();
            $.post('".site_url('pages/ajax/add_st_sibling')."', $('#add_sibling').serialize())
            .done(function(result) {
              $('#lists').html(result);
              $('#add_sibling')[0].reset();
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
        "2" =>"
          $('div#lists').on('click','#delete_sibling',function(){
            console.log('error');
            if(!confirm('Are you sure?'))
              return false;
            const sibling_id = $(this).attr('data-id');
            const st_id = $('#st_id').val();
            $.post('".site_url('pages/ajax/delete_st_sibling')."', {sibling_id:sibling_id,st_id:st_id})
            .done(function(result) {
              $('#lists').html(result);
            })
            .fail(function() {
              console.log('error');
            });
            
          });
        ",
      );
      $data['main_content'] = 'reports/ajax_student_siblings';
    }
    $this->load->view('ajax_template',$data);
  }

  public function add_st_medical_condition()
  {
    check_access('su_admin');
    if(trim_post('stat') == 'Update')
    {
      if($this->ajax_model->update_st_medical_condition())
      {
        echo"<script>message_display('success','Medical Condition Updated Succesfully.');</script>";
      }
      else
      {
        echo"<script>message_display('danger','Ajax Error');</script>";
      }
    }
    else
    {
      if($this->ajax_model->add_st_medical_condition())
      {
        echo"<script>message_display('success','Medical Condition Added Succesfully.');</script>";
      }
      else
      {
        echo"<script>message_display('danger','Ajax Error');</script>";
      }
    }

    $data['results'] = $this->ajax_model->st_medical_condition(trim_post('st_id'));
    $this->load->view('reports/st_medical_condition_list',$data);
  }

  public function delete_st_medical_condition()
  {
    check_access('su_admin');
    if(!$this->ajax_model->delete_st_medical_condition())
    {
      echo"<script>message_display('danger','Ajax Error');</script>";
    }
    $data['results'] = $this->ajax_model->st_medical_condition(trim_post('st_id'));
    $this->load->view('reports/st_medical_condition_list',$data);
  }

  public function get_employee_account()
  {
    $data['profile_id'] = trim_post('emp_id');
    $this->load->model('theme_option/user_account_model');
    $this->load->model('theme_option/manage_menu_model');
    $stat = $this->user_account_model->check_account($data['profile_id']);
    if($stat != NULL)
    {
      $data['status'] = 'exist';
      $data['user']=$stat; 
    }
    else
    {
      $data['status'] ='new';
    }
    $data['script'] = "$( '#createuser' ).submit(function( e ) {
      //e.preventDefault();
      var pass=$('#pass').val();
      var con_pass=$('#repass').val();
      if(pass==con_pass)
      {
          $( '#createuser' ).submit();
      }
      else
      {
          //alert('not same');
          $( '#conf-pass' ).addClass('has-error');
          $( '#error_pass' ).show();
          return false;
      }
    });";
    $data['result']=$this->manage_menu_model->get_user_type();
    $data['main_content'] = 'reports/ajax_user_account';
    $this->load->view('ajax_template',$data);

  }

  public function st_evaluation()
  {
    $this->load->model('classes/evaluation_criteria_manager_model');
    $this->load->model('profile/evaluation_model');
    $data['evaluations'] = $this->evaluation_criteria_manager_model->get_evaluation_type(1);
    $data['st_id'] = $this->input->get('st_id');
    $data['exam_id'] = $this->input->get('exam_id');
    $data['section_id'] = $this->input->get('section_id');
    //$data['results'] = $this->evaluation_model->get_st_evaluated(1,,$this->input->get('exam_id'));
    //$data['main_content'] = 'reports/st_class_evalution';
    //$this->load->view('ajax_template',$data);
    $this->load->view('pages/reports/st_class_evalution',$data);
  }

  public function pt_evaluation()
  {
    $this->load->model('classes/evaluation_criteria_manager_model');
    $this->load->model('profile/evaluation_model');
    $data['evaluations'] = $this->evaluation_criteria_manager_model->get_evaluation_type(2);
    $data['st_id'] = $this->input->get('st_id');
    $data['exam_id'] = $this->input->get('exam_id');
    $data['section_id'] = $this->input->get('section_id');
    //$data['results'] = $this->evaluation_model->get_st_evaluated(1,,$this->input->get('exam_id'));
    //$data['main_content'] = 'reports/st_class_evalution';
    //$this->load->view('ajax_template',$data);
    $this->load->view('pages/reports/pt_class_evalution',$data);
  }

  public function sst_evaluation()
  {
    $this->load->model('classes/evaluation_criteria_manager_model');
    
    $data['evaluations'] = $this->evaluation_criteria_manager_model->get_evaluation_type(3);
    $data['st_id'] = $this->input->get('st_id');
    $data['exam_id'] = $this->input->get('exam_id');
    $data['subject_id'] = $this->input->get('subject_id');
    //$data['results'] = $this->evaluation_model->get_st_evaluated(1,,$this->input->get('exam_id'));
    //$data['main_content'] = 'reports/st_class_evalution';
    //$this->load->view('ajax_template',$data);
    $this->load->view('pages/reports/sst_class_evalution',$data);
  }

  public function st_appraisal()
  {
    $this->load->model('classes/appraisal_manager_model');

    $data['st_id'] = $this->input->get("st_id");
    $data['exam_id'] = $this->input->get("exam_id");
    $data['section_id'] = $this->input->get('section_id');
    $data['ap_heades'] = $this->appraisal_manager_model->get_appraisals();
    $data['grades'] = $this->appraisal_manager_model->get_grades();
    $this->load->view('pages/reports/st_appraisal',$data);
  }

  public function st_terminal_comment()
  {
    $this->load->model('profile/evaluation_model');
    $data['st_id'] = $this->input->get("st_id");
    $data['exam_id'] = $this->input->get("exam_id");
    $data['section_id'] = $this->input->get('section_id');
    $result = $this->evaluation_model->st_terminal_comment( $data['st_id'],$data['exam_id'],$data['section_id'] );
    if($result != NULL)
    {
     
      echo'<label><b>Terminal Feedback:</b></label><textarea class="form-control" placeholder="Remark" name="comment" id="terminal_comment_option" readonly placeholder="Terminal Comment"required >'.$result.'</textarea>';
    }
    else
    {
      echo'<div class="note note-info text-center">No Feedback Given.</div>'; 
    }
  }

  public function get_activity_detail($class_days_id)
  {
    $this->load->model('classes/lession_plan_model');
    //$data['info'] = $this->lession_plan_model->get_info_by_topic(trim_post('id'));
    $data['activities'] = $this->lession_plan_model->get_activity_detail(trim_post('id'));
    $this->load->view('pages/classes/activity_detail', $data);
  }

  public function get_class_teacher($section_id)
  {
    return $this->ajax_model->get_class_teacher($section_id);
  }

  public function get_st_feedback()
  {
    $st_id = $this->input->get('student_id');
    $class_days_id = $this->input->get('class_days_id');
    $data['feedbacks'] = $this->ajax_model->get_st_feedback($st_id, $class_days_id);
    $this->load->view('pages/profile/st_feedback', $data);
  }

  public function get_st_feedback_sub()
  {
    $st_id = $this->input->get('st_id');
    $subject_id = $this->input->get('subject_id');
    $data['feedbacks'] = $this->ajax_model->get_st_feedback_sub($st_id, $subject_id);
    
    $this->load->view('pages/profile/st_feedback', $data);
  }

  public function teacher_feedback_list()
  {
    $employee_id = trim_get('employee_id');
    $from_date = trim_get('from_date');
    $to_date = trim_get('to_date');
    $data['feedbacks'] = $this->ajax_model->get_feedback_date($from_date, $to_date, $employee_id);
    
    $this->load->view('pages/profile/teacher_feedback_list', $data);
  }
}