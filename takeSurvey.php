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
        ?>

        <form method="post" action="takeSurvey.php">
            
        <?php
            // Loop through all of the university questions for the course
            for($i = 0; $i < sizeof($Uquestion); $i++) {

                // Number the question and display the question title
                echo $i + 1 . ": " . $Uquestion[$i][2] . "<br>";

                // Retrieve the response rate for the current question and display the table
                $temp = getQuestionTitleAndChoices($Uquestion[$i][0],$_SESSION["username"]);
                foreach($temp as $row) {
                    echo "<input name = " . $Uquestion[$i][0] . " type='radio' value=" . $row[1] . ">" . $row[1] . ": " . $row[2] . "</input><br>";
                }
            }

            // Check if there are department questions associated with this course. If there are none, do not display the header for department questions
            if($Dquestion ! null) {
                echo "<h2> Department Questions: </h2>";
            }

            // Loop through all of the department questions for the course
            for($i = 0; $i < sizeof($Dquestion); $i++) {

                // Number the question and display the question title
                echo $i + 1 . ": " . $Dquestion[$i][2] . "<br>";

                // Retrieve the response rate for the current question and display the table
                $temp = getQuestionTitleAndChoices($Dquestion[$i][0],$_SESSION["username"]);
                foreach($temp as $row) {       
                    echo "<input name = " . $Dquestion[$i][0] . " type='radio' value=" . $row[1] . ">" . $row[1] . ": " . $row[2] . "</input><br>";
                }
            }

            // Check if there are instructor questions associated with this course. If there are none, do not display the header for intructor questions
            if($Iquestion != null) {
                echo "<h2> Instructor Questions: </h2>";
            }

            // Loop through all of the instructor questions for the course
            for($i = 0; $i < sizeof($Iquestion); $i++) {

                // Number the question and display the question title
                echo $i + 1 . ": " . $Iquestion[$i][2] . "<br>";

                // Retrieve the response rate for the current question and display the table
                $temp = getQuestionTitleAndChoices($Iquestion[$i][0],$_SESSION["username"]);
                foreach($temp as $row){ 
                    echo "<input name = " . $Iquestion[$i][0] . " type='radio' value=" . $row[1] . ">" . $row[1] . ": " . $row[2] . "</input><br>";
                }
            }

            // Generate a new response ID for inserting the new entries for the current sruvey into the surveyResponse table in the database
            $temp = getNewestResponseID();
            $newid = $temp[0][0] + 1;
            
            echo "<input type ='submit' name='submit' value='Submit'>";
            echo "</form>";

            // Once the submit button is clicked
            if(isset($_POST["submit"])) {

                // Loop through all of the keys in on the page. One is for the "Submit" button, but all of the others are QIDs
                foreach(array_keys($_POST)as $x) {

                    // If the array key is a QID, retrive new temporary variables for the section, course name, department, and title for inserting into the surveyResponse table
                    if($x != "submit") {
                        $insertTemp = getInfoForInsertingResponse($x, $_SESSION["course"]);
                        $sectionTemp = $insertTemp[0][0];
                        $courseName = $insertTemp[0][1];
                        $deptName = $insertTemp[0][2];
                        $questionTemp = $insertTemp[0][3];

                        // Insert a new entry inot the surveyResponse table (1 per question on the page)
                        insertIntoSurveyResponseTable($newid, $x, $_SESSION["course"], $courseName, $deptName, $questionTemp, $sectionTemp, $_POST[$x]);
                    }
                }

                // Update the time the current student completed the survey with the current timestamp, then naviagte to the successful completion page
                updateSurveyTime($_SESSION["username"],$_SESSION["course"]);
                header("LOCATION:surveyCompletePage.php");
            }
        ?>
    </body>
</html>
