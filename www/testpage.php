<?php
session_start();
echo "
    BrukerID: " . $_SESSION['USER_ID'] . "<br>
    Fornavn: " . $_POST['firstname'] . "<br>
    Etternavn: " . $_POST['lastname'] . "<br>
    Mail: " . $_POST['email'] . "<br>
    Telefon: " . $_POST['phone']
;