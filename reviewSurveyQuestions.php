<?php
    session_start();
    require "db.php";
    $Dquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "Department");
    $Uquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "University");
    $Iquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "Instructor");
?>

<html>
    <body>
        <?php
            echo "<h1> Survey Questions for " . $_SESSION["course"] . "</h2>";

            // Check if there are university questions associated with this course. If there are none, do not display the header for university questions
            if($Uquestion != null) {
                echo "<h2> University Questions: </h2>";
            }

            // Loop through all of the university questions for the course
            for($i = 0; $i < sizeof($Uquestion); $i++) {

                // Number the question and display the question title
                echo $i + 1 . ": " . $Uquestion[$i][2] . "<br>";

                // Retrieve all of the choice IDs and answer choices associated with the current question ID
                $temp = getQuestionTitleAndChoices($Uquestion[$i][0],$_SESSION["username"]);

                // Loop through all of the possible choices to display them for the current question
                foreach($temp as $row) {        
                    echo "<p>" . $row[1] . ": " . $row[2] . "</p>";
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

                // Retrieve all of the choice IDs and answer choices associated with the current question ID
                $temp = getQuestionTitleAndChoices($Dquestion[$i][0],$_SESSION["username"]);
                    
                // Loop through all of the possible choices to display them for the current question
                foreach($temp as $row) {
                    echo "<p>" . $row[1] . ": " . $row[2] . "</p>";
                }
                echo "</table>";
            }

            // Check if there are instructor questions associated with this course. If there are none, do not display the header for instructor questions
            if($Iquestion != null) {
                echo "<h2> Instructor Questions: </h2>";
            }

            // Loop through all of the instructor questions for the course
            for($i = 0; $i < sizeof($Iquestion); $i++) {

                // Number the question and display the question title
                echo $i + 1 . ": " . $Iquestion[$i][2] . "<br>";

                // Retrieve all of the choice IDs and answer choices associated with the current question ID
                $temp = getQuestionTitleAndChoices($Iquestion[$i][0],$_SESSION["username"]);
                    
                // Loop through all of the possible choices to display them for the current question
                foreach($temp as $row){
                    echo "<p>" . $row[1] . ": " . $row[2] . "</p>";
                }
                echo "</table>";
            }
        ?>
    </body>
</html>            