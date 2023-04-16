<?php
    require "db.php";
    session_start();

    if (isset($_POST["submit"])) {

        // Verify the new password isn't empty. There are no additional password requirements
        if(($_POST["newPass"])!=null) {

            // Call the password reset function for instructors in db.php, display a success message
            stuPassReset($_SESSION["username"], $_POST["newPass"]);
            echo '<p style="color:green"> Your password was successfully reset</p>';
            echo '<form method="post" action="stuPassReset.php"> <input type="submit" value="Login" name="login">';
        } else {
            echo '<p style="color:red"> Please enter a valid password</p>';
        }   
    }

    // The login buttons redirects to the main login page (first verify the user actually submitted a new password)
    if (isset($_POST["login"])){
         header("LOCATION:login.php");
    } 
?>

<html>
    <body>
        <form method="post" action="stuPassReset.php">
            Please enter new password: <br>
            <input type ="text" placeholder="New Password" name="newPass">
            <input type ="submit" value="Submit" name="submit">

        </form>
</body>
</html>
