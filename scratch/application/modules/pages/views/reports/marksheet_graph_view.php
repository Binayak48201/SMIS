<?php 

$subjects = modules::run("pages/ajax/get_class_subjects",$grade,$batch);
$st_info =  modules::run("pages/ajax/get_st_info",$st_id);
if($exam != AGGREGATE_ID)
  {
    $exam_info = modules::run("pages/ajax/get_exam_info",$st_id,$batch,$grade,$exam);
  }
  else
  {
    $final_exam = modules::run("pages/ajax/get_final_exam",$batch,$grade);
    $exam_info = modules::run("pages/ajax/get_exam_info",$st_id,$batch,$grade,$final_exam->exam_id);
  }
    $marks = array();
    if(isset($subjects))
    {
      $total_mark = 0;
      $total_obtain = 0;
      foreach($subjects as $subject)
      {
        $final_mark = modules::run("pages/exam/marks_entry/students_final_mark",$st_id,$subject->subject_id,$exam);
        if($final_mark != NULL && $exam != AGGREGATE_ID)
          $sub_total = $final_mark->total_marks;
        else if($final_mark != NULL && $exam == AGGREGATE_ID)
          $sub_total = $final_mark->final_mark;
        else
          $sub_total = 0;
        $marks[]="['$subject->subject_name', $subject->full_marks, $subject->pass_marks, $sub_total]";        
      }
    }
  
  
    $marks=implode(',',$marks);
?>
<div id="barchart_material" style="width: 100%; height: 450px;"></div>
<script type="text/javascript">
  let chart_width = .6*parseInt($('html').width());
   google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Subjects', 'Full Mark', 'Pass Mark', 'Obtain Mark'],
            <?= $marks ?>
          ]);

          var options = {
            chart: {
              title: '<?= $exam != AGGREGATE_ID ? $exam_info->terminal_name.' EXAMINATION' : 'CONSOLIDATED RESULT'?>, <?= $exam_info->batch?>',
              subtitle: '<?= $st_info->st_fname ?> <?= $st_info->st_mname ?> <?= $st_info->st_lname ?>',
            },
            bars: 'vertical', // Required for Material Bar Charts.
            vAxis:{title:'Marks'},
            height: 450,
            width: chart_width,
            colors: ['4CAF50', '#03A9F4', '#d27a37']
          };

          var chart = new google.charts.Bar(document.getElementById('barchart_material'));

          chart.draw(data, google.charts.Bar.convertOptions(options));
        }
</script>