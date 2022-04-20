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

		.CreateEvent_Header {
			min-height: 100vh;
			width: 100%;
			position: absolute;
		}

		.InputIdentifier {
			color: white;
		}

		.container {
			width: 100%;
			box-sizing: border-box;
			overflow: hidden;
			margin-left: 15%;
			position: absolute;
			text-align: left;
		}

		.createEventHeader {
			width: 100%;
			font-size: 28px;
			color: white;
		}

		.customFormControl {
			width: 60%;
		}

		.InterestButton {
			margin: 5px;
		}

		input {
			margin-bottom: 20px;
			color: black;
		}

		textarea {
			margin-bottom: 20px;
			color: black;
		}

		.customDrop {}
	</style>
	<!-- Start of database connection and editing -->
	<?php include 'CreateEvent_ServerPHP.php'; ?>
	<section class="CreateEvent_Header">
		<?php include 'LeftFloatingNavBar.html'; ?>
		<div class="container">
			<h3 class="createEventHeader" id="PageHeader">Create An Event</h3>
			<form id="CreateEventForm" action="CreateEvent_ServerPHP.php" method="post">
				<input type="hidden" id="str" name="str" value="" />
				<input type="hidden" id="editEventIndex" name="editEventIndex" value="" />
				<p class="InputIdentifier">*Title:</p><br /> <input type="text" name="newEventTitle" id="EventTitle" maxlength="50" required /><br />
				<p class="InputIdentifier">*Date:</p><br /> <input type="date" id="datefield" name="newEventDate" min='1899-01-01' required /><br />
				<p class="InputIdentifier">*Time:</p><br /> <input type="time" name="newEventTime" id="EventTime" required /><br />
				<p class="InputIdentifier">*Location:</p><br /> <input type="text" name="newEventLocation" id="EventLocation" maxlength="50" required /><br />
				<p class="InputIdentifier">*Description:</p><br /> <textarea name="newEventDescription" id="EventDescription" maxlength="100" required></textarea><br />
				<p class="InputIdentifier">Interest Tags:</p><br />
				<div class="dropdown customDrop">
					<input type="text" name="newEventTag" class="form-control form-control-lg customFormControl" placeholder="Type Here..." id="newEventTag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data(this.value)">
					<span id="search_result"></span>
				</div>
				<button type="button" class="InterestButton" onclick="AddInterest()">Add Tag</button>
				<div class="displayInterests">
					<p class="InputIdentifier" id="InterestList"></p>
				</div>
				<input type="submit" name="Submit" id="btn" value="Create Event" class="submitButton" style="color: black;">
				<p class="InputIdentifier">* Denotes a required field.</p>
			</form>
		</div>
	</section>
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