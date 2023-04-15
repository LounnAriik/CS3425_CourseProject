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

                // Specical login for students.    
                if(isset($_POST["stulogin"])) {
                    
                    if(authenticateStudent($_POST["username"], $_POST["password"])==1){
                        $_SESSION["username"]=$_POST["username"];
                        
                        // Force the student to go to the reset password page if it's their first login.
                        if (firstLoginStudent($_POST["username"]) == 1){
                            header("LOCATION:stuPassReset.php");
                        }
                        else {
                            header("LOCATION:stuMain.php");
                        }    
                        return;
                    }else{
                        echo '<p style="color:red"> incorrect username and password</p>';
                    }
                }

                // Special login for instuctors.
                if(isset($_POST["instlogin"])) {
                    
                    if(authenticateInstructor($_POST["username"], $_POST["password"])==1){
                        $_SESSION["username"]=$_POST["username"];
                        
                        // Force the instructor to go to the reset password page if it's their first login.
                        if (firstLoginInstructor($_POST["username"]) == 1){
                            header("LOCATION:instPassReset.php");
                        }
                        else {
                            header("LOCATION:instMain.php");
                        } 
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
            <br>
            <input type="submit" value="Student Login" name="stulogin">
            <input type="submit" value="Instructor Login" name="instlogin">

        </form>
    </body>
</html>
