<?php
    echo '<p style="color:green;"> Your survey has been successfully submitted. </p>';

    // Once the "Go Home" button has been clicked, navigate to to the student main page
    if(isset($_POST["back"])){
        header("LOCATION:stuMain.php");    
    }
?>

<html>
    <body>
        <form method="post" action="surveyCompletePage.php">
            <input type="submit" value="Go Home" name = "back">
        </form>
    </body>
</html>    
