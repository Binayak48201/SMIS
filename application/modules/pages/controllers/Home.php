<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		check_access();
	}

	public function index()
	{
    modules::run('dashboard/user_log/log');
    $this->load->model('notification_model');
    $data['notification'] = $this->notification_model->show_notification($this->session->userdata('smis_usertype_id'));
    $data['change_pass']=$this->session->userdata('smis_reset_pass');
    

    $data['styles'] = array(
      site_url('assets') . "/admin/pages/css/profile.css",
      site_url('assets')."/global/css/styles.css",
      site_url('assets') . "/admin/pages/css/tasks.css",
    );

    $data['script']="
                      $('#ticker').tickerme(
                         {
                          fade_speed: 1000,
                          duration: 10000,
                         });                       
                    ";
    if($this->session->userdata('smis_reset_pass'))
    {
      $data['ajax_script']=array('0'=>"$('#initial_reset').trigger('click');" );
    }   

    $data['addons']=array(
      site_url('assets')."/global/scripts/ticker.js",
      site_url('assets')."/global/scripts/ticker.min.js",
    ); 
    $user_type=$this->session->userdata("smis_role");
   
    $this->load->model('bug_model');
    $t_date = date('Y-m-d');
    $data['theme_option'] = $this->theme_model->get_theme_data();
    //$data['bug_report'] = $this->bug_model->get_new_bug();
    //$scholar_id = $data['theme_option']->scholar_id;
    //$data['latest_info'] = $this->payments_model->get_updates($scholar_id,$t_date,1);
    //$data['latest_waived'] = $this->payments_model->day_waived($scholar_id,$t_date,1);
    if($user_type == 'su_admin')
    {
      $data['main_content'] = 'admin_home';
    }
    else if($user_type == 'teacher'){
      $data['ajax_script']=array(
        '1' => "$('.class_routine').click(function(){
          const section_id = $(this).attr('data-id');
          $('#section_name').html($(this).attr('data-for'));
          $.post('".site_url('pages/ajax/get_class_routine')."', {section_id: section_id})
          .done(function(result) {
            $('#routine_display').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });"
      );
      $this->load->model('classes/class_manager_model');
      $this->load->model('classes/section_manager_model');
      $this->load->model('ajax_model');
      //$date = explode('-',AD_to_BS());
      $emp_id = $this->session->userdata("smis_profile_id");
      $data['info'] = $this->ajax_model->get_employee_profile($this->session->userdata('smis_profile_id'));
      $data['classes'] = $this->class_manager_model->teacher_current_class($emp_id, date('Y-m-d'));
      $data['sections'] = $this->section_manager_model->class_teacher_section($emp_id, date('Y-m-d'));
      //print_e($this->db->last_query());
      $data['main_content'] = 'teacher_home';
    }
    else if($user_type == 'board' || $user_type == 'admin'){
      $data['ajax_script']=array(
        '1' => "$('.class_routine').click(function(){
          const section_id = $(this).attr('data-id');
          $('#section_name').html($(this).attr('data-for'));
          $.post('".site_url('pages/ajax/get_class_routine')."', {section_id: section_id})
          .done(function(result) {
            $('#routine_display').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });"
      );
      $data['addons']=array(
        //site_url('assets') . "/global/scripts/loader.js",
        // site_url('assets')."/global/scripts/ticker.js",
        site_url('assets')."/global/scripts/ticker.min.js",
      ); 
      $this->load->model('classes/class_manager_model');
      $this->load->model('classes/section_manager_model');
      $this->load->model('classes/grade_manager_model');
      $data['grades'] = $this->grade_manager_model->get_grades();
      //$date = explode('-',AD_to_BS());
      //$emp_id = $this->session->userdata("smis_profile_id");
      $data['main_content'] = 'board_home';
    }
    else if($user_type == 'student')
    {
      $this->load->model('ajax_model');
      $this->load->model('profile/evaluation_model');
      $this->load->model('profile/student_model');
      $this->load->model('classes/course_manager_model');
      $st_id = $this->session->userdata("smis_profile_id");
      $data['results'] = $this->student_model->get_st_details($st_id);
      $data['ajax_script'] = array(
      "0" => "
          $('.pop').click(function(){
            const text = $(this).attr('data-id');
            const st_id = ".$st_id.";
            $('#caption').text(text);
             $.post('".site_url('pages/ajax/profile_data')."', {text: text,st_id: st_id})
             .done(function(result) {
                  $('#modal-body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      "1" => "
          $('.st_evaluation').click(function(){
            const exam_id = $(this).attr('data-id');
            const section_id = $(this).attr('data-section-id');
            const caption = $(this).attr('data-caption');
            const st_id = ".$st_id.";
            $('#eval_caption').text(caption);
            $.get('".site_url('pages/ajax/st_evaluation')."', {exam_id: exam_id,st_id: st_id,section_id:section_id})
             .done(function(result) {
                  $('#st_evaluation_body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      "2" => "
          $('.pt_evaluation').click(function(){
            const exam_id = $(this).attr('data-id');
            const section_id = $(this).attr('data-section-id');
            const caption = $(this).attr('data-caption');
            const st_id = ".$st_id.";
            $('#pt_eval_caption').text(caption);
            $.get('".site_url('pages/ajax/pt_evaluation')."', {exam_id: exam_id,st_id: st_id,section_id:section_id})
             .done(function(result) {
                  $('#pt_evaluation_body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      "3" => "
          $('.sst_evaluation').click(function(){
            const exam_id = $(this).attr('data-id');
            const subject_id = $(this).attr('data-subject-id');
            const caption = $(this).attr('data-caption');
            const st_id = ".$st_id.";
            $('#sst_eval_caption').text(caption);
            $.get('".site_url('pages/ajax/sst_evaluation')."', {exam_id: exam_id,st_id: st_id,subject_id:subject_id})
             .done(function(result) {
                  $('#sst_evaluation_body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      '4' => "$('.class_routine').click(function(){
          const section_id = $(this).attr('data-id');
          $.post('".site_url('pages/ajax/get_class_routine')."', {section_id: section_id})
          .done(function(result) {
            $('#class_Routine').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });",
        '5' => "$('.feedback_view').click(function(){
          const class_days_id = $(this).attr('data-id');
          const student_id = $(this).attr('data-st-id');
          const caption = $(this).attr('data-caption');
          $('#feedback_caption').text(caption);
          $.get('".site_url('pages/ajax/get_st_feedback')."', {class_days_id: class_days_id, student_id: student_id})
          .done(function(result) {
            $('#feedback-modal-body').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });"
     
      );
    
      $data['jscript']="

        function printDiv(divID) {
        var mywindow = window.open('', 'PRINT', 'height=700,width=900');

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        //mywindow.document.write('<link href=\"".site_url('assets')."/global/plugins/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\"/>'); 
        mywindow.document.write('<link href=\"".site_url('assets')."/admin/layout2/css/print.css\" rel=\"stylesheet\" type=\"text/css\"/>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById(divID).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        //mywindow.close();

        return true;
        }
      ";
      $data['exams'] = $this->ajax_model->get_exams($data['results']->section_id);
      $data['st_evaluations'] = $this->evaluation_model->get_st_evaluation_head($data['results']);
      $data['pt_evaluations'] = $this->evaluation_model->get_pt_evaluation_head($data['results']);
      //print_e($this->db->last_query());

      $data['courses'] = $this->course_manager_model->get_st_classes($data['results']);
      $data['sst_evaluations'] = $this->evaluation_model->get_sst_evaluation_head($data['results']);
      $data['main_content'] = 'student_home';
    }else if($user_type == 'parent')
    {
      $this->load->model('ajax_model');
      $this->load->model('profile/evaluation_model');
      $this->load->model('profile/student_model');
      $this->load->model('classes/course_manager_model');
      $st_id = $this->session->userdata("smis_profile_id");
      $data['results'] = $this->student_model->get_st_details($st_id);
      $data['ajax_script'] = array(
      "0" => "
          $('.pop').click(function(){
            const text = $(this).attr('data-id');
            const st_id = ".$st_id.";
            $('#caption').text(text);
             $.post('".site_url('pages/ajax/profile_data')."', {text: text,st_id: st_id})
             .done(function(result) {
                  $('#modal-body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      "1" => "
          $('.st_evaluation').click(function(){
            const exam_id = $(this).attr('data-id');
            const section_id = $(this).attr('data-section-id');
            const caption = $(this).attr('data-caption');
            const st_id = ".$st_id.";
            $('#eval_caption').text(caption);
            $.get('".site_url('pages/ajax/st_evaluation')."', {exam_id: exam_id,st_id: st_id,section_id:section_id})
             .done(function(result) {
                  $('#st_evaluation_body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      "2" => "
          $('.pt_evaluation').click(function(){
            const exam_id = $(this).attr('data-id');
            const section_id = $(this).attr('data-section-id');
            const caption = $(this).attr('data-caption');
            const st_id = ".$st_id.";
            $('#pt_eval_caption').text(caption);
            $.get('".site_url('pages/ajax/pt_evaluation')."', {exam_id: exam_id,st_id: st_id,section_id:section_id})
             .done(function(result) {
                  $('#pt_evaluation_body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      "3" => "
          $('.sst_evaluation').click(function(){
            const exam_id = $(this).attr('data-id');
            const subject_id = $(this).attr('data-subject-id');
            const caption = $(this).attr('data-caption');
            const st_id = ".$st_id.";
            $('#sst_eval_caption').text(caption);
            $.get('".site_url('pages/ajax/sst_evaluation')."', {exam_id: exam_id,st_id: st_id,subject_id:subject_id})
             .done(function(result) {
                  $('#sst_evaluation_body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      '4' => "$('.class_routine').click(function(){
          const section_id = $(this).attr('data-id');
          $.post('".site_url('pages/ajax/get_class_routine')."', {section_id: section_id})
          .done(function(result) {
            $('#class_Routine').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });",
        '5' => "$('.feedback_view').click(function(){
          const class_days_id = $(this).attr('data-id');
          const student_id = $(this).attr('data-st-id');
          const caption = $(this).attr('data-caption');
          $('#feedback_caption').text(caption);
          $.get('".site_url('pages/ajax/get_st_feedback')."', {class_days_id: class_days_id, student_id: student_id})
          .done(function(result) {
            $('#feedback-modal-body').html(result);
          })
          .fail(function() {
            console.log('error');
          });
        });"
     
      );
    
      $data['jscript']="

        function printDiv(divID) {
        var mywindow = window.open('', 'PRINT', 'height=700,width=900');

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        //mywindow.document.write('<link href=\"".site_url('assets')."/global/plugins/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\"/>'); 
        mywindow.document.write('<link href=\"".site_url('assets')."/admin/layout2/css/print.css\" rel=\"stylesheet\" type=\"text/css\"/>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById(divID).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        //mywindow.close();

        return true;
        }
      ";
      $data['exams'] = $this->ajax_model->get_exams($data['results']->section_id);
      $data['st_evaluations'] = $this->evaluation_model->get_st_evaluation_head($data['results']);
      $data['pt_evaluations'] = $this->evaluation_model->get_pt_evaluation_head($data['results']);
      //print_e($this->db->last_query());

      $data['courses'] = $this->course_manager_model->get_st_classes($data['results']);
      $data['sst_evaluations'] = $this->evaluation_model->get_sst_evaluation_head($data['results']);
      $data['main_content'] = 'parent_home';
    }
		$this->load->view('template',$data);
	}

  public function find_menu()
  {

    $data['ajax_script']=array(
      '0'=>"
          $('#find_menu').keyup(function(){
            var txt = $(this).val();
            if(txt.length >= 3)
            {
               $.post('".site_url('pages/home/menu_list')."', {option: txt})
              .done(function(result) {
                   $('#menu_list').html(result);
                 //alert(result);
              })
              .fail(function() {
                 console.log('error');
              });
             // alert(txt);
            }
            else
            {
              $('#menu_list').html('');
            }
          });
        "
        );

    $data['main_content']='find_menu';
    $data['theme_option']=$this->theme_model->get_theme_data();
    
    $this->load->view('template',$data);
  }

  public function menu_list()
  {

    $this->load->model('manage_menu_model');
    $option=$this->input->post('option');
    $data['result']=$this->manage_menu_model->menu_list($option);
    $this->load->view('pages/menu_list',$data);
  }

  public function access_control($value='')
  {
    $this->load->model('user_account_model');
    $data['styles'] = array(
          site_url('assets')."/global/css/styles.css",
      );
      $data['script']="
                         $('#ticker').tickerme(
                         {
                          fade_speed: 1000,
                          duration: 10000,
                         });
                    ";
    
    $user_type=$this->session->userdata("smis_role");

      $data['styles'] = array(
          site_url('assets') . "/admin/pages/css/profile.css",
          site_url('assets')."/global/css/styles.css",
          site_url('assets') . "/admin/pages/css/tasks.css",
      );
      $data['results']=$this->user_account_model->get_block_list($this->session->userdata('smis_profile_id'));
      $data['main_content']='access_control';
 
   
    $data['theme_option']=$this->theme_model->get_theme_data();
    
    $this->load->view('template',$data);
  }

  public function allow_ip($id)
  {
    $this->load->model('user_account_model');
    $result = $this->user_account_model->allow_ip($id);
    if ($result) {
      $this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('error_msg', 'Ip Unblocked Succesfully');
    } else {
      $this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('error_msg', 'Error occured while Unblocking Ip');
    }
    redirect(site_url("pages/home/access_control"), 'refresh');
  }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */