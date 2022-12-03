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

echo "  
    <div class='user-info'>
    Fornavn: $thisUser->first_name<br><br>
    Etternavn: $thisUser->last_name<br><br>
    Epost: $thisUser->email<br><br>
    Telefon: $thisUser->phone<br><br>
    <form method='post' action='edituser.php'>
        <input type='submit' value='Endre bruker'>
    </form>
    <form method='post' action='editpassword.php'>
        <input type='submit' value='Endre passord'>
    </form>
    </div>";


