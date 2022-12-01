<?php
require dirname(__DIR__) . "/www/assets/inc/header.php";
require dirname(__DIR__) . "/www/assets/lib/class.Event.php";
require dirname(__DIR__) . "/www/assets/lib/class.Category.php";
require __DIR__."/assets/inc/authenticate.php";
?>
<body class="main">
    <div class="container login mt-5" style="width: fit-content">
        <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> autocomplete="off">
            <h1 class="h3 mb-3 fw-normal">Opprett arrangement</h1>
            <label for="title">Tittel:</label>
            <div class="form-floating">
                <input type="text" id="title" name="title" autocomplete="off">
            </div>
            <label for="bio">Beskrivelse:</label>
            <div class="form-floating">
                <input type="text" id="bio" name="bio" autocomplete="off">
            </div>
            <label for="local">Lokasjon:</label>
            <div class="form-floating">
                <input type="text" id="local" name="local" autocomplete="off">
            </div>
            <label for="date">Dato:</label>
            <div class="form-floating">
                <input type="datetime-local" id="date" name="date" autocomplete="off">
            </div>
            <label class="mt-1" for="cat">Kategori:</label>
            <div class="form-floating">
                <select name="category">
                    <?php
                        $category = new Category();
                        $categoryOptions = $category->selectCategory();
                        while ($row = mysqli_fetch_array($categoryOptions)) {
                            echo "<option value='" . $row['category_id'] . "'>" . $row['name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <input class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="submit" value="Opprett" autocomplete="off"></input>
        </form>
    </div>
</body>
<?php
if (isset($_POST["submit"])) {
    // legge inn check for hvert felt
    $title = $_POST['title'];
    $info = $_POST['bio'];
    $location = $_POST['local'];
    $host = $_SESSION['USER_ID'];
    $time = $_POST['date'];
    $cat = $_POST['category'];

    $events = new Event();
    $CreateEvent = $events->createEvent($title, $info, $host, $location, $time, $cat);
}