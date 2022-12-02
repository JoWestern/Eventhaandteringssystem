<?php 
class DbConn{

function connect(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "eventhandling";

    //connect
    $conn = new mysqli($servername, $username, $password, $database);

    //check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br><br>");
    }
    return $conn;    
}
}
?>