<?php
require dirname(__DIR__) . "/www/assets/inc/header.php";
require dirname(__DIR__) . "/www/assets/lib/class.User.php";
require __DIR__."/assets/inc/stringFilter.php";
require __DIR__."/assets/inc/displayError.php";
?>

<?php
if (isset($_POST["submit"])) {
        if (empty($_POST["firstname"])) {
            $fnameErr = "Fornavn mangler";
            $arrayErr = $fnameErr;
            // sjekker om input er med riktige tegn.
        } else if (!preg_match("/^[a-zA-Z-' æÆøØåÅéÉ]*$/", $_POST['firstname'])) {
            $fnameErr = "Kun bokstaver og mellomrom";
            $arrayErr = $fnameErr;
        }
        else {
            $firstname = stringFilter($_POST['firstname']);
        }

        if (empty($_POST["lastname"])) {
            $lastname = "";
            // sjekker om input er med riktige tegn.
        } else 
        if (!preg_match("/^[a-zA-Z-' æÆøØåÅéÉ]*$/", $_POST['lastname'])) {
            $lnameErr = "Kun bokstaver og mellomrom";
            $arrayErr = $lnameErr;
        }
        else {
            $lastname = stringFilter($_POST['lastname']);
        }

        if (empty($_POST["email"])) {
            $emailErr = "E-post er påkrevd";
            $arrayErr = $emailErr;
            // sjekker om input er med riktige tegn.
        } else {
            $inputEmail = $_POST["email"];
            $emailSanitized = filter_var($inputEmail, FILTER_SANITIZE_EMAIL);
            if (!filter_var($emailSanitized, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Ugyldig E-post";
                $arrayErr = $emailErr;
            } else {
                $email = $emailSanitized;
            }
        }

        if (empty($_POST["password"]) || empty($_POST["passwordconfirm"])) {
            $passErr = "Passord er påkrevd";
            $arrayErr = $passErr;
            // sjekker om input er med riktige tegn.
        } else if(
            !preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%.,]{8,12}$/', $_POST['password']) ||
            !preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%.,]{8,12}$/', $_POST['passwordconfirm']) 
            ) {
            $passErr = 'Passord møter ikke kravene';
            $arrayErr = $passErr;
        }
        else if ($_POST['password'] !== $_POST['passwordconfirm']){
            $passErr = "Passordene må være like";
            $arrayErr = $passErr;
        }
        else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        if (empty($_POST["phone"])) {
            $phoneErr = "Mobilnummer er påkrevd";
            $arrayErr = $phoneErr;
            // sjekker om input er med riktige tegn.
        } else if (!is_numeric($_POST["phone"])) {
            $phoneErr = "Mobilnummer kan kun inneholde tall";
            $arrayErr = $phoneErr;
        }  
        else {
            $phone = $_POST['phone'];
        }

        if ((empty($arrayErr))) {
            $users = new User();
            if (
                $CreateUser = $users->createUser($firstname, $lastname, $email, $phone, $password)
                ) {
                    echo "User registered!";
                }
            $users->validateUser($email, $_POST['password']);
        }
    }


if (isset($_POST["login"])) {
    header('Location: login.php');
    exit();
}

?>
<body class="main text-center">
        <div class="container login mt-5" style="width: fit-content">
            <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> autocomplete="off">
                <h1 class="h3 mb-3 fw-normal">Registrer bruker</h1>
                <p>Felt merket med * er obligatoriske</p>
                <label for="firstname">Fornavn/organisasjonsnavn: *</label>
                <div class="form-floating">
                    <input class="form-control" type="text" id="firstname" name="firstname" autocomplete="off" required>
                    <?php 
                    if(isset($fnameErr)) displayerror($fnameErr); 
                    ?>
                </div>
                <label for="lastname">Etternavn:</label>
                <div class="form-floating">
                    <input class="form-control" type="text" id="lastname" name="lastname" autocomplete="off">
                    <?php 
                    if(isset($lnameErr)) displayerror($lnameErr); 
                    ?>
                </div>
                <label for="email">E-post: *</label>
                <div class="form-floating">
                    <input class="form-control" type="email" id="email" name="email" autocomplete="off" required>
                    <?php 
                    if(isset($emailErr)) displayerror($emailErr); 
                    ?>
                </div>
                <label for="password">Passord (8-12 tegn, minst ett tall): *</label>
                <div class="form-floating">
                    <input class="form-control" type="password" id="password" name="password" autocomplete="off" required>
                    <?php 
                    if(isset($passErr)) displayerror($passErr); 
                    ?>
                </div>
                <label for="password">Bekreft passord: *</label>
                <div class="form-floating">
                    <input class="form-control" type="password" id="password" name="passwordconfirm" autocomplete="off" required>
                </div>
                <label for="phone">Telefonnummer: *</label>
                <div class="form-floating">
                    <input class="form-control" type="number" id="phone" name="phone" autocomplete="off" required>
                    <?php 
                    if(isset($phoneErr)) displayerror($phoneErr); 
                    ?>
                </div>
                <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="submit" value="Registrer" autocomplete="off"></input>
                <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="login" value="Til login" autocomplete="off" />
            </form>
        </div>
    </div>
</body>