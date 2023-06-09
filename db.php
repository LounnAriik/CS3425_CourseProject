<?php
// This file contains all of the database functions for the project
// Comments for the majority of the SQL queries are inside the "surveyResponses.sql" file from Phase 1



// Function to connect to the database, used in all other database functions
// Parameters: none
// Returns: $dbh variable for database connections
function connectDB()
{
    $config = parse_ini_file("db.ini");
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

// Helper function for transactions to set the autocommit setting to 0
// Parameters: none
// Returns: none, only executes a SQL statement
function setAutocommit(){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "set autocommit = 0"
        );
        $result = $statement->execute();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Helper function for transactions to set the isolation level
// Parameters: none
// Returns: none, only executes a SQL statement
function setIsolationLevel(){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "set session transaction isolation level serializable"
        );
        $result = $statement->execute();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Helper function for transactions to begin a transaction
// Parameters: none
// Returns: none, only executes a SQL statement
function beginTransaction(){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "begin"
        );
        $result = $statement->execute();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Helper function for transactions to commit a transaction
// Parameters: none
// Returns: none, only executes a SQL statement
function commitTransaction(){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "commit"
        );
        $result = $statement->execute();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
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
        $row = $statement->fetch();
        $dbh = null;
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
        $row = $statement->fetch();
        $dbh = null;
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
        $row = $statement->fetch();
        $dbh = null;
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
        $row = $statement->fetch();
        $dbh = null;
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
        
        // Wrap update statement in a transaction
        setAutocommit();
        setIsolationLevel();
        beginTransaction();
        $result = $statement->execute();
        commitTransaction();

        $dbh = null;
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

        // Wrap update statement in a transaction
        setAutocommit();
        setIsolationLevel();
        beginTransaction();
        $result = $statement->execute();
        commitTransaction();

        $dbh = null;
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
            "select distinct CID, CName, Credits, InstID, Department
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
            "select CID, Responses, Students, round((Responses/Students) * 100, 2)
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
            "select Answer as Choice, AnswerText, round(ifnull(totals, 0)) as Frequency, round(round(ifnull(totals, 0)) / (select sum(totals) from 
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

// Function to return all individual survey responses for a given course
// Parameters: course ID
// Returns: the result of the query (table with Response ID, Section, QID, Question Text, Choice Selected, Choice Text)
function getAllIndividualSurveyResponses($course) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select ResponseID, project_surveyResponse.Section, QID, Title, Answer, AnswerText  
            from project_surveyResponse join project_choice using (QID)
            where Answer = ChoiceID and CID = :courseID"
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

// Function to return only the question text for a specific question of a specific course
// Parameters: course ID, question ID
// Returns: the result of the query (table with question IDs, section, and question title)
function getAllQuestionsAndQIDsForCourse($course, $section) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select distinct QID, Section, Title, Department, CName
            from project_surveyResponse
            where CID = :courseID and Section = :section"
        );
        $statement->bindParam(":courseID", $course);
        $statement->bindParam(":section", $section);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to return the question title and all question choices for a given question ID
// Parameters: question ID
// Returns: the result of the query (table with question title, choices (A, B, C, etc.), and choice answer text)
function getQuestionTitleAndChoices($question) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select Title, ChoiceID, AnswerText 
            from project_choice join project_question using (QID)
            where QID = :questionID"
        );
        $statement->bindParam(":questionID", $question);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to assign a student to a new course
// Parameters: instructor ID, new password to update instructor table with
// Returns: nothing, this function only executes an update statement
function registerForCourse($user, $course){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "insert into project_enrollsIn values (:studentID, :courseID, 'N/A')"
        );
        $statement->bindParam(":studentID", $user);
        $statement->bindParam(":courseID", $course);

        // Wrap insert statement in a transaction
        setAutocommit();
        setIsolationLevel();
        beginTransaction();
        $result = $statement->execute();
        commitTransaction();

        $dbh=null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to get the newest response ID, important for generating a new response ID for a new survey response
// Parameters: none
// Returns: the result of the query (table with 1 response ID)
function getNewestResponseID(){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select ResponseID 
            from project_surveyResponse
            order by ResponseID desc
            limit 1"
        );
        $result = $statement->execute();
        return $statement->fetchAll();
        $dbh=null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to insert a new entry into the surveyResponse table
// Parameters: all surveyResponse colummns
// Returns: none
function insertIntoSurveyResponseTable($rID, $qID, $cID, $cName, $department, $qTitle, $section, $answer) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "insert into project_surveyResponse values(
                :rID,
                :qID,
                :cID,
                :cName,
                :department,
                :qTitle,
                :section,
                :answer
            )"
        );
        $statement->bindParam(":rID", $rID);
        $statement->bindParam(":qID", $qID);
        $statement->bindParam(":cID", $cID);
        $statement->bindParam(":cName", $cName);
        $statement->bindParam(":department", $department);
        $statement->bindParam(":qTitle", $qTitle);
        $statement->bindParam(":section", $section);
        $statement->bindParam(":answer", $answer);

        // Wrap insert statement in a transaction
        setAutocommit();
        setIsolationLevel();
        beginTransaction();
        $statement->execute();
        commitTransaction();

        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to get additional information for inserting a new entry into the survey response table
// Parameters: question ID and course ID
// Returns: the result of the query (table with section, course name, department, and question title)
function getInfoForInsertingResponse($qID, $cID){
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "select distinct Section, CName, Department, Title
            from project_surveyResponse
            where QID = :qID and CID = :cID"
        );
        $statement->bindParam(":qID", $qID);
        $statement->bindParam(":cID", $cID);
        $result = $statement->execute();
        return $statement->fetchAll();
        $dbh=null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

// Function to update the response time attribute of the enrolls in table when a student submits a survey
// Parameters: student ID, course ID
// Returns: none
function updateSurveyTime($sID, $cID) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare(
            "update project_enrollsIn set Time = Now()
            where StuID = :sID and CID = :cID"
        );
        $statement->bindParam(":sID", $sID);
        $statement->bindParam(":cID", $cID);

        // Wrap update statement in a transaction
        setAutocommit();
        setIsolationLevel();
        beginTransaction();
        $statement->execute();
        commitTransaction();

        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

?>