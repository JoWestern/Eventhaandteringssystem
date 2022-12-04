<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/lib/class.User.php";
require __DIR__."/assets/inc/authenticate.php";
require __DIR__."/assets/inc/stringFilter.php";
?>

<div class="main">
<div class="headline">
<text>Hei <?php echo $_SESSION['FIRSTNAME']?>!</text>
</div>

<?php
$user = new User();
$result = $user->getUserInfo($_SESSION['USER_ID']);
$thisUser = $result->fetch_object();

$userID = $_SESSION['USER_ID'];
$firstname = $thisUser->first_name;
$lastname = $thisUser->last_name;
$email = $thisUser->email;
$phone = $thisUser->phone;

echo '
<body class="main text-center">
        <div class="container login mt-5" style="width: fit-content">
            <form method="POST" action="" autocomplete="off">
                <h1 class="h3 mb-3 fw-normal">Endre bruker</h1>
                <label for="firstname">Fornavn:</label>
                <div class="form-floating">
                    <input type="text" id="firstname" name="firstname" autocomplete="off" value="'.$firstname.'">
                </div>
                <label for="lastname">Etternavn:</label>
                <div class="form-floating">
                    <input type="text" id="lastname" name="lastname" autocomplete="off" value="'.$lastname.'">
                </div>
                <label for="email">E-post:</label>
                <div class="form-floating">
                    <input type="email" id="email" name="email" autocomplete="off" value="'.$email.'">
                </div>
                <label for="phone">Telefonnummer:</label>
                <div class="form-floating">
                    <input type="number" id="phone" name="phone" autocomplete="off" value="'.$phone.'">
                </div>
                <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="edit" value="Endre bruker" autocomplete="off" />
            </form>
        </div>
    </div>
</body>';
$arrayErr = array();
if (isset($_POST["edit"])) {

    if (empty($_POST["firstname"])) {
        $arrayErr["fnameErr"] = "Firstname is required";
        // sjekker om input er med riktige tegn.
    } else {
        $editedFirstname = stringFilter($_POST['firstname']);
    }
    
    if (empty($_POST["lastname"])) {
        $arrayErr["lnameErr"] = "Lastname is required";
        // sjekker om input er med riktige tegn.
    } else {
        $editedLastname = stringFilter($_POST['lastname']);
    }

    if (empty($_POST["email"])) {
        $arrayErr["emailErr"] = "Email is required";
        // sjekker om input er med riktige tegn.
    } else {
        $inputEmail = $_POST["email"];
        $emailSanitized = filter_var($inputEmail, FILTER_SANITIZE_EMAIL);
        if (!filter_var($emailSanitized, FILTER_VALIDATE_EMAIL)) {
            $arrayErr["emailErr"] = "Email is invalid";
        } else {
            $editedEmail = $emailSanitized;
        }
    }

    if (empty($_POST["phone"])) {
        $arrayErr["phoneErr"] = "Phonenumber is required";
        // sjekker om input er med riktige tegn.
    } else {
        $editedPhone = $_POST['phone'];
    }

    if (!(empty($arrayErr))) {
        foreach ($arrayErr as  $value) {
            echo "$value <br>";
        }
    } else {
        $user->editUserInfo($_SESSION['USER_ID'], $editedFirstname, $editedLastname, $editedEmail, $editedPhone);
        $_SESSION['FIRSTNAME'] = $editedFirstname;
        header('Location: minprofil.php');
    }
}