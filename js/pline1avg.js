google.charts.load('current', {'packages':['gauge']});
google.charts.setOnLoadCallback(drawChart3);
      
	  
 function drawChart3() {
		var divavg = document.getElementById("dom-target-pline1-avg");
		var myDatapline1avg = divavg.textContent;
		integerDatavg = parseInt(myDatapline1avg);
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Average', integerDatavg]
        
        ]);

        var options = {
          width: 400, height: 120,
		  redFrom: 500, redTo: 600,
          yellowFrom:400, yellowTo: 500,
		  greenFrom: 150, greenTo: 400,
          minorTicks: 20,
		  //majorTicks: none,
		  //animation.easing: "out",
		  //animation.duration: 200; //milliseconds, calculate when page loads, give number greater than that
		  majorTicks: ['0', '600'],
		  max: 600,
		  min: 0
		  

        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div_pline1_avg'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, integerDatavg);
          chart.draw(data, options);
        }, 13000);
        setInterval(function() {
          data.setValue(1, 1, integerDatavg);
          chart.draw(data, options);
        }, 5000);
        setInterval(function() {
          data.setValue(2, 1, integerDatavg);
          chart.draw(data, options);
        }, 26000);
      }