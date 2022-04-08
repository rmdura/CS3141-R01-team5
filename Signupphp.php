<?php
if (isset($_POST["signupUsername"]) && isset($_POST['signupPassword']) && isset($_POST['signupBirthdate']) && isset($_POST['signupEmail'])) 
{
	$username = $_POST["signupUsername"]; // variable username is the value in the username text box
	$email = $_POST['signupEmail'];
	list($user, $domain) = explode('@', $email); //split email into username and domain
	$password = $_POST['signupPassword'];
	$hashed_password = sha1($password); // use sha1 hashing algorithm

	// password requirement variables
	$uppercase = preg_match('@[A-Z]@', $password); // check for uppercase letter
	$lowercase = preg_match('@[a-z]@', $password); // check for lowercase letter
	$special = preg_match('@[^\w]@', $password); // check for special character
	$number = preg_match('@[0-9]@', $password); // check for number

	$time = strtotime($_POST['signupBirthdate']); //convert date in html form to sql date format
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

	if ($username == ""){ //check if username has been entered
		?>
		<script> alert ("Please enter username.")
		window.location.href='index.php';
		</script>
		<?php
	}
	elseif ($email == ""){ //check if email has been entered
		?>
		<script> alert ("Please enter email.")
		window.location.href='index.php';
		</script>
		<?php
	}
	elseif (strpos($email, '@') == false) {//email address given is not valid (doesn't contain @)
		?>
		<script> alert ("Must use a valid email address.")</script>
		<?php
	}
	elseif ($domain != 'mtu.edu'){	//if the domain is not an mtu.edu email, the user will be given a popup warning, which will redirect to signup page when exited out of
		?>
		<script> alert ("Must use a valid MTU address.")</script>
		<?php
	}
	elseif ($password == ""){ //check if password has been entered
		?>
		<script> alert ("Please enter password.")
		window.location.href='index.php';
		</script>
		<?php
	}
	elseif (!$uppercase || !$lowercase || !$special || !$number || strlen($password) < 8){ // check for uppercase, lowercase, special character, number, and 8 or more characters
		?>
		<script> alert ("Invalid password.  Your password must be 8 characters long, including an uppercase and lowercase letter, as well as a special character and number.")
		</script>
		<?php	
	}
	elseif ($time == ""){ //check if birthdate has been entered
		?>
		<script> alert ("Please enter birthdate.")
		window.location.href='index.php';
		</script>
		<?php
	}
	elseif (getAge($birthdate) < 18){
		?>
		<script> alert ("You must be 18 years of age or older to create an account.")
		window.location.href='index.php';
		</script>
		<?php
	}
	else{
		try{
			$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
 			$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
  			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
		
			// test to see if username or email are already in use
			// prepare statements used to prevent SQL injection 
			$userquery = "Select * from Student where username = :userVal";
			$userstep = $dbh->prepare($userquery);
			$userstep->bindParam(':userVal', $username);
			$userstep->execute();
			$userFound = $userstep->fetch();

			$emailquery = "Select * from Student where email = :emailVal";
			$emailstep = $dbh->prepare($emailquery);
			$emailstep->bindParam(':emailVal', $email);
			$emailstep->execute();
			$emailFound = $emailstep->fetch();		

			if ($userFound) //username is already in use, popup error will be given
			{
				?>
				<script> alert ("This username is already in use.  Please choose a new username.")</script>
				<?php
			}
			elseif ($emailFound) //email is already in use, popup error will be given
			{
				?>
				<script> alert ("There is already an account under this email.  If you have forgotten your password, please return to the home page to reset it.")</script>
				<?php
			}
			else{ //username and email are new, good to continue
				$query = "Insert into Student(username, email, password, birthdate) values(:newUser, :newEmail, :newPass, :newBirthdate)"; //query to create new account
				$step = $dbh->prepare($query); //prepare statement to prevent SQL injection
				$step->bindParam(':newUser', $username); //bind the parameters of query to form answers
				$step->bindParam(':newEmail', $email);
				$step->bindParam(':newPass', $hashed_password);
				$step->bindParam(':newBirthdate', $birthdate);
				if($step->execute()){
					//If query was successful, shows pop up and then redirected to index.php
					?>
					<script> alert ("Account created successfully!")
					window.location.href='index.php';
					</script>
					<?php
				}
				else{
					//print error messages if query could not be performed
					print "The account was not able to be created.  Please try again.";
					print $e->getMessage();	
				}
			}	
		} 
		catch (PDOException $e) 
		{
			//print error messages if query could not be performed due to backend/database issues
			print "The account was not able to be created.  Please try again.";
			print $e->getMessage();
			die();
		}
	}
}

?>