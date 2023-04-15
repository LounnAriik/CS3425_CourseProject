<?php
    require "db.php";
    session_start();
    instPassReset($_POST["username"], $_POST["newPass"]);
    header("LOCATION:stuMain.php");
?>

<html>
    <body>
        <form method="post" action="stuPassReset.php">
            Please enter new password: <br>
            <input type ="input" placeholder="New Password" name="newPass">
            <input type ="submit" value="Submit" name="submit">
        </form>
</body>
</html>
