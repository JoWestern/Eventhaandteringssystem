<?php
require dirname(__DIR__) . "/www/assets/inc/header.php";
require dirname(__DIR__) . "/www/assets/lib/class.User.php";
require __DIR__."/assets/inc/stringFilter.php";
?>
<body class="main text-center">
        <div class="container login mt-5" style="width: fit-content">
            <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> autocomplete="off">
                <h1 class="h3 mb-3 fw-normal">Registrer bruker</h1>
                <label for="firstname">Fornavn:</label>
                <div class="form-floating">
                    <input type="text" id="firstname" name="firstname" autocomplete="off">
                </div>
                <label for="lastname">Etternavn:</label>
                <div class="form-floating">
                    <input type="text" id="lastname" name="lastname" autocomplete="off">
                </div>
                <label for="email">E-post:</label>
                <div class="form-floating">
                    <input type="email" id="email" name="email" autocomplete="off">
                </div>
                <label for="password">Passord:</label>
                <div class="form-floating">
                    <input type="password" id="password" name="password" autocomplete="off">
                </div>
                <label for="password">Bekreft passord:</label>
                <div class="form-floating">
                    <input type="password" id="password" name="passwordconfirm" autocomplete="off">
                </div>
                <label for="phone">Telefonnummer:</label>
                <div class="form-floating">
                    <input type="number" id="phone" name="phone" autocomplete="off">
                </div>
                <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="submit" value="Registrer" autocomplete="off"></input>
                <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="login" value="til login" autocomplete="off" />
            </form>
        </div>
    </div>
</body>
<?php
if (isset($_POST["submit"])) {
        if (empty($_POST["firstname"])) {
            $arrayErr["fnameErr"] = "Firstname is required";
            // sjekker om input er med riktige tegn.
        } else {
            $firstname = stringFilter($_POST['firstname']);
        }
        
        if (empty($_POST["lastname"])) {
            $arrayErr["lnameErr"] = "Lastname is required";
            // sjekker om input er med riktige tegn.
        } else {
            $lastname = stringFilter($_POST['lastname']);
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
                $email = $emailSanitized;
            }
        }

        if (empty($_POST["password"]) || empty($_POST["passwordconfirm"])) {
            $arrayErr["passErr"] = "Password is required";
            // sjekker om input er med riktige tegn.
        } else if ($_POST['password'] !== $_POST['passwordconfirm']){
            $arrayErr["nameErr"] = "Passordene må være like";
        }
        else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        if (empty($_POST["phone"])) {
            $arrayErr["phoneErr"] = "Phonenumber is required";
            // sjekker om input er med riktige tegn.
        } else {
            $phone = $_POST['phone'];
        }

        if (!(empty($arrayErr))) {
            foreach ($arrayErr as  $value) {
                echo "$value <br>";
            }
        } else {
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

// BEDRE VALIDERING
//  // Validate username
//  if(empty(trim($_POST["username"]))){
//     $username_err = "Vennligst skriv inn et brukernavn.";
// } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
//     $username_err = "Username can only contain letters, numbers, and underscores.";
// } else {

// $sql = "SELECT user_id FROM users WHERE email = ?";

// if($stmt = mysqli_prepare($link, $sql)) {
//     // Bind variables to the prepared statement as parameters
//     mysqli_stmt_bind_param($stmt, "s", $param_username);
    
//     // Set parameters
//     $param_username = trim($_POST["username"]);
    
//     // Attempt to execute the prepared statement
//     if(mysqli_stmt_execute($stmt)){
//         /* store result */
//         mysqli_stmt_store_result($stmt);
        
//         if(mysqli_stmt_num_rows($stmt) == 1) {
//             $username_err = "This username is already taken.";
//         } else {
//             $username = trim($_POST["username"]);
//         }
//     } else {
//         echo "Oops! Something went wrong. Please try again later.";
//     }
//     // Close statement
//     mysqli_stmt_close($stmt);

//     // Validate password
//     if(empty(trim($_POST["password"]))){
//         $password_err = "Please enter a password.";     
//     } elseif(strlen(trim($_POST["password"])) < 6){
//         $password_err = "Password must have atleast 6 characters.";
//     } else{
//         $password = trim($_POST["password"]);
//     }

//     // Validate confirm password
//     if(empty(trim($_POST["confirm_password"]))){
//         $confirm_password_err = "Please confirm password.";     
//     } else{
//         $confirm_password = trim($_POST["confirm_password"]);
//         if(empty($password_err) && ($password != $confirm_password)){
//             $confirm_password_err = "Password did not match.";
//         }

// }}