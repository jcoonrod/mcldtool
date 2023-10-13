<!-- TO DO:: Need to optimize this code later by using the chart class. -->
<!-- TO DO:: Need to make it part of the Chart Class -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>

// defaults for all charts
Chart.defaults.global.responsive = true;
Chart.defaults.global.defaultColor = 'white';
Chart.defaults.global.defaultFontColor = 'white';
Chart.defaults.global.tooltips.backgroundColor = '#fff';
Chart.defaults.global.tooltips.titleFontColor = 'black';
Chart.defaults.global.tooltips.bodyFontColor = 'black';
Chart.defaults.global.animation.duration = 1500;
Chart.defaults.global.animation.easing = 'easeInOutQuart';
Chart.defaults.global.maintainAspectRatio = true;
Chart.defaults.global.legend.display = false;

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMultSeries);

function drawMultSeries() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Type of Participants');
      data.addColumn('number', 'Target');
      data.addColumn('number', 'Actual');

      data.addRows([
        ['Events', <?php echo $noOfEventsTarget;?>, <?php echo $noOfEventsActual;?>],
        ['Male', <?php echo $noOfMalesTarget;?>, <?php echo $noOfMalesActual;?>],
        ['Female', <?php echo $noOfFemalesTarget;?>, <?php echo $noOfFemalesActual;?>]
      ]);

      var options = {
        title: 'Column Chart for Number of Total People Reached',
        hAxis: {
          title: 'Type Of People'
        },
        vAxis: {
          title: 'Number of People Reached'
        }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_div'));
      chart.draw(data, options);
    }
</script>
<?php
function make_chart($n,$ctitle,$ctype,$x,$y){
	echo("<div class='pure-u-1-3'><h3>$ctitle</h3><canvas id=chart$n width=500 height=350></canvas></div>\n");
	echo("<script>\n");
	echo("var data$n = { \n");
	echo("  labels : ".json_encode($x).",\n");
	echo("  datasets : [{\n"); 
	echo("	label: '$ctitle',\n");
	if( 'line' == $ctype ){
		echo("	fill: false,\n");
    }else{
    	echo("	fill: true,\n");
    }
	echo("	backgroundColor: 'lightgreen',\n");
	echo("	borderWidth: 2,\n	borderColor: 'lightgreen',\n");
	echo("	pointBorderColor: 'lightgreen',\n");
	echo("	data: ".json_encode($y)."\n	} \n], \n}; \n");
	echo("var c$n = document.getElementById('chart".$n."').getContext('2d');\n");
 	echo("var cc$n = new Chart(c$n,{ type: '$ctype', data: data$n, options: ChartOptions } );\n");
 	echo("</script>\n");
}
?>