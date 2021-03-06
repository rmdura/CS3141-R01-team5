<?php
session_start(); // start session

if (isset($_SESSION["login_attempts"])) // initialize login attempts if session is starting
{} else{
	$_SESSION["login_attempts"] = 0;
}

if (isset($_SESSION["locked"])) // if session is locked, check if enough time has passed and unlock if so
{
	$difference = time() - $_SESSION["locked"];
	if ($difference > 30)
	{
		unset($_SESSION["locked"]);
		$_SESSION["login_attempts"] = 0;
	}
}

// must define cookies before any html (throws warning otherwise)
if (isset($_POST["testUsername"]) && isset($_POST['testPassword'])) 
{
	$username = $_POST["testUsername"]; // variable username is the value in the username text box
	setcookie("username",$username); // set cookie so username can be used later
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <title>MTU Student Socializing Platform</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <section class="header">
        <nav>
            <a href="index.php"><img src="images/logo.png"></a>
            <div class="nav-links">
                <ul>
                    <li><a href="">HOME</a></li>
                    <li><a href="about.php">ABOUT</a></li>
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
    <button onclick="document.getElementById('id02').style.display='block'" class="signup-btn">Sign Up Now</button>
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

<!-- LOGIN PHP -->
<?php include 'Loginphp.php'; ?>

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
			<?php
				if ($_SESSION["login_attempts"] > 2) // print lock message and remove login button if locked out
				{
					$_SESSION["locked"] = time();
					echo '<i style="color:red;font-family:calibri ;">Locked out.  Please wait 30 seconds. </i> ';
				} else{
			?>
		</div>
			<input type = "submit" name = "ok" value = "LOGIN" class ="signin-btn">
                   	
			<?php } ?>
                </form>
		
			<div class="options">
                        
                    </div>
                    <div class="sign-up">
                        <button onclick="document.getElementById('id02').style.display='block'" class="signin-btn">New to College Socializing Platform?</button>
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

<!-- SIGNUP PHP -->
<?php include 'Signupphp.php'; ?>

    <!-- Signup Button Section -->
    <section>
        <div id="id02" class="modal">
            <div class="login-div">
                <div class="title">Welcome to College Socializing Platform</div>

                <div class="form">
                    <form method = "post" >
                        <div class="newUsername">
                            <input type="text" placeholder="Username" name = "signupUsername">
                        </div>

                        <div class="newEmail">
                            <input type="text" placeholder="Email" name = "signupEmail">
                        </div>

                        <div class="newBirthdate">
                            <input placeholder = "Birthdate" class = "textbox-n" type = "text" onfocus = "(this.type = 'date')"  id = "date" name = "signupBirthdate">
                        </div>

                        <div class="newPassword">
                            <input type="password" placeholder="Password" name = "signupPassword">
                        </div>
		</div>
                        <input type = "submit" name = "ok" value = "Create Account" class ="signin-btn">
                    </form>

                    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancel-btn">Cancel</button>
                
            </div>
        </div>
    </section>
    <section class="footer">
    	<h4>
            Connect with Us!
        </h4>
        <div class="icons">
            <i class="fa fa-facebook"></i>
            <i class="fa fa-twitter"></i>
            <i class="fa fa-instagram"></i>
            <i class="fa fa-linkedin"></i>
        </div>
        <p>
            Made by Team 5
        </p>
    </section>
</body>
</html>