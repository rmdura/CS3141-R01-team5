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
        <!-- Fetch the current user's account information --> 
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Birthdate</th>
            </tr>

            <tr>
                <td><?php echo $username ?></td>
                <td><?php echo $email ?></td>
                <td><?php echo $password ?></td>
                <td><?php echo $birthdate ?></td>
            </tr>
        </table>

        <!-- Side navigation -->
        <div class="sidenav">
            <a href="profile.php">Profile</a>
            <a href="profileEdit.php">Edit Profile</a>
            <a href="#">Interest Tags</a> <!-- Skip to Interest Tags section on profile.php maybe or create a new .php for it -->
            <a href="DashBoard.php">Go Back</a>
        </div>
    </body>
</html>