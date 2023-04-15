<?php
    session_start();
?>
<html>
    <body>
        <form method=post action=login.php>
            <?php
            require "db.php";
                if (isset($_POST["logout"])) {
                    session_destroy();
                    header("LOCATION: login.php");
                    exit();
                    }
                if(isset($_POST["stulogin"])) {
                    
                    if(authenticateStudent($_POST["username"], $_POST["password"])==1){
                        $_SESSION["username"]=$_POST["username"];
                        header("LOCATION:main.php");
                        return;
                    }else{
                        echo '<p style="color:red"> incorrect username and password</p>';
                    }
                }
                if(isset($_POST["instlogin"])) {
                    
                    if(authenticateInstructor($_POST["username"], $_POST["password"])==1){
                        $_SESSION["username"]=$_POST["username"];
                        header("LOCATION:main.php");
                        return;
                    }else{
                        echo '<p style="color:red"> incorrect username and password</p>';
                    }
                }
               
            ?>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="text" id="password" name="password"><br>
            <input type="submit" value="Student Login" name="stulogin">
            <input type="submit" value="Instructor Login" name="instlogin">

        </form>
    </body>
</html>
