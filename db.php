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
        $statement = $dbh->prepare("SELECT count(*) FROM project_student ".
        "where StuID = :username and StuPassword = sha2(:password,256) ");
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
        $statement = $dbh->prepare("SELECT count(*) FROM project_instructor ".
        "where InstID = :username and InstPassword = sha2(:password,256) ");
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
        $statement = $dbh->prepare("SELECT count(*) FROM project_student ".
        "where StuID = :username and FirstLogin = true ");
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
        $statement = $dbh->prepare("SELECT count(*) FROM project_instructor ".
        "where InstID = :username and FirstLogin = true ");
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
        $statement = $dbh->prepare("update project_student set StuPassword = sha2(:newPassword, 256), FirstLogin=false where StuID = :user");
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
        $statement = $dbh->prepare("update project_instructor set InstPassword = sha2(:newPassword, 256), FirstLogin=false where InstID = :user");
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
        $statement = $dbh->prepare("SELECT CID, CName, Credits name FROM project_teaches join project_course using (CID) 
        where InstID = :username ");
        $statement->bindParam(":username", $user);
        $statement->execute();
        return $statement->fetchAll();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}


?>