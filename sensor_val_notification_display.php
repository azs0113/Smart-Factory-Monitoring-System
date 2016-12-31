/* <!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Sensor Value Notification Confirmation Display </title>
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
					$action_taken =  $_POST['Actionradio'];
					$issue_reported =  $_POST['Valueradio'];
					$plineNumber = $_POST['plineNumber'];
					$comments =  $_POST['comments'];
					 
					$con=mysqli_connect($servername, $username, $password, $dbname);
					// Check connection
					if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					else{
						
						if($comments!=''){	
							$result = mysqli_query($con,"INSERT into case_details(production_line, issue_reported, action_taken, comments) values ('$plineNumber','$issue_reported', '$action_taken', '$comments')");

							echo "<br/><br/><span>Data Inserted successfully...!!</span>";
						}
						else{
							echo "<p>Insertion Failed <br/> Some Fields are blank...!!</b></p>";
						}
					}	

						mysqli_close($con);
				?> 
			</form>
		</div>

	<div class="form">
		<form class="menu-form">

			<br><br><button type=button onClick="location.href='main_menu.html'">Home</button>
		</form>
	</div>
		
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>
 
  </body>
</html>
