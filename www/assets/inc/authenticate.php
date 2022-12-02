<?php
if (empty($_SESSION['LOGGED_IN'])) {
    header("Location: login.php");
    exit();
}