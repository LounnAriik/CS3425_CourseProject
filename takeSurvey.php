<?php
    session_start();
    require "db.php";
    $Dquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "Department");
    $Uquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "University");
    $Iquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "Instructor");
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
            height:fit-content;
            background-color:#fbfbfb;
            border-radius: 10px;
            box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.9);
            margin-top:10px;
       }
       input{
        margin:5px;
       }
       label{
        color:black;
        font-family: "Raleway", sans-serif;
       }

       input[type="submit"]{
        color:#fbfbfb;
        margin-top:10px;
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
        
            <form method="post" action="takeSurvey.php">
        <?php
                echo "<h1> Survey Questions for " . $_SESSION["course"] . "</h2>";
                    if($Uquestion!=null){
                        echo "<h2> University Questions: </h2>";
                    }
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
                updateSurveyTime($_SESSION["username"],$_SESSION["course"]);
                header("LOCATION:surveyCompletePage.php");
            }
            ?>
    </body>
</html>
