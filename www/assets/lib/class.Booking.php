<?php
require __DIR__."/class.DbConn.php";

class Booking{
    function getBookings($number, $userID){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        if($number == null){
            $limit = ";";
        }
        else{
            $limit = " LIMIT $number;";
        }

        $sql = "SELECT bookings.event_id as event_id, title, info, time 
        FROM eventhandling.bookings
        INNER JOIN events ON bookings.event_id = events.event_id
        INNER JOIN users ON events.host = users.user_id
        INNER JOIN categories ON events.category_id = categories.category_id
        WHERE bookings.user_id = $userID  
        ORDER BY time ASC" . $limit;

        $result = $conn->query($sql);

        return $result;
    }
}