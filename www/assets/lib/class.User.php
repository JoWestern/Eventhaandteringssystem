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
        
        try{
        $stmt->execute();
        return true;
        }
        catch (Exception $e){
            return false;
            // echo "Det er allerede registrert en bruker med oppgitt telefonnummer eller e-post";
        }

        $stmt->close();
        $conn->close();
    }

    function validateUser($username, $password) {
        $dbConn = new DbConn();
        $conn = $dbConn->connect();
        
        $sql =
            "SELECT user_id, first_name, email, password FROM eventhandling.users 
            WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if(!$user || !password_verify($password, $user["password"])){
            return false;
        } else {
            session_start();
            $_SESSION["USER_ID"] = $user["user_id"];
            $_SESSION["USERNAME"] = $user["email"];
            $_SESSION["FIRSTNAME"]= $user["first_name"];
            $_SESSION["LOGGED_IN"] = true;
            return true;
        }
        $stmt->close();
        $conn->close();
    }

    function getUserInfo($userID){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $sql =
            "SELECT * FROM eventhandling.users 
            WHERE user_id = $userID;";

        $result = $conn->query($sql);
        return $result;
    }

    function editUserInfo($userID, $firstname, $lastname, $email, $phone){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $stmt = $conn->prepare(
            "UPDATE users 
            SET
                first_name = ?,
                last_name = ?,
                email = ?,
                phone = ?
            WHERE user_id = $userID;"
        );

        $stmt->bind_param('ssss', $firstname, $lastname, $email, $phone);
        
        try{
        $stmt->execute();
        }
        catch (Exception $e){
            echo "Noe gikk galt, endringen ble ikke lagret";
        }

        $stmt->close();
        $conn->close();
    }

    function editUserPassword($userID, $newPassword){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $stmt = $conn->prepare(
            "UPDATE users 
            SET
                password = ?
            WHERE user_id = $userID;"
        );

        $stmt->bind_param('s', $newPassword);
        
        try{
        $stmt->execute();
        }
        catch (Exception $e){
            echo "Noe gikk galt, endringen ble ikke lagret";
        }

        $stmt->close();
        $conn->close();
    }
}
