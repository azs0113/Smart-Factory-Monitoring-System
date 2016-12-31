<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>List of logs</title>
  
        <link rel="stylesheet" href="css/style.css">
		
  </head>
	<h1> <img src="aulogo.png" alt= "AU Logo">
		Smart Factory Monitoring System
	</h1>
  <body>

    
	
	<div class="form">
		<form class="menu-form">
			<p align="left"><b>Admin, list of previous logs: </b></p>
			
			 
			 
                <?php
				
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

						$result = mysqli_query($con,"SELECT case_id,production_line,issue_report_time FROM case_details");

						echo "<table border='1'>
						<thead>
						<tr>
						<th scope='col'>Case Number</th>
						<th scope='col'>Production Line</th>
						<th scope='col'>Time Reported</th>
						</tr></thead>";

						while($row = mysqli_fetch_array($result))
						{
							echo "<tr>";
							echo "<td>" . $row['case_id'] . "</td>";
							echo "<td>" . $row['production_line'] . "</td>";
							echo "<td>" . $row['issue_report_time'] . "</td>";
							echo "</tr>";
						}
						echo "</table>";

						mysqli_close($con);
				?> 
				
				</form>
			</div>
			
			<div class="form">
			<form class="menu-form" action = "view_log_details.php" method = "get" >
			<p align="left"><b>View Case Number:</b></p><input type="text" name="caseID">
 			<button input type="submit" value="Submit">Search</button>
			<br><br><button type=button onClick="location.href='main_menu.html'">Home</button>
			</form>	
			</div>
			
			

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

    
    
    
  </body>
</html>
