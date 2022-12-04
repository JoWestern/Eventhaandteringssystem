<?php
    
    class Display{
        function displayCards($result){
            if ($result->num_rows > 0) {
                echo "<div class=\"flex-container\">";
                
                //echo each row from table
                while($row = $result->fetch_assoc()) {
                    $datetime = new DateTimeImmutable($row['time']);

                    if(file_exists($row['img_path'])) $img = $img = $row['img_path'];
                    else $img = "assets/img/stock.png";

                    if(strlen($row['info']) > 200){
                        $info = substr($row["info"],0,200) . "...";
                    }
                    else $info = $row['info'];
                    
                    echo "
                    <div class=\"card\" style=\"width: 18rem;\">
                    <div class=\"card-img\">
                        <img class=\"card-img-top\" src=\"" . $img . "\" alt=\"Arrangementsbilde\">
                    </div>
                    <div class=\"card-body d-flex flex-column\">
                        <h5 class=\"card-title\">" . $row["title"] . "</h5>
                        <p class=\"card-text\">$info</p>
                    </div>
                    <div class=\"card-footer\">
                        <p class=\"card-text\"><strong>" . $row["location"] . "</strong></p>
                        <p class=\"card-text\"><strong>" . self::formatDatetime($datetime) . "</strong></p>
                        <a href=\"event.php?event_id=" . $row['event_id'] . "\" class\"btn btn-primary\">Les mer</a>
                    </div>
                    </div>
                    ";
                }
                echo "</div>";
                }
                else {
                echo "<div class='no-results'><text>Ingen treff</text></div>";
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

        function formatDatetime($datetime){
            $formattedDatetime = $datetime->format('j.') . " " . self::translateMonth($datetime->format('F')) . " " . $datetime->format('Y') . " kl. " . $datetime->format('H:i');
            return $formattedDatetime;
        }
    }
?>