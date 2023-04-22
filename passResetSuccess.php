<?php
    echo '<p style="color:green;"> Your password has been successfully reset. Login again with new credentials </p>';

    // Once the "Back to Login" button is clicked, navigate to the login page
    if(isset($_POST["back"])){
        header("LOCATION:login.php");    
    }
?>

<html>
    <body>
        <form method="post" action="passResetSuccess.php">
            <input type="submit" value="Back to Login" name = "back">
        </form>
    </body>
</html>    

