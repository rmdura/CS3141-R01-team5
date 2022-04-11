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
	<?php include 'LeftFloatingNavBar.html'; ?>

	<style>
		input {
			margin-bottom: 20px;
		}

		textarea {
			margin-bottom: 20px;
		}

		.container {
			width: 100%;
			box-sizing: border-box;
			overflow: hidden;
			margin-left: 15%;
			position: absolute;
			top: 25%;
			left: 15%;
			text-align: left;
			border-style: solid;
			border-width: 4px;
			border-color: #EFEFEF;
			display: inline-block;
			background: #D5D5D5;
			border-radius: 25px;
		}

		.encapsulation {
			position: relative;
			left: 33%;
		}

		.createEventHeader {
			width: 100%;
			text-align: center;
			font-size: 24px;

		}

		.customFormControl {
			width: 60%;
		}

		.InterestButton {
			margin: 5px;
		}

		.customDrop {
		}
	</style>

	<!-- Start of database connection and editing -->
	<?php include 'CreateEvent_ServerPHP.php'; ?>

	<div class="container">
		<h3 class="createEventHeader">Create An Event</h3>
		<form id="CreateEventForm" action="CreateEvent_ServerPHP.php" method="post">
			<input type="hidden" id="str" name="str" value="" />
			<div class="encapsulation">
				Title:<br /> <input type="text" name="newEventTitle" /><br />
				Date:<br /> <input type="date" name="newEventDate" /><br />
				Time:<br /> <input type="time" name="newEventTime" /><br />
				Location:<br /> <input type="text" name="newEventLocation" /><br />
				Description:<br /> <textarea name="newEventDescription"></textarea><br />
				Interest Tags:<br /> 
				<div class="dropdown customDrop">
					<input type="text" name="newEventTag" class="form-control form-control-lg customFormControl" placeholder="Type Here..." id="newEventTag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data(this.value)">
					<span id="search_result"></span>
				</div>
				<button type="button" class="InterestButton" onclick="AddInterest()">Add Tag</button>
				<div class="displayInterests">
					<p id="InterestList"></p>
				</div>
				<input type="submit" name="Submit" id="btn" value="Create Event" class="submitButton">
			</div>
		</form>

	</div>

</body>

</html>

<script src="CreateEvent_Javascript.js"></script>