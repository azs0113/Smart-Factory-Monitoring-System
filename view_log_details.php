<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Individual Log details</title>
  
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
					$username = "";
					$password = "";
					$dbname = "";
					$case_id =  $_GET['caseID'];
					
					 // Wrong input error to be inserted here
					 
					 
					$con=mysqli_connect($servername, $username, $password, $dbname);
					$result = mysqli_query($con,"select count(case_id) as countofCas from case_details");
					
					$array1 = array();
					while($row = $result->fetch_assoc()) {
						$array1[] = $row;
					}
					
					$countofCases = $array1[0]['countofCas'];
			
					// Check connection
					if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					
					if(intval($case_id)<=0 ){
						
						echo "<div style='text-align: left'>Invalid Case number entered</div><br>";
					}

					if(intval($case_id) > intval($countofCases)){
						
						echo "<div style='text-align: left'>Invalid Case number entered</div><br>";
					} 
					else{
						
						$result = mysqli_query($con,"SELECT * FROM case_details where case_id= $case_id ");
						$array = array();
						while($row = $result->fetch_assoc()) {
								$array[] = $row;
						}
						echo "<br><div style='text-align: left'>Case Number:\t".$array[0]['case_id']."</div>";
						echo "<br><div style='text-align: left'>Production Line:\t".$array[0]['production_line']."</div>";
						echo "<br><div style='text-align: left'>Time Reported:\t".$array[0]['issue_report_time']."</div>";
						echo "<br><div style='text-align: left'>Issue Reported:\t".$array[0]['issue_reported']."</div>";
						echo "<br><div style='text-align: left'>Action Taken:\t".$array[0]['action_taken']."</div>";
						echo "<br><div style='text-align: left'>Additional Comments:\t". $array[0]['comments']."</b></div>";
					}
					mysqli_close($con);
					
					?> 	
				</form>
			</div>		
			
			<div class="form">
			<button type=button onClick="location.href='//pdfcrowd.com/url_to_pdf/'">Save as PDF</button><br><br>
			<button type=button onClick="location.href='view_logs.php'">Make New Selection</button><br><br>
			<button type=button onClick="location.href='main_menu.html'">Home</button>
			</div>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

    
    
  </body>
</html>
