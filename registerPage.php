

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
            text-align:center;
       }

       label{
        color:black;
        font-family: "Raleway", sans-serif;
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
       </style>
    <body>
    <form method="post" action="registerPage.php">
<?php
    echo '<p style="color:green;"> You have been successfully registered for the course </p>';

    // Once the "Go Back" button is clicked, navigate to the student main page
    if(isset($_POST["back"])){
        header("LOCATION:stuMain.php");    
    }
?>

<html>
    <body>
        <form method="post" action="registerPage.php">
            <input type="submit" value="Go Back" name = "back">
        </form>
    </body>
</html>    
