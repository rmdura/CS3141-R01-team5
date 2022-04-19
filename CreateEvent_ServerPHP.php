<?php
$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
// Initialize
$name = "";
$date = "";
$time = "";
$location = "";
$description = "";

if (isset($_POST['edit'])) { // True if the page was navigated to by the "Edit" button
	$event_index = $_POST['edit']; // save event index value
	$result = $dbh->query("SELECT * FROM `Event` WHERE event_index='$event_index'"); // Grab the event that matches the event index value
	while ($row = $result->fetch()) {
		// Set values to be obtained from the form
		$name = $row['name'];
		$date = $row['event_date'];
		$time = $row['event_time'];
		$location = $row['location'];
		$description = $row['description'];
	}
	// Select all of the tags associated with the event index to be obtained by the form
	$tag_query = $dbh->query("SELECT GROUP_CONCAT(tag_name SEPARATOR ',') FROM `Event_Tag` WHERE event_id='$event_index'");
	$tag_query = $tag_query->fetch();
	$tag_results = implode(",", $tag_query); // implode array by comma (creates string)
}
// Below is for when the form is submitted
if (isset($_POST['newEventTitle']) && isset($_POST['newEventDate']) && isset($_POST['newEventTime']) && isset($_POST['newEventLocation']) && isset($_POST['newEventDescription']) && isset($_POST['Submit'])) {
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

	if (isset($_POST['editEventIndex'])) { // Is an Edit -- Update existing event
		try {
			$event_index = $_POST['editEventIndex'];
			// Enter data into Event table	
			$query = "UPDATE `Event` SET `name`='$name',`event_time`='$event_time',`event_date`='$event_date',`location`='$location',`description`='$description' WHERE event_index='$event_index'"; //query to update existing event
			$step = $dbh->prepare($query); //prepare statement to prevent SQL injection
			$step->execute();


			$dbh->query("DELETE FROM `Event_Tag` WHERE event_id='$event_index'"); // clears all of the existing tags related to this event
			// Enter data into Event_Tag table
			if (!empty($tag_data)) { // Checks that atleast one tag was selected
				$stmt = $dbh->prepare("INSERT INTO `Event_Tag` (`event_id`, `tag_name`) VALUES (:eventInd, :eventTag)"); // prepare statement to prevent SQL injection
				//bind the parameters of query to form answers
				$stmt->bindParam(':eventInd', $event_index);
				$stmt->bindParam(':eventTag', $tag);
				foreach ($tags as $row) {
					$tag = $row;
					$stmt->execute();
				}
			}
?>
			<script>
				window.location.href = 'DashBoard.php';
				alert("Event was updated successfully!")
			</script>
		<?php

		} catch (PDOException $e) {
		?>
			<script>
				window.location.href = 'DashBoard.php';
				alert("Event was unable to be updated.")
			</script>
		<?php
			die();
		}
	} else { // Not an EDIT -- New Event
		$result = "SELECT MAX(event_index) FROM `Event`"; // Grab the maximum existing event_index so that a new one can be selected
		$statement = $dbh->query($result);
		$result = $statement->fetch();
		$eventIndex = $result[0];
		$eventIndex = $eventIndex + 1;

		try {
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

			if (!empty($tag_data)) { // Checks that atleast one tag was selected
				// Enter data into Event_Tag table
				$stmt = $dbh->prepare("INSERT INTO `Event_Tag` (`event_id`, `tag_name`) VALUES (:eventInd, :eventTag)"); // prepare statement to prevent SQL injection
				//bind the parameters of query to form answers
				$stmt->bindParam(':eventInd', $eventIndex);
				$stmt->bindParam(':eventTag', $tag);
				foreach ($tags as $row) {
					$tag = $row;
					$stmt->execute();
				}
			}
		?>
			<script>
				window.location.href = 'DashBoard.php';
				alert("Event was created successfully!")
			</script>
		<?php
		} catch (PDOException $e) {
		?>
			<script>
				window.location.href = 'DashBoard.php';
				alert("Event was unable to be created.")
			</script>
<?php
			die();
		}
	}
}
?>