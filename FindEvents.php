<!-- PHP code to establish connection -->
<!-- with the localserver -->
<?php

// Information needed to access the database
$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
  
// SQL query to select data from database
$eventQuery = $dbh->query("SELECT description, event_date, event_time, location, name FROM Event");
?>

<!-- HTML code to display -->
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

    <!-- CSS for styling the table -->
    <style>
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
        }
  
        h1 {
            text-align: center;
            color: #006600;
            font-size: xx-large;
            font-family: 'Gill Sans', 'Gill Sans MT', 
            ' Calibri', 'Trebuchet MS', 'sans-serif';
        }
  
        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }
  
        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
  
        td {
            font-weight: lighter;
        }
    </style>
</head>

<body>
<?php include 'LeftFloatingNavBar.html'; ?>

    <h3>Find Events Page</h3>

    <!-- Creating search bar and it's button -->
    <div class="dropdown">
		Find Event: <input type="text" name="newEventTag" class="form-control form-control-lg" placeholder="Type Here..." id="newEventTag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data(this.value)"/>
		<span id="search_result"></span>
	</div>
    <input type = "submit" name = "Submit" id="btn" value = "Search Events">

    <!-- Adding table with event information -->
    <section>
        <h1>Event information</h1>

        <!-- TABLE CONSTRUCTION-->
        <table>
            <tr>
                <th>description:</th>
                <th>event date:</th>
                <th>event time:</th>
                <th>location:</th>
                <th>name:</th>
            </tr>

            <!-- PHP CODE TO FETCH DATA FROM ROWS-->
            <?php   // LOOP TILL END OF DATA 
                while($rows=$eventQuery->fetch())
                {
             ?>
            <tr>
                <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
                <td><?php echo $rows['description'];?></td>
                <td><?php echo $rows['event_date'];?></td>
                <td><?php echo $rows['event_time'];?></td>
                <td><?php echo $rows['location'];?></td>
                <td><?php echo $rows['name'];?></td>
            </tr>
            <?php
                }
             ?>
        </table>
    </section>
</body>

</html>

<!-- Scripts to populate what events get searched for. -->
<script src="CreateEvent_Javascript.js"></script>