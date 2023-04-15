<?php
    session_start();
?>
<html>
    <body>
        <?php     
            if(!isset($_SESSION["username"])) {
               header("LOCATION:login.php");
            } else {
                echo '<p align="right"> Welcome ' . $_SESSION["username"].'</p>';
        ?>
        
        <form method="post" action="login.php">
            <p align="right">
                <input type="submit" value="logout" name="logout">
            </p>
        </form>
        
        <?php
            }
        ?>
        
        Welcome to our online minibank! <br>
        We can help you to transfer the money or display your accounts <br>
        What would you like to do? Please click one of the buttons<br>
        <form method=post action=bankoperation.php>
            <input type ="submit" value = "Transfer" name="transfer">
            <input type="submit" value = "Accounts" name="accounts">
        </form>
    </body>
</html>
