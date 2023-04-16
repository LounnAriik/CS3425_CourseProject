<?php
    session_start();
?>
<html>
<style>
        table,th,td{
            border:1px solid black;
            border-collapse:collapse;
        }
    </style>
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
        <?php
            require "db.php";
            $classes = getCoursesTeaching($_SESSION["username"]);
        ?>
            <table>
                <tr>
                    <th>C_ID</th>
                    <th>Title</th>
                    <th>Credit</th>
                </tr>
        <?php
            foreach($classes as $row){
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
        <?php
            if(isset($_POST["course"])){

            }
        ?>
        <br><br>
        Please enter course first then click button
        <form method="post" action="instMain.php">
            <label for="course">Course:</label> 
            <input type="text" id="course" name="course"><br>
            <input type="submit" value="Review Survey Questions" name="surveyQuestions">
            <input type="submit" value="Check Survey Result" name = "checkResult">
            <input type="submit" value="Create Instructor Questions" name="createInstQuestions">
        </form>
    </body>
</html>