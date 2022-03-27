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
<body>
    <section class="header">
        <nav>
            <a href="index.php"><img src="images/logo.png"></a>
            <div class="nav-links">
                <ul>
                    <li><a href="">HOME</a></li>
                    <li><a href="about.html">ABOUT</a></li>
                    <button onclick="document.getElementById('id01').style.display='block'" class="login-btn">LOGIN</button>
                </ul>
            </div>
        </nav>
<div class="text-box">
    <h1>
        The College Socializing Platform
    </h1>
    <p>
        The platform where college students can get together and have a good time! Use this website to join and communicate events <br>and activities around campus to your fellow peers. This tool is a great and easy way to get out and meet new people!
    </p>
    <a href="Signup.php" class="signup-btn">Sign Up Now</a>
</div>
    </section>
    <section class="activities">
        <h1>
            A Few Things You Can Find on the College Socializing Platform.
        </h1>
        <p>
            There are a ton of fun things you can do at Michigan Tech. Let this College Socializing Platform find them for you! You'll know exactly when and where the action is happening. Below are a few examples of what you might see.
        </p>
        <div class="row">
            <div class="activity-col">
                <img src="images/broomball.jpg">
                <div class="layer">
                    <h3>
                        Broomball
                    </h3>
                    <p>
                        Broomball is an extremely popular sport at Michigan Tech. Find ongoing Broomball events and make some friends on the ice!
                    </p>
                </div>
            </div>
            <div class="activity-col">
                <img src="images/techtrails.png">
                <div class="layer">
                    <h3>
                        Skiing
                    </h3>
                    <p>
                        Michigan Tech is known for its Tech Trails and Mont Ripley Ski Areas. Join some Tech students for a great time skiing, snowboarding, tubing, and more!
                    </p>
                </div>
            </div>
            <div class="activity-col">
                <img src="images/boatbuilding.jpg">
                <div class="layer">
                    <h3>
                        Cardboard Boat Race
                    </h3>
                    <p>
                        Cardboard boat race is an awesome activity hosted during the Fall semester at Michigan Tech. Several teams spend time building a boat out of cardboard and tape. Then, the compete against each other to see which boat reigns supreme!
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="reviews">
        <h1>
            What The Students Say
        </h1>
        <p>
            Don't take it from us. Check out what students have to say about the college socializing platform.
        </p>
        <div class="row">
            <div class="reviews-col">
                <img src="images/Review1.png">
            </div>
            <div class="reviews-col">
                <img src="images/Review2.png">
            </div>
            <div class="reviews-col">
                <img src="images/Review3.png">
            </div>
        </div>
    </section>

<!-- Start of database connection and editing --> 
<?php
if (isset($_POST["testUsername"]) && isset($_POST['testPassword'])) 
{
	$username = $_POST["testUsername"]; // variable username is the value in the username text box
	setcookie("username",$username); // set cookie so username can be used later
	$password = $_POST['testPassword'];
	try{
		$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
 		$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
  		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
	
		$result = $dbh->query("select * from Student where username = '" .$username ."' and password = '" .$password ."'"); //look for Student in database with username and password
		$found = $result->fetch(); //get result of query above
  		if (! $found) //result did not return an account
   		{
			//script will produce popup, which shows the message and returns to index.php when the popup is exited
			?>
			<script> alert ("Login failed.  Please make sure that you have entered valid credentials and try again.")</script>
			<?php
  		}
   		else
   		{
			//Login successful, shows popup then redirects to next page.
			?>
			<script> alert ("Successful Login!")
			window.location.href='LoggedIn.php';
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

    <!-- Login Button Section -->
    <section>
        <div id="id01" class="modal">
            <div class="login-div">
                <div class="title">College Socializing Platform</div>

		<div class="form">
                <form method = "post" >
                    <div class="username">
                        <input type="text" placeholder="Username" name="testUsername">
            	    </div>
		    <div class="password">
                        <input type="password" placeholder="Password" name = "testPassword">
                    </div>
		</div>
			<input type = "submit" name = "ok" value = "LOGIN" class ="signin-btn">
                   
                </form>
		
			<div class="options">
                        <div class="remember-me">
                            <input id="remember-me" type="checkbox">
                            <label for="remember-me">Remember me?</label>
                        </div>

                        <div class="forgot-password">
                            <a href="newPassword.php">Forget Password?</a>
                        </div>
                    </div>
                    <div class="sign-up">
                        <a href="Signup.php">New to College Socializing Platform?</a>
                    </div>

                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancel-btn">Cancel</button>
           
            </div>
        </div>

        <script>
            // Get the modal
            var offClick = document.getElementById('id01');
            
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == offClick) {
                    offClick.style.display = "none";
                }
            }
        </script>
    </section>
</body>
</html>