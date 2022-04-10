<?php
    include('profileSession.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h3>Confirm Current Password To Continue</h3>
        <form method = "post">
            Password: <input type = "password" name = "confirmPassword" /><br />
            <input type = "submit" name = "ok" value = "Confirm">
        </form>

        <!-- Go back to profile.php -->
        <a href="profile.php">Cancel</a>

        <!-- Side navigation -->
        <div class="sidenav">
            <a href="profile.php">Profile</a>
            <a href="profileEditConfirm.php">Edit Profile</a>
            <a href="#">Interest Tags</a> <!-- Skip to Interest Tags section on profile.php maybe or create a new .php for it -->
            <a href="DashBoard.php">Go Back</a>
        </div>
    </body>
</html>