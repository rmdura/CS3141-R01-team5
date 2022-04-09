<?php
if (isset($_POST["testUsername"]) && isset($_POST['testPassword']) && $_SESSION["login_attempts"] < 3) 
{

	$password = sha1($_POST['testPassword']); // hashes using sha1 algorithm
	try{
		$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
 		$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
  		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
	
		$loginquery = "Select * from Student where username = :userVal and password = :passVal";
		$loginstep = $dbh->prepare($loginquery);
		$loginstep->bindParam(':userVal', $username);
		$loginstep->bindParam(':passVal', $password);
		$loginstep->execute();
		$loginfound = $loginstep->fetch();

  		if (! $loginfound) //result did not return an account
   		{
			$_SESSION["login_attempts"] += 1; // increment failed login attempts
			if (isset($_SESSION["locked"]))
			{} else{
			//script will produce popup, which shows the message and returns to index.php when the popup is exited
			?>
			<script> alert ("Login failed.  Please make sure that you have entered valid credentials and try again.")</script>
			<?php
			}
  		}
   		else
   		{
			//Login successful, shows popup then redirects to next page.
			unset($_SESSION["locked"]);
			$_SESSION["login_attempts"] = 0;
			?>
			<script> alert ("Successful Login!")
			window.location.href='DashBoard.php'; 
			</script>
			<?php
        		
        	}
	
	} catch (PDOException $e) {
		//should not be reached, but handles errors in database connection and other backend errors
		print "The account was not able to be created.  Please try again.";
		print $e->getMessage();
		die();
	}
}
?>