<?php
    class Display{
        function displayCards($result){
            if ($result->num_rows > 0) {
                //table headers
                echo "<table>
                            <tr>
                                <th>ID</th>
                                <th>Tittel</th>
                                <th>Informasjon</th>
                                <th>Vert</th>
                                <th>Sted</th>
                                <th>Start</th>
                                <th>Slutt</th>
                                <th>Kategori</th>
                                <th>Pris</th>
                                <th>Nettside</th>
                            </tr>";
                
                //echo each row from table
                while($row = $result->fetch_assoc()) {
                    echo
                    "<tr>
                    <td>" . $row["event_id"] . "</td>
                    <td>" . $row["title"] . "</td>
                    <td>" . $row["info"] . "</td>
                    <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
                    <td>" . $row["location"] . "</td>
                    <td>" . $row["time"] . "</td>
                    <td>" . $row["endtime"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["ticketprice"] . "</td>
                    <td>" . $row["website"] . "</td>
                    </tr>";
                }
                echo "</table>";
                }
                else {
                echo "0 results";
            }
        }
    }
?>