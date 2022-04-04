<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!-- Connect to the local database -->
        <?php
            $host = "localhost";
            $user = "root";
            $password = "";
            $database = "accounts";
            $conn = mysqli_connect($host, $user, $password, $database);
            $username = 'bob'; //current user's username
            $results = $conn->query("select * from students where username='$username'"); //select user's information
        ?>
        <!-- Fetch the current user's account information --> 
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Birthdate</th>
            </tr>

            <?php while ($data = $results->fetch_assoc()):?>
                <?php print_r($data);?>
                <tr>
                    <td><?php echo $data['username'] ?></td>
                    <td><?php echo $data['email'] ?></td>
                    <td><?php echo $data['password'] ?></td>
                    <td><?php echo $data['birthdate'] ?></td>
                </tr>
            <?php endwhile;?>
        </table>
        <!-- Editing of current user's account information -->
        
        
        <!-- Side navigation -->
        <div class="sidenav">
            <a href="#">Edit Profile</a>
            <a href="#">Interest Tags</a>
            <a href="#">Settings</a>
            <a href="#">Go Back</a>
        </div>
    </body>
</html>