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
            if($Uquestion!=null){
                echo "<h2> University Questions: </h2>";
            }
            ?>
            <form method="post" action="takeSurvey.php">
            <?php
            for($i=0;$i<sizeof($Uquestion);$i++){
                echo $i+1 . ": " . $Uquestion[$i][2] . "<br>";
                $temp = getQuestionTitleAndChoices($Uquestion[$i][0],$_SESSION["username"]);
                    foreach($temp as $row){
                        
                        echo "<input name = " . $Uquestion[$i][0] . " type='radio' value=" . $row[1] . ">" . $row[1] . ": " . $row[2] . "</input><br>";
  
                    }
            }
            if($Dquestion!=null){
                echo "<h2> Department Questions: </h2>";
            }

            for($i=0;$i<sizeof($Dquestion);$i++){
                echo $i+1 . ": " . $Dquestion[$i][2] . "<br>";
                $temp = getQuestionTitleAndChoices($Dquestion[$i][0],$_SESSION["username"]);
                    foreach($temp as $row){
                        
                        echo "<input name = " . $Dquestion[$i][0] . " type='radio' value=" . $row[1] . ">" . $row[1] . ": " . $row[2] . "</input><br>";
  
                    }
            }

            if($Iquestion!=null){
                echo "<h2> Instructor Questions: </h2>";
            }

            for($i=0;$i<sizeof($Iquestion);$i++){
                echo $i+1 . ": " . $Iquestion[$i][2] . "<br>";
                $temp = getQuestionTitleAndChoices($Iquestion[$i][0],$_SESSION["username"]);
                    foreach($temp as $row){
                        
                        echo "<input name = " . $Iquestion[$i][0] . " type='radio' value=" . $row[1] . ">" . $row[1] . ": " . $row[2] . "</input><br>";
  
                    }
            }

            
            $temp = getNewestResponseID();
            $newid = $temp[0][0]+1;
            
            echo "<input type ='submit' name='submit' value='Submit'>";
            echo "</form>";
            if(isset($_POST["submit"])){
                foreach(array_keys($_POST)as $x){
                    if($x!="submit"){
                        $insertTemp = getInfoForInsertingResponse($x, $_SESSION["course"]);
                        $sectionTemp = $insertTemp[0][0];
                        $courseName = $insertTemp[0][1];
                        $deptName = $insertTemp[0][2];
                        $questionTemp = $insertTemp[0][3];

                        insertIntoSurveyResponseTable($newid,$x,$_SESSION["course"],$courseName, $deptName,$questionTemp,$sectionTemp, $_POST[$x]);
                    }
                }
                header("LOCATION:surveyCompletePage.php");
            }
            ?>
    </body>
</html>
