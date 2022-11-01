<?php 
class DbConn{

function connect(){
    $servername = "localhost";
    $username = "root";
    $password = "";

    //connect
    $conn = new mysqli($servername, $username, $password);

    //check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br><br>");
    }
    return $conn;    
}
}
?>