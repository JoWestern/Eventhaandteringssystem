<?php
require_once __DIR__."/class.DbConn.php";

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
        $conn->close();
    }
    
    function checkBooking($userID, $eventID){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();
        
        $sql = "SELECT * FROM eventhandling.bookings
        WHERE user_id = $userID and event_id = $eventID;";

        $result = $conn->query($sql);

        if (mysqli_num_rows($result)==0) return false;
        else return true;

        $conn->close();
    }

    function addBooking($userID, $eventID){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $stmt = $conn->prepare(
            "INSERT INTO eventhandling.bookings 
            (user_id, event_id) 
            VALUES 
            (?,?)"
        );

        $stmt->bind_param('ii', $userID, $eventID);
        
        try{
        $stmt->execute();
        }
        catch(Exception $e){
            "Det har oppstått en feil. Sjekk på Min Side om du har blitt påmeldt arrangementet ditt, 
            hvis ikke kan du kontakte oss via epost.<br><br>
            
            $e";


        }

        $stmt->close();
        $conn->close();
    }

    function cancelBooking($userID, $eventID){
        $dbConn = new DbConn();
        $conn = $dbConn->connect();
        
        $sql = "DELETE FROM eventhandling.bookings
        WHERE user_id = $userID AND event_id = $eventID;";

        $result = $conn->query($sql);

        $conn->close();
    }
}
?>