<?php 
require __DIR__."/assets/inc/header.php";
require __DIR__."/assets/lib/class.User.php";
require __DIR__."/assets/inc/authenticate.php";
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
$password = $thisUser->password;

echo '
<body class="main text-center">
        <div class="container login mt-5" style="width: fit-content">
            <form method="POST" action="" autocomplete="off">
                <h1 class="h3 mb-3 fw-normal">Endre passord</h1>
                <label for="oldpassword">Gammelt passord:</label>
                <div class="form-floating">
                    <input type="password" name="oldpassword" autocomplete="off">
                </div>
                <label for="newpassword">Nytt passord:</label>
                <div class="form-floating">
                    <input type="password" name="newpassword" autocomplete="off">
                </div>
                <label for="confirmpassword">Bekreft passord:</label>
                <div class="form-floating">
                    <input type="password" name="confirmpassword" autocomplete="off">
                </div>
                <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="edit" value="Endre passord" autocomplete="off" />
            </form>
        </div>
    </div>
</body>';
$arrayErr = array();
if (isset($_POST["edit"])) {
    $oldPass = $_POST['oldpassword'];
    $newPass = $_POST['newpassword'];
    $confirmPass = $_POST['confirmpassword'];

    if (empty($_POST['oldpassword']) || empty($_POST['newpassword']) || empty($_POST['confirmpassword'])) {
        $arrayErr['oldpassErr'] = "Password is required";
    } else if(!password_verify($_POST['oldpassword'], $thisUser->password)){
        echo "Feil passord";
        die();
    }
    elseif($_POST['newpassword'] !== $_POST['confirmpassword']){
        echo "De nye passordene må være like";
        die();
    }
    else{
        $user->editUserPassword($_SESSION['USER_ID'], password_hash($_POST['newpassword'], PASSWORD_DEFAULT));
        echo "Passord endret";
    }


}