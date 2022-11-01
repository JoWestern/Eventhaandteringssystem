<form method="post">
    <br>
    <input type="text" name="password">
    <input type="submit" name="submit" value="Hash passord">
</form>

<?php
if(isset($_POST['submit'])){
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    echo "<br><br>Hashet passord: $hash";
}
?>