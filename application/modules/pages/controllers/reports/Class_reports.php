<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_reports extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		modules::run('dashboard/user_log/log');
	  check_access();
	
		$this->load->model('reports/class_reports_model');
	}

	public function list_classes()
  {

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
    
   // $np_date_arr = explode('-', AD_to_BS(date('Y-m-d'))); 
   // $escape_year = $np_date_arr[0];
    $escape_year = current_batch();
    $data['classes'] = $this->class_reports_model->list_classes($escape_year);
    //print_e($data['classes']);
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/list_classes';
    $this->load->view('template',$data);
  }

  /*public function attendance_overall()
	{

		 $data['styles']=array(
        site_url('assets')."/global/plugins/select2/select2.css",                                       //requires for select 2 
        );

    $data['addons'] = array(
       site_url('assets')."/global/scripts/jquery.table2excel.min.js",
      // site_url('assets')."/global/plugins/datatables/media/js/jquery.dataTables.min.js",
       // site_url('assets')."/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
       site_url('assets')."/global/plugins/select2/select2.min.js",
      ); 
   
    $data['addons_load'] = array(
      ); 
    
   	$data['ajax_script'] = array(			
			);			
		
		//$np_date_arr = explode('-', AD_to_BS(date('Y-m-d'))); 
  	//$escape_year = $np_date_arr[0];
  	$escape_year = current_batch();
    $data['classes'] = $this->class_reports_model->list_classes($escape_year);
    //print_e($data['classes']);
    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content'] = 'reports/attendance_overall';
    $this->load->view('template',$data);
	}*/

  public function gender_distribution()
  {
    $opt= 'grade';
    $batch = current_batch();
    $this->load->model('reports/general_reports_model');
    $data['addons'] = array(
      site_url('assets')."/global/scripts/loader.js",
    ); 

      $pieGrade_stat = $this->general_reports_model->current_student_overall($batch, $opt);
    //$pieGrade_stat = $this->general_reports_model->current_student_overall($batch=2074, $opt);

    $barGradesGender= [];
    $male = [];
    $female = [];
    if($pieGrade_stat != NULL)
    {
      foreach($pieGrade_stat as $row){
        
        $male[] = $row->male;
        $female[] = $row->female;
        $barGradesGender[]="['$row->grade', $row->male, $row->female]";
      }      
    }
    $barGradesGender=implode(',',$barGradesGender);

    $total_male = array_sum($male);
    $total_female = array_sum($female);
    $piesGender=array();
    if($pieGrade_stat != NULL)
    {
      
        $piesGender[]="['male', $total_male]";
        $piesGender[]="['female', $total_female]";
         
    }
    $piesGender=implode(',',$piesGender);

    //print_e($bars);
    $data['jscript']="
      google.charts.load('current', {'packages':['bar','corechart']});
      google.charts.setOnLoadCallback(genderChart);
      google.charts.setOnLoadCallback(drawPieChartGrade);

      function drawPieChartGrade() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          $piesGender
        ]);

        var options = {
          title: 'Overall Students Gender Report',
          is3D: true,
          colors: ['#90caf9', '#f48fb1'],
          chartArea:{left:20,top:20,width:'100%',height:'100%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_grade'));
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
      function genderChart() {
        //const chart_width = .6*parseInt($('.graph-modal-body').width());
        var data = google.visualization.arrayToDataTable([
          ['','Male', 'Female'],
          $barGradesGender 
        ]);

        var options = {
          chart: {
            title: 'Grade wise Students Gender Report',
            subtitle: '',
          },
          bars: 'vertical', // Required for Material Bar Charts.
          vAxis:{title:'No. of Students'},
          height: 350,
          colors: ['#90caf9', '#f48fb1']
        };

        var chart = new google.charts.Bar(document.getElementById('genderbarchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    " ; 

    $data['theme_option'] = $this->theme_model->get_theme_data();
    $data['main_content']='reports/genderwise_graph';
    $this->load->view('template',$data);
  }

}

/* End of file Class_reports.php */
/* Location: ./application/modules/pages/controllers/reports/Class_reports.php */
