<?php
    $config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
    $connect = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

    //start profile session
    session_start();
    $currentUser = $_COOKIE['username']; //current user's username

    //Fetch the current user's account information
    $results = $connect->query("select * from Student where username='$currentUser'"); //select user's information
    while($row = $results->fetch()) {
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];
        $birthdate = $row['birthdate'];
    }

    //Edit the current user's account information
    if (isset($_POST['newEmail']) && isset($_POST['newBirthdate']) && isset($_POST['newPassword'])) {
        $email = $_POST['newEmail'];
        if ($email == "") { //check if email has been entered
            ?>
            <script> alert ("Please enter email.")
                window.location.href='profileSession.php';
            </script>
            <?php
        } 
        else {
            if (strpos($email, '@') == false) { //email address given is not valid (doesn't contain @)
                ?>
                <script> alert ("Must use a valid email address.")</script>
                <?php
            }
            else {
                list($user, $domain) = explode('@', $email); //split email into username and domain
                if ($domain != 'mtu.edu') { //if the domain is not an mtu.edu email, the user will be given a popup warning, which will redirect to signup page when exited out of
                    ?>
                    <script> alert ("Must use a valid MTU address.")</script>
                    <?php
                } 
                else { //valid email, can move on
                    $password = $_POST['newPassword'];
                    if ($password == "") { //check if password has been entered
                        ?>
                        <script> alert ("Please enter password.")
                            window.location.href='profileSession.php';
                        </script>
                        <?php
                    }
                    else {
                        $time = strtotime($_POST['newBirthdate']); //convert date in html form to sql date format
                        $birthdate = date('Y-m-d', $time);
                        try {
                            //test to see if email is already in use
                            $emailResult = $connect->query("select * from Student where email = '" .$email ."'");
                            $emailFound = $emailResult->fetch();
                            if ($emailFound) { //email is already in use, popup error will be given
                                ?>
                                <script> alert ("There is already an account under this email.")</script>
                                <?php
                            }
                            else { 
                                $query = "update Student set email=:newEmail, password=:newPassword, birthdate=:newBirthdate where username='$username'"; //update query of account
                                $step = $connect->prepare($query); //prepare statement to prevent SQL injection
                                $step->bindParam(':newEmail', $email);
                                $step->bindParam(':newPassword', $password);
                                $step->bindParam(':newBirthdate', $birthdate);
                        
                                if($step->execute()) {
                                    //If query was successful, shows pop up and then redirected to index.php
                                    ?>
                                    <script> alert ("Account updated successfully!")
                                        window.location.href='profile.php';
                                    </script>
                                    <?php
                                }
                                else {
                                    //print error messages if query could not be performed
                                    print "The account was not able to be updated.  Please try again.";
                                    print $e->getMessage();	
                                }
                            }
                        } catch (PDOException $e) {
                            //print error messages if query could not be performed due to backend/database issues
                            print "The account was not able to be updated.  Please try again.";
                            print $e->getMessage();
                            die();
                        }
                    }
                }
            }
        }
    }
    //Fetch the current user's interest tags

    //Edit and delete the current user's interest tags

    //end profile session
    if(!isset($currentUser)) {
        session_destroy();
        header("Location: DashBoard.php"); //redirect to DashBoard
    }
?>