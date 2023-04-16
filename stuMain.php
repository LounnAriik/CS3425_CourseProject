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
        
    </body>
</html>