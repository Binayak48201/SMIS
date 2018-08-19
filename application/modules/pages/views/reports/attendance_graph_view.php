<?php 
$st_info =  modules::run("pages/ajax/get_st_info",$st_id);

$exam_info = modules::run("pages/ajax/get_exam_info",$st_id,$batch,$grade,$exam);
 
    $attendance = array();
   
    if($result != NULL)
    {
      $attendance[]="['$exam_info->terminal_name', $result->total_class, $result->present_class, $result->absent_class]";        
    }
    $attendance=implode(',',$attendance);
?>
<div id="barchart_material" style="width: 100%; height: 450px;"></div>
<script type="text/javascript">
  let chart_width = .6*parseInt($('.graph-modal-body').width());
   google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Attendance', 'Total Class', 'Present Class', 'Absent Class'],
            <?= $attendance ?>
          ]);

          var options = {
            chart: {
              title: '',
              subtitle: '<?= $st_info->st_fname ?> <?= $st_info->st_mname ?> <?= $st_info->st_lname ?>',
            },
            bars: 'vertical', // Required for Material Bar Charts.
            vAxis:{title:'No. of Days'},
            height: 450,
            width: chart_width,
            colors: ['4CAF50', '#03A9F4', '#d27a37']
          };

          var chart = new google.charts.Bar(document.getElementById('barchart_material'));

          chart.draw(data, google.charts.Bar.convertOptions(options));
        }
</script>