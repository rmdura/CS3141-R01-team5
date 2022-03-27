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
if (isset($_POST["newEventTitle"]) && isset($_POST['newEventDateTime']) && isset($_POST['newEventLocation']) && isset($_POST['newEventDescription']) && isset($_POST['newEventTag'])) 
{
	$eventTitle = $_POST["newEventTitle"]; // variable username is the value in the username text box

    // *** QUESTIONABLE FORMATTING ***
    $time = strtotime($_POST['newEventDate']); //convert date in html form to sql date format
	$eventDateTime = date('Y-m-d', $time);

	$eventLocation = $_POST['newEventLocation'];
    $eventLocation = $_POST['newEventLocation'];
    $eventDescription = $_POST['newEventDescription'];
    $eventTag = $_POST['newEventTag'];
	try{
		$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
 		$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
  		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
		
		$query = "Insert into Event(title, datetime, location, description, tag) values(:newEventTitle, :newEventDateTime, :newEventLocation, :newEventDescription, :newEventTag)"; //query to create new account
		$step = $dbh->prepare($query); //prepare statement to prevent SQL injection
		$step->bindParam(':newEventTitle', $eventTitle); //bind the parameters of query to form answers
		$step->bindParam(':newEventDateTime', $eventDateTime);
		$step->bindParam(':newEventLocation', $eventLocation);
		$step->bindParam(':newEventDescription', $eventDescription);
        $step->bindParam(':newEventTag', $eventTag);

        // *** MUST MAKE EventCreateSuccess.php ***
		if($step->execute()){
			header("Location: EventCreateSuccess.php"); //if query could be executed redirect user to successful event creation webpage
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
	Datetime: <input type = "datetime-local" name = "newEventDateTime" /><br />
	Location: <input type = "text" name = "newEventLocation" /><br />
	Description: <input type = "text" name = "newEventDescription" /><br />
    Tags: <input type = "text" name = "newEventTag" /><br />
	<input type = "submit" name = "ok" value = "Create Event">
   	</form>
</body>
</html>
