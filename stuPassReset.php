<?php
    require "db.php";
    session_start();

    // Verify the user has already logged in. If not, redirect them to login.php immediately
    if(!isset($_SESSION["username"])) {
        header("LOCATION:login.php");
    }

    // Once the "Submit" button is clicked
    if (isset($_POST["submit"])) {

        // Verify the new password isn't empty. There are no additional password requirements
        if(($_POST["newPass"]) != null) {

            // Call the password reset function for students in db.php to update the password and naviagte to the reset success page
            stuPassReset($_SESSION["username"], $_POST["newPass"]);
            header("LOCATION:passResetSuccess.php");          
        } else {
            echo '<p style="color:red; position:absolute"> Please enter a valid password</p>';
        }   
    }
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
       input[type="text"], input[type="password"]{
        border:none;
        border-bottom: 1px solid black; 
       }
       input[type="submit"]{
        color:#fbfbfb;
        font-family: Verdana;
        border:none;
        padding:12px;
        cursor: pointer;
        border-radius:20px;
        background-image: linear-gradient(#21192C, #453750);
       }
       input[type="submit"]:hover{
        box-shadow: 1px 1px 5px #453750;
       }
       #login{
        position:relative;
        top:161px;
        left:150px;
       }
    </style>
    <body>
        <form method="post" action="stuPassReset.php">
            <h2>Password Reset</h2> <br>
            <input type ="text" placeholder="New Password" autocomplete="off" name="newPass"><br><br>
            <input type ="submit" value="Submit" name="submit">
        </form>
</body>
</html>
