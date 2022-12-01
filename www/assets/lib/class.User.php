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
            "SELECT user_id, email, password FROM users 
            WHERE email = $username AND password = $password;";

        $result = $conn->query($sql); 
        $user = $result->fetch_assoc();

        if (!empty($user)) {
            session_start();
            // $_SESSION["USER_ID"] = $user->user_id;
            // $_SESSION["USERNAME"] = $user->email;
            // $_SESSION["LOGGED_IN"] = true;
            redirect("minside.php");
        }else {
            unset($_SESSION["USER"], $_SESSION["LOGGED_IN"]);
            echo "<strong><span style='color:red'>Feil brukernavn eller passord</span></strong>";
            redirect("register.php");
        }
    }
}
