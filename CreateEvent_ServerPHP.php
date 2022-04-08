<?php
if (isset($_POST["newEventTitle"]) && isset($_POST['newEventDate']) && isset($_POST['newEventTime']) && isset($_POST['newEventLocation']) && isset($_POST['newEventDescription']))
{

    $config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

		$name = $_POST["newEventTitle"]; // variable name is the value in the eventTitle text box

		// *** QUESTIONABLE FORMATTING ***
		$time = strtotime($_POST['newEventDate']); //convert date in html form to sql date format
		$event_date = date('Y-m-d', $time);

		$stime = $_POST['newEventTime'];
		$event_time = date('h:i:s', strtotime($stime));

		$location = $_POST['newEventLocation'];
		$eventLocation = $_POST['newEventLocation'];
		$description = $_POST['newEventDescription'];
		// OBTAIN USERNAME OF CURRENT ACCOUNT SESSION $owner = ... :username

		$tag_name = $_POST['newEventTag'];

		$eventIndex = "SELECT MAX(event_index) FROM `Event`";
        $eventIndex=intval($eventIndex);
		$eventIndex = $eventIndex + 1;

		try{			
			$query = "Insert into Event(name, event_date, event_time, location, description, event_index) values(:newEventTitle, :newEventDate, :newEventTime, :newEventLocation, :newEventDescription, :eventInd)"; //query to create new event
			$step = $dbh->prepare($query); //prepare statement to prevent SQL injection
			$step->bindParam(':newEventTitle', $name); //bind the parameters of query to form answers
			$step->bindParam(':newEventDate', $event_date);
			$step->bindParam(':newEventTime', $event_time);
			$step->bindParam(':newEventLocation', $location);
			$step->bindParam(':newEventDescription', $description);
            $step->bindParam(':eventInd', $eventIndex);
            $step->execute();
			//$step->bindParam(':username', $owner);
			
		} catch (PDOException $e) {
			//print error messages if query could not be performed due to backend/database issues
			print "The event was not able to be created.  Please try again.";
			print $e->getMessage();
			die();
		}
		try{
            // Santizing the string this way is a little safer than using $_POST['tag_array']
            //$tagArray = filter_input(INPUT_POST, 'tag_array', FILTER_SANITIZE_STRING);
            
			// Turn the sanitized JSON string into a PHP object
            //$tags = json_decode($tagArray);
            //$tags = explode(",", $tags);

			//$json = $_POST['myData'];
			//$tags = json_decode($json,true);
			$tags = explode(",", $_GET['Itags']);
            
            $stmt = $dbh->prepare("INSERT INTO `Event_Tag` (`event_id`, `tag_name`) VALUES (:eventInd, :eventTag)");
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
?>