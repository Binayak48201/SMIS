<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_entry extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('exam/marks_entry_model');
	}

	public function index()
	{

		if($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT' )
		{
			redirect(site_url('pages/exam/marks_entry/add/').trim_post('subject_id'),'refresh');
		}

		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('exam/assessment_setting_model');

		$data['addons'] = array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    ); 
		$data['styles'] = array(
        );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load'] = array(
			); 
		$data['script'] = "
									";

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
					});"
			);		
		$data['batchs'] = $this->batch_model->get_batch();
		$data['grades'] = $this->grade_manager_model->get_grades();					
		$data['exams'] = $this->assessment_setting_model->get_assessments();					
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'exam/marks_entry';
		$this->load->view('template',$data);
	}

	public function add($class_days_id)
	{
		teacher_restrict($class_days_id);
		$this->load->model('classes/course_manager_model');
	 	$data['ajax_script']=array(
     	'0' => "$('.mark_cal').on('blur keyup',function(){
	      const id = $(this).attr('data-id');
	      const count = parseInt($(this).attr('data-count'));
	      const exam = parseInt($(this).attr('data-exam'));
	      const assessment_cal = parseFloat($('#'+exam+'_cal_assessment').val());
	      
	      const full_mark = parseInt($('#exam_'+exam+'_'+id).attr('data-full-mark'));
	      const convert_to = parseInt($('#exam_'+exam+'_'+id).attr('data-convert'));
	      let obtain_mark = parseFloat($('#exam_'+exam+'_'+id).val());

	      let total = 0,i;
	      if(assessment_cal == 1)
	      {
	      	obtain_mark = (obtain_mark/full_mark)*convert_to;
	        for(i=1;i<=count;i++){
	          total=parseFloat(total)+parseFloat($('#'+exam+'_'+i+'_'+id).val());
	        }
	        //console.log(full_mark);
	      }
	      $('#final_'+exam+'_'+id).val(Math.round(total+obtain_mark)); 
	      
	     });" ,
	    '1' => " $('#final_import').click(function(){
	    		const tabs = $(this).attr('data-tab');

	    		let i;
	    		for(i=1;i<=tabs;i++)
	    		{
						//console.log(i);
						$(\"form#frm\"+i+\" :input[data-info='cal']\").each(function(){
	           	var input = $(this);
	           	var val=input.val();
	           	const id = input.attr('data-id');
	           	const exam_id = input.attr('data-exam');
	           	const average_at = parseFloat($('#avg_'+exam_id+'_'+id).attr('data-average'));
           		const full_mark = parseFloat($('#avg_'+exam_id+'_'+id).attr('data-full-mark'));
           		//let converted_mark = (parseFloat(val)/full_mark ) * average_at;
           		let converted_mark = (average_at/100 ) * parseFloat(val);
	           	$('#avg_'+exam_id+'_'+id).val(Math.round(converted_mark));
	          });
					}
					
					$(\"form#frm_final :input[data-info='cal']\").each(function(){
           	var input = $(this);
           	var val=input.val();
           	const id = input.attr('data-id');
           	const exam_id = input.attr('data-exam');
           	const data_obj = JSON.parse(exam_id);

						let avg_mark = 0, mark;
           	for (let key in data_obj) {
            	mark = $('#avg_'+data_obj[key]+'_'+id).val();
							avg_mark = avg_mark + parseFloat(mark);
           	}
           	$('#avg_final_'+id).val(avg_mark);
          });

				});
	    "

           );
		$data['script'] = '
		$("table.arrow-nav").keydown(function(e){  
          var keyCode = e.keyCode || e.which;
          var arrow = {left: 37, up: 38, right: 39, down: 40 };                       //creating object corresponding to the key value
          var $table = $(this);                                                       //pointing the current table object
          var $active = $("input:focus, select:focus",$table);                        //pointing the active input from table
          var $next = null;                                                           //pointer to next input if not exist
          var focusableQuery = "input:not([readonly]),select:not([readonly]),textarea:not([readonly])";           //selecting which to focus
          var position = parseInt( $active.closest("td").index()) + 1;                //defining the current position + 1 //index starts from 0 
          //console.log("position :",position);
          //console.log("table :",$table);
          //console.log("active :",$active);
          switch(keyCode){
            case arrow.up: 
              e.preventDefault(); 
              $next = $active
                .closest("tr")
                .prev()                
                .find("td:nth-child(" + position + ")")
                .find(focusableQuery)
              ;
            break;
             case arrow.right: 
              e.preventDefault();
              $next = $active.closest("td").next().find(focusableQuery);            
            break;
            case arrow.down: 
              e.preventDefault();
              $next = $active
                  .closest("tr")
                  .next()                
                  .find("td:nth-child(" + position + ")")
                  .find(focusableQuery)
              ;
            break;
            case arrow.left: 
              e.preventDefault();
              $next = $active.parent("td").prev().find(focusableQuery);   
            break;
          }       
          if($next && $next.length)
          {    
            $next.focus().select();                      //focusing and selecting on given position input after above calculation
            
          }
        });
				';
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['info'] = $this->course_manager_model->get_courses_by_id($class_days_id);
		if(empty($data['info']))
		{
			echo"<script>alert('Teacher Not Assigned - Redirecting to source');</script>";
			/*if(teacher_restrict($class_days_id))
			{
				redirect(site_url('home'),'refresh');
			}*/
			redirect(site_url('pages/exam/marks_entry') ,'refresh');
		}
		//print_e($data['info']);
		$data['exams'] = $this->marks_entry_model->get_exams($data['info']);
		$data['assessment_module'] = 0;
		if($data['theme_option']->assessment_module)
		{
			$data['assessment_module'] = 1;
			$data['assessments'] = $this->marks_entry_model->get_assessments($data['info']);
		}
		$data['students'] = $this->marks_entry_model->get_students($data['info']);
		$data['main_content'] = 'exam/add_marks';
		$this->load->view('template',$data);
		//print_e($data['students']);
	}

	/*
		module to get student with marks for individual exam (if exist)
		else returns the list of student for particular section
	*/
	public function students_with_mark($section_id,$subject_id,$exam_id)
	{
		$data['update'] = $this->marks_entry_model->isset_students_mark($section_id,$subject_id,$exam_id);
		$data['results'] = $this->marks_entry_model->students_with_mark($section_id,$subject_id,$exam_id);
		return $data;
	}
	
	/*
		module to get student with marks for individual exam (if exist)
		else returns the list of student for particular section
	*/
	public function students_final_mark($st_id,$subject_id,$exam_id)
	{
		$results = $this->marks_entry_model->students_final_mark($st_id,$subject_id,$exam_id);
		return $results;
	}

	public function students_terminal_mark($st_id,$subject_id,$exam_id)
	{

		$results = $this->marks_entry_model->students_terminal_mark($st_id,$subject_id,$exam_id);
		return $results;
	}

	/*
		module to get student with marks for individual exam (if exist)
		else returns the list of student for particular section
	*/
	public function student_final_mark($section_id,$subject_id)
	{
		$data['results'] = $this->marks_entry_model->student_final_mark($section_id,$subject_id);
		$data['update'] = $this->marks_entry_model->isset_student_final_mark($section_id,$subject_id);
		return $data;
	}

	public function insert($class_days_id)
	{
		//teacher_class_restrict($class_days_id);
    if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') {
      $result = $this->marks_entry_model->add_internalmarks($class_days_id);
      if ($result) {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Added Exam Mark');
      } else {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Adding Exam Mark');
      }
    }
    redirect(site_url("pages/exam/marks_entry/add/$class_days_id"), 'refresh');
	}

	public function update($class_days_id)
	{
		//teacher_class_restrict($class_days_id);
    if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') {
      $result = $this->marks_entry_model->update_internalmarks($class_days_id);
      if ($result) {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Updated Exam Mark');
      } else {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Updating Exam Mark');
      }
    }
    redirect(site_url("pages/exam/marks_entry/add/$class_days_id"), 'refresh');
	}

	public function final_insert($class_days_id)
	{
		//teacher_class_restrict($class_days_id);
    if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') {
      $result = $this->marks_entry_model->add_final_internalmarks($class_days_id);
      if ($result) {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Added Final Mark');
      } else {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Adding Final Mark');
      }
    }
    redirect(site_url("pages/exam/marks_entry/add/$class_days_id"), 'refresh');
	}

	public function final_update($class_days_id)
	{
		//teacher_class_restrict($class_days_id);
    if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') {
      $result = $this->marks_entry_model->update_final_internalmarks($class_days_id);
      if ($result) {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Updated Final Mark');
      } else {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Updating Final Mark');
      }
    }
    redirect(site_url("pages/exam/marks_entry/add/$class_days_id"), 'refresh');
	}

	public function terminal_total()
	{
		/*if($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT' )
		{
			redirect('pages/exam/marks_entry/add/'.trim_post('subject_id'),'refresh');
		}*/

		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('exam/assessment_setting_model');

		$data['addons'] = array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    ); 
		$data['styles'] = array(
        );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load'] = array(
			); 
		$data['script'] = "
									";

		$data['ajax_script'] = array(
			"0" => "
			$('.display_section').change(function(){
						const batch = $('#batch').val();
						const grade = $('#grade').val();

						if(batch != '' && grade != '')
						{
							$.post('".site_url('pages/ajax/get_section/all')."', {batch: batch, grade: grade})
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
			$('#section').change(function(){
				const section = $('#section').val();
				const batch = $('#batch').val();
				$('#exam_id').html('<option>Loading</option>');
				
					$.post('".site_url('pages/ajax/get_exams/final')."', {section: section, batch: batch})
           .done(function(result) {
            $('#exam_id').html(result);
         	})
         	.fail(function() {
            console.log('error');
         	});
				
			});",
      '2' => "
        $('#terminal_opt').submit(function(e){
          e.preventDefault();
          $('#ajax-content').html('<div class=\'alert\'>Loading.</div>');
          $.post('".site_url('pages/exam/marks_entry/view_terminal_total')."', $('#terminal_opt').serialize())
          .done(function(result) {
             $('#ajax-content').html(result);
          })
          .fail(function() {
            console.log('Ajax Error.');
          });
        });
      "
			);		
		$data['batchs'] = $this->batch_model->get_batch();
		$data['grades'] = $this->grade_manager_model->get_grades();					
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'exam/terminal_total';
		$this->load->view('template',$data);
	}
	public function view_terminal_total()
	{
		$this->load->model('classes/subject_manager_model');
		$this->load->model('profile/student_model');
		$data['exam_id'] = trim_post('exam_id');
		$data['grade'] = trim_post('grade_id');
		$data['subjects'] = $this->subject_manager_model->get_subject_opt(trim_post('batch_id'),trim_post('grade_id'));
		$data['students'] = $this->student_model->get_students(trim_post('section_id'),trim_post('batch_id'),trim_post('grade_id'));
		$this->load->view('exam/view_terminal_total',$data);
	}

	public function add_terminal_total()
	{
		if($this->input->post('action') != NULL && $this->input->post('action') == 'ADD')
		{
			$result = $this->marks_entry_model->add_terminal_total();
			if($result)
				set_flash('success','Successfully Updated Records.'); 
			else
				set_flash('error','Database Error Occurred.'); 
		}
		redirect(site_url("pages/exam/marks_entry/terminal_total"),'refresh');
	}
}

/* End of file marks_entry.php */
/* Location: ./application/modules/pages/controllers/exam/marks_entry.php */
