<!DOCTYPE html>
<html>
<head>
    <meta name = "viewport" content="with=device-width, initial-scale=1.0">
    <title>MTU Student Socializing Platform</title>
    <link rel = "stylesheet" href="style.css">
    <link rel = "preconnect" href="https://fonts.googleapis.com">
	<link rel = "preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href = "https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
	<section class="header">
	    <nav>
	    	// Uses the logo to lead to their DashBoard since they are logged in.
	        <a href = "DashBoard.php"><img src="images/logo.png"></a>
	    </nav>
	</section>
    <?php
    	try {
			$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
			$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
		} catch (PDOException $e) {
			//print error messages if query could not be performed due to backend/database issues
			print $e->getMessage();
			die();
		}
	?>
	// Creates a table with 5 columns on the website.
	<table>
		<tr>
			<th>Event</th>
			<th>Time</th>
			<th>Date</th>
			<th>Location</th>
			<th>Description</th>
		</tr>
		<?php
			// Pulls data for the table above from the database.
			$sql = "SELECT name, event_time, event_date, location, description from Event";
			$result = $dbh-> query($sql);
			
			// Checks if there are any results.
			if($result-> num_rows > 0) {
				while($row = $result-> fetch_assoc()) {
					echo "<tr><td>". $row["Event"]."</td><td>". $row["Time"]."</td><td>". $row["Date"]."</td><td>". $row["Location"]."</td><td>". $row["Description"]."</td></tr>";
				}
			echo "</table";
			} else {
				echo "0 results";
			}
			
			// Closes connection to the database.
			$dbh-> close();
		?>
	</table>
</body>
</html>
