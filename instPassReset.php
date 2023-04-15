<?php
    require "db.php";
    session_start();
    if (isset($_POST["submit"])){
        instPassReset($_SESSION["username"], $_POST["newPass"]);
        header("LOCATION:instMain.php");
    }    
?>

<html>
    <body>
        <form method="post" action="instPassReset.php">
            Please enter new password: <br>
            <input type ="input" placeholder="New Password" name="newPass">
            <input type ="submit" value="Submit" name="submit">
        </form>
</body>
</html>
