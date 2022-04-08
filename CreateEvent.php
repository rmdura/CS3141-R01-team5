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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

</head>

<header>Create Event Page</header>

<body>

<!-- Start of database connection and editing --> 
<?php include 'CreateEvent_ServerPHP.php';?>

<h3>Event Information</h3>
	<form id="CreateEventForm" action="CreateEvent_ServerPHP.php" method = "post" >
	<input type="hidden" id="str" name="str" value="" />
	Title: <input type = "text" name = "newEventTitle" /><br />
	Date: <input type = "date" name = "newEventDate" /><br />
	Time: <input type = "time" name = "newEventTime" /><br />
	Location: <input type = "text" name = "newEventLocation" /><br />
	Description: <textarea name = "newEventDescription"></textarea><br />
	<div class="dropdown">
		Tag: <input type="text" name="newEventTag" class="form-control form-control-lg" placeholder="Type Here..." id="newEventTag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data(this.value)"/>
		<span id="search_result"></span>
	</div>
	<input type = "submit" name = "Submit" id="btn" value = "Create Event">
   	</form>

	<button onclick="AddInterest()">Add Interest</button>
	<p id="InterestList"></p>

</body>
</html>

<script>

function get_text(event)
{
	var string = event.textContent;

	document.getElementsByName('newEventTag')[0].value = string;
	
	document.getElementById('search_result').innerHTML = '';
}

function load_data(query)
{
	if(query.length > 2)
	{
		var form_data = new FormData();

		form_data.append('query', query);

		var ajax_request = new XMLHttpRequest();

		ajax_request.open('POST', 'process_data.php');

		ajax_request.send(form_data);

		ajax_request.onreadystatechange = function()
		{
			if(ajax_request.readyState == 4 && ajax_request.status == 200)
			{
				var response = JSON.parse(ajax_request.responseText);

				var html = '<div class="list-group">';

				if(response.length > 0)
				{
					for(var count = 0; count < response.length; count++)
					{
						html += '<a href="#" class="list-group-item list-group-item-action" onclick="get_text(this)">'+response[count].name+'</a>';
					}
				}
				else
				{
					html += '<a href="#" class="list-group-item list-group-item-action disabled">No Data Found</a>';
				}

				html += '</div>';

				document.getElementById('search_result').innerHTML = html;
			}
		}
	}
	else
	{
		document.getElementById('search_result').innerHTML = '';
	}
}

</script>

<script type="text/javascript">
	var tag_array = new Array();

	function AddInterest() {
		tag_array.push(document.getElementById("newEventTag").value)

		PopulateList(tag_array);
	}

	function PopulateList(arr) {
		LLen = arr.length;

		
		text = "<ol>";
		for (i = 0; i < LLen; i++) {
			text += "<li>" + arr[i] + "<input type='button' onclick='Delitem(" + i + ")' value='Delete' /></li>";

		}
		text += "</ol>";

		document.getElementById("InterestList").innerHTML = text;

		text = arr[0];
		for (i = 1; i < LLen; i++) {
			text += "," + arr[i];
		}

		oFormObject = document.forms['CreateEventForm'];
		oFormObject.elements["str"].value = text;
	}

	function Delitem(index) {
		tag_array.splice(index, 1);
		PopulateList(tag_array);
	}
	
</script>