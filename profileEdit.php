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
        <!-- Editing of current user's account information -->
        <h3>Edit Profile</h3>
        <form method = "post" >
            Email: <input type = "text" name = "newEmail" /><br />
            Birthdate: <input type = "date" name = "newBirthdate" /><br />
            Password: <input type = "password" name = "newPassword" /><br />
            <input type = "submit" name = "ok" value = "Edit Account">
        </form>

        <!-- Side navigation -->
        <div class="sidenav">
            <a href="profile.php">Profile</a>
            <a href="profileEdit.php">Edit Profile</a>
            <a href="#">Interest Tags</a> <!-- Skip to Interest Tags section on profile.php maybe or create a new .php for it -->
            <a href="DashBoard.php">Go Back</a>
        </div>
    </body>
</html>