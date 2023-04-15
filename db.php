<?php
function connectDB()
{
    $config = parse_ini_file("db.ini");
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

//return number of rows matching the given user and passwd for student login.
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
    }catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

//return number of rows matching the given user and passwd for instructor login.
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
    }catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

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
    }catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

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
    }catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function stuPassReset($user, $password){
    try{
        $dbh = connectDB();
        $statement = $dbh->prepare("update project_student set StuPassword = :newPassword, FirstLogin=false where StuID = :user");
        $statement->bindParam(":newPassword", $password);
        $statement->bindParam(":user", $user);
        $result = $statement->execute();
        $dbh=null;
    }catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function instPassReset($user, $password){
    try{
        $dbh = connectDB();
        $statement = $dbh->prepare("update project_inst set InstPassword = :newPassword, FirstLogin=false where InstID = :user");
        $statement->bindParam(":newPassword", $password);
        $statement->bindParam(":user", $user);
        $result = $statement->execute();
        $dbh=null;
    }catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}


?>