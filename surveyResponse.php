<?php
    session_start();
    require "db.php";
?>

<html>
    <style>
                table,th,td{
            border:1px solid black;
            border-collapse:collapse;
            margin:auto;
        }
        </style>
        
    <body>
        <?php
         $course = getSurveyResponseRate($_SESSION["course"]);
        ?>

        <table>
                <tr>
                    <th>C_ID</th>
                    <th>Responses</th>
                    <th>Students</th>
                    <th>Response Rate</th>
                </tr>
        <?php
            foreach($course as $row){
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";

                echo "</tr>";
            }
            echo "</table>";
        ?>
    </body>

</html>
