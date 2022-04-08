<?php
    $config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
    $connect = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

    //session_start(); //start profile session

    $username = 'testUser'; //current user's username [TEMP SOLUTION, works on session access]
    $results = $connect->query("select * from Student where username='$username'"); //select user's information
    while($row = $results->fetch()) {
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];
        $birthdate = $row['birthdate'];
    }
?>