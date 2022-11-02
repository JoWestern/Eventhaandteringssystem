<?php
require dirname(__DIR__) . "/www/assets/inc/header.php";
?>

<body class="text-center">
    <!-- <div class="container login" style="width: fit-content"> -->
    <div class="container login">
        <main class="form-signin w-100 m-auto">
            <form>
                <br>
                <h1 class="h3 mb-3 fw-normal">Logg inn</h1>

                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingInput" placeholder="E-post">
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Passord">
                </div>
                <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Sign in</button>
                <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Registrer</button>
                <p class="mt-5 mb-3 text-muted">© 2022</p>
            </form>
        </main>
    </div>
</body>