<?php
require __DIR__ . "/class.DbConn.php";

class Event
{
    function getAllEvents()
    {
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $sql = "SELECT event_id, title, info, first_name, last_name, location, time, name, endtime, ticketprice, website
        FROM eventhandling.events
        INNER JOIN eventhandling.users ON users.user_id = events.host
        INNER JOIN eventhandling.categories ON categories.category_id = events.category_id;";

        $result = $conn->query($sql);

        return $result;
    }

    function createEvent($title, $info, $host, $location, $time, $category_id)
    {
        $dbConn = new DbConn();
        $conn = $dbConn->connect();
        // $sql = "INSERT INTO events 
        // (event_id, title, info, host, location, time, category_id) 
        // VALUES 
        // (?,?,?,?,?,?,?)";

        $stmt = $conn->prepare(
            "INSERT INTO eventhandling.events 
            (title, info, host, location, time, category_id) 
            VALUES 
            (?,?,?,?,?,?)"
        );

        $stmt->bind_param('ssssss', $title, $info, $host, $location, $time, $category_id);
        $stmt->execute();

        echo "Data inserted";

        $stmt->close();
        $conn->close();
    }
}
