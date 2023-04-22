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
       #card{
            padding: 50px;
            height:fit-content;
            background-color:#fbfbfb;
            border-radius: 10px;
            box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.9);
            margin-top:10px;
       }

       label{
        color:black;
        font-family: "Raleway", sans-serif;
       }
       p{
        margin-left:30px;
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
        <div id=card>
        <?php
        echo "<h1> Survey Questions for " . $_SESSION["course"] . "</h2>";
            if($Uquestion!=null){
                echo "<h2> University Questions: </h2>";
            }
            for($i=0;$i<sizeof($Uquestion);$i++){
                echo  $i+1 . ": " . $Uquestion[$i][2] . "<br>";
                $temp = getQuestionTitleAndChoices($Uquestion[$i][0],$_SESSION["username"]);
                    foreach($temp as $row){
                        
                        echo "<p>" . $row[1] . ": " . $row[2] . "</p>";
  
                    }
            }
            if($Dquestion!=null){
                echo "<h2> Department Questions: </h2>";
            }
            for($i=0;$i<sizeof($Dquestion);$i++){
                echo $i+1 . ": " . $Dquestion[$i][2] . "<br>";
                $temp = getQuestionTitleAndChoices($Dquestion[$i][0],$_SESSION["username"]);
                    foreach($temp as $row){
                        
                        echo "<p>" . $row[1] . ": " . $row[2] . "</p>";
  
                    }
            }
            if($Iquestion!=null){
                echo "<h2> Instructor Questions: </h2>";
            }
            for($i=0;$i<sizeof($Iquestion);$i++){
                echo $i+1 . ": " . $Iquestion[$i][2] . "<br>";
                $temp = getQuestionTitleAndChoices($Iquestion[$i][0],$_SESSION["username"]);
                    foreach($temp as $row){
                        
                        echo "<p>" . $row[1] . ": " . $row[2] . "</p>";
  
                    }
            }
            if(isset($_POST["back"])){
                header("LOCATION:instMain.php");
            }
            ?>
            <form method=post action=reviewSurveyQuestions.php>
                <input type="submit" value="Go Back" name = "back">
            </form>
            </div>
        </body>
    </html>