<!-- PHP code to establish connection -->
<!-- with the localserver -->
<?php

// Information needed to access the database
$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
  
// SQL query to select data from database
$eventQuery = $dbh->query("SELECT event_index, description, event_date, event_time, location, name FROM Event");

?>