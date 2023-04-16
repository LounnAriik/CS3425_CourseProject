<?php
    session_start();
?>
<html>
    <style>
        body{
            display: flex;
            align-items:center;
            justify-content:center;
            background-image: linear-gradient(#21192C, #453750);
        }
       form{
            padding: 50px;
            height:400px;
            background-color:#fbfbfb;
            border-radius: 10px;
            box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.9);
       }
       h2{
        font-family: "Raleway Thin", sans-serif;
        letter-spacing:3px;
        text-align:center;
        color:black;
       }
       label{
        color:black;
        font-family: "Raleway", sans-serif;
       }
       input[type="submit"]{
        border:none;
       }
    </style>
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
            <h2>LOGIN</h2><br><br>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br><br>
            <br>
            
            <input id="stuSubmit" type="submit" value="Student Login" name="stulogin">
            <input id="instSubmit" type="submit" value="Instructor Login" name="instlogin">

        </form>
    </body>
</html>
