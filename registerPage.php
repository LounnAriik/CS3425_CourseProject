<?php
    echo '<p style="color:green;"> You have been registered</p>';

    if(isset($_POST["back"])){
        header("LOCATION:stuMain.php");    

    }
?>

<html>
    <body>
    <form method="post" action="registerPage.php">
            <input type="submit" value="Go Back" name = "back">
        </form>
