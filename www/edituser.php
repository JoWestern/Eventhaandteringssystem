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

if (isset($_POST["edit"])) {
    

    $user->editUserInfo($_SESSION['USER_ID'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone']);
    $_SESSION['FIRSTNAME'] = $_POST['firstname'];
    header('Location: minprofil.php');
}