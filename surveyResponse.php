<?php
    session_start();
    require "db.php";
    $Dquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "Department");
    $Uquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "University");
    $Iquestion = getAllQuestionsAndQIDsForCourse($_SESSION["course"], "Instructor");
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

        <br>
            <?php
            if($Uquestion!=null){
                echo "<h2> University Questions: </h2>";
            }
                for($i=0;$i<sizeof($Uquestion);$i++){
                    echo $i+1 . ": " . $Uquestion[$i][2] . "<br>";
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
                if($Dquestion!=null){
                    echo "<h2> Department Questions: </h2>";
                }
                for($i=0;$i<sizeof($Dquestion);$i++){
                    echo $i+1 . ": " . $Dquestion[$i][2] . "<br>";
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
                if($Iquestion!=null){
                    echo "<h2> Instructor Questions: </h2>";
                }
                for($i=0;$i<sizeof($Iquestion);$i++){
                    echo $i+1 . ": " . $Iquestion[$i][2] . "<br>";
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
