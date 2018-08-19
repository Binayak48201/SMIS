<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('classes/attendance_model');
		$this->load->model('classes/course_manager_model');
		$this->load->model('exam/marks_entry_model');
	}

	public function add($class_days_id)
	{
		$data['styles'] = array(
            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            );

    $data['addons'] = array(
        site_url('assets')."/global/plugins/select2/select2.min.js",
        site_url('assets')."/global/plugins/jquery-validation/js/jquery.validate.min.js",               //required  for datepicker
        site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",       //required  for datepicker
        site_url('assets')."/admin/pages/scripts/form-validation.js",
        );

		$data['ajax_script'] = array(
			"0" => ""
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

	    $(".total_class").keyup(function(){
				const days = $(this).val();
				$(".total_class").val(days);
	    });

	    $("input").focus(function(){
	    	$(this).select();
	    });
				';	
		$data['info'] = $this->course_manager_model->get_courses_by_id($class_days_id);	
		$data['exams'] = $this->marks_entry_model->get_exams($data['info']);	
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'classes/add_attandance';
		$this->load->view('template',$data);
	}

	/*
		module to get student with marks for individual exam (if exist)
		else returns the list of student for particular section
	*/
	public function students_with_attendance($class_days_id,$exam_id)
	{
		$data['update'] = $this->attendance_model->isset_students_attendance($class_days_id,$exam_id);
		$data['results'] = $this->attendance_model->students_with_attandance($class_days_id,$exam_id);
		return $data;
	}

	public function insert($class_days_id)
	{
		//teacher_class_restrict($class_days_id);
    if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') {
      $result = $this->attendance_model->add_attendance($class_days_id);
      if ($result) {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Added Student Attendance');
      } else {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Adding Student Attendance');
      }
    }
    redirect(site_url("pages/classes/attendance/add/$class_days_id"), 'refresh');
	}

	public function update($class_days_id)
	{
		//teacher_class_restrict($class_days_id);
    if ($this->input->post('submit') != NULL && $this->input->post('submit') == 'SUBMIT') {
      $result = $this->attendance_model->update_attendance($class_days_id);
      if ($result) {
        $this->session->set_flashdata('error', FALSE);
        $this->session->set_flashdata('alert_msg', 'Succesfully Updated Student Attendance');
      } else {
        $this->session->set_flashdata('error', TRUE);
        $this->session->set_flashdata('alert_msg', 'ERROR Occured while Updating Student Attendance');
      }
    }
    redirect(site_url("pages/classes/attendance/add/$class_days_id"), 'refresh');
	}

}

/* End of file Attendance.php */
/* Location: ./application/modules/pages/controllers/classes/Attendance.php */
