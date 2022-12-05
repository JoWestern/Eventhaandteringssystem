<?php
require_once __DIR__."/class.DbConn.php";

class Event{
    function getEvents($number, $comingEvents){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        if($number == null){
            $limit = ";";
        }
        else{
            $limit = " LIMIT $number;";
        }

        if($comingEvents){
            $time = " AND time >= CURRENT_DATE ";
        }
        else $time = " AND time < CURRENT_DATE ";

        $sql = "SELECT event_id, title, info, location, time, img_path 
        FROM eventhandling.events
        INNER JOIN eventhandling.users ON users.user_id = events.host"
        . $time .
        "ORDER BY time ASC" . 
        $limit;

        $result = $conn->query($sql);

        return $result;
        $conn->close();
    }

    function singleEvent($event_id){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $sql = "SELECT event_id, title, info, host, first_name, last_name, location, time, name, events.category_id, endtime, ticketprice, website, img_path
        FROM events
        INNER JOIN eventhandling.users ON users.user_id = events.host
        INNER JOIN eventhandling.categories ON categories.category_id = events.category_id 
        WHERE event_id = $event_id;";

        $result = $conn->query($sql);

        return $result;
        $conn->close();
    }

    function createEvent($title, $info, $host, $location, $time, $category_id, $endtime, $ticketprice, $website, $img_url)
    {
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $stmt = $conn->prepare(
            "INSERT INTO eventhandling.events 
            (title, info, host, location, time, category_id, endtime, ticketprice, website, img_path) 
            VALUES 
            (?,?,?,?,?,?,?,?,?,?)"
        );

        $stmt->bind_param('ssssssssss', $title, $info, $host, $location, $time, $category_id, $endtime, $ticketprice, $website, $img_url);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }

    function eventsByHost($host, $number, $comingEvents){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        if($number == null){
            $limit = ";";
        }
        else{
            $limit = " LIMIT $number;";
        }

        if($comingEvents){
            $time = " AND time >= CURRENT_DATE ";
        }
        else $time = " AND time < CURRENT_DATE ";

        $sql = "SELECT event_id, title, info, location, time, img_path 
        FROM eventhandling.events
        INNER JOIN eventhandling.users ON users.user_id = events.host
        WHERE host = $host" . $time . 
        "ORDER BY time ASC" . 
        $limit;

        $result = $conn->query($sql);

        return $result;
        $conn->close();
    }

    function editEvent($eventID, $title, $info, $location, $time, $categoryID, $endtime, $ticketprice, $website, $img_url){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $stmt = $conn->prepare(
            "UPDATE events 
            SET
                title = ?,
                info = ?,
                location = ?,
                time = ?,
                category_id = ?,
                endtime = ?,
                ticketprice = ?,
                website = ?,
                img_path = ? 
            WHERE event_id = $eventID;"
        );

        $stmt->bind_param('ssssissss', $title, $info, $location, $time, $categoryID, $endtime, $ticketprice, $website, $img_url);
        
        try{
            $stmt->execute();
        }
        catch (Exception $e){
            echo "Noe gikk galt, endringen ble ikke lagret";
        }

        $stmt->close();
        $conn->close();
    }
    
    function deleteEvent(){

    }
}
?>