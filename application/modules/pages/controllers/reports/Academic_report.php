<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Academic_report extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('reports/academic_report_model');
	}

	public function exam_summary_report()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('exam/assessment_setting_model');

		$data['addons'] = array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/global/scripts/loader.js",
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
          $.post('".site_url('pages/reports/academic_report/view_terminal_total')."', $('#terminal_opt').serialize())
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
		$data['main_content'] = 'reports/exam_summary_report';
		$this->load->view('template',$data);
	}

	public function view_terminal_total()
	{
		$this->load->model('classes/subject_manager_model');
		$this->load->model('profile/student_model');

		$data['ajax_script'] = array(
		"0" => "
			$('.print').click(function(){
				const exam = $('#exam').val();
				const grade = $('#grade').val();
				const batch = $('#batch').val()
				const st_id = $(this).attr('data-id');
				$.post('".site_url('pages/ajax/marksheet_view')."', {exam: exam, grade: grade, st_id: st_id, batch: batch})
       	.done(function(result) {
          $('#modal-body').html(result);
       	})
       	.fail(function() {
          console.log('error');
       	});
			});",	
		"1" => "
			$('.view_graph').click(function(){
				const exam = $('#exam').val();
				const grade = $('#grade').val();
				const batch = $('#batch').val()
				const st_id = $(this).attr('data-id');
				$.post('".site_url('pages/ajax/marksheet_graph_view')."', {exam: exam, grade: grade, st_id: st_id, batch: batch})
       	.done(function(result) {
          $('#graph-modal-body').html(result);
       	})
       	.fail(function() {
          console.log('error');
       	});
			});",
		
			);	

		$data['addons'] = array(
													site_url('assets')."/global/scripts/metronic.min.js",
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/global/scripts/jquery.table2excel.min.js",

										    ); 

		$data['script'] = "
			 $('.exportTable').click(function() {
        const table_name = $(this).attr('data-id');
        $('#'+table_name).table2excel({
          exclude: '.noExl',
          name: 'Excel Document Name',
          filename: 'Downloads',
          fileext: '.xlsx',
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

			$('.simple_table').DataTable(
			{paging : false});
								";			
		$data['post_arr'] = base64_encode(serialize($_POST));
		$data['exam_id'] = trim_post('exam_id');
		$data['grade'] = trim_post('grade_id');
		$data['subjects'] = $this->subject_manager_model->get_subject_opt(trim_post('batch_id'),trim_post('grade_id'));
		$data['students'] = $this->student_model->get_students(trim_post('section_id'),trim_post('batch_id'),trim_post('grade_id'));
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'reports/view_terminal_total';
		$this->load->view('ajax_template',$data);
	}

	public function print_all_marksheet()
	{
		$this->load->model('ajax_model');
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['styles'] = array(
                          site_url('assets') . "/global/plugins/simple-line-icons/simple-line-icons.min.css",   
                          site_url('assets') . "/admin/layout2/css/print.css",   
                           
                        );
		//$this->load->model('exam/exam_setting_model');
		 $data['jscript']="

        function printDiv(divID) {

                //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page\'s HTML with div\'s HTML only
            document.body.innerHTML = 
              '<html><head><title></title></head><body>' + 
              divElements + '</body>';

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
        }
      ";
    $this->load->model('classes/appraisal_manager_model');
    $this->load->model('profile/student_model');
    $post_arr = unserialize(base64_decode($this->input->get('data')));
    $data['batch'] = $post_arr['batch_id'];
    $data['exam'] = $post_arr['exam_id'];
    $data['grade'] = $post_arr['grade_id'];
    $data['section_id'] = $post_arr['section_id'];
    $data['assessment_module'] = 0;
    $data['final_grading'] = 0;
    if($data['theme_option']->assessment_module)
    {
      $data['assessment_module'] = 1;
    }
    if($data['theme_option']->final_upscale_marking)
    {
      $data['final_grading'] = 1;
      $data['exams'] = $this->ajax_model->get_all_exams($post_arr['grade_id'],$post_arr['batch_id']);
    }
    $data['students'] = $this->student_model->get_students($data['section_id'],$data['batch'],$data['grade']);
    $data['appraisal_heads'] = $this->appraisal_manager_model->get_appraisals();
		$data['main_content'] = 'reports/print_all_marksheet';
		$this->load->view('ajax_template',$data);
	}
	
	public function st_attendance_report()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('exam/assessment_setting_model');

		$data['addons'] = array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/global/scripts/loader.js",
										    ); 
		$data['styles'] = array(
        );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load'] = array(
			); 
		
			
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
			$('#section').change(function(){
				const section = $('#section').val();
				const batch = $('#batch').val();
				$('#exam_id').html('<option>Loading</option>');
				
					$.post('".site_url('pages/ajax/get_exams')."', {section: section, batch: batch})
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
          $.post('".site_url('pages/reports/academic_report/view_terminal_attendance')."', $('#terminal_opt').serialize())
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
		$data['main_content'] = 'reports/st_attendance_report';
		$this->load->view('template',$data);
	}

	public function view_terminal_attendance()
	{
		$this->load->model('classes/subject_manager_model');
		$this->load->model('profile/student_model');

		$data['ajax_script'] = array(
		"0" => "
			$('.view_graph').click(function(){
				const exam = $('#exam').val();
				const section = $('#section').val();
				const grade = $('#grade').val();
				const batch = $('#batch').val()
				const st_id = $(this).attr('data-id');
				$.post('".site_url('pages/ajax/attendance_graph_view')."', {exam: exam, section: section, st_id: st_id,grade: grade ,batch: batch})
       	.done(function(result) {
          $('#graph-modal-body').html(result);
       	})
       	.fail(function() {
          console.log('error');
       	});
			});",
		
			);
			$data['script'] = "
		$('.simple_table').DataTable(
			{paging : false});
								";			
		$data['addons'] = array(
													site_url('assets')."/global/scripts/metronic.min.js",
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    ); 
		$data['post_arr'] = base64_encode(serialize($_POST));
		$data['exam_id'] = trim_post('exam_id');
		$data['grade'] = trim_post('grade_id');
		$data['section_id'] = trim_post('section_id');
		$data['students'] = $this->student_model->get_students(trim_post('section_id'),trim_post('batch_id'),trim_post('grade_id'));
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'reports/view_terminal_attendance';
		$this->load->view('ajax_template',$data);
	}

	public function class_rank($value='')
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('exam/assessment_setting_model');

		$data['addons'] = array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/global/scripts/loader.js",
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
			",
			"1" => "
			$('.display_section').change(function(){
				const section = 'all';
				const batch = $('#batch').val();
				if(batch != '' && grade != '')
				{
					$('#exam_id').html('<option>Loading</option>');
				
					$.post('".site_url('pages/ajax/get_exams/final')."', {section: section, batch: batch})
           .done(function(result) {
            $('#exam_id').html(result);
         	})
         	.fail(function() {
            console.log('error');
         	});
				}
			});",
      '2' => "
        $('#terminal_opt').submit(function(e){
          e.preventDefault();
          $('#ajax-content').html('<div class=\'alert\'>Loading.</div>');
          $.post('".site_url('pages/reports/academic_report/view_class_rank')."', $('#terminal_opt').serialize())
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
		$data['main_content'] = 'reports/class_rank';
		$this->load->view('template',$data);
	}

	public function view_class_rank($value='')
	{
		$this->load->model('classes/subject_manager_model');
		$this->load->model('profile/student_model');

		$data['ajax_script'] = array(		
			);
			$data['script'] = "
			 $('.exportTable').click(function() {
        const table_name = $(this).attr('data-id');
        $('#'+table_name).table2excel({
          exclude: '.noExl',
          name: 'Excel Document Name',
          filename: 'Downloads',
          fileext: '.xlsx',
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

			$('.simple_table').DataTable(
			{paging : false});
								";			
		$data['addons'] = array(
													site_url('assets')."/global/scripts/metronic.min.js",
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/global/scripts/jquery.table2excel.min.js",
										    ); 

		$data['exam_id'] = trim_post('exam_id');
		$data['grade'] = trim_post('grade_id');
		$data['students'] = $this->academic_report_model->students_for_rank(trim_post('batch_id'),trim_post('grade_id'),trim_post('exam_id'));
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'reports/view_class_rank';
		$this->load->view('ajax_template',$data);
	}

	public function view_marksheet($st_id='')
	{
		if($this->session->userdata('smis_role') == 'student')
		{
			$st_id = $this->session->userdata('smis_profile_id');
		}
		$this->load->model('classes/batch_model');
		$this->load->model('exam/exam_setting_model');
		$this->load->model('classes/grade_manager_model');
		if($this->input->post('view') != NULL && trim_post('view') == 'VIEW')
		{
			$data['sbatch'] = trim_post('batch_id');
			$data['sgrade'] = trim_post('grade_id');
			$data['sexam'] = trim_post('exam_id');
			$data['sst_id'] = $st_id;
		}

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
       	//mywindow.close();

        return true;
      }
      ";
      $data['styles'] = array(
                          site_url('assets') . "/admin/layout2/css/print.css",   
                        );
		$data['batchs'] = $this->batch_model->get_batch();
		$data['grades'] = $this->grade_manager_model->get_grades();					
		$data['exams'] = $this->exam_setting_model->get_term_name();	
		$data['theme_option'] = $this->theme_model->get_theme_data();
		$data['main_content'] = 'reports/view_marksheet';
		$this->load->view('template',$data);
	}

	public function student_evaluation_overall()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('exam/assessment_setting_model');

		$data['addons'] = array(
													site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
										    	site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
										    	site_url('assets')."/global/scripts/loader.js",
										    ); 
		$data['styles'] = array(
        );
		/*
		required js plugins Functions to run script for the page
		 */
		$data['addons_load'] = array(
			); 
		
			
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
			$('#section').change(function(){
				const section = $('#section').val();
				const batch = $('#batch').val();
				$('#exam_id').html('<option>Loading</option>');
				
					$.post('".site_url('pages/ajax/get_id_exams')."', {section: section, batch: batch})
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
          const section = $('#section').val();
          $('#ajax-content').html('<div class=\'alert\'>Loading.</div>');
          $.get('".site_url('pages/reports/academic_report/list_student/')."'+section)
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
		$data['main_content'] = 'reports/student_evaluation_overall';
		$this->load->view('template',$data);
	}

	public function list_student($section_id)
	{
		$this->load->model('classes/course_manager_model');
		$this->load->model('profile/student_model');
		$this->load->model('ajax_model');

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
			$('.dropdown-toggle-cstm').click(function(){
				$(this).toggleClass('open');
			});

			 $('.modal').on('hidden.bs.modal', function(){
	      $('#class_evaluation_option').html('');
	      $('#parent_evaluation_option').html('');
	      $('#subject_evaluation_option').html('');
	      $('#terminal_comment_option').html('');
	      $('#appraisal_evaluation_option').html('');
	      $('#terminal_comment').html('');
	    });
	    ";

	    $data['ajax_script']=array(
	      '0' => "
	        $('.target_evaluation').click(function(){
	          const st_id = $(this).attr('data-id');
	          const exam_id = $('#exam_id').val();
	          const section_id = $('#section').val();
	          const teacher = $(this).attr('data-teacher');
	          $('.class_teacher').html(teacher);
	          $.get('".site_url('pages/ajax/st_evaluation')."', {exam_id: exam_id,st_id: st_id,section_id:section_id})
             .done(function(result) {
                  $('#class_evaluation_option').html(result);
             })
	          .fail(function() {
	            console.log('error');
	          });
	        });",
	       '2' => "
	        $('.target_parent_evaluation_model').click(function(){
	          const st_id = $(this).attr('data-id');
	          const exam_id = $('#exam_id').val();
	          const section_id = $('#section').val();
	          const teacher = $(this).attr('data-teacher');
	          $('.class_teacher').html(teacher);
						$.get('".site_url('pages/ajax/pt_evaluation')."', {exam_id: exam_id,st_id: st_id,section_id:section_id})
             .done(function(result) {
                  $('#parent_evaluation_option').html(result);
             })
	          .fail(function() {
	            message_display('danger','Ajax Error.');
	          });
	        });",
	      '3' => "
	        $('.target_sub_evaluation').click(function(){
	        	const st_for = $(this).attr('data-for');
						const sub_teacher = $(this).children('a').attr('data-id');
						$('.st_for').html(st_for);
						$('#sub_teacher').html(sub_teacher);
	          const st_id = $(this).attr('data-id');
	          const exam_id = $('#exam_id').val();
	          const subject_id = $(this).attr('data-subject');
						$.get('".site_url('pages/ajax/sst_evaluation')."', {exam_id: exam_id,st_id: st_id,subject_id:subject_id})
             .done(function(result) {
                  $('#subject_evaluation_option').html(result);
             })
	          .fail(function() {
	            message_display('danger','Ajax Error.');
	          });
	        });",
	      '4' => "
	        $('.target_appraisal').click(function(){
	          const st_id = $(this).attr('data-id');
	          const exam_id = $('#exam_id').val();
	          const section_id = $('#section').val();
	          $.get('".site_url('pages/ajax/st_appraisal')."', { exam_id: exam_id,st_id: st_id,section_id:section_id })
             .done(function(result) {
                  $('#appraisal_evaluation_option').html(result);
             })
	          .fail(function() {
	            console.log('error');
	          });
	        });",
	      '6' => "
	        $('.target_comment').click(function(){
	          const st_id = $(this).attr('data-id');
	          const exam_id = $('#exam_id').val();
	          const section_id = $('#section').val();
	          const teacher = $(this).attr('data-teacher');
	          $('.class_teacher').html(teacher);
	          $.get('".site_url('pages/ajax/st_terminal_comment/')."', { st_id: st_id, exam_id: exam_id, section_id:section_id })
	          .done(function(result) {
	            $('#terminal_comment').html(result);
	          })
	          .fail(function() {
	            console.log('error');
	          });
	        });",
	        '7' => "
	        $('.target_feedback').click(function(){
	        	const st_for = $(this).attr('data-for');
						const sub_teacher = $(this).children('a').attr('data-id');
						$('.st_for').html(st_for);
						$('#sub_teacher_feedback').html(sub_teacher);
	          const st_id = $(this).attr('data-id');
	          const teacher = $(this).attr('data-teacher');
	          const subject_id = $(this).attr('data-subject');
	          $('.class_teacher').html(teacher);
	          $.get('".site_url('pages/ajax/get_st_feedback_sub/')."', { st_id: st_id,subject_id:subject_id })
	          .done(function(result) {
	            $('#subject_feedback_option').html(result);
	          })
	          .fail(function() {
	            console.log('error');
	          });
	        });",
	     
	      );
	    //$data['info']=$this->course_manager_model->get_courses_by_id($class_days_id);
	    $this->load->model('exam/exam_setting_model');
    $data['students'] = $this->student_model->get_students($section_id);
    $data['subjects'] = $this->exam_setting_model->get_section_subjects($section_id); 
    $data['class_teacher'] = $this->ajax_model->get_class_teacher($section_id);
    $data['theme_option'] = $this->theme_model->get_theme_data();
    //print_e($data['class_teacher']);
		$data['main_content'] = 'reports/list_students_for_eval';
		$this->load->view('ajax_template',$data);
	}

}

/* End of file Academic_report.php */
/* Location: ./application/modules/pages/controllers/reports/Academic_report.php */
