<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <title>MTU Student Socializing Platform</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">

</head>

<header>Create Event Page</header>

<body>

<!-- Start of database connection and editing --> 
<?php
if (isset($_POST["newEventTitle"]) && isset($_POST['newEventDate']) && isset($_POST['newEventTime']) && isset($_POST['newEventLocation']) && isset($_POST['newEventDescription'])) 
{
		$name = $_POST["newEventTitle"]; // variable name is the value in the eventTitle text box

		// *** QUESTIONABLE FORMATTING ***
		$time = strtotime($_POST['newEventDate']); //convert date in html form to sql date format
		$event_date = date('Y-m-d', $time);

		$stime = $_POST['newEventTime'];
		$event_time = date('h:i:s', strtotime($stime));

		$location = $_POST['newEventLocation'];
		$eventLocation = $_POST['newEventLocation'];
		$description = $_POST['newEventDescription'];
		$tag1 = $_POST['newEventTag1'];
		$tag2 = $_POST['newEventTag2'];
		$tag3 = $_POST['newEventTag3'];
		try{
			$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
			$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
			
			$query = "Insert into Event(name, event_date, event_time, location, description, tag1, tag2, tag3) values(:newEventTitle, :newEventDate, :newEventTime, :newEventLocation, :newEventDescription, :newEventTag1, :newEventTag2, :newEventTag3)"; //query to create new event
			$step = $dbh->prepare($query); //prepare statement to prevent SQL injection
			$step->bindParam(':newEventTitle', $name); //bind the parameters of query to form answers
			$step->bindParam(':newEventDate', $event_date);
			$step->bindParam(':newEventTime', $event_time);
			$step->bindParam(':newEventLocation', $location);
			$step->bindParam(':newEventDescription', $description);
			$step->bindParam(':newEventTag1', $tag1);
			$step->bindParam(':newEventTag2', $tag2);
			$step->bindParam(':newEventTag3', $tag3);

			
			// *** MUST MAKE EventCreateSuccess.php ***
			if($step->execute()){
				header("Location: AccountCreateSuccess.php"); //if query could be executed redirect user to successful event creation webpage
			}
			else{
				//print error messages if query could not be performed
				print "The event was not able to be created.  Please try again.";
				print $e->getMessage();	
			}
			
		} catch (PDOException $e) {
			//print error messages if query could not be performed due to backend/database issues
			print "The event was not able to be created.  Please try again.";
			print $e->getMessage();
			die();
		}
	}
?>

<h3>Event Information</h3>
	<form method = "post" >
	Title: <input type = "text" name = "newEventTitle" /><br />
	Date: <input type = "date" name = "newEventDate" /><br />
	Time: <input type = "time" name = "newEventTime" /><br />
	Location: <input type = "text" name = "newEventLocation" /><br />
	Description: <textarea name = "newEventDescription"></textarea><br />
    Tag 1: <input type = "text" name = "newEventTag1"></select><br />
	Tag 2: <input type = "text" name = "newEventTag2"></select><br />
	Tag 3: <input type = "text" name = "newEventTag3"></select><br />
	<input type = "submit" name = "ok" value = "Create Event">
   	</form>
</body>
</html>
