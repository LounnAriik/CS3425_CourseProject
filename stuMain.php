<?php
    session_start();
?>
<html>
    <body>
        <!-- Welcome message with logout button using the session username -->
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
        <!-- Created table for courses taking by student id using the username -->
        <?php
            require "db.php";
            $classes = getCoursesTaking($_SESSION["username"]);
        ?>
            <table>
                <tr>
                    <th>C_ID</th>
                    <th>Title</th>
                    <th>Credit</th>
                    <th>Instructor</th>
                    <th>Survey Time</th>
                </tr>
        <?php
            foreach($classes as $row){
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[4] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
        <!-- Created table for courses not taken by student id using the username -->
        <?php
            require "db.php";
            $classes = getCoursesNotTaking($_SESSION["username"]);
        ?>
            <table>
                <tr>
                    <th>C_ID</th>
                    <th>Title</th>
                    <th>Credit</th>
                    <th>Instructor</th>
                    <th>Survey Time</th>
                </tr>
        <?php
            foreach($classes as $row){
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[4] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
        <br><br>
        Please enter course first then click button
        <form method="post" action="stuMain.php">
            <label for="course">Course ID:</label> 
            <input type="text" id="course" name="course"><br>
            <input type="submit" value="Register new course" name="registerCourse">
            <input type="submit" value="Take Survey" name = "takeSurvey">
        </form>
    </body>
</html>