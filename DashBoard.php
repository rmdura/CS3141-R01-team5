<!--Sets Connection to Database.-->
<?php
	$user = $_COOKIE['username'];
	try {
		$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
		$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
	} catch (PDOException $e) {
		// print error messages if query could not be performed due to backend/database issues
		print $e->getMessage();
		die();
	}
	
	// Pulls Joined Events Data From the database.
	$joinSql = "SELECT event_index, name, event_time, event_date, location, description FROM Event 
		WHERE event_index IN (SELECT event_id FROM Student_Event WHERE student_name='$user')";
	$joinResult = $dbh->query($joinSql);
	
	// Pulls Owned Events Data From the Database.
	$ownSql = "SELECT event_index, name, event_time, event_date, location, description FROM Event WHERE owner='$user'";
	$ownResult = $dbh->query($ownSql);	
?>

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
	
	<style>
		table {
			margin: 0 auto;
			font-size: large;
			border: 1px solid black;
		}
		
		h1 {
			text-align: center;
			color: #006600;
			font-size: xx-large;
			font-family: 'Gill Sans', 'Gill Sans MT',
				'Calibri', Trebuchet MS', sans-serif';
		}
		
		.myDiv, td {
			background-color: #E4F5D4;
			border: 1px solid black;
			text-align: center;
		}
		
		.myDiv, th, td {
			font-weight: bold;
			border: 1px solid black;
			padding: 10px;
			text-align: center;
		}
		
		td {
			font-weight: lighter;
		}
	</style>
</head>

<body>
	<?php include 'LeftFloatingNavBar.html'; ?>
	
	<!--Creates Joined Table On the Website.-->
	<h1>Joined Events</h1>
	<?php if($joinResult->rowCount() > 0) { ?>
		<table>
			<tr>
				<th>Event</th>
				<th>Time</th>
				<th>Date</th>
				<th>Location</th>
				<th>Description</th>
			</tr>
			
			<?php
				// Populates Table from Database.
				while($row=$joinResult->fetch())
				{ ?>
					<form action=LeaveEvent.php method=post>
						<tr>
							<!--FETCHING DATA FROM EACH ROW OF EVERY COLUMN-->
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['event_time'];?></td>
							<td><?php echo $row['event_date'];?></td>
							<td><?php echo $row['location'];?></td>
							<td><?php echo $row['description'];?></td>
							<td><button type="submit" name="leave" value=<?php print_r($row['event_index']);?>>Leave Event</button></td>
						</tr>
					</form>
			<?php
				} ?>
		</table>
	<?php } else { ?>
		<div class="myDiv">
			<h2>Not part of an Event?</h2>
			<a href="FindEvents.php">Join Now!</a>
		</div>
	<?php } ?>
	
	<h1>Your Events</h1>
		<?php if($ownResult->rowCount() > 0) { ?>
		<table>
			<tr>
				<th>Event</th>
				<th>Time</th>
				<th>Date</th>
				<th>Location</th>
				<th>Description</th>
			</tr>
			
			<?php
				while($row=$ownResult->fetch())
				{ ?>
					<form action=CreateEvent.php method=post>
						<tr>
							<!--FETCHING DATA FROM EACH ROW OF EVERY COLUMN-->
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['event_time'];?></td>
							<td><?php echo $row['event_date'];?></td>
							<td><?php echo $row['location'];?></td>
							<td><?php echo $row['description'];?></td>
							<td><button type="submit" name="edit" value=<?php print_r($row['event_index']);?>>Edit Event</button></td>
							<td><a href="DeleteEvent.php?event=<?php print_r($row['event_index']);?>">Delete Event</a></td>
						</tr>
					</form>
			<?php
				} ?>
		</table>
		<?php } else { ?>
			<div class="myDiv">
				<h2>Not hosting an Event?</h2>
				<a href="CreateEvent.php">Create An Event Now!</a>
			</div>
		<?php } ?>
</body>
</html>