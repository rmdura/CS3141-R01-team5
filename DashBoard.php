<!DOCTYPE html>
<html>
<head>
	<link href = "https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
	<link rel = "stylesheet" href="style.css">
</head>
<body>
	<style>
		input { margin-bottom: 20px; }
		
		textarea { margin-bottom: 20px; }
		
		.container {
			width: 100%;
			box-sizing: border-box;
			overflow: hidden;
			margin-left: 15%;
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
		
		.createEventHeader {
			width: 100%;
			text-align: center;
			font-size: 24px;

		}
		
		.customFormControl { width: 60%; }
		
		.InterestButton { margin: 5px; }
		
		.customDrop { }
	</style>
	
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
</body>
</html>