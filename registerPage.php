<?php
    echo '<p style="color:green;"> You have been successfully registered for the course </p>';

    // Once the "Go Back" button is clicked, navigate to the student main page
    if(isset($_POST["back"])){
        header("LOCATION:stuMain.php");    
    }
?>

<html>
    <body>
        <form method="post" action="registerPage.php">
            <input type="submit" value="Go Back" name = "back">
        </form>
    </body>
</html>    
