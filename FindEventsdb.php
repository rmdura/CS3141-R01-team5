<!-- PHP code to establish connection -->
<!-- with the localserver -->
<?php

// Information needed to access the database
$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

// Declaring necessary variables
$user = $_COOKIE['username'];

// SQL query with given input
if (isset($_POST["btn"]) && !empty(($_POST["findEventString"])))
{
    $eventString = $_POST["findEventString"];
    $condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]);
    $eventQuery = $dbh->query("SELECT event_index, name, event_time, event_date, location, description FROM Event 
    WHERE event_index NOT IN (SELECT event_id FROM Student_Event WHERE student_name='$user') AND event_index NOT IN (SELECT event_index FROM Event WHERE owner='$user') AND name LIKE '%".$condition."%'");
}
// Default SQL query to select data from database
else
{
    $eventQuery = $dbh->query("SELECT event_index, name, event_time, event_date, location, description FROM Event 
    WHERE event_index NOT IN (SELECT event_id FROM Student_Event WHERE student_name='$user') AND event_index NOT IN (SELECT event_index FROM Event WHERE owner='$user')");
}

?>