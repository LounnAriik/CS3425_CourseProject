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
                if(isset($_POST["login"])) {
                    
                    if(authenticate($_POST["username"], $_POST["password"], $_POST["loginOption"])==1){
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
            <input type="submit" value="Submit" name="login">
            <label>I am logging in as a:</label><br>
            <input type="radio" id="1a" name="loginOption" value="student" checked>
                <label for="1a">student</label><br>
            <input type="radio" id="1b" name="loginOption" value="instructor">
                <label for="1b">instructor</label><br>
        </form>
    </body>
</html>
