<!-- TO DO:: Need to optimize this code later by using the chart class. -->
<!-- TO DO:: Need to make it part of the Chart Class -->
<script>
google.charts.load('current', {packages: ['line']});
google.charts.setOnLoadCallback(drawCurveTypes);

function drawCurveTypes() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
      data.addColumn('number', 'Target');
      data.addColumn('number', 'Actual');

      data.addRows( <?php echo json_encode($lineData);?> );

      var options = {
        title: 'Line chart comparing Targetted Events Vs Actual Events',
        width: 850,
        height: 500,
        hAxis: {
          title: 'By Month (Time)'
        },
        vAxis: {
          title: 'Total Number of Events'
        },
        series: {
          1: {curveType: 'function'}
        }
        //legend: { position: 'bottom' }
        //curveType: 'function'
      };

      var chart = new google.visualization.LineChart(document.getElementById('linechart_div'));
      chart.draw(data, options);
    }
</script>