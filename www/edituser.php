<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/lib/class.User.php";
require __DIR__."/assets/inc/authenticate.php";
require __DIR__."/assets/inc/stringFilter.php";
require __DIR__."/assets/inc/displayError.php";

$user = new User();
$result = $user->getUserInfo($_SESSION['USER_ID']);
$thisUser = $result->fetch_object();

$userID = $_SESSION['USER_ID'];
$firstname = $thisUser->first_name;
$lastname = $thisUser->last_name;
$email = $thisUser->email;
$phone = $thisUser->phone;

$arrayErr = array();
if (isset($_POST["edit"])) {

    if (empty($_POST["firstname"])) {
        $fnameErr = "Brukernavn er påkrevd";
        $arrayErr["fnameErr"] = $fnameErr;
        // sjekker om input er med riktige tegn.
    } else if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["firstname"])) {
        $fnameErr = "Kun bokstaver og mellomrom er tillatt";
        $arrayErr = $fnameErr;
    }
    else {
        $editedFirstname = stringFilter($_POST['firstname']);
    }
    
    if (empty($_POST["lastname"])) {
        $editedLastname = "";
        // sjekker om input er med riktige tegn.
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["lastname"])) {
        $lnameErr = "Kun bokstaver og mellomrom er tillatt";
        $arrayErr = $lnameErr;
    }
    else {
        $editedLastname = stringFilter($_POST['lastname']);
    }

    if (empty($_POST["email"])) {
        $emailErr = "E-post er påkrevd";
        $arrayErr["emailErr"] = $emailErr;
        // sjekker om input er med riktige tegn.
    } else {
        $inputEmail = $_POST["email"];
        $emailSanitized = filter_var($inputEmail, FILTER_SANITIZE_EMAIL);
        if (!filter_var($emailSanitized, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Ugyldig E-post";
            $arrayErr["emailErr"] = $emailErr;
        } else {
            $editedEmail = $emailSanitized;
        }
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Mobilnummer er påkrevd";
        $arrayErr["phoneErr"] = $phoneErr;
        // sjekker om input er med riktige tegn.
    } else if (!is_numeric($_POST["phone"])) {
        $phoneErr = "Mobilnummer må være tall";
        $arrayErr["phoneErr"] = $phoneErr;
    }  
    else {
        $editedPhone = $_POST['phone'];
    }

    if ((empty($arrayErr))) {
        $user->editUserInfo($_SESSION['USER_ID'], $editedFirstname, $editedLastname, $editedEmail, $editedPhone);
        $_SESSION['FIRSTNAME'] = $editedFirstname;
        header('Location: minprofil.php');
    }
}

?>

<div class="main">
<div class="headline">
<text>Hei <?php echo $_SESSION['FIRSTNAME']?>!</text>
</div>
<body class="main text-center">
        <div class="container login mt-5" style="width: fit-content">
            <form method="POST" action="" autocomplete="off">
                <h1 class="h3 mb-3 fw-normal">Endre bruker</h1>
                <p>Felt merket med * er obligatoriske</p>
                <label for="firstname">Fornavn/organisasjonsnavn: *</label>
                <div class="form-floating">
                    <input type="text" id="firstname" name="firstname" autocomplete="off" value="<?php echo $firstname?> required">
                    <?php 
                    if(isset($fnameErr)) displayerror($fnameErr); 
                    ?>
                </div>
                <label for="lastname">Etternavn:</label>
                <div class="form-floating">
                    <input type="text" id="lastname" name="lastname" autocomplete="off" value=<?php echo $lastname ?>>
                    <?php 
                    if(isset($lnameErr)) displayerror($lnameErr); 
                    ?>
                </div>
                <label for="email">E-post: *</label>
                <div class="form-floating">
                    <input type="email" id="email" name="email" autocomplete="off" value= <?php echo $email ?> required>
                    <?php 
                    if(isset($emailErr)) displayerror($emailErr); 
                    ?>
                </div>
                <label for="phone">Telefonnummer: *</label>
                <div class="form-floating">
                    <input type="number" id="phone" name="phone" autocomplete="off" value=<?php echo $phone ?> required>
                    <?php 
                    if(isset($phoneErr)) displayerror($phoneErr); 
                    ?>
                </div>
                <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="edit" value="Endre bruker" autocomplete="off" />
            </form>
        </div>
    </div>
</body>