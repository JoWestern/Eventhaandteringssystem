<?php
    class Display{
        function displayCards($result){
            if ($result->num_rows > 0) {
                echo "<div class=\"flex-container\">";
                
                //echo each row from table
                while($row = $result->fetch_assoc()) {
                    echo "
                    <div class=\"card\" style=\"width: 18rem;\">
                    <div class=\"card-img\">
                        <img class=\"card-img-top\" src=\"...\" alt=\"Card image cap\">
                    </div>
                    <div class=\"card-body d-flex flex-column\">
                        <h5 class=\"card-title\">" . $row["title"] . "</h5>
                        <p class=\"card-text\">" . $row["info"] . "</p>
                    </div>
                    <div class=\"card-footer\">
                        <a href=\"\" class\"btn btn-primary\">Les mer</a>
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
    }
?>