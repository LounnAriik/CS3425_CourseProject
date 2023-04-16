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
        
        
    </body>
</html>