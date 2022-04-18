<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="with=device-width, initial-scale=1.0">
	<meta charset="utf-8" />
	<title>MTU Student Socializing Platform</title>
	<link rel="stylesheet" href="style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
	<style>
		input {
			margin-bottom: 20px;
		}
		
		textarea {
			margin-bottom: 20px;
		}
		
		.container {
			width: 100%;
			box-sizing: border-box;
			overflow: hidden;
			margin-left: 5%;
			position: absolute;
			top: 25%;
			left: 15%;
			text-align: left;
			border-style: solid;
			border-width: 4px;
			border-color: #EFEFEF;
			display: inline-block;
			background: #D5D5D5;
			border-radius: 25px;
		}
		
		.encapsulation {
			position: relative;
			left: 33%;
		}
		
		.JoinedEventHeader {
			width: 100%;
			text-align: center;
			font-size: 24px;
		}
		
		.customFormControl {
			width: 60%;
		}
		
		.InterestButton {
			margin: 5px;
		}
		
		.customDrop {
		}
	</style>
	
	<!--Sets Connection to Database.-->
	<?php
		try {
			$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
			$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
		} catch (PDOException $e) {
			// print error messages if query could not be performed due to backend/database issues
			print $e->getMessage();
			die();
		}
	?>
	
	<section class="CreateEvent_Header">
		<?php include 'LeftFloatingNavBar.html'; ?>
		<div class="container">
			<h3 class="JoinedEventHeader">Events You Joined</h3>
			
			<!--Creates a table with 5 columns on the website.-->
			<table border='1' width='1200' style='text-align:center' cellspacing='0'>
				<tr>
					<th>Event</th>
					<th>Time</th>
					<th>Date</th>
					<th>Location</th>
					<th>Description</th>
				</tr>
				
				<?php
					// The username used for checking joined/owned events (Currently for testing purposes).
					$user='pjellens';
					
					// Pulls joined events data from the database.
					$sql = "SELECT name, event_time, event_date, location, description FROM Event 
						WHERE event_index IN (SELECT event_id FROM Student_Event WHERE student_name='$user')";
					$result = $dbh->query($sql);
					
					// Checks if there are any results.
					if($result->rowCount() > 0) {
						while($row = $result->fetch()) {
							echo "<tr><td>". $row["name"]."</td><td>". $row["event_time"]."</td><td>". $row["event_date"]."</td><td>". 
								$row["location"]."</td><td>". $row["description"]."</td></tr>";
							<td><button type="submit" name="leave" value=<?php print_r($row['event_index']); ?>>Leave Event</button></td>
						}
					}
					
					// Pulls owned event data from the database.
					$sql = "SELECT name, event_time, event_date, location, description FROM Event WHERE owner='$user'";
					$result = $dbh->query($sql);
					
					// Checks if there are any results.
					if($result->rowCount() > 0) {
						while($row = $result->fetch()) {
							echo "<tr><td>". $row["name"]."</td><td>". $row["event_time"]."</td><td>". $row["event_date"]."</td><td>". 
							$row["location"]."</td><td>". $row["description"]."</td></tr>";
						}
					}
				?>
			</table>
			
			<input type="submit" name="Submit" id="btn" value="Leave Event" class="submitButton" style="color: black;">
		</div>
	</section>
</body>
</html>