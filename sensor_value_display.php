<!DOCTYPE html>   


<html >
  <head>
  
	
    <meta  http-equiv="refresh" content="8" charset="UTF-8">
    <title>Sensor Value Display </title>
        <link rel="stylesheet" href="css/style.css">   
  </head>
	<h1> <img src="aulogo.png" alt= "AU Logo">
		Smart Factory Monitoring System
	</h1>
  <body>

    
	
	<div class="form">
		<form class="menu-form">
			
			
			<?php
					echo "<p align='left'><b>Welcome Admin,</p>";
					$servername = "";
					$portAddress= "";
					$username = "";
					$password = "";
					$dbname = "";
					$sensor_id =  $_GET['sensorId'];
					
					if ($sensor_id >= 13){
							$Production_line_no = 4;
						} 
						elseif($sensor_id >= 9 && $sensor_id <13){
							$Production_line_no = 3;
						}
						elseif($sensor_id >= 5 && $sensor_id <9){
							$Production_line_no = 2;
						}
						else{
							$Production_line_no = 1;
						}
					 
					$con=mysqli_connect($servername, $username, $password, $dbname);
					// Check connection
					if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					else if ($sensor_id <1 OR $sensor_id >14 OR $sensor_id==4 OR $sensor_id ==5 ){
						echo "<div style='text-align: left'>Invalid Sensor ID provided</div><br>";
						
					}
					else{
						
						$result = mysqli_query($con,"SELECT sensor_id, sensor_value FROM sensor_table where sensor_id= $sensor_id ");

						$array = array();

						while($row = $result->fetch_assoc()) {
								$array[] = $row;
						}
						
						echo "<div style='text-align: left'> Production Line:\t$Production_line_no </div>";
						echo "<br><div style='text-align: left'>Sensor ID:\t".$array[0]['sensor_id']."</div>";
						echo "<div id='chart_div' style='position: absolute; width: 400px; height: 120px; top: 80px; left: 100px;'></div>";
						echo "<br><div style='text-align: left'>Reported Value:\t". $array[0]['sensor_value']."</b></div>";
						
						echo "<div id='dom-target' style='display: none;'>";
						$output = $array[0]['sensor_value']; 
						echo htmlspecialchars($output);
						echo "</div>";
						
						
					}	

						mysqli_close($con);
				?> 
			</div>
			</form>
		</div>
			<div class="form">
		<form>
			<button type=button onClick="location.href='sensor_selection.html'">Make New Selection</button>
			<br><br><button type=button onClick="location.href='main_menu.html'">Home</button>
		</div>
		</form>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       

        <script src="js/index.js"></script>

    
    
    
  </body>
</html>
