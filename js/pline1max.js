google.charts.load('current', {'packages':['gauge']});
google.charts.setOnLoadCallback(drawChart1);
      
	  
 function drawChart1() {
		var divmax = document.getElementById("dom-target-pline1-max");
		var myDatapline1max = divmax.textContent;
		integerDatamax = parseInt(myDatapline1max);
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Max', integerDatamax]
        
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

        var chart = new google.visualization.Gauge(document.getElementById('chart_div_pline1_max'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, integerDatamax);
          chart.draw(data, options);
        }, 13000);
        setInterval(function() {
          data.setValue(1, 1, integerDatamax);
          chart.draw(data, options);
        }, 5000);
        setInterval(function() {
          data.setValue(2, 1, integerDatamax);
          chart.draw(data, options);
        }, 26000);
      }