<?php
    echo '<p style="color:green;"> Your password has been reset, login with new credentials</p>';

    if(isset($_POST["back"])){
        header("LOCATION:login.php");    

    }
?>

<html>
    <body>
    <form method="post" action="passResetSuccess.php">
            <input type="submit" value="Back to Login" name = "back">
        </form>
