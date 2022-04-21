<?php include 'LoginCheck.php'; ?>
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
<header>
</header>

<body>
	<style>
		body {
			background-image: url(images/mainWebBG.png);
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: center;
			background-size: cover;
		}
		.container {
			width: 100%;
			overflow: hidden;
			margin-left: 10%;
			position: absolute;
			text-align: left;
		}

		.InputIdentifier {
			color: white;
		}
		.createEventHeader {
			width: 100%;
			font-size: 28px;
			color: white;
		}

		.InterestButton {
			padding: 2px;
			margin-bottom: 10px;
		}

		input, textarea {
			margin-bottom: 25px;
			color: black;
			padding: 2px;
		}
		.displayInterests {
			margin-left: 2%;
		}
	</style>
	<!-- Start of database connection and editing -->
	<?php include 'CreateEvent_ServerPHP.php'; ?>
		<?php include 'LeftFloatingNavBar.html'; ?>
		<div class="container">
			<h3 class="createEventHeader" id="PageHeader">Create An Event</h3>
			<form id="CreateEventForm" action="CreateEvent_ServerPHP.php" method="post">
				<input type="hidden" id="str" name="str" value="" />
				<input type="hidden" id="editEventIndex" name="editEventIndex" value="" />
				<label class="InputIdentifier">*Title:<br /> <input type="text" name="newEventTitle" id="EventTitle" maxlength="50" size=50 required /></label><br />
				<label class="InputIdentifier">*Date:<br /> <input type="date" id="datefield" name="newEventDate" min='1899-01-01' required /></label><br />
				<label class="InputIdentifier">*Time:<br /> <input type="time" name="newEventTime" id="EventTime" required /></label><br />
				<label class="InputIdentifier">*Location:<br /> <input type="text" name="newEventLocation" id="EventLocation" maxlength="50" size=50 required /></label><br />
				<label class="InputIdentifier">*Description:<br /> <textarea name="newEventDescription" id="EventDescription" maxlength="100" rows="2" cols="50" required></textarea></label><br />
				<label class="InputIdentifier">Interest Tags:<br />
				<div class="dropdown">
					<input type="text" name="newEventTag" class="form-control form-control-lg customFormControl" placeholder="Type Here..." id="newEventTag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data(this.value)" size=50>
					<span id="search_result"></span>
				</div></label><br />
				<button type="button" class="InterestButton" onclick="AddInterest()">Add Tag</button><br />
				<div class="displayInterests">
					<p class="InputIdentifier" id="InterestList"></p>
				</div><br />
				<input type="submit" name="Submit" id="btn" value="Create Event" class="submitButton" style="color: black;"><br />
				<p class="InputIdentifier">* Denotes a required field.</p>
			</form>
		</div>
</body>

</html>
<script type="text/javascript" src="CreateEvent_Javascript.js"></script>

<script type="text/javascript">
	var indexForEditEvent = "";
	indexForEditEvent = <?php echo (json_encode($event_index)); ?>; // Obtain value of index -- is only valid if this is an "Edit An Event"
	if (indexForEditEvent.length != 0) {
		// Change form values to those obtained from the database
		document.getElementById("EventTitle").value = <?php echo (json_encode($name)); ?>;
		document.getElementById("datefield").value = <?php echo (json_encode($date)); ?>;
		document.getElementById("EventTime").value = <?php echo (json_encode($time)); ?>;
		document.getElementById("EventLocation").value = <?php echo (json_encode($location)); ?>;
		document.getElementById("EventDescription").innerHTML = <?php echo (json_encode($description)); ?>;
		// Change page text to match the new page purpose
		document.getElementById("PageHeader").innerHTML = "Edit An Event";
		document.getElementById("btn").value = "Update Event";
		// Maintain event index for when the event is updated
		document.getElementById("editEventIndex").value = indexForEditEvent;
		// Grab tag list from database and populate form with them
		var tags = <?php echo (json_encode($tag_results)); ?>; // Gets tags from PHP pull from SQL
		tagsArray = tags.split(',') // Parse tags list
		for (i = 0; i < tagsArray.length; i++) { // For each tag, populate the newEventTag input value and add the interest to the list
			document.getElementsByName('newEventTag')[0].value = tagsArray[i];
			setValidInterestTag(tagsArray[i]);
			AddInterest();
		}
		document.getElementsByName('newEventTag')[0].value = ""; // clear newEventTag input
	}
</script>