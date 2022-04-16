<?php
    include('profileSession.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Account Settings</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php include 'LeftFloatingNavBar.html'; ?>
        <style>
            body {
                margin-left: 200px;
                padding: 40px;
                color: white;
                background: #1c1b22;
            }

            .accountInfoHeader, .interestTagsHeader {
                font-size: 15px;
                display: flex;
            }
            button {
                margin-left: 10px;
            }

            .editAccount {
                position: relative;
            }

            .accountInfo {
                padding: 15px;
                font-size: 20px;
            }
            
            /*  Edit Account Infomation */
            .edit-btn{
                display: inline-block;
                text-decoration: none;
                color: white;
                border: transparent;
                padding: 5px 15px;
                font-size: 13px;
                background: transparent;
                position: relative;
                cursor: pointer;
            }

            .edit-btn::after{
                content: '';
                width: 0%;
                height: 2px;
                background: #f44336;
                display: block;
                margin: auto;
                transition: 0.5s;
            }
            .edit-btn:hover::after{
                width: 100%;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0,0,0);
                background-color: rgba(0,0,0,0.5);
                padding-top: 60px;
            }

            .cancel-btn {
                width: auto;
                margin-top: 20px;
                margin-left: 140px;
                text-align: center;
                color: gray;
                border: none;
                background: transparent;
                font-size: 18px;
            }

            .cancel-btn:hover{
                color: #f44336;
                transition: 0.75s;
            }

            .edit-div {
                margin: 100px auto;
                width: 360px;
                background-color: white;
                border-radius: 20px;
                padding: 40px;
            }

            .title {
                text-align: center;
                color: black;
                font-weight: bolder;
                font-size: 20px;
            }

            .form {
                width: 100%;
                margin-top: 30px;
            }

            .form input {
                font-size: 16px;
                padding: 10px 20px 10px 5px;
                border: none;
                outline: none;
                background: none;
            }

            .newEmail, .newBirthdate, .newPassword, .currentPassword, .confirmNewPassword {
                display: block;
                border-radius: 5px;
                border: 1px solid rgba(0, 0, 0, 0.2);
                padding: 5px;
                margin: 10px 0;
            }

            .editAccount-btn {
                width: 100%;
                padding: 12px 10px;
                border: 1px solid black;
                font-size: 18px;
                border-radius: 5px;
                background-color: gray;
                color: white;
                margin-bottom: 20px;
                cursor: pointer;
            }

            .editAccount-btn:hover {
                border: 1px solid #f44336;
                background: #f44336;
                transition: 0.75s;
            }
        </style>

        <div class="accountInfoHeader">
            <h1>Account Infomation</h1>
            <button onclick="document.getElementById('id03').style.display='block'" class="edit-btn">Edit Account</button>
        </div>

        <!-- Edit Account Infomation Button Section -->
        <section>
        <div id="id03" class="modal">
            <div class="edit-div">
                <div class="title">Edit Account Form</div>
                <div class="form">
                    <form method = "post" >
                        <div class="currentPassword">
                            <input type="password" placeholder="Current Password" name = "confirmPassword">
                        </div>

                        <div class="newEmail">
                            <input type="text" placeholder="New Email" name = "newEmail">
                        </div>

                        <div class="newBirthdate">
                            <input placeholder = "New Birthdate" class = "textbox-n" type = "text" onfocus = "(this.type = 'date')"  id = "date" name = "newBirthdate">
                        </div>

                        <div class="newPassword">
                            <input type="password" placeholder="New Password" name = "newPassword">
                        </div>

                        <div class="confirmNewPassword">
                            <input type="password" placeholder="Confirm New Password" name = "confirmNewPassword">
                        </div>
		        </div>
                        <input type = "submit" name = "ok" value = "Edit Account" class ="editAccount-btn">
                    </form>
                    <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancel-btn">Cancel</button>
                </div>
            </div>
        </div>
        <script>
            // Get the modal
            var offClick = document.getElementById('id03');
            
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == offClick) {
                    offClick.style.display = "none";
                }
            }
        </script>
    </section>

        <!-- Fetch the current user's account information -->
        <div class="accountInfo">
                <h3>Username</h3>
                <p><?php echo $username ?></p>
                <h3>Email</h3>
                <p><?php echo $email ?></p>
                <h3>Birthday</h3>
                <p><?php echo $birthdate ?></p>
        </div>

        <div class="interestTagsHeader">
            <h1>Interest Tags</h1>
        </div>
    </body>
</html>