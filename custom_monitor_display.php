<!DOCTYPE html>
<html >
  <head>
    <meta http-equiv="refresh" content="8" charset="UTF-8">
    <title>Custom Monitor Display </title>
        <link rel="stylesheet" href="css/style.css">   
  </head>
	<h1> <img src="aulogo.png" alt= "AU Logo">
		Smart Factory Monitoring System
	</h1>
  <body>

    
	
	<div class="form">
		<form class="menu-form">
		
		
			<?php
					echo "<p align='left'><b>Welcome Admin, You are now custom monitoring selected sensors </p>";
					$servername = "";
					$username = "";
					$password = "";
					$dbname = "";
					$con=mysqli_connect($servername, $username, $password, $dbname);
					// Check connection
				
					if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					else{						
						$sensorArray = $_GET['sensors'];
						$sensorArray2 = implode(",", $sensorArray);

						$result1 = mysqli_query($con,"select sensor_id, sensor_value from sensor_table where sensor_value= (select MAX(sensor_value) from sensor_table where sensor_id IN ($sensorArray2)) LIMIT 1 ");
						$array1 = array();
						while($row = $result1->fetch_assoc()) {
								$array1[] = $row;
						}
						echo "<br><br><div style='text-align: left'>Maximum Value:\t".$array1[0]['sensor_value']."</div>";
						echo "<br><div style='text-align: left'>Sensor ID:\t" .$array1[0]['sensor_id']. "</div>"; 
						

						
						$result2 = mysqli_query($con,"select sensor_id, sensor_value from sensor_table where sensor_value= (select MIN(sensor_value) from sensor_table where sensor_id IN ($sensorArray2)) LIMIT 1 ");
						$array2 = array();
						while($row = $result2->fetch_assoc()) {
								$array2[] = $row;
						}
						echo "<br><br><br><br><div style='text-align: left'>Minimum Value:\t".$array2[0]['sensor_value']."</div>";
						echo "<br><div style='text-align: left'>Sensor ID:\t" .$array2[0]['sensor_id']. "</div><br>"; 
						
						
						
						$result3 = mysqli_query($con,"select AVG(sensor_value) as avg_value from sensor_table where sensor_id IN($sensorArray2)");
						$array3 = array();
						while($row = $result3->fetch_assoc()) {
								$array3[] = $row;
						}
						echo "<br><br><br><div style='text-align: left'>Average Value:\t".round($array3[0]['avg_value'],2)."</b></div><br><br>";
						
						
						echo "<div id='dom-target-pline1-max' style='display: none;'>";
						$outputpline1max = $array1[0]['sensor_value']; 
						echo htmlspecialchars($outputpline1max);
						echo "</div>";
						
						
						echo "<div id='dom-target-pline1-min' style='display: none;'>";
						$outputpline1min = $array2[0]['sensor_value']; 
						echo htmlspecialchars($outputpline1min);
						echo "</div>";
						
						
						echo "<div id='dom-target-pline1-avg' style='display: none;'>";
						$outputpline1avg = $array3[0]['avg_value']; 
						echo htmlspecialchars($outputpline1avg);
						echo "</div>";
						
						
						echo "<div id='chart_div_pline1_max' style='position: absolute; width: 400px; height: 120px; top: 120px; left: 80px;'></div>";
						
						echo "<div id='chart_div_pline1_min' style='position: absolute; width: 400px; height: 120px; top: 250px; left: 80px;'></div>";
						
						echo "<div id='chart_div_pline1_avg' style='position: absolute; width: 400px; height: 120px; top: 380px; left: 80px;'></div>";
						
						
						
					}
					mysqli_close($con);
					
			?> 
		</form>
	</div>
		
		
		<div class="form">
			<form class="menu-form">
				<br><br><button type=button onClick="location.href='custom_monitor.html'">Make new selection</button>
				<br><br><button type=button onClick="location.href='main_menu.html'">Home</button>
			</form>
		</div>

    <<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script src="js/pline1max.js"></script>
		<script src="js/pline1min.js"></script> 
		<script src="js/pline1avg.js"></script> 		
    
    
    
  </body>
</html>
