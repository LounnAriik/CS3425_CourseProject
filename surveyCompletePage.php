<?php
    echo '<p style="color:green;"> Your survey is complete</p>';

    if(isset($_POST["back"])){
        header("LOCATION:stuMain.php");    

    }
?>

<html>
    <body>
    <form method="post" action="surveyCompletePage.php">
            <input type="submit" value="Go Home" name = "back">
        </form>
