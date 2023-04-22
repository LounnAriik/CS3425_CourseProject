<?php
    session_start();
    require "db.php";
    
    $Dquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "Department");
    $Uquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "University");
    $Iquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "Instructor");
?>

<html>
    <style>
        table,th,td {
            border:1px solid black;
            border-collapse:collapse;
        }
    </style>

    <body>
        <?php
            // Display the overall response rate for the course 
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
            foreach($course as $row) {
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";

                echo "</tr>";
            }
            echo "</table>";
        ?>

        <br>
            
        <?php
            // Check if there are university questions associated with this course. If there are none, do not display the header for university questions
            if($Uquestion != null) {
                echo "<h2> University Questions: </h2>";
            }

            // Loop through all of the university questions for the course
            for($i = 0; $i < sizeof($Uquestion); $i++) {

                // Number the question and display the question title
                echo $i + 1 . ": " . $Uquestion[$i][2] . "<br>";

                // Retrieve the response rate for the current question and display the table
                $temp = getQuestionChoiceResponseRate($_SESSION["course"], $Uquestion[$i][0],$_SESSION["username"]);
                ?>

                <table>
                    <tr>
                        <th>Choice</th>
                        <th>Text</th>
                        <th>Frequency</th>
                        <th>Percentage</th>
                    </tr> 
                <?php
                    foreach($temp as $row){
                        echo "<tr>";
                        echo "<td>" . $row[0] . "</td>";
                        echo "<td>" . $row[1] . "</td>";
                        echo "<td>" . $row[2] . "</td>";
                        echo "<td>" . $row[3] . "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            }

            // Check if there are department questions associated with this course. If there are none, do not display the header for department questions
            if($Dquestion != null) {
                echo "<h2> Department Questions: </h2>";
            }

            // Loop through all of the department questions for the course
            for($i = 0; $i < sizeof($Dquestion); $i++) {

                // Number the question and display the question title
                echo $i + 1 . ": " . $Dquestion[$i][2] . "<br>";

                // Retrieve the response rate for the current question and display the table
                $temp = getQuestionChoiceResponseRate($_SESSION["course"], $Dquestion[$i][0],$_SESSION["username"]);
                ?>
                <table>
                    <tr>
                        <th>Choice</th>
                        <th>Text</th>
                        <th>Frequency</th>
                        <th>Percentage</th>
                    </tr> 
                <?php
                    foreach($temp as $row){
                        echo "<tr>";
                        echo "<td>" . $row[0] . "</td>";
                        echo "<td>" . $row[1] . "</td>";
                        echo "<td>" . $row[2] . "</td>";
                        echo "<td>" . $row[3] . "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            }

            // Check if there are instructor questions associated with this course. If there are none, do not display the header for instructor questions
            if($Iquestion!=null){
                echo "<h2> Instructor Questions: </h2>";
            }
                
            // Loop through all of the instructor questions for the course
            for($i = 0;$i < sizeof($Iquestion); $i++) {

                // Number the question and display the question title
                echo $i + 1 . ": " . $Iquestion[$i][2] . "<br>";

                // Retrieve the response rate for the current question and display the table
                $temp = getQuestionChoiceResponseRate($_SESSION["course"], $Iquestion[$i][0],$_SESSION["username"]);
                ?>

                <table>
                    <tr>
                        <th>Choice</th>
                        <th>Text</th>
                        <th>Frequency</th>
                        <th>Percentage</th>
                    </tr> 
                <?php
                    foreach($temp as $row){
                        echo "<tr>";
                        echo "<td>" . $row[0] . "</td>";
                        echo "<td>" . $row[1] . "</td>";
                        echo "<td>" . $row[2] . "</td>";
                        echo "<td>" . $row[3] . "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            }
            
            // Retrieve all individual survey responses for the course and display the table
            $indivdual = getAllIndividualSurveyResponses($_SESSION["course"]);
            echo "<h2> All Individual Survey Responses for " . $_SESSION["course"] . "</h2> <br>";
        ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Section</th>
                <th>QID</th>
                <th>Title</th>
                <th>Answer</th>
                <th>Answer Text</th>
            </tr>
        <?php
            foreach($indivdual as $row){
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[4] . "</td>";
                echo "<td>" . $row[5] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </body>
</html>
