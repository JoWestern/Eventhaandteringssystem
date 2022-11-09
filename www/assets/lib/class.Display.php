<?php
    
    class Display{
        function displayCards($result){
            if ($result->num_rows > 0) {
                echo "<div class=\"flex-container\">";
                
                //echo each row from table
                while($row = $result->fetch_assoc()) {
                    $datetime = new DateTimeImmutable($row['time']);
                    $img = "assets/img/event" . $row['event_id'] . ".jpg";
                    
                    echo "
                    <div class=\"card\" style=\"width: 18rem;\">
                    <div class=\"card-img\">
                        <img class=\"card-img-top\" src=\"" . $img . "\" alt=\"Arrangementsbilde\">
                    </div>
                    <div class=\"card-body d-flex flex-column\">
                        <h5 class=\"card-title\">" . $row["title"] . "</h5>
                        <p class=\"card-text\">" . $row["info"] . "</p>
                        <p class=\"card-text\">" . $datetime->format('j.') . " " . self::translateMonth($datetime->format('F')) . " " . $datetime->format('Y') . " kl. " . $datetime->format('H:i') . "</p>
                    </div>
                    <div class=\"card-footer\">
                        <a href=\"event.php?event_id=" . $row['event_id'] . "\" class\"btn btn-primary\">Les mer</a>
                    </div>
                    </div>
                    ";

                    // "<tr>
                    // <td>" . $row["event_id"] . "</td>
                    // <td>" . $row["title"] . "</td>
                    // <td>" . $row["info"] . "</td>
                    // <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
                    // <td>" . $row["location"] . "</td>
                    // <td>" . $row["time"] . "</td>
                    // <td>" . $row["endtime"] . "</td>
                    // <td>" . $row["name"] . "</td>
                    // <td>" . $row["ticketprice"] . "</td>
                    // <td>" . $row["website"] . "</td>
                    // </tr>";
                }
                echo "</div>";
                }
                else {
                echo "0 results";
            }
        }

        function translateMonth($month){
            return $translated = match($month){
                "January"=>"januar",
                "February"=>"februar",
                "March"=>"mars",
                "April"=>"april",
                "May"=>"mai",
                "June"=>"juni",
                "July"=>"juli",
                "August"=>"august",
                "September"=>"september",
                "October"=>"oktober",
                "November"=>"november",
                "December"=>"desember"
            };
        }
    }
?>