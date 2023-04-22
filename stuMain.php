<?php
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
            box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.9);
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
        <!-- Welcome message with logout button using the session username -->
        <?php     
            if(!isset($_SESSION["username"])) {
               header("LOCATION:login.php");
            } else {
                echo '<h2> Welcome ' . $_SESSION["username"].'</h2>';
        ?>
        
        <form method="post" action="login.php">
            <p >
                <input type="submit" value="Logout" name="logout">
            </p>
        </form>
        
        <?php
            }
        ?>
        <!-- Created table for courses taking by student id using the username -->
        <?php
            require "db.php";
            $courses = getCoursesTaking($_SESSION["username"]);
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
            foreach($courses as $row){
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
        <br>    
        <!-- Created table for courses not taken by student id using the username -->
        <?php
            $classes = getCoursesNotTaking($_SESSION["username"]);
            if($classes!=null){

            ?>
                <table>
                    <tr>
                        <th>C_ID</th>
                        <th>Title</th>
                        <th>Credit</th>
                        <th>Instructor ID</th>
                        <th>Department Name</th>
                    </tr>
                <?php
            }
        ?>
        
            
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

            if(isset($_POST["registerCourse"])){
                if(($_POST["course"])!=null){
                    for($i=0;$i<sizeof($classes);$i++){
                        if($classes[$i][0]==$_POST["course"]){
                            $_SESSION["course"]=$_POST["course"];
                            registerForCourse($_SESSION["username"],$_POST["course"]);
                            header("LOCATION:registerPage.php");    
                        }
                    }
                    echo '<p style="color:red; "> Please enter a valid class</p>';
                }else{
                    echo '<p style="color:red;"> Please enter a class</p>';
                }
            }
            if(isset($_POST["takeSurvey"])){
                if(($_POST["course"])!=null){
                    for($i=0;$i<sizeof($courses);$i++){
                        if($courses[$i][0]==$_POST["course"]){
                            if($courses[$i][4]=="N/A"){
                                $_SESSION["course"]=$_POST["course"];
                                header("LOCATION:takeSurvey.php"); 
                            }else{
                                echo '<p style="color:red;"> You cannot take another survey </p>';   
                            
                            }
                               
                        }
                    }
                    echo '<p style="color:red; "> Please enter a valid class</p>';
                }else{
                    echo '<p style="color:red;"> Please enter a class</p>';
                }
            }
        ?>
        <br><br>
        Please enter course first then click button
        <form method="post" action="stuMain.php">
            <label for="course">Course ID:</label> 
            <input type="text" id="course" name="course"><br><br>
            <input type="submit" value="Register new course" name="registerCourse">
            <input type="submit" value="Take Survey" name = "takeSurvey">
        </form>
        </div>
    </body>
</html>