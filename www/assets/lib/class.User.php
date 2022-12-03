<?php
require __DIR__."/class.DbConn.php";

class User{

function createUser($firstname, $lastname, $email, $phone, $password)
    {
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $stmt = $conn->prepare(
            "INSERT INTO eventhandling.users 
            (first_name, last_name, email, phone, password) 
            VALUES 
            (?,?,?,?,?)"
        );

        $stmt->bind_param('sssis', $firstname, $lastname, $email, $phone, $password);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }

    function validateUser($username, $password) {
        $dbConn = new DbConn();
        $conn = $dbConn->connect();
        
        $sql =
            "SELECT user_id, email, password FROM eventhandling.users 
            WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if(!$user || !password_verify($password, $user["password"])){
            echo "<br>Brukernavn eller passord er feil";
            die();
        } else {
            session_start();
            $_SESSION["USER_ID"] = $user["user_id"];
            $_SESSION["USERNAME"] = $user["email"];
            $_SESSION["LOGGED_IN"] = true;
            header("Location: mineArrangementer.php");
            exit();
        }

        $conn->close();
    }
}
