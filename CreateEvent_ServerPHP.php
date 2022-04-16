<?php
if (isset($_POST['newEventTitle']) && isset($_POST['newEventDate']) && isset($_POST['newEventTime']) && isset($_POST['newEventLocation']) && isset($_POST['newEventDescription']) && isset($_POST['Submit']))
{
    $config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

		$name = $_POST["newEventTitle"]; // Event title
		$time = strtotime($_POST['newEventDate']); //convert date in html form to sql date format
		$event_date = date('Y-m-d', $time); // store date
		$stime = $_POST['newEventTime']; // store time
		$event_time = date('h:i:s', strtotime($stime)); // convert time from html form to sql time format
		$location = $_POST['newEventLocation']; // location
		$description = $_POST['newEventDescription']; // description
		$owner = $_COOKIE['username']; // username from COOKIE
		$tag_data = $_POST['str']; // string of interest tags from html form
		$tags = explode(",", $tag_data); // explode string by comma (creates array)

		$result = "SELECT MAX(event_index) FROM `Event`";
		$statement = $dbh->query($result);
		$result = $statement->fetch();
		$eventIndex = $result[0];
		$eventIndex = $eventIndex + 1;

		try{		
			// Enter data into Event table	
			$query = "Insert into Event(name, event_date, event_time, location, description, event_index, owner) values(:newEventTitle, :newEventDate, :newEventTime, :newEventLocation, :newEventDescription, :eventInd, :username)"; //query to create new event
			$step = $dbh->prepare($query); //prepare statement to prevent SQL injection
			//bind the parameters of query to form answers
			$step->bindParam(':newEventTitle', $name);
			$step->bindParam(':newEventDate', $event_date);
			$step->bindParam(':newEventTime', $event_time);
			$step->bindParam(':newEventLocation', $location);
			$step->bindParam(':newEventDescription', $description);
            $step->bindParam(':eventInd', $eventIndex);
			$step->bindParam(':username', $owner);
            $step->execute();

			// Enter data into Event_Tag table
			$stmt = $dbh->prepare("INSERT INTO `Event_Tag` (`event_id`, `tag_name`) VALUES (:eventInd, :eventTag)"); // prepare statement to prevent SQL injection
			//bind the parameters of query to form answers
            $stmt->bindParam(':eventInd', $eventIndex);
            $stmt->bindParam(':eventTag', $tag);
            foreach ($tags as $row)
            {
                $tag = $row;
                $stmt->execute();
            }
			
		} catch (PDOException $e) {
			//print error messages if query could not be performed due to backend/database issues
			print "The event was not able to be created.  Please try again.";
			print $e->getMessage();
			die();
		}
	}
