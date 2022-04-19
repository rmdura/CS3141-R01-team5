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
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <section class="sub-header">
        <nav>
            <a href="index.php"><img src="images/logo.png"></a>
            <div class="nav-links">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="about.php">ABOUT</a></li>
                    <button onclick="document.getElementById('id01').style.display='block'" class="login-btn">LOGIN</button>
                </ul>
            </div>
        </nav>
<div class="text-box">
    <h1>
        About Us
    </h1>
</div>
    </section>
<!----- About Us Content ----->
<main class="container">
    <section class="card">
        <img src="images/EliP.jpg" alt="">
        <div>
            <h3>Eli Pinnoo</h3>
            <p>
                <b>Major:</b> Computer Science<br><b>Year:</b> Sophomore<br><b>Hometown:</b> St. Claire, Michigan<br><b>Interests:</b> Playing for the Michigan Tech Tennis team and hanging with friends
            </p>
        </div>
    </section>
    <section class="card" data-aos="fade-left">
        <img src="images/RyanD.jpg" alt="">
        <div>
            <h3>Ryan Dura</h3>
            <p>
                <b>Major:</b> Statistics<br><b>Minor:</b> Computer Science<br><b>Year:</b> Senior<br><b>Hometown:</b> Porterfield, Wisconsin<br><b>Interests:</b> Exercising, reading, playing cards, and meeting new people
            </p>
        </div>
    </section>
    <section class="card" data-aos="fade-right">
        <img src="images/JoshG.jpg" alt="">
        <div>
            <h3>Joshua Green</h3>
            <p>
                <b>Major:</b> Electrical Engineering<br><b>Minor:</b> Computer Science<br><b>Year:</b> Senior<br><b>Hometown:</b> Taylor, Michigan<br><b>Interests:</b> Picking up a new hobby every two seconds, video/card games, and hanging out with friends
            </p>
        </div>
    </section>
    <section class="card" data-aos="fade-left">
        <img src="images/SeanL.jpg" alt="">
        <div>
            <h3>Sean Leverenz</h3>
            <p>
                <b>Major:</b> Computer Science<br><b>Year:</b> Sophomore<br><b>Hometown:</b> Macomb, Michigan<br><b>Interests:</b> Enjoys learning new and interesting skills
            </p>
        </div>
    </section>
    <section class="card" data-aos="fade-right">
        <img src="images/PhilE.jpg" alt="">
        <div>
            <h3>Phillip Ellenson</h3>
            <p>
                <b>Major:</b> Computer Science<br><b>Minor:</b> Mathematics, Cyber Security, Financial Technology<br><b>Year:</b> Sophomore<br><b>Hometown:</b> Warroad, Minnesota<br><b>Interests:</b> Playing for the Husky Pep Band and playing cards
            </p>
        </div>
    </section>
</main>

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
    <!-- Script for scrolling animations -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({
          offset: 400,
          duration: 800
      });
    </script>
</body>

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
    <!-- Script for scrolling animations -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({
          offset: 400,
          duration: 800
      });
    </script>
</body>
</html>