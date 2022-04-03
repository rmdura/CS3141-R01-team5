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

<header>Forgot Password Page</header>

<body>

<!-- Start of database connection and editing --> 
<?php
if (isset($_POST["oldUsername"]) && isset($_POST['newPassword']) && isset($_POST['oldBirthdate']) && isset($_POST['oldEmail'])) 
{

	$username = $_POST["oldUsername"]; // variable username is the value in the username text box
	$email = $_POST['oldEmail'];
	$password = $_POST['newPassword'];
	$hashed_password = sha1($password); // use sha1 hashing algorithm
	$time = strtotime($_POST['oldBirthdate']); //convert date in html form to sql date format
	$birthdate = date('Y-m-d', $time);
	
	// password requirement variables
	$uppercase = preg_match('@[A-Z]@', $password); // check for uppercase letter
	$lowercase = preg_match('@[a-z]@', $password); // check for lowercase letter
	$special = preg_match('@[^\w]@', $password); // check for special character
	$number = preg_match('@[0-9]@', $password); // check for number

	try{
		$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
 		$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
  		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
		
		//query to look for account with the credentials given (prepare used to prevent SQL injection)
		$accountquery = "Select * from Student where username = :userVal and email = :emailVal and birthdate = :birthVal";
		$accountstep = $dbh->prepare($accountquery);
		$accountstep->bindParam(':userVal', $username);
		$accountstep->bindParam(':emailVal', $email);
		$accountstep->bindParam(':birthVal', $birthdate);
		$accountstep->execute();
		$accountFound = $accountstep->fetch();
		if (! $accountFound) //result did not return an account
   		{
			//script will produce popup saying that credentials aren't linked to current account
			?>
			<script> alert ("The credentials given are not linked to a current account.  Please make sure that the username, email, and birthdate are correct and try again.")</script>
			<?php
  		}
		else if (!$uppercase || !$lowercase || !$special || !$number || strlen($password) < 8) // check for uppercase, lowercase, special character, number, and 8 or more characters
		{
			?>
			<script> alert ("Invalid password.  Your password must be 8 characters long, including an uppercase and lowercase letter, as well as a special character and number.")
			</script>
			<?php	
		}
		else{ //good to change password
			$query = "Update Student set password = :newPassword where username = :oldUsername"; //query to update password
			$step = $dbh->prepare($query); //prepare statement to prevent SQL injection
			$step->bindParam(':oldUsername', $username); //bind the parameters of query to form answers
			$step->bindParam(':newPassword', $hashed_password);
			if($step->execute()){
				//if successful, shows popup and redirects to index.php
				?>
				<script> alert ("New password has been set successfully!")
				window.location.href='index.php';
				</script>
				<?php				
			}
			else{
				//print error messages if query could not be performed
				print "The password was not able to be changed.  Please try again.";
				print $e->getMessage();	
			}
		}
	

	
	} catch (PDOException $e) {
		//print error messages if query could not be performed due to backend/database issues
		print "The account was not able to be created.  Please try again.";
		print $e->getMessage();
		die();
	}
}
?>


<h3>Account Information</h3>
	<form method = "post" >
	Username: <input type = "text" name = "oldUsername" /><br />
	Email: <input type = "text" name = "oldEmail" /><br />
	Birthdate: <input type = "date" name = "oldBirthdate" /><br />
	New Password: <input type = "password" name = "newPassword" /><br />
	<input type = "submit" name = "ok" value = "Change Password">
   	</form>

</body>
</html>