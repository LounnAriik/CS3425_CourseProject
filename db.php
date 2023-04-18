<?php

// Function to connect to the database, used in all other database functions
// Parameters: nothing
// Returns: $dbh variable for database connections
function connectDB()
{
    $config = parse_ini_file("db.ini");
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

// Function to authenticate a student user
// Parameters: student ID and student password
// Returns: the number of rows that match the query(0 --> invalid, 1 --> valid, 2+ --> other error)
function authenticateStudent($user, $password) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select count(*) 
            from project_student 
            where StuID = :username and StuPassword = sha2(:password,256) "
        );
        $statement->bindParam(":username", $user);
        $statement->bindParam(":password", $password);
        $result = $statement->execute();
        $row=$statement->fetch();
        $dbh=null;
        return $row[0];
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to authenticate an instructor user
// Parameters: instructor ID and instructor password
// Returns: the number of rows that match the query(0 --> invalid, 1 --> valid, 2+ --> other error)
function authenticateInstructor($user, $password) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select count(*) 
            from project_instructor 
            where InstID = :username and InstPassword = sha2(:password,256) "
        );
        $statement->bindParam(":username", $user);
        $statement->bindParam(":password", $password);
        $result = $statement->execute();
        $row=$statement->fetch();
        $dbh=null;
        return $row[0];
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to determine if it is a student user's first login
// Parameters: student ID
// Returns: the number of rows that match the query(0 --> not first login, 1 --> first login, 2+ --> other error)
function firstLoginStudent($user){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select count(*)   
            from project_student
            where StuID = :username and FirstLogin = true "
        );
        $statement->bindParam(":username", $user);
        $result = $statement->execute();
        $row=$statement->fetch();
        $dbh=null;
        return $row[0];
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to determine if it is an instructor user's first login
// Parameters: instructor ID
// Returns: the number of rows that match the query(0 --> not first login, 1 --> first login, 2+ --> other error)
function firstLoginInstructor($user){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select count(*) 
            from project_instructor 
            where InstID = :username and FirstLogin = true"
        );
        $statement->bindParam(":username", $user);
        $result = $statement->execute();
        $row=$statement->fetch();
        $dbh=null;
        return $row[0];
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to update a student user's password and set FirstLogin attribute to false
// Parameters: student ID, new password to update student table with
// Returns: nothing, this function only executes an update statement
function stuPassReset($user, $password){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "update project_student 
            set StuPassword = sha2(:newPassword, 256), FirstLogin=false 
            where StuID = :user"
        );
        $statement->bindParam(":newPassword", $password);
        $statement->bindParam(":user", $user);
        $result = $statement->execute();
        $dbh=null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to update an instructor user's password and set FirstLogin attribute to false
// Parameters: instructor ID, new password to update instructor table with
// Returns: nothing, this function only executes an update statement
function instPassReset($user, $password){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "update project_instructor 
            set InstPassword = sha2(:newPassword, 256), FirstLogin=false 
            where InstID = :user"
        );
        $statement->bindParam(":newPassword", $password);
        $statement->bindParam(":user", $user);
        $result = $statement->execute();
        $dbh=null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to return all of the courses that an instructor user is currently teaching to display on InstMain.php
// Parameters: instructor ID
// Returns: the result of the query (table with CID, CName, and Credits)
function getCoursesTeaching($user) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select CID, CName, Credits 
            from project_teaches join project_course using (CID) 
            where InstID = :username"
        );
        $statement->bindParam(":username", $user);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to return all of the courses than a student user is currently enrolled in to display on StuMain.php
// Parameters: student ID
// Returns: the result of the query (table with CID, CName, Credits, InstName, and Time)
function getCoursesTaking($user) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select CID, CName, Credits, InstName, Time
            from 
                (project_enrollsIn join project_course using (CID)) join 
                (project_instructor join project_teaches using (InstID)) using (CID)
            where StuID = :studentID"
        );
        $statement->bindParam(":studentID", $user);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to return all of the courses than a student user is currently not enrolled in to display on StuMain.php
// Parameters: student ID
// Returns: the result of the query (table with CID, CName, Credits, InstName, and Time)
function getCoursesNotTaking($user) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select distinct CID, CName, Credits, InstName, Time
            from 
                (project_enrollsIn join project_course using (CID)) join 
                (project_instructor join project_teaches using (InstID)) using (CID)
                
            where CID not in
                (select CID
                from 
                    (project_enrollsIn join project_course using (CID)) join 
                    (project_instructor join project_teaches using (InstID)) using (CID)
                where StuID = :studentID)"
        );
        $statement->bindParam(":studentID", $user);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to return the full response rate for a specific course to display when "Check Survey Result" is clicked by an instructor
// Parameters: course ID
// Returns: the result of the query (table with CID, Number of Responses, Number of Students, and Response Rate)
function getSurveyResponseRate($course) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select CID, Responses, Students, round((Responses/Students) * 100, 2) as ""Response Rate""
            from (
            
                (select CID, count(*) as Students 
                from project_enrollsIn
                where CID = :courseID
                group by CID) as t1
            
                join 
            
                (select CID, count(distinct(ResponseID)) as Responses
                from project_choice natural join project_surveyResponse natural join project_instructor
                where CID = :courseID) as t2
                
                using (CID)
            )"
        );
        $statement->bindParam(":courseID", $course);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to return the response rate for each answer selected of a specific question for a given course
// Parameters: course ID, question ID, and instructor ID
// Returns: the result of the query (table with Choice(A, B, C, etc.), Choice Text, Frequency, and Percent)
function getQuestionChoiceResponseRate($course, $question, $instructor) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select Answer as Choice, AnswerText as ""Response Option"", round(ifnull(totals, 0)) as Frequency, round(round(ifnull(totals, 0)) / (select sum(totals) from 
            (select Answer, count(*) / count(distinct(ChoiceID)) as totals
            from project_choice natural join project_surveyResponse natural join project_instructor 
            where CID = :courseID and InstID = :instructorID and QID = :questionID 
            group by Answer) as t3), 2) * 100 as Percent
        
            from (
                (select AnswerText, ChoiceID as Answer
                from project_choice
                where QID = :questionID) as t1
            
                left outer join
            
                (select Answer, count(*) / count(distinct(ChoiceID)) as totals
                from project_choice natural join project_surveyResponse natural join project_instructor 
                where CID = :courseID and InstID = :instructorID and QID = :questionID 
                group by Answer) as t2
            
                using (Answer)
            )"
        );
        $statement->bindParam(":courseID", $course);
        $statement->bindParam(":questionID", $question);
        $statement->bindParam(":instructorID", $instructor);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// 
function getAllResponses($course, $question, $instructor) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            ""
        );
        $statement->bindParam(":courseID", $course);
        $statement->bindParam(":questionID", $question);
        $statement->bindParam(":instructorID", $instructor);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

?>