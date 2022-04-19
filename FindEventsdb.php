<!-- PHP code to establish connection -->
<!-- with the localserver -->
<?php

// Information needed to access the database
$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

// Declaring some variables;
$look = "";

// Detect if the search button is clicked
if (isset($_POST["Submit"]))
{
    $look = $_GET["Submit"];
}

// SQL query with given input
if (!($look == ""))
{
    // put: eventquery = dbh->queary(......)
}
// Default SQL query to select data from database
else
{
    $eventQuery = $dbh->query("SELECT event_index, description, event_date, event_time, location, name FROM Event");
}

?>