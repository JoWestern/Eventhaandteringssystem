<?php 
include "./assets/inc/header.php";
require __DIR__."/assets/lib/class.User.php";

// session_start();
// // Check if the user is already logged in, if yes then redirect him to welcome page
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     header("location: mineArrangementer.php");
//     exit();
// }
?>
    <body class="text-center">
        <div class="container login" style="width: fit-content">
            <main class="form-signin w-100 m-auto">
                <div class="main">
                    <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> autocomplete="off">  
                        <h1 class="h3 mb-3 fw-normal">Logg inn</h1>
                        <div class="form-floating">
                            <input type="email" id="username" name="username" placeholder="E-post" autocomplete="off">
                        </div>
                        <div class="form-floating">
                            <input type="password" id="password" name="password" placeholder="Passord" autocomplete="off">
                        </div>

                        <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="login" value="Logg inn" autocomplete="off" />
                        <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="register" value="Registrer" autocomplete="off" />
                        <p class="mt-5 mb-3 text-muted">© 2022</p>
                    </form>
                </div>
            </main>
        </div>
    </body>
<?php  
    $arrayInput = array();
    $arrayErr = array();
    $username = $password = "";

    if (isset($_POST["login"])) {
        //sjekker om navnefeltet er tomt.
        if (empty($_POST["username"])) {
            $arrayErr["nameErr"] = "Username is required";
            // sjekker om input er med riktige tegn.
        } else {
            // input er riktig og blir lagt inn i array
            $arrayInput["username"] = $_POST["username"];
            $username = $_POST['username'];
        }
        // de tre neste kodeblokkene opperer på samme måte som den over.
        if (empty($_POST["password"])) {
            $arrayErr["enameErr"] = "Password is required";
        } else {
            $arrayInput["password"] = $_POST["password"];
            $inputPassword = $_POST['password'];
            $password = $_POST["password"];
        }
        // hvis error-matrisen ikke er tom, print feil
        if (!(empty($arrayErr))) {
            foreach ($arrayErr as  $value) {
                echo "$value <br>";
            }
        } else {
            $users = new User();
            $validateUser = $users->validateUser($username, $password);
        }
    }


if (isset($_POST["register"])) {
    redirect("register.php");
}

function redirect($url) {
    header('Location: '.$url);
    exit();
}
?>
