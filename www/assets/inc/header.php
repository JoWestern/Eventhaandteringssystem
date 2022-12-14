<?php
session_start()
?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/eventhaandteringssystem/www/assets/css/styles.css">
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="/eventhaandteringssystem/www/index.php">Arr!</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link active" href="/eventhaandteringssystem/www/allEvents.php">Alle arrangementer</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/eventhaandteringssystem/www/createevent.php">Opprett arrangement</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/eventhaandteringssystem/www/mineArrangementer.php">Mine arrangementer</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/eventhaandteringssystem/www/minprofil.php">Min profil</a>
      </li>
      <?php
      if(isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] == true){
      echo '<li class="nav-item active">
              <a class="nav-link" href="/eventhaandteringssystem/www/logout.php">Logg ut</a>
            </li>';
      }
      ?>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="GET" action="results.php">
      <input class="form-control mr-sm-2" name="query" type="search" placeholder="Søk" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Søk</button>
    </form>
  </div>
</nav>
