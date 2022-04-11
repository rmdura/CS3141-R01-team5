<!DOCTYPE html>
<html>
<head>
	<link href = "https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
	<link rel = "stylesheet" href="style.css">
</head>
<body>
	<section class="header">
		<nav>
			<!--Uses the logo to lead to their DashBoard since they are logged in.-->
			<a href = "DashBoard.php"><img src="images/logo.png"></a>
		</nav>
	</section>
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
			$user='pjellens';
			
			// Pulls joined events data for the table above from the database.
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
			
			// Pulls owned events data for the table above from the database.
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