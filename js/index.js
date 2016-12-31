function selectSensor(select)
{
  var option = select.options[select.selectedIndex];
  var ul = select.parentNode.getElementsByTagName('ul')[0];
     
  var choices = ul.getElementsByTagName('input');
  for (var i = 0; i < choices.length; i++)
    if (choices[i].value == option.value)
      return;
     
  var li = document.createElement('li');
  var input = document.createElement('input');
  var text = document.createTextNode(option.firstChild.data);
     
  input.type = 'hidden';
  input.name = 'sensors[]';
  input.value = option.value;

  
  li.appendChild(input);
  li.appendChild(text);
  li.setAttribute('onclick', 'this.parentNode.removeChild(this);');     
    
  ul.appendChild(li);
}

google.charts.load('current', {'packages':['gauge']});
google.charts.setOnLoadCallback(drawChart);
      
	  
 function drawChart() {
		var div = document.getElementById("dom-target");
		var myData = div.textContent;
		integerData = parseInt(myData);
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Value', integerData],
        
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

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, integerData);
          chart.draw(data, options);
        }, 13000);
        setInterval(function() {
          data.setValue(1, 1, integerData);
          chart.draw(data, options);
        }, 5000);
        setInterval(function() {
          data.setValue(2, 1, integerData);
          chart.draw(data, options);
        }, 26000);
      }