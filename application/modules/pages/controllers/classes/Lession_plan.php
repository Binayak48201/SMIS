
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lession_plan extends MX_Controller {

	public function __construct() {
    parent::__construct();
    modules::run('dashboard/user_log/log');
    check_access();
    $this->load->model('classes/batch_model');
    $this->load->model('classes/lession_plan_model');
    $this->load->model('classes/grade_manager_model');
    $this->load->model('classes/section_manager_model');
    $this->load->model('classes/course_manager_model');
    $this->load->model('control/employee_control_model');
  }

  public function index()
  {
    if($this->input->post('view')!=NULL && $this->input->post('view')=='VIEW')
    {
      redirect(site_url("pages/course_pointer/lession_plan/view/".$this->input->post('course_id')),'refresh');
    }
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
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

            }
            else
            {
              $('#section').html('<option value=\"\">Select Sections</option>');
            }
          });",
      "1" => "
      $('.display_class').change(function(){
            const section = $('#section').val();

            if(section != '')
            {
              $.post('".site_url('pages/ajax/get_class_days')."', {section: section})
               .done(function(result) {
                $('#subject').html(result);
              })
              .fail(function() {
                console.log('error');
              });
            }
          });",
      "2" => "
      $('#subject').change(function(){
            $('.exams').html('<option>Loading..</option>');
            const class_days_id = $('#subject').val();

            if(class_days_id != '')
            {
              $.post('".site_url('pages/ajax/get_class_exams')."', {class_days_id: class_days_id})
               .done(function(result) {
                $('.exams').html(result);
              })
              .fail(function() {
                console.log('error');
              });
            }
          });",
              
           '3'=>"$('#delete_row_no').click(function()
          {
            var id=$('#row_id').val();
            if(id>0)
            {
              var inp=$('table tbody.frm_body tr:nth-child('+id+')').remove();
            }
            else
            {
              var inp=$('table tbody.frm_body tr').last().remove();
            }
          });",
          '4'=>"$('#insert_row_no').click(function()
          {
            var id=$('#row_id').val();
            const data_row = $('#addditional_row').html();
            //console.log(data_row);
            if(id>0)
            {
              $(data_row).insertBefore('table tbody.frm_body tr:nth-child('+id+')');
            }
            else
            {
                $('table tbody.frm_body').append(data_row);
            }
           
          });"
    );
    $data['addons'] = array(
        site_url('assets') . "/global/plugins/select2/select2.min.js",
        site_url('assets') . "/global/plugins/jquery-validation/js/jquery.validate.min.js", //required for date picker
        site_url('assets') . "/admin/pages/scripts/form-validation.js", //required for date picker
    );
    $data['styles'] = array(
        site_url('assets') . "/global/plugins/select2/select2.css",
    );
    $data['addons_load'] = array(
        "FormValidation.init();", ////required for date picker
    );
    $data['programlevels'] = $this->programlevel_model->get_programlevel();
    $data['main_content'] = 'course_pointer/lession_plan';
    $this->load->view('template', $data);
  }

	public function add()
	{
    //$this->load->model('exam/assessment_setting_model');
	  $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
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

          }
          else
          {
            $('#section').html('<option value=\"\">Select Sections</option>');
          }
        });",
      "1" => "
        $('.display_class').change(function(){
          const section = $('#section').val();

          if(section != '')
          {
            $.post('".site_url('pages/ajax/get_class_days')."', {section: section})
             .done(function(result) {
              $('#subject').html(result);
            })
            .fail(function() {
              console.log('error');
            });
          }
        });",
      "2" => "
        $('#subject').change(function(){
          $('.exams').html('<option>Loading..</option>');
          const class_days_id = $('#subject').val();

          if(class_days_id != '')
          {
            $.post('".site_url('pages/ajax/get_class_exams')."', {class_days_id: class_days_id})
             .done(function(result) {
              $('.exams').html(result);
            })
            .fail(function() {
              console.log('error');
            });
          }
        });",
      '3'=>"$('#delete_row_no').click(function()
        {
          var id=$('#row_id').val();
          if(id>0)
          {
            var inp=$('table tbody.frm_body tr:nth-child('+id+')').remove();
          }
          else
          {
            var inp=$('table tbody.frm_body tr').last().remove();
          }
        });",
      '4'=>"$('#insert_row_no').click(function()
        {
          var id=$('#row_id').val();
          const data_row = $('#addditional_row').html();
          //console.log(data_row);
          if(id>0)
          {
            $(data_row).insertBefore('table tbody.frm_body tr:nth-child('+id+')');
          }
          else
          {
              $('table tbody.frm_body').append(data_row);
          }
         
        });"

    );
    
    

    $data['addons'] = array(
                          site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
                          site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
                        ); 

       
    $data['batchs'] = $this->batch_model->get_batch();
    $data['grades'] = $this->grade_manager_model->get_grades();         
    $data['main_content'] = 'classes/add_lession_plan';
    $this->load->view('template', $data);
	}

  public function insert()
  {
    if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') 
    {
      $result = $this->lession_plan_model->insert();
      if ($result) 
      {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Added Lesson Plan');
      } 
      else 
      {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Creating Lesson Plan');
      }
    }
    redirect(site_url("pages/classes/lession_plan/add"), 'refresh');
  }

  public function edit()
  {
    $this->load->model('ajax_model');
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
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

            }
            else
            {
              $('#section').html('<option value=\"\">Select Sections</option>');
            }
          });",
        "1" => "
          $('.display_class').change(function(){
            const section = $('#section').val();

            if(section != '')
            {
              $.post('".site_url('pages/ajax/get_class_days')."', {section: section})
               .done(function(result) {
                $('#subject').html(result);
              })
              .fail(function() {
                console.log('error');
              });
            }
          });",
        "2" => "
          $('#subject').change(function(){
            $('.exams').html('<option>Loading..</option>');
            const class_days_id = $('#subject').val();

            if(class_days_id != '')
            {
              $.post('".site_url('pages/ajax/get_class_exams')."', {class_days_id: class_days_id})
               .done(function(result) {
                $('.exams').html(result);
              })
              .fail(function() {
                console.log('error');
              });
            }
          });",
              
        '3'=>"$('#delete_row_no').click(function()
          {
            var id=$('#row_id').val();
            if(id>0)
            {
              var inp=$('table tbody.frm_body tr:nth-child('+id+')').remove();
            }
            else
            {
              var inp=$('table tbody.frm_body tr').last().remove();
            }
          });",
        '4'=>"$('#insert_row_no').click(function()
          {
            var id=$('#row_id').val();
            const data_row = $('#addditional_row').html();
            //console.log(data_row);
            if(id>0)
            {
              $(data_row).insertBefore('table tbody.frm_body tr:nth-child('+id+')');
            }
            else
            {
                $('table tbody.frm_body').append(data_row);
            }
           
          });"

    );
    $data['addons'] = array(
        site_url('assets') . "/global/plugins/select2/select2.min.js",
        site_url('assets') . "/global/plugins/jquery-validation/js/jquery.validate.min.js", //required for date picker
        site_url('assets') . "/admin/pages/scripts/form-validation.js", //required for date picker
    );
    $data['styles'] = array(
        site_url('assets') . "/global/plugins/select2/select2.css",
    );
    $data['addons_load'] = array(
        "FormValidation.init();", ////required for date picker
    );

    if($this->input->post('edit')!=NULL && $this->input->post('edit')=='EDIT')
    {
      $data['sbatch'] = trim_post('batch');
      $data['sgrade'] = trim_post('grade');
      $data['ssection'] = trim_post('section_id');
      $data['scourse'] = trim_post('subject_id');
      $data['sections'] = $this->section_manager_model->get_sections_opt($data['sbatch'],$data['sgrade']);
      $data['subjects'] = $this->ajax_model->get_class_days($data['ssection']);
      $info = $this->course_manager_model->get_courses_by_id($data['scourse']);
      $data['exams'] = $this->ajax_model->get_class_exams($info);
      $data['result'] = $this->lession_plan_model->edit($data['scourse']);
    }
    $data['batchs'] = $this->batch_model->get_batch();
    $data['grades'] = $this->grade_manager_model->get_grades();         
    $data['main_content'] = 'classes/edit_lession_plan';
    $this->load->view('template', $data);
  }

  public function update($class_day)
  {
    //teacher_class_restrict($class_day);
    if ($this->input->post('update') != NULL && $this->input->post('update') == 'UPDATE') 
    {
      $result = $this->lession_plan_model->update($class_day);
      if ($result) 
      {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Edited Lesson Plan');
      } 
      else 
      {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Deleting Old Lesson Plan');
      }
    }
    redirect(site_url("pages/classes/lession_plan/edit"), 'refresh');
  }

  /*
  function used to migrate old lesson plan class to new class 
  @param: class_days_id
  */
  public function migrate()
  {
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
         "0" => "
      $('.from_display_section').change(function(){
            const batch = $('#from_batch').val();
            const grade = $('#from_grade').val();

            if(batch != '' && grade != '')
            {
              $.post('".site_url('pages/ajax/get_section')."', {batch: batch, grade: grade})
               .done(function(result) {
                    $('#from_section').html(result);
              })
              .fail(function() {
                console.log('error');
              });

            }
            else
            {
              $('#from_section').html('<option value=\"\">Select Sections</option>');
            }
          });",
      "1" => "
      $('.from_display_class').change(function(){
            const section = $('#from_section').val();

            if(section != '')
            {
              $.post('".site_url('pages/ajax/get_teacher_class')."', {section: section})
               .done(function(result) {
                $('#from_subject').html(result);
              })
              .fail(function() {
                console.log('error');
              });
            }
          });",
      "3" => "
      $('.to_display_section').change(function(){
            const batch = $('#to_batch').val();
            const grade = $('#to_grade').val();

            if(batch != '' && grade != '')
            {
              $.post('".site_url('pages/ajax/get_section')."', {batch: batch, grade: grade})
               .done(function(result) {
                    $('#to_section').html(result);
              })
              .fail(function() {
                console.log('error');
              });

            }
            else
            {
              $('#to_section').html('<option value=\"\">Select Sections</option>');
            }
          });",
      "4" => "
      $('.to_display_class').change(function(){
            const section = $('#to_section').val();

            if(section != '')
            {
              $.post('".site_url('pages/ajax/get_teacher_class')."', {section: section})
               .done(function(result) {
                $('#to_subject').html(result);
              })
              .fail(function() {
                console.log('error');
              });
            }
          });",
      "5" => "
        $('#to_subject').change(function(){
          const class_days_id = $(this).val();
          $.post('".site_url('pages/ajax/check_lession_plan')."', {class_days_id: class_days_id})
               .done(function(result) {
                if(result == 1){
                  $('#ajax_alert').show();
                  $('#migrate').attr('disabled','disabled');
                }
                else if(result == 2)
                {
                  $('#ajax_alert').hide();
                  $('#migrate').removeAttr('disabled');
                }
                //$('#to_subject').html(result);
              })
              .fail(function() {
                console.log('error');
              });
        });
      "     
    );
    $data['addons'] = array(
    );
    $data['styles'] = array(
    );
    $data['addons_load'] = array(
       
    );
    if($this->input->post('migrate')!=NULL && $this->input->post('migrate')=='MIGRATE')
    {
      $result = $this->lession_plan_model->migrate();
      if ($result) 
      {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Migrated Lesson Plan');
      } 
      else 
      {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Migrating Lesson Plan');
      }
    }

    $data['batchs'] = $this->batch_model->get_batch();
    $data['grades'] = $this->grade_manager_model->get_grades();  
    $data['main_content'] = 'classes/migrate_lession_plan';
    $this->load->view('template', $data);
  }

  public function add_activity()
  {
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
      "0" => "
        $('.display_section').on('click change',function(){
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

          }
          else
          {
            $('#section').html('<option value=\"\">Select Sections</option>');
          }
        });",
      "1" => "
        $('.display_class').change(function(){
          const section = $('#section').val();

          if(section != '')
          {
            $.post('".site_url('pages/ajax/get_class_days')."', {section: section})
             .done(function(result) {
              $('#subject').html(result);
            })
            .fail(function() {
              console.log('error');
            });
          }
        });",
      "2" => "
        $('#subject').change(function(){
          $('#lesson_id').html('<option>Loading..</option>');
          const class_days_id = $('#subject').val();
          
          if(class_days_id != '')
          {
            $.post('".site_url('pages/ajax/get_lessons')."', {class_days_id: class_days_id})
             .done(function(result) {
              $('#lesson_id').html(result);
              console.log(result);
            })
            .fail(function() {
              console.log('error');
            });
          }
        });",
      '4' => "$('#lesson_id').change(function()
        {
          $('#topic_id').html('<option value=\'\'> Loading... </option>');
          const class_days_id = $('#subject').val();
          const ch_id = $('#lesson_id').val();

          $.post('".site_url('pages/ajax/get_topics')."', {class_days_id: class_days_id, ch_id: ch_id})
          .done(function(result) {
              $('#topic_id').html(result);
              console.log(result);
          })
          .fail(function() {
            console.log('error');
          })
        });",
      '5' => "$('#add_file').click(function()
        {
          if($(this).prop('checked'))
          {
            $('.file-adder').show();
          }
          else
          {
            $('.file-adder').hide();
          }
        });"
    );
    $data['addons'] = array(
        site_url('assets') . "/global/plugins/select2/select2.min.js",
        site_url('assets') . "/global/plugins/jquery-validation/js/jquery.validate.min.js", //required for date picker
        site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
        site_url('assets') . "/admin/pages/scripts/form-validation.js", //required for date picker
        site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js",                //required to load custom functions
    );
    $data['styles'] = array(
        site_url('assets') . "/global/plugins/select2/select2.css",
        site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
        site_url('assets')."/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css",               //requires for file input in a form 
    );
    $data['addons_load'] = array(
        "FormValidation.init();", ////required for date picker
    );
    $data['script'] = "
                    $( '.date-picker' ).datepicker({format: 'yyyy-mm-dd',multidate: true});
                ";  
    $data['batchs'] = $this->batch_model->get_batch();
    $data['grades'] = $this->grade_manager_model->get_grades();   
    $data['standards'] = $this->lession_plan_model->get_standards();  

    $data['main_content'] = 'classes/add_activity';
    $this->load->view('template', $data);
  }

  public function insert_activity()
  {
    $activity_file='';
    if($this->input->post('add_file')==1)
    {
      if(isset($_FILES['activity_file']) && is_uploaded_file($_FILES['activity_file']['tmp_name']))
      {
        $stat=$this->general->upload('activity_file',0,'','activities');
        if($stat['status']==TRUE)
        {
          $activity_file=$stat['result'];
        }
        else
        {
          $this->session->set_flashdata('error', TRUE);
          $this->session->set_flashdata('alert_msg', $stat['result']);
          redirect(site_url("pages/classes/lession_plan/add_activity"), 'refresh');
        }
      }
    }
    
    $res=$this->lession_plan_model->insert_activity($activity_file);
    if($res) 
    {
      $this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('alert_msg', 'Succesfully Added Lesson Activity');
    } 
    else 
    {
      $this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('alert_msg', 'ERROR Occured while Adding Lession Activity');
    }
   redirect(site_url("pages/classes/lession_plan/add_activity"), 'refresh');
  }
  public function delete_activity($class_days_id, $id)
  {
    teacher_restrict();    
    $res = $this->lession_plan_model->delete_activity($id);
    //echo"<script> window.close(); </script>";
    if($res) 
    {
      set_flash('success','Successfully Deleted Lesson Activity.'); 
    } 
    else 
    {
      set_flash('error','ERROR Occurred while Deleting Lesson Activity.'); 
    }
   redirect(site_url("pages/classes/lession_plan/course_pointer/".$class_days_id), 'refresh');
  }

  public function view($class_day)
  {
    //faculty_class_restrict($class_day);
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
    );
    $data['addons'] = array(
    );
    $data['styles'] = array(
    );
    $data['addons_load'] = array(
    );
    $data['info']=$this->course_manager_model->get_courses_by_id($class_day);
    $data['result']=$this->lession_plan_model->get_lesson_plan($class_day);
    $data['lession_activities']=$this->lession_plan_model->get_activities($class_day);
    $data['main_content'] = 'classes/view_lesson_plan';
    $this->load->view('template', $data);
  }

  public function activity($name,$file)
  { 
    $file_path=base64_decode($file);
    $data = file_get_contents(site_url("uploads/$file_path")); // Read the file's contents
    $file_info=pathinfo("uploads/$file_path");     
    force_download($name.'.'.$file_info['extension'], $data); 
  }

  public function setting()
  {
    $this->load->model('programs/subjecteacher_model');
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
    );
    $data['addons'] = array(
    );
    $data['styles'] = array(
    );
    $data['addons_load'] = array(
    );
    //    $data['result']=$this->lession_plan_model->edit($class_day);
    $data['main_content'] = 'classes/setting_lession_plan';
    $this->load->view('template', $data);
  }

  public function update_setting()
  {
    if($this->input->post('submit')!=NULL && $this->input->post('submit')=='SUBMIT')
    {
      $result = $this->lession_plan_model->update_setting();
      if ($result) 
      {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Lesson Plan setting updated');
      } 
      else 
      {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Updating Lesson Plan setting');
      }
    }
    redirect(site_url("pages/classes/lession_plan/setting"), 'refresh');
  }

  /*public function list_all()
  {
    $this->load->model('pages/programs/program_model');
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['ajax_script'] = array(
    );
    $data['addons'] = array(
       site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
      site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",  
    );
    $data['styles'] = array(
    );
    $data['addons_load'] = array(
    );
     $data['script'] = "
                        $('.simple_table').DataTable({'iDisplayLength': 100});
                    ";
    //    $data['result']=$this->lession_plan_model->edit($class_day);
    $data['programs']= $this->program_model->get_active_program();
    $data['result']=$this->lession_plan_model->list_all();
    $data['main_content'] = 'classes/list_lession_plan';
    $this->load->view('template', $data);
  }*/

  public function standards()
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
                     // $('.simple_table').DataTable();
                  ";
    $data['ajax_script']=array(
      "0" => ""
      );    
    $data['theme_option']=$this->theme_model->get_theme_data();
    $data['standards']=$this->lession_plan_model->get_standards();
    $data['main_content']='classes/activity_standards';
    $this->load->view('template',$data);
  }

  public function insert_standard()
  {
    if($this->input->post('add')!=NULL && $this->input->post('add')=='ADD')
    {
      $result=$this->lession_plan_model->insert_standard();
    }
    else
    {
      $result=FALSE;
    }
    if($result)
    {
      $this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('alert_msg', 'Standard successfully Added');
    }
    else
    {
      $this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
    }
    redirect(site_url("pages/classes/lession_plan/standards"),'refresh');
  }

  public function update_standard()
  {
    if($this->input->post('update')!=NULL && $this->input->post('update')=='UPDATE')
    {
      $result=$this->lession_plan_model->update_standard();
    }
    else
    {
      $result=FALSE;
    }
    if($result)
    {
      $this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('alert_msg', 'Standard Updated Successfully.');
    }
    else
    {
      $this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
    }
    redirect(site_url("pages/classes/lession_plan/standards"),'refresh');
  }

  public function delete_standard($id='')
  {
    $result=$this->lession_plan_model->delete_standard($id);
    if($result)
    {
      $this->session->set_flashdata('error', FALSE);
      $this->session->set_flashdata('alert_msg', 'Standard Deleted Successfully.');
    }
    else
    {
      $this->session->set_flashdata('error', TRUE);
      $this->session->set_flashdata('alert_msg', 'Database Error, Try Again.');
    }
    redirect(site_url("pages/classes/lession_plan/standards"),'refresh');
  }

  public function course_pointer($class_day)
  {
    teacher_restrict($class_day);
    $data['theme_option'] = $this->theme_model->get_theme_data();
    
    $data['styles']=array(
        site_url('assets')."/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css",               //requires for file input in a form 
      );

      $data['addons'] = array(
       // site_url('assets') . "/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
        //site_url('assets') . "/admin/pages/scripts/components-form-tools.js",
        site_url('assets') . "/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js",

      );
      /*
        required js plugins Functions to run script for the page
       */
      $data['addons_load'] = array(
       //   "TableManaged.init();",
      );
    
    $data['ajax_script'] = array(
      
      '0' => "$('input[name=\"lession_covered\"]').on('switchChange.bootstrapSwitch', function(event, state) {
        var id=$(this).attr('data-id');
        var ob=$(this);
        if(state)
         {
          var option=1;
          $.post('".site_url('pages/ajax/update_course_pointer')."', {option: option,id:id})
          .done(function(result) {
            if(result==1)
            {
              ob.closest('tr').attr('Class','success');
              message_display('success','Course pointer has been Updated.');
            }
          })
          .fail(function() {
             console.log('error');
          })
         }
         else
         {
          var option=0;
          $.post('".site_url('pages/ajax/update_course_pointer')."', {option: option,id:id})
          .done(function(result) {
            if(result==1){
              ob.closest('tr').attr('Class','');  
              message_display('success','Course pointer has been Updated.') ;
            }
          })
          .fail(function() {
             console.log('error');
          })
         }
      });"
      ,
      '1' =>'
        $(".activity").click(function(){
          const title = $(this).attr("data-title");
          const id = $(this).attr("data-id");
          $("#activity_title").text(title);
          $.post("'.site_url('pages/ajax/get_activity_detail/'.$this->uri->segment(5)).'", {id: id})
          .done(function(result) {
              $("#activity_info_body").html(result);
          })
          .fail(function() {
            console.log("error");
          })
        });
      '
    );
    //$data['programlevels'] = $this->programlevel_model->get_programlevel();
    $data['info']=$this->course_manager_model->get_courses_by_id($class_day);
    $data['results']=$this->lession_plan_model->get_lesson_plan($class_day);
    $data['lession_activities']=$this->lession_plan_model->get_activities($class_day);
    $data['main_content'] = 'classes/course_pointer';
    $this->load->view('template', $data);
  }
}

/* End of file lession_plan.php */
/* Location: ./application/modules/pages/controllers/classes/lession_plan.php */