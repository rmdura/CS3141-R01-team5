<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <title>MTU Student Socializing Platform</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<header>Create Account Page</header>

<body>

<!-- Start of database connection and editing --> 
<?php
if (isset($_POST["newUsername"]) && isset($_POST['newPassword']) && isset($_POST['newBirthdate']) && isset($_POST['newEmail'])) 
{
	$username = $_POST["newUsername"]; // variable username is the value in the username text box
	if ($username == ""){ //check if username has been entered
		?>
		<script> alert ("Please enter username.")
		window.location.href='Signup.php';
		</script>
		<?php
	}
	else{
	setcookie("username",$username); // set cookie so username can be used later
	$email = $_POST['newEmail'];
	if ($email == ""){ //check if email has been entered
		?>
		<script> alert ("Please enter email.")
		window.location.href='Signup.php';
		</script>
		<?php
	}
	else{
	if (strpos($email, '@') == false)
	{//email address given is not valid (doesn't contain @)
		?>
		<script> alert ("Must use a valid email address.")</script>
		<?php
	}
	else{

	list($user, $domain) = explode('@', $email); //split email into username and domain
	if ($domain != 'mtu.edu') //if the domain is not an mtu.edu email, the user will be given a popup warning, which will redirect to signup page when exited out of
	{
		?>
		<script> alert ("Must use a valid MTU address.")</script>
		<?php
	}
	else{ //valid email, can move on
	$password = $_POST['newPassword'];
	if ($password == ""){ //check if password has been entered
		?>
		<script> alert ("Please enter password.")
		window.location.href='Signup.php';
		</script>
		<?php
	}
	else{
	$time = strtotime($_POST['newBirthdate']); //convert date in html form to sql date format
	$birthdate = date('Y-m-d', $time);
	try{
		$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
 		$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
  		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
		
		//test to see if username or email are already in use
		$userResult = $dbh->query("select * from Student where username = '" .$username ."'");
		$userFound = $userResult->fetch();
		$emailResult = $dbh->query("select * from Student where email = '" .$email ."'");
		$emailFound = $emailResult->fetch();
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
		$step->bindParam(':newPass', $password);
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
		
	
	} catch (PDOException $e) {
		//print error messages if query could not be performed due to backend/database issues
		print "The account was not able to be created.  Please try again.";
		print $e->getMessage();
		die();
	}
	
	}}}}}
}
?>

<h3>Login Credentials</h3>
	<form method = "post" >
	Username: <input type = "text" name = "newUsername" /><br />
	Email: <input type = "text" name = "newEmail" /><br />
	Birthdate: <input type = "date" name = "newBirthdate" /><br />
	Password: <input type = "password" name = "newPassword" /><br />
	<input type = "submit" name = "ok" value = "Create Account">
   	</form>
</body>
</html>
