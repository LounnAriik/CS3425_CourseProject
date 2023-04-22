<?php 
    require "db.php";
    session_start();
?>
<html>
<style>
        table,th,td{
            border:1px solid black;
            border-collapse:collapse;
            margin:auto;
        }
        body{
            height:98%;
            display: flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            background-image: linear-gradient(#21192C, #453750);
        }
        #card{
            background-color:#fbfbfb;
            border-radius:10px;
            padding:50px;
            text-align:center;
            bbox-shadow: 1px 2px 8px rgba(0, 0, 0, 0.9);
        }
        input[type="submit"]{
        color:#fbfbfb;
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
       h2{
        font-family: "Raleway Thin", sans-serif;
        letter-spacing:2px;
        text-align:center;
        color:black;
       }
    </style>
    <body>
    <div id="card">
        <?php
            // If a user is logged in, display a welcome message. Otherwise, immediately navigate to the login page to prevent unauthorized access
            if(!isset($_SESSION["username"])) {
                header("LOCATION:login.php");
            } else {
                echo '<h2> Welcome ' . $_SESSION["username"].'</h2>';
        ?>
        
        <form method="post" action="login.php">
            <p>
                <input type="submit" value="Logout" name="logout">
            </p>
        </form>
        
        <?php
            }
        ?>

        <?php
            // Display all of the courses the instructor is assigned to using the associated db.php function and display the results 
            $classes = getCoursesTeaching($_SESSION["username"]);
        ?>
            <table>
                <tr>
                    <th>C_ID</th>
                    <th>Title</th>
                    <th>Credit</th>
                </tr>
        <?php
            foreach($classes as $row) {
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>

        <?php
            // Once the "Check Survey Results" button is clicked
            if(isset($_POST["checkResult"])){

                // Verify that the user entered in a course before attempting to check results
                if(($_POST["course"]) != null) {

                    // Loop through all of the classes the instructor is assigned to verify the course entered is valid
                    for($i = 0; $i < sizeof($classes); $i++) {

                        // Only navigate to the survey responses page if the course entered matches a course the instructor is assigned to
                        if($classes[0][$i] == $_POST["course"]) {
                            $_SESSION["course"] = $_POST["course"];
                            header("LOCATION:surveyResponse.php");    
                        }
                    }
                    echo '<p style="color:red; "> Please enter a valid class</p>';
                } else {
                    echo '<p style="color:red;"> Please enter a class</p>';
                }
            }

            // Once the "Review Survey Questions" button is clicked
            if(isset($_POST["surveyQuestions"])) {

                // Verify that the user entered in a course before attempting to review the questions
                if(($_POST["course"]) != null) {

                    // Loop through all of the classes the instructor is assigned to verify the course entered is valid
                    for($i = 0; $i < sizeof($classes); $i++) {

                        // Only navigate to the review questions page if the course entered matches a course the instructor is assigned to
                        if($classes[0][$i] == $_POST["course"]) {
                            $_SESSION["course"]=$_POST["course"];
                            header("LOCATION:reviewSurveyQuestions.php");    
                        }
                    }
                    echo '<p style="color:red; "> Please enter a valid class</p>';
                } else {
                    echo '<p style="color:red;"> Please enter a class</p>';
                }
            }
        ?>
        <br><br>
        Please enter course first, then click button
        <form method="post" action="instMain.php">
            <label for="course">Course:</label> 
            <input type="text" id="course" name="course"><br><br>
            <input type="submit" value="Review Survey Questions" name="surveyQuestions">
            <input type="submit" value="Check Survey Result" name = "checkResult">
            <!--<input type="submit" value="Create Instructor Questions" name="createInstQuestions"> -->
        </form>
        </div>
    </body>
</html>