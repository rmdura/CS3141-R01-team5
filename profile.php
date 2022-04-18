<?php
    include('profileSession.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Account Settings</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
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
                font-size: 10px;
                display: flex;
            }

            .accountInfo, .searchInterestTags, .currentInterestTags {
                padding: 15px;
                font-size: 15px;
                margin-right: 700px;
            }
            
            /*  Edit Account Infomation */
            .edit-btn {
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

            .edit-btn::after {
                content: '';
                width: 0%;
                height: 2px;
                background: #f44336;
                display: block;
                margin: auto;
                transition: 0.5s;
            }
            .edit-btn:hover::after {
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
                padding-top: 50px;
            }

            .cancel-btn {
                width: auto;
                margin-top: 20px;
                margin-left: 105px;
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

            .newEmail, .newBirthdate, .newPassword, .currentPassword {
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
            <h3>Account Infomation</h3>
            <button onclick="document.getElementById('id03').style.display='block'" class="edit-btn">
                <span class="button_icon">
                    <ion-icon name="pencil-outline"></ion-icon>
                </span>
            </button>
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
            <h5>Username</h5>
            <p><?php echo $username ?></p>
            <h5>Email</h5>
            <p><?php echo $email ?></p>
            <h5>Birthday</h5>
            <p><?php echo $birthdate ?></p>
        </div>

        <div class="interestTagsHeader">
            <h3>Interest Tags</h3>
        </div>
        
        <!-- Display of Current Interest Tags Assign to the User -->
        <div class="searchInterestTags">
            <!-- For Searching for New Interest tags -->
            <h5>Search Interest Tags</h5>
            <div class="dropdown customDrop">
                <input type="text" name="newEventTag" class="form-control form-control-lg customFormControl" placeholder="Type Here..." id="newEventTag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onkeyup="javascript:load_data(this.value)">
                <span id="search_result"></span>
            </div>
            <button onclick="ob_adRows.addRow()" class="edit-btn">Add Tag</button>
        </div>

        <div class="currentInterestTags">
            <h5>Current Interest Tags</h5>
            <table id="table1">
                <tbody>
                    <?php
                        foreach ($TAGS as $TAGS) {
                            echo'<tr>';
                            echo'<td>'.$TAGS['tagName'].'<td>';
                            echo '<td><input type="button" value="Delete" onclick="ob_adRows.delRow(this)" /><td>';
                            echo'<tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
            //JS class to add/delete rows in html table - https://coursesweb.net/javascript/ 
            //receives table id
            function adRowsTable(id) {
                var table = document.getElementById(id);
                var me = this;
                if (document.getElementById(id)) {
                    var row1 = table.rows[1].outerHTML;

                    //adds index-id in cols with class .tbl_id
                    function setIds() {
                        var tbl_id = document.querySelectorAll('#' + id + ' .tbl_id');
                        for (var i = 0; i < tbl_id.length; i++) tbl_id[i].innerHTML = i + 1;
                    }

                    //add row after clicked row; receives clicked button in row
                    me.addRow = function (btn) {
                        btn ? btn.parentNode.parentNode.insertAdjacentHTML('afterend', row1) : table.insertAdjacentHTML('beforeend', row1);
                        setIds();
                    }

                    //delete clicked row; receives clicked button in row
                    me.delRow = function (btn) {
                        btn.parentNode.parentNode.outerHTML = '';
                        setIds();
                    }
                }
            }

            //create object of adRowsTable(), pass the table id
            var ob_adRows = new adRowsTable('table1');
        </script>

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="CreateEvent_Javascript.js"></script>
    </body>
</html>