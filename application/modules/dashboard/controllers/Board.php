<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MX_Controller {

  public function __construct()
  {
    parent::__construct();
    //modules::run('dashboard/user_log/log');
    //$this->load->model('pages/programs/program_model');
  }
	public function status_graph()
  {

    $opt= 'grade';
    $batch = current_batch();
    $this->load->model('reports/general_reports_model');
    $pieGrade_stat = $this->general_reports_model->current_student_overall($batch, $opt);

    $piesGrades=array();
    if($pieGrade_stat != NULL)
    {
      foreach($pieGrade_stat as $row){
        $piesGrades[]="['$row->grade', $row->total]";
      }      
    }
    $piesGrades=implode(',',$piesGrades);

   
    //print_e($bars);
    $data['jscript']="
    google.charts.load('current', {'packages':['bar','corechart']});
    google.charts.setOnLoadCallback(drawPieChartGrade);

    function drawPieChartGrade() {
      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        $piesGrades
      ]);

      var options = {
        title: 'Grade wise Students',
        is3D: true,
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
  "
  ; 

    $data['main_content']='status_graph';
    $this->load->view('template',$data);
  }

  public function genderwise_classgraph()
	{

    $opt= 'grade';
    $batch = current_batch();
    $this->load->model('reports/general_reports_model');
    $pieGrade_stat = $this->general_reports_model->current_student_overall($batch, $opt);

   	$piesGradesGender=array();

    if($pieGrade_stat != NULL)
    {
     	foreach($pieGrade_stat as $row){
     		$piesGradesGender[]="['$row->grade', $row->male, $row->female]";
     	}      
    }
   	$piesGradesGender=implode(',',$piesGradesGender);
   	//print_e($bars);
		$data['jscript']="
		google.charts.load('current', {'packages':['bar','corechart']});
    google.charts.setOnLoadCallback(genderChart);

    function genderChart() {
      //const chart_width = .6*parseInt($('.graph-modal-body').width());
      var data = google.visualization.arrayToDataTable([
        ['','Male', 'Female'],
        $piesGradesGender 
      ]);

      var options = {
        chart: {
          title: 'Gender wise Students Gender Report',
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
  "
  ; 

    $data['main_content']='genderwise_graph';
    $this->load->view('template',$data);
	}

  public function grade_progress_status($grade,$exam_id)
  {
      $this->load->model('reports/class_reports_model');
     
      $result = $this->class_reports_model->grade_progress_status($grade,$exam_id=1);
      $piesGradesStat=array();
      if($result != NULL)
      {
        foreach($result as $row){
          $piesGradesStat[]="['$row->status', $row->num]";
        }      
      }
      $piesGradesStat=implode(',',$piesGradesStat);
      //print_e($bars);
      $data['jscript']="
      google.charts.load('current', {'packages':['bar','corechart']});
      google.charts.setOnLoadCallback(drawPieChart".$grade.");


      function drawPieChart".$grade."() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          $piesGradesStat
        ]);

        var options = {
          title: 'Grade ".$grade." Status',
          is3D: true,
          chartArea:{left:20,top:20,width:'100%',height:'100%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_".$grade."_status'));
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
    "; 
    $data['grade'] = $grade;
    $data['main_content']='class_status_graph';
    $this->load->view('template',$data);
  }

  public function class_progress()
  {
        
    $this->load->model('report/course/course_report_model');
    $data['class_stats'] = $this->course_report_model->get_course_pointer_summary_board();
    $data['programs'] = $this->program_model->get_active_program();
    $data['main_content'] = 'class_progress';
    $this->load->view('template',$data);
  }

  public function feedback_status()
  {
    $this->load->model('pages/student_info/student_feedback_model');
    $data['results'] = $this->student_feedback_model->get_feedback_status();
    $data['programs'] = $this->program_model->get_active_program();
    $data['main_content'] = 'feedback_status';
    $this->load->view('template',$data);
  }
}

/* End of file board_graph.php */
/* Location: ./application/modules/dashboard/controllers/board_graph.php */