<?php
    $config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
    $connect = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

    //start profile session
    session_start();
    $currentUser = $_COOKIE['username']; //current user's username

    //Fetch the current user's account information
    $results = $connect->query("select * from Student where username='$currentUser'"); //select user's information
    while ($row = $results->fetch()) {
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];
        $birthdate = $row['birthdate'];
    }

    //Confirm the current password before editing
    if (isset($_POST['confirmPassword'])){
        $confirmPassword = $_POST['confirmPassword'];
        if ($password == sha1($confirmPassword)) { //if the current hashed password matches, continue with editing account
            
            if (isset($_POST['newEmail'])) {
                $email = $_POST['newEmail'];
                list($user, $domain) = explode('@', $email); //split email into username and domain

                if ($email == "") { //check if email has been entered
                    ?>
                    <script> alert ("Please enter an email address.")
                        window.location.href='profile.php';
                    </script>
                    <?php
                } elseif (strpos($email, '@') == false) {//email address given is not valid (doesn't contain @)
                    ?>
                    <script> alert ("Must use a valid email address.") </script>
                    <?php
                } elseif ($domain != 'mtu.edu'){	//if the domain is not an mtu.edu email, the user will be given a popup warning, which will redirect to signup page when exited out of
                    ?>
                    <script> alert ("Must use a valid MTU address.") </script>
                    <?php
                } else {
                    try {
                        //test to see if email is already in use
                        $emailResult = $connect->query("select * from Student where email = '" .$email ."'");
                        $emailFound = $emailResult->fetch();
                        if ($emailFound) { //email is already in use, popup error will be given
                            ?>
                            <script> alert ("There is already an account under this email.")</script>
                            <?php
                        } else { 
                            $query = "update Student set email=:newEmail where username='$username'"; //update query of account
                            $step = $connect->prepare($query); //prepare statement to prevent SQL injection
                            $step->bindParam(':newEmail', $email);
                    
                            if($step->execute()) {
                                //If query was successful, shows pop up and then redirected to profile.php
                                ?>
                                <script> alert ("Email updated successfully!")
                                    window.location.href='profile.php';
                                </script>
                                <?php
                            }
                            else {
                                //print error messages if query could not be performed
                                print "Email was not able to be updated.  Please try again.";
                                print $e->getMessage();	
                            }
                        }
                    } catch (PDOException $e) {
                        //print error messages if query could not be performed due to backend/database issues
                        print "Email was not able to be updated.  Please try again.";
                        print $e->getMessage();
                        die();
                    }
                }
            }

            else if (isset($_POST['newBirthdate'])) {
                $time = strtotime($_POST['newBirthdate']); //convert date in html form to sql date format
                $birthdate = date('Y-m-d', $time);

                //function to find users age from birthday (will use to check if 18)
                function getAge($bday) {
                    $dob = new DateTime($bday);
                    $now = new DateTime();
                    $diff = $now->diff($dob);
                    $age = $diff->y;
                    return $age;
                }

                if ($time == ""){ //check if birthdate has been entered
                    ?>
                    <script> alert ("Please enter birthdate.")
                        window.location.href='profile.php';
                    </script>
                    <?php
                } elseif (getAge($birthdate) < 18){
                    ?>
                    <script> alert ("You must be 18 years of age or older to have an account.")
                        window.location.href='profile.php';
                    </script>
                    <?php
                } else {
                    try {
                        $query = "update Student set birthdate=:newBirthdate where username='$username'"; //update query of account
                        $step = $connect->prepare($query); //prepare statement to prevent SQL injection
                        $step->bindParam(':newBirthdate', $birthdate);
                
                        if($step->execute()) {
                            //If query was successful, shows pop up and then redirected to profile.php
                            ?>
                            <script> alert ("Birthdate updated successfully!")
                                window.location.href='profile.php';
                            </script>
                            <?php
                        }
                        else {
                            //print error messages if query could not be performed
                            print "Birthdate was not able to be updated.  Please try again.";
                            print $e->getMessage();	
                        }
                    } catch (PDOException $e) {
                        //print error messages if query could not be performed due to backend/database issues
                        print "Birthdate was not able to be updated.  Please try again.";
                        print $e->getMessage();
                        die();
                    }
                }
            }

            else if (isset($_POST['newPassword'])) {
                $password = $_POST['newPassword'];
                $hashed_password = sha1($password); //use sha1 hashing algorithm

                // password requirement variables
                $uppercase = preg_match('@[A-Z]@', $password); //check for uppercase letter
                $lowercase = preg_match('@[a-z]@', $password); //check for lowercase letter
                $special = preg_match('@[^\w]@', $password); //check for special character
                $number = preg_match('@[0-9]@', $password); //check for number

                if ($password == ""){ //check if password has been entered
                    ?>
                    <script> alert ("Please enter password.")
                        window.location.href='profile.php';
                    </script>
                    <?php
                } elseif (!$uppercase || !$lowercase || !$special || !$number || strlen($password) < 8){ // check for uppercase, lowercase, special character, number, and 8 or more characters
                    ?>
                    <script> alert ("Invalid password. Your password must be 8 characters long, including an uppercase and lowercase letter, as well as a special character and number.") </script>
                    <?php	
                } else {
                    try {
                        $query = "update Student set password=:newPassword where username='$username'"; //update query of account
                        $step = $connect->prepare($query); //prepare statement to prevent SQL injection
                        $step->bindParam(':newPassword', $hashed_password);
                
                        if($step->execute()) {
                            //If query was successful, shows pop up and then redirected to profile.php
                            ?>
                            <script> alert ("Password updated successfully!")
                                window.location.href='profile.php';
                            </script>
                            <?php
                        }
                        else {
                            //print error messages if query could not be performed
                            print "Password was not able to be updated.  Please try again.";
                            print $e->getMessage();	
                        }
                    } catch (PDOException $e) {
                        //print error messages if query could not be performed due to backend/database issues
                        print "Password was not able to be updated.  Please try again.";
                        print $e->getMessage();
                        die();
                    }
                }
            }  
        } 
        elseif ($confirmPassword == "") { //check if password has been entered
            ?>
            <script> alert ("Please enter your current password to edit account settings.") </script>
            <?php
        } 
        else { //password is incorrect
            ?>
            <script> alert ("The current password entered is incorrect. Please try again.") </script>
            <?php
        }
    }

    //Fetch the current user's interest tags
    $interests = $connect->query("select tag_name from Student_Tag where student_name='$currentUser'"); //select user's information
    $TAGS = array();
    while ($row = $interests->fetch(PDO::FETCH_ASSOC)) {
        $TAGS[] = array('tagName' => $row['tag_name']);
    }

    //Edit and delete the current user's interest tags
    // SQL query with given input
    if (!empty(($_POST["newInterest"]))) {
        $condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["newInterest"]);
        $interests = $connect->query("insert into Student_Tag(student_name, tag_name) values('$currentUser', '%".$condition."%')");
    }

    if (isset($_POST['deleteInterest'])) {
        $statement = $connect->prepare("delete from Student_Tag where tag_name='Indie Rock';"); //update query of interest tags
        $statement->execute();
    }

    //end profile session
    if(!isset($currentUser)) {
        session_destroy();
        header("Location: index.php"); //redirect to index
    }
?>