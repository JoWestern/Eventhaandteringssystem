<?php
require dirname(__DIR__) . "/www/assets/inc/header.php";
require dirname(__DIR__) . "/www/assets/lib/class.Event.php";
require dirname(__DIR__) . "/www/assets/lib/class.Category.php";
require __DIR__."/assets/inc/authenticate.php";
?>
<!doctype html>
<html>
    <body class="main text-left">
        <div class="container login mt-5" style="width: fit-content">
        <div class="">
        <?php 
            // $img = "assets/img/stock.png";
            // function showPic($filename){
                if (isset($_POST["show"])){
                $src = checkFile();
                // echo "<div>
                // <img id='showPic' src=\"" . $img . "\" alt=\"Arrangementsbilde\" width='600rem'>
                // </div>";
                echo "<img id='showPic' src=\"" . $src . "\" alt=\"Arrangementsbilde\" width='600rem'>";
            } 
        ?>
        </div>
            <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> autocomplete="off" enctype="multipart/form-data">
                <h1 class="h3 mb-3 fw-normal">Opprett arrangement</h1>
                <label for="title">Tittel:</label>
                <div class="form-floating">
                    <input type="text" id="title" name="title" autocomplete="off">
                </div>
                <label for="bio">Beskrivelse:</label>
                <div class="form-floating">
                    <input type="text" id="bio" name="bio" autocomplete="off">
                </div>
                <label for="local">Lokasjon:</label>
                <div class="form-floating">
                    <input type="text" id="local" name="local" autocomplete="off">
                </div>
                <label for="startdate">Startdato:</label>
                <div class="form-floating">
                    <input type="datetime-local" id="startdate" name="startdate" autocomplete="off">
                </div>
                <label for="enddate">Sluttdato:</label>
                <div class="form-floating">
                    <input type="datetime-local" id="enddate" name="enddate" autocomplete="off">
                </div>
                <label for="ticketprice">Pris:</label>
                    <div class="form-floating">
                        <input type="number" id="ticketprice" name="ticketprice" autocomplete="off">
                    </div>
                <label class="mt-1" for="cat">Kategori:</label>
                <div class="form-floating">
                    <select name="category">
                        <?php
                            $category = new Category();
                            $categoryOptions = $category->selectCategory();
                            while ($row = mysqli_fetch_array($categoryOptions)) {
                                echo "<option value='" . $row['category_id'] . "'>" . $row['name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <label for="website">Link til nettside:</label>
                <div class="form-floating">
                    <input type="text" id="website" name="website" autocomplete="off">
                </div>
                <div class="form-floating">
                    <label for="imgFile">Velg fil:</label>
                    <div class="form-floating">
                        <input name="imgFile" type="file">
                    </div>
                    <input name="show" type="submit" value="Vis bilde">
                </div>
                <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="submit" value="Opprett" autocomplete="off"></input>
            </form>
        </div>
    </body>
</html>
<?php
// if (isset($_POST["show"])){
//     $img = "assets/img/stock.png";
//     echo "<img class='' src=\"" . $img . "\" alt=\"Arrangementsbilde\" width='600rem'>";
// }

if (isset($_POST["submit"])) {
    // legge inn check for hvert felt
    $title = $_POST['title'];
    $info = $_POST['bio'];
    $location = $_POST['local'];
    $host = $_SESSION['USER_ID'];
    $starttime = $_POST['startdate'];
    $endtime = $_POST['enddate'];
    $cat = $_POST['category'];
    $ticketprice = $_POST['ticketprice'];
    $website = $_POST['website'];

    // checkFile();

    $events = new Event();
    $CreateEvent = $events->createEvent($title, $info, $host, $location, $starttime, $cat, $endtime, $ticketprice, $website);
    echo "<p class='mb-3 fw-normal'>Arrangementet er lagret!</p>";
}

//runs when form has been submitted
function checkFile() {
    // if (isset($_POST["show"])){

    // Define array for messages 
    $messages = array();
    
    // File upload 
    if (is_uploaded_file($_FILES['imgFile']['tmp_name'])) 
    {
        // Collecting information about file 
        $file_type = $_FILES['imgFile']['type'];
        $file_size = $_FILES['imgFile']['size'];
        
        // Configurations
        $acc_file_types = array("jpg" => "image/jpeg",
                                "png" => "image/png"
        );
        $max_file_size = 2097152; // in bytes
        // $dir = $_SERVER['DOCUMENT_ROOT'] . "/Eventhaandteringssystem/www/assets/img/";
        $dir = "/Applications/XAMPP/xamppfiles/htdocs/Eventhaandteringssystem/www/assets/img/";
        // No directory with that name?
        if(!file_exists($dir)) 
        {
            if (!mkdir($dir, 0777, true)) 
                die("Cannot create directory..." . $dir);
        }
        
        // Constructing file name
        $suffix = array_search($_FILES['imgFile']['type'], $acc_file_types);

        //$filename  = "gunnar" . '.' . $suffix;

        /* If the file already exists for some reason */
        do {
            $filename  = substr(md5(date('YmdHis')), 0, 5) . '.' . $suffix;
        }
        while(file_exists($dir . $filename));
        
        // Errors?
        if (!in_array($file_type, $acc_file_types)) 
        {
            $types = implode(", ", array_keys($acc_file_types));
            $messages['error'][] = "Ugyldig filformat (Kun <em>" . $types . "</em> er tillatt)";
        }
        if ($file_size > $max_file_size)
            $messages['error'][] = "Filstørrelsen (" . round($file_size / 1048576, 2) . " MB) er større enn tillatt (" . round($max_file_size / 1048576, 2) . " MB)"; // Bin. conversion
        
        // If success
        if (empty($messages)) 
        {
            /*if user has picture but of different type, 
            the old gets deleted instead of there being two*/
            foreach($acc_file_types as $value){
                $file = "gunnar" . '.' . array_search($value, $acc_file_types);
                if (file_exists($dir . $file)) {
                    unlink($dir . $file);
                }
            }

            // Moving uploaded file
            $filepath = $dir . $filename;
            $uploaded_file = move_uploaded_file($_FILES['imgFile']['tmp_name'], $filepath);
           
            if ($uploaded_file){
                $img = "assets/img/".$filename;
                // showPic($img);
                //echo "<img class='' src=\"" . $img . "\" alt=\"Arrangementsbilde\" width='600rem'>";
                $messages['success'][] = "Filen ble lastet opp!";
            } else {
                $messages['error'][] = "Not uploaded because of error #".$_FILES["imgFile"]["error"];
            }
            $img = "assets/img/" . $filename;
            return $img;
            // if (!$uploaded_file) 
            //     $messages['error'][] = "Filen kunne ikke lastes opp";
            // else
            //     $messages['success'][] = "Filen ble lastet opp!";
        }

    } else {
        $messages['error'][] = "Ingen fil er lastet opp";
        $img = "assets/img/stock.png";
        return $img;
    }
    // Output messages to user
    // if(isset($messages) && !empty($messages))
    // {
    //     echo "<strong>Message" . (sizeof($messages, COUNT_RECURSIVE)-1 > 1 ? "s:<br>" : ":<br>") . "</strong>";
    //     foreach($messages as $msg_type => $type_messages)
    //     {
    //         if($msg_type == 'error')
    //             foreach($type_messages as $message) { echo '<span style="color:red";>- ' . $message . '</span><br>'; }
    //         elseif($msg_type == 'success')
    //             foreach($type_messages as $message) { echo '<span style="color:green";>- ' . $message . '</span><br>'; }
    //     }
    // }
    // else
    // {
    //     echo "<strong>Vennligst velg fil for opplasting</strong>";
    // }
}
?>
