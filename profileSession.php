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
    if (isset($_POST['confirmPassword'])) {
        $confirmPassword = $_POST['confirmPassword'];
        if ($password == sha1($confirmPassword)) { //if the current hashed password matches, redirect to profileEdit.php
            header("Location: profileEdit.php");
        } elseif ($confirmPassword == "") { //check if password has been entered
            ?>
            <script> alert ("Please enter your current password.")
                window.location.href='profileEditConfirm.php';
            </script>
            <?php
        } else { //password is incorrect
            ?>
            <script> alert ("The password entered is incorrect. Please try again.")
                window.location.href='profileEditConfirm.php';
            </script>
            <?php
        }
    }

    //Edit the current user's account information
    if (isset($_POST['newEmail']) && isset($_POST['newBirthdate']) && isset($_POST['newPassword'])) {
        //variables
        $email = $_POST['newEmail'];
        list($user, $domain) = explode('@', $email); //split email into username and domain
        $password = $_POST['newPassword'];
        $hashed_password = sha1($password); //use sha1 hashing algorithm

        // password requirement variables
        $uppercase = preg_match('@[A-Z]@', $password); //check for uppercase letter
        $lowercase = preg_match('@[a-z]@', $password); //check for lowercase letter
        $special = preg_match('@[^\w]@', $password); //check for special character
        $number = preg_match('@[0-9]@', $password); //check for number

        $time = strtotime($_POST['newBirthdate']); //convert date in html form to sql date format
        $birthdate = date('Y-m-d', $time);

        //function to find users age from birthday (will use to check if 18)
        function getAge($bday)
        {
            $dob = new DateTime($bday);
            $now = new DateTime();
            $diff = $now->diff($dob);
            $age = $diff->y;
            return $age;
        }

        if ($email == "") { //check if email has been entered
            ?>
            <script> alert ("Please enter email.")
                window.location.href='profileEdit.php';
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
        } elseif ($password == ""){ //check if password has been entered
            ?>
            <script> alert ("Please enter password.")
                window.location.href='profileEdit.php';
            </script>
            <?php
        } elseif (!$uppercase || !$lowercase || !$special || !$number || strlen($password) < 8){ // check for uppercase, lowercase, special character, number, and 8 or more characters
            ?>
            <script> alert ("Invalid password. Your password must be 8 characters long, including an uppercase and lowercase letter, as well as a special character and number.") </script>
            <?php	
        } elseif ($time == ""){ //check if birthdate has been entered
            ?>
            <script> alert ("Please enter birthdate.")
                window.location.href='profileEdit.php';
            </script>
            <?php
        } elseif (getAge($birthdate) < 18){
            ?>
            <script> alert ("You must be 18 years of age or older to have an account.")
                window.location.href='profileEdit.php';
            </script>
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
                    $query = "update Student set email=:newEmail, password=:newPassword, birthdate=:newBirthdate where username='$username'"; //update query of account
                    $step = $connect->prepare($query); //prepare statement to prevent SQL injection
                    $step->bindParam(':newEmail', $email);
                    $step->bindParam(':newPassword', $password);
                    $step->bindParam(':newBirthdate', $birthdate);
            
                    if($step->execute()) {
                        //If query was successful, shows pop up and then redirected to profile.php
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

    //Fetch the current user's interest tags

    //Edit and delete the current user's interest tags

    //end profile session
    if(!isset($currentUser)) {
        session_destroy();
        header("Location: DashBoard.php"); //redirect to DashBoard
    }
?>