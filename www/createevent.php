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
        <div class="img-fluid">
        <?php 
            // $img = "assets/img/stock.png";
            // function showPic($filename){
            if (isset($_POST["show"])){
                $src = checkFile();
                displayImage($src);
            } else {
                $src = "assets/img/stock.png";
                displayImage($src);
            }
        ?>
        </div>
            <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> autocomplete="off" enctype="multipart/form-data">
                <h1 class="h3 mb-3 fw-normal">Opprett arrangement</h1>
                    <label for="title">Tittel:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="text" id="title" name="title" autocomplete="off">
                    </div>
                    <label for="bio">Beskrivelse:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="text" id="bio" name="bio" autocomplete="off">
                    </div>
                    <label for="local">Lokasjon:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="text" id="local" name="local" autocomplete="off">
                    </div>
                    <label for="startdate">Startdato:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="datetime-local" id="startdate" name="startdate" autocomplete="off">
                    </div>
                    <label for="enddate">Sluttdato:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="datetime-local" id="enddate" name="enddate" autocomplete="off">
                    </div>
                    <label for="ticketprice">Pris:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">kr</span>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" type="number" id="ticketprice" name="ticketprice" autocomplete="off">
                        </div>
                    </div>
                    <label class="mt-1" for="cat">Kategori:</label>
                    <div class="form-floating">
                        <select class="form-control form-control-sm" name="category">
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
                        <input class="form-control form-control-sm" type="text" id="website" name="website" autocomplete="off" placeholder="www.nettside.no">
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-floating" style="margin:5px;">
                            <label for="imgFile">Legg til bilde:</label>
                            <div>
                                <input name="imgFile" type="file">
                                <input name="show" type="submit" value="Lagre bilde">
                            </div>
                        </div>
                    <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="submit" value="Opprett" autocomplete="off"></input>
                </div>
            </form>
        </div>
    </body>
</html>
<?php

if (isset($_POST["submit"])) {
    // legge inn check for hvert felt
    $title = $_POST['title'];
    // $title = filter_var($_POST['title'], FILTER_CALLBACK, array('options' => 'my_filter'));

    $info = $_POST['bio'];
    // $info = filter_var($_POST['bio'], FILTER_CALLBACK, array('options' => 'my_filter'));

    $location = $_POST['local'];
    // $location = filter_var($_POST['local'], FILTER_CALLBACK, array('options' => 'my_filter'));

    $host = $_SESSION['USER_ID'];
    
    $starttime = $_POST['startdate'];
    $endtime = $_POST['enddate'];
    $cat = $_POST['category'];
    $ticketprice = $_POST['ticketprice'];

    $website = $_POST['website'];
    // $website = filter_var($_POST['website'], FILTER_SANITIZE_URL);

    // checkFile();

    $events = new Event();
    $CreateEvent = $events->createEvent($title, $info, $host, $location, $starttime, $cat, $endtime, $ticketprice, $website);
    echo "<p class='mb-3 fw-normal'>Arrangementet er oppretter!</p>";
}

function stringFilter($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//runs when form has been submitted
function checkFile() {
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
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/Eventhaandteringssystem/www/assets/img/";
        // No directory with that name?
        if(!file_exists($dir)) 
        {
            if (!mkdir($dir, 0777, true)) 
                die("Cannot create directory..." . $dir);
        }
        
        // Constructing file name
        $suffix = array_search($_FILES['imgFile']['type'], $acc_file_types);

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
                $messages['success'][] = "Filen ble lastet opp!";
                $img = "assets/img/" . $filename;
                return $img;
            } else {
                $messages['error'][] = "Not uploaded because of error #".$_FILES["imgFile"]["error"];
                $img = "assets/img/stock.png";
                return $img;
            }
        }

    } else {
        $messages['error'][] = "Ingen fil er lastet opp";
        $img = "/stock.png";
        return $img;
    }
}

function displayImage($src) {
    echo "<img class='placeholderImg' id='showPic' src='" . $src . "' alt=\"Arrangementsbilde\" style=\"width: 20rem; margin: 150px;\">";
}
?>
