<?php
require dirname(__DIR__) . "/www/assets/inc/header.php";
require dirname(__DIR__) . "/www/assets/lib/class.Event.php";
require dirname(__DIR__) . "/www/assets/lib/class.Category.php";
require __DIR__."/assets/inc/authenticate.php";
require __DIR__."/assets/inc/stringFilter.php";
require __DIR__."/assets/inc/displayError.php";

$arrayErr = array();
if (isset($_POST["submit"])) {

    // legge inn check for hvert felt
    if (empty($_POST["title"])) {
        $titleErr = "Tittel er påkrevd";
        $arrayErr["titleErr"] = $titleErr;
        // sjekker om input er med riktige tegn.
    } else if (!preg_match('/^[a-zA-Z0-9 .!?$%@#&+\-]+$/',$_POST["title"])) {
        $titleErr = "Kun bokstaver, tall og tegn";
        $arrayErr["titleErr"] = $titleErr;
    }
    else {
        $title = stringFilter($_POST['title']);
    }
    // $title = filter_var($_POST['title'], FILTER_CALLBACK, array('options' => 'my_filter'));
    if (empty($_POST["bio"])) {
        $bioErr = "Beksrivelse er påkrevd";
        $arrayErr["bioErr"] = $bioErr;
        // sjekker om input er med riktige tegn.
    } else if (!preg_match('/^[a-zA-Z0-9 .!?$%@#&+\-]+$/',$_POST["bio"])) {
        $bioErr = "Kun bokstaver, tall og tegn";
        $arrayErr["bioErr"] = $bioErr;
    }
    else {
        $info = stringFilter($_POST['bio']);
    }
    // $info = filter_var($_POST['bio'], FILTER_CALLBACK, array('options' => 'my_filter'));
    if (empty($_POST["local"])) {
        $localErr = "Sted er påkrevd";
        $arrayErr["localErr"] = $localErr;
        // sjekker om input er med riktige tegn.
    } else if (!preg_match('/^[a-zA-Z0-9 .!?$%@#&+\-]+$/',$_POST["local"])) {
        $localErr = "Kun bokstaver, tall og tegn";
        $arrayErr["localErr"] = $localErr;
    }
    else {
        $location = stringFilter($_POST['local']);
    }
    // $location = filter_var($_POST['local'], FILTER_CALLBACK, array('options' => 'my_filter'));

    $host = $_SESSION['USER_ID'];

    if ($_POST['startdate'] == null) {
        $startdateErr = "Startdato er påkrevd";
        $arrayErr = $startdateErr;
    } else {
        $starttime = $_POST['startdate'];
    }

    if ($_POST['enddate'] == null){
        $endtime = null;
    }
    else $endtime = $_POST['enddate'];
    $cat = $_POST['category'];

    if (empty($_POST["ticketprice"])) {
        $ticketprice = 0;
    } else if (!is_numeric($_POST["ticketprice"])) {
        $ticketErr = "Pris må være et tall";
        $arrayErr["priceErr"] = $ticketErr;
    } else {
        $ticketprice = $_POST['ticketprice'];
    }

    // $website = $_POST['website'];
    if (empty($_POST['website'])) {
        $website = "";
    } else {
        $inputWebsite = filter_var($_POST['website'], FILTER_SANITIZE_URL);
        if (!filter_var($inputWebsite, FILTER_VALIDATE_URL)) {
            $urlErr = "Ugyldig URL";
            $arrayErr["urlErr"] = $urlErr;
        } else {
            $website = $inputWebsite;
        }
    }

    if (isset($_FILES['imgFile'])) {
        $img_url = checkFile();
    }
    // checkFile();
    if ((empty($arrayErr))) {
        $events = new Event();
        if (
            $CreateEvent = $events->createEvent($title, $info, $host, $location, $starttime, $cat, $endtime, $ticketprice, $website, $img_url)
        ){
            $success = "Arrangement opprettet!";
        } else {
            $unsuccess = "Det oppstod en feil";
        }
    }
}

//runs when form has been submitted
function checkFile() {
    // Define array for messages 
    $messages = array();
    $semiPath = "assets/img/";
    $filepathStock = $semiPath . "stock.png";
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

            // Moving uploaded file
            $filepath = $dir . $filename;
            $uploaded_file = move_uploaded_file($_FILES['imgFile']['tmp_name'], $filepath);
           
            if ($uploaded_file){
                $messages['success'][] = "Filen ble lastet opp!";
                $imgPath = $semiPath . $filename;
                return $imgPath;
            } else {
                $messages['error'][] = "Not uploaded because of error #".$_FILES["imgFile"]["error"];
                return $filepathStock;
            }
        }
    } 
    else {
        $messages['error'][] = "Ingen fil er lastet opp";
        return $filepathStock;
    }
}

function displayImage($src) {
    echo "<img class='placeholderImg' id='showPic' src='" . $src . "' alt=\"Arrangementsbilde\" style=\"width: 20rem; margin: 150px;\">";
}
?>

<!doctype html>
<html>
    <body class="main text-left">
        <div class="container login mt-5" style="width: fit-content">
        <div class="img-fluid">
        </div>
            <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> autocomplete="off" enctype="multipart/form-data">
                <h1 class="h3 mb-3 fw-normal">Opprett arrangement</h1>
                <?php 
                 if (isset($success)) {
                    echo "<small><p style='color: green;'><b>".$success."</b></p></small>";
                } else if (isset($unsuccess)) {
                    echo "<small><p style='color: red;'><b>".$unsuccess."</b></p></small>";
                }
                ?>
                    <label for="title">Tittel:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="text" id="title" name="title" autocomplete="off">
                        <?php 
                        if(isset($titleErr)) displayerror($titleErr); 
                        ?>
                    </div>
                    <label for="bio">Beskrivelse:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="text" id="bio" name="bio" autocomplete="off">
                        <?php 
                        if(isset($bioErr)) displayerror($bioErr); 
                        ?>
                    </div>
                    <label for="local">Lokasjon:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="text" id="local" name="local" autocomplete="off">
                        <?php 
                        if(isset($localErr)) displayerror($localErr); 
                        ?>
                    </div>
                    <label for="startdate">Startdato:</label>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" type="datetime-local" id="startdate" name="startdate" autocomplete="off">
                        <?php 
                            if(isset($startdateErr)) displayerror($startdateErr); 
                            ?>
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
                            <?php 
                            if(isset($ticketErr)) displayerror($ticketErr); 
                            ?>
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
                        <input class="form-control form-control-sm" type="text" id="website" name="website" autocomplete="off" placeholder="https://www.nettside.no">
                            <?php 
                            if(isset($urlErr)) displayerror($urlErr); 
                            ?>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-floating" style="margin:5px;">
                            <label for="imgFile">Legg til bilde: (kun .jpg og .png)</label>
                            <div>
                                <input name="imgFile" type="file">
                            </div>
                        </div>
                    <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="submit" value="Opprett" autocomplete="off"></input>
                </div>
            </form>
        </div>
    </body>
</html>