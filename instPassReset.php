<?php
    require "db.php";
    session_start();
    if (isset($_POST["submit"])){
        if(($_POST["newPass"])!=null){
        stuPassReset($_SESSION["username"], $_POST["newPass"]);
        echo '<p style="color:green"> Your password was successfully reset</p>';
        }else{
            echo '<p style="color:red"> Please enter a valid password</p>';
        }
        
    }
    if (isset($_POST["login"])){
        header("LOCATION:login.php");
    } 
?>

<html>
    <body>
        <form method="post" action="instPassReset.php">
            Please enter new password: <br>
            <input type ="text" placeholder="New Password" name="newPass">
            <input type ="submit" value="Submit" name="submit">
            <input type ="submit" value="Login" name ="login">

        </form>
</body>
</html>
