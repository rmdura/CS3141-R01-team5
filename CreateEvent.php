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
		.CreateEvent_Header {
			min-height: 100vh;
			width: 100%;
			background-image: url(images/mainWebBG.png);
			background-position: center;
			background-size: cover;
			position: absolute;
		}

		input {
			margin-bottom: 20px;
			color: white;
		}

		textarea {
			margin-bottom: 20px;
			color: white;
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

		.customDrop {}
	</style>
	<!-- Start of database connection and editing -->
	<?php include 'CreateEvent_ServerPHP.php'; ?>
	<section class="CreateEvent_Header">
		<?php include 'LeftFloatingNavBar.html'; ?>
		<div class="container">
			<h3 class="createEventHeader">Create An Event</h3>
			<form id="CreateEventForm" action="CreateEvent_ServerPHP.php" method="post">
				<input type="hidden" id="str" name="str" value="" />
				<p class="InputIdentifier">*Title:</p><br /> <input type="text" name="newEventTitle" maxlength="50" required /><br />
				<p class="InputIdentifier">*Date:</p><br /> <input type="date" id="datefield" name="newEventDate" min='1899-01-01' required /><br />
				<p class="InputIdentifier">*Time:</p><br /> <input type="time" name="newEventTime" required /><br />
				<p class="InputIdentifier">*Location:</p><br /> <input type="text" name="newEventLocation" maxlength="50" required /><br />
				<p class="InputIdentifier">*Description:</p><br /> <textarea name="newEventDescription" maxlength="100" required></textarea><br />
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
<script src="CreateEvent_Javascript.js"></script>