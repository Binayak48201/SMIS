<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class General_reports extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('reports/general_reports_model');
	}

	public function student_list()
  {
    $this->load->model('classes/batch_model');
    $this->load->model('classes/grade_manager_model');
    $this->load->model('classes/section_manager_model');
    $this->load->model('profile/student_model');

    

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
       site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
        site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(      
      "0" => "$('.display_section').change(function(){
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
              $('#section').html('<option value=\"\">Select Section</option>');
            }
          });",
        '1' => "$('.gender_by').click(function() {
                  if($(this).val()=='f')
                   {
                    $('.gender-Male').hide();
                    $('.gender-Female').show();
                   }
                   else if($(this).val()=='m')
                   {
                    $('.gender-Male').show();
                    $('.gender-Female').hide();
                   }
                   else
                   {
                      $('.gender-Male').show();
                      $('.gender-Female').show();
                   }
              });"
      );      
    $data['script'] = '
      $(".exportTable").click(function() {
        const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      $(".simple_table").DataTable({paging: false});
    ';    

    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')
    {

      $data['sbatch'] = trim_post('batch');
      $data['sgrade'] = trim_post('grade');
      $data['ssection'] = trim_post('section_id');
      $data['sections'] = $this->section_manager_model->get_sections_opt($data['sbatch'], $data['sgrade']);
      $data['students'] = $this->student_model->get_students($data['ssection'],$data['sbatch'],$data['sgrade']);
    }
    $data['grades'] = $this->grade_manager_model->get_grades();
    $data['batchs'] = $this->batch_model->get_batch();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/student_list';
    $this->load->view('template',$data);
  }

  public function dropped_student_list()
	{
		$this->load->model('classes/batch_model');
		$this->load->model('classes/grade_manager_model');
		$this->load->model('classes/section_manager_model');
		$this->load->model('profile/student_model');

		

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
       site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
        site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(			
			);			
		$data['script'] = '
			$(".exportTable").click(function() {
				const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      $(".simple_table").DataTable({paging: false});
		';		

		$data['students'] = $this->student_model->dropped_student_list();
    //print_e($data['students']);
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/dropped_student_list';
    $this->load->view('template',$data);
	}

	public function prev_school_st_list()
	{
		$this->load->model('general_content/school_model');

		 $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
       site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
        site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(			
			);			
		$data['script'] = '
			$(".exportTable").click(function() {
				const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      $(".simple_table").DataTable({paging: false});
		';		

    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')
    {

      $data['sschool'] = trim_post('school');
			$data['students'] = $this->general_reports_model->prev_school_st_list($data['sschool']);
    }
		$data['schools'] = $this->school_model->get_school();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/prev_school_st_list';
    $this->load->view('template',$data);
	}

	public function district_st_list()
  {
    $this->load->model('general_content/district_model');

     $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
      // site_url('assets')."/global/scripts/jquery.table2excel.min.js",
      // site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
       // site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(      
      );      
    $data['script'] = '
      $(".exportTable").click(function() {
        const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      //$(".simple_table").DataTable({paging: false});
    ';    

    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')
    {

      $data['sdistrict'] = trim_post('district');
      $data['students'] = $this->general_reports_model->district_st_list($data['sdistrict']);
    }
    $data['districts'] = $this->district_model->get_district();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/district_st_list';
    $this->load->view('template',$data);
  }

  public function district_st_dist()
  {
    $this->load->model('general_content/district_model');

     $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
      // site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
       // site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(      
      );      
    $data['script'] = '
      $(".exportTable").click(function() {
        const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      //$(".simple_table").DataTable({paging: false});
    ';    

   
    $data['students'] = $this->general_reports_model->district_st_dist();
    $data['districts'] = $this->district_model->get_district();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/district_st_dist';
    $this->load->view('template',$data);
  }

  public function student_overall()
  {
    $this->load->model('general_content/district_model');

     $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
      // site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
       // site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(      
      );      
    $data['script'] = '
      $(".exportTable").click(function() {
        const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      //$(".simple_table").DataTable({paging: false});
    ';    
    //$data['students'] = $this->general_reports_model->student_overall();
    if(trim_post('year') != NULL)
    {
      $data['syear'] = trim_post('year');
      $data['students'] = $this->general_reports_model->student_overall(trim_post('year'));
    }
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/student_overall';
    $this->load->view('template',$data);
  }

  public function current_student_overall()
	{
		$this->load->model('general_content/district_model');

		 $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
      // site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
       // site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(			
			);			
		$data['script'] = '
			$(".exportTable").click(function() {
				const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      //$(".simple_table").DataTable({paging: false});
		';		
		//$data['students'] = $this->general_reports_model->student_overall();
    $opt= 'grade';
    $data['students'] = $this->general_reports_model->current_student_overall(current_batch(), $opt);
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/current_student_overall';
    $this->load->view('template',$data);
	}

  public function guardian_list_class()
  {
    $this->load->model('classes/batch_model');
    $this->load->model('classes/grade_manager_model');
    $this->load->model('classes/section_manager_model');
    $this->load->model('profile/student_model');

    

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
       site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
        site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(      
      "0" => "$('.display_section').change(function(){
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
              $('#section').html('<option value=\"\">Select Section</option>');
            }
          });"
      );      
    $data['script'] = '
      $(".exportTable").click(function() {
        const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      $(".simple_table").DataTable({paging: false});
    ';    

    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')
    {

      $data['sbatch'] = trim_post('batch');
      $data['sgrade'] = trim_post('grade');
      $data['ssection'] = trim_post('section_id');
      $data['sections'] = $this->section_manager_model->get_sections_opt($data['sbatch'], $data['sgrade']);
      $data['students'] = $this->general_reports_model->guardian_list_class($data['ssection'],$data['sbatch'],$data['sgrade']);
    }
    $data['grades'] = $this->grade_manager_model->get_grades();
    $data['batchs'] = $this->batch_model->get_batch();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/guardian_list_class';
    $this->load->view('template',$data);
  }

  public function occupation_guardian_list()
  {
    $this->load->model('general_content/occupation_model');

     $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
       site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
        site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(      
      );      
    $data['script'] = '
      $(".exportTable").click(function() {
        const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });
      $(".simple_table").DataTable({paging: false});
    ';    

    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')
    {

      $data['soccupation'] = trim_post('occupation');
      $data['students'] = $this->general_reports_model->occupation_guardian_list($data['soccupation']);
    }
    $data['occupations'] = $this->occupation_model->get_occupation();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/occupation_guardian_list';
    $this->load->view('template',$data);
  }

  public function search_guardian_list()
  {
   // $this->load->model('general_content/occupation_model');

     $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
       site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
        site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(      
      );      
    $data['script'] = '
      $(".exportTable").click(function() {
        const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });
      $(".simple_table").DataTable({paging: false});
    ';    

    if(trim_post('search') != NULL && trim_post('search') == 'SEARCH')
    {

      $data['sname'] = trim_post('name');
      $data['students'] = $this->general_reports_model->search_guardian_list($data['sname']);
    }
    //$data['occupations'] = $this->occupation_model->get_occupation();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/search_guardian_list';
    $this->load->view('template',$data);
  }

  public function birthday_students()
  {
    $data['students'] = $this->general_reports_model->birthday_students();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/birthday_students';
    $this->load->view('template',$data);
  }

  public function student_by_bus()
  {
    $this->load->model('general_content/school_model');
    $this->load->model('general_content/transportation_model');

     $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
       site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
        site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    
   $data['ajax_script'] = array(     
      "0" => "
          $('#bus_id').change(function(){
            const bus_id = $(this).val();

             $.post('".site_url('pages/ajax/get_bus_stop/all')."', {bus_id: bus_id})
             .done(function(result) {
                  $('#stop_id').html(result);
             })
             .fail(function() {
                console.log('error');
             })
          });
      ",
      "1" => "
        $('#bus_list').submit((e) => {
          e.preventDefault();
          const stop_id = $('#stop_id').val();
          const bus_id = $('#bus_id').val();
          $.get('".site_url('pages/ajax/student_by_bus')."', {bus_id: bus_id, stop_id: stop_id})
             .done(function(result) {
                  $('#list_body').html(result);
             })
             .fail(function() {
                console.log('error');
             })
        })
      " 
      );      
    $data['script'] = '
      $(document).on("click", ".exportTable", function() {
        const table_name = $(this).attr("data-id");
        $("#"+table_name).table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });

      $(".simple_table").DataTable({paging: false});
    ';    
    $data['buses'] = $this->transportation_model->transportation_list();
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/student_by_bus';
    $this->load->view('template',$data);
  }

  public function bus_time_table()
  {
    $this->load->model('general_content/transportation_model'); 
    $data['addons']=array(
                         site_url('assets')."/global/scripts/jquery.table2excel.min.js",     
                        ); 
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load']=array(

      ); 
   
    $data['ajax_script']=array(
      "0" => "$('#bus_id').change(() => {
          const bus_id = $('#bus_id').val();
           $.post('".site_url('pages/ajax/bus_stops_time_table')."', {bus_id: bus_id})
           .done(function(result) {
                $('#bus_stops_content').html(result);
           })
           .fail(function() {
              console.log('error');
           })
        });"
      );   
    $data['script'] = '
      $(document).on("click" ,".exportTable", function() {
        $("#tblExport").table2excel({
          exclude: ".noExl",
          name: "Excel Document Name",
          filename: "Downloads",
          fileext: ".xlsx",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
        });
      });';           
    $data['theme_option']=$this->theme_model->get_theme_data();
    $data['results']=$this->transportation_model->transportation_list();
    $data['main_content']='reports/bus_time_table';
    $this->load->view('template',$data);
  }

  public function employee_distribution()
  {
   
    $this->load->model('reports/general_reports_model');
    $data['addons'] = array(
      site_url('assets')."/global/scripts/loader.js",
    ); 

      $result = $this->general_reports_model->get_employees();
    //$pieGrade_stat = $this->general_reports_model->current_student_overall($batch=2074, $opt);
   
    $pieEmp_stat=array();
    if($result != NULL)
    {
      foreach($result as $row)
      {
        $pieEmp_stat[]="['$row->agreement_type', $row->total]";
      }  
         
    }
    $pieEmp_stat=implode(',',$pieEmp_stat);

    //print_e($bars);
    $data['jscript']="
      google.charts.load('current', {'packages':['bar','corechart']});
      google.charts.setOnLoadCallback(drawPieChartGrade);

      function drawPieChartGrade() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          $pieEmp_stat
        ]);

        var options = {
          title: 'Employee Distribution Chart',
          is3D: true,
          chartArea:{left:20,top:20,width:'100%',height:'100%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_emp'));
        chart.draw(data, options);
        
        google.visualization.events.addListener(chart, 'select', selectHandlerPie);

        function selectHandlerPie() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            //alert(topping);
          }
        }
      }
      
    " ; 

    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content']='reports/employee_distribution';
    $this->load->view('template',$data);
  }

  public function teacher_feedback_list($value='')
  {
    $this->load->model('classes/batch_model');
    $this->load->model('classes/grade_manager_model');
    $this->load->model('control/employee_control_model');

    $data['addons'] = array(
      site_url('assets')."/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",  
      site_url('assets')."/global/plugins/select2/select2.min.js",
    ); 
    $data['styles'] = array(
            site_url('assets')."/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            site_url('assets')."/global/plugins/select2/select2.css",                
            );
    /*
    required js plugins Functions to run script for the page
     */
    $data['addons_load'] = array(
      ); 
    $data['script'] = "
                    $( '.date-picker' ).datepicker({format: 'yyyy-mm-dd'});
                ";  
      
    $data['ajax_script'] = array(
      '2' => "
        $('#terminal_opt').submit(function(e){
          e.preventDefault();
          $('#ajax-content').html('<div class=\'alert\'>Loading.</div>');
          $.get('".site_url('pages/ajax/teacher_feedback_list')."', $('#terminal_opt').serialize())
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
    $data['teachers']=$this->employee_control_model->get_teachers();      
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/feedback_list';
    $this->load->view('template',$data);
  }
}

/* End of file General_reports.php */
/* Location: ./application/modules/pages/controllers/reports/General_reports.php */
