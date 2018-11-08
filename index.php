<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sneakr</title>
    <link rel="stylesheet" href="css/master.css">
    <script src="js/jquery.js"></script>
    <script src="js/button-scripts.js"></script>
  </head>
  <body>
    <?php
      session_start();

      //default link
      $defaultUserLink = "user.php";

      //if user is logged in, user should be able to view their page
      if (isset($_SESSION['valid_user'])) {
        $defaultUserLink = "profile.php";
      }
    ?>
    <!-- main container -->
    <section class="main-grid-container">
      <!-- navigaton menu -->
      <nav class="main-nav">
        <ul class="nav-grid-container">
          <li class="nav-item-a"><a href=<?= $defaultUserLink ?>>USERS</a></li>
          <li class="nav-item-b"><a href="index.php">SNEAKR</a></li>
          <li class="nav-item-c"><a href="search.php">SEARCH</a></li>
        </ul>
      </nav>

      <!-- featured shoe -->
      <div class="hero-banner">
        <h3>NOVEMBER 23</h3>
        <div class="hero-banner-img">
          <img src="img/shoes/nike-air-max-97-grape/1.jpg" alt="featured shoe">
        </div>
        <h1>NIKE AIR MAX 97</h1>
      </div>

      <section class="search-results-grid-container">
        <div class="shoe-date-container">
          <h3>NOVEMBER 23</h3>
          <img src="img/shoes/nike-air-max-97-grape/1.jpg" alt="featured shoe">
          <h1>NIKE AIR MAX 97</h1>
        </div>

        <div class="shoe-date-container">
          <h3>NOVEMBER 23</h3>
          <img src="img/shoes/nike-air-max-97-grape/1.jpg" alt="featured shoe">
          <h1>NIKE AIR MAX 97</h1>
        </div>

        <div class="shoe-date-container">
          <h3>NOVEMBER 23</h3>
          <img src="img/shoes/nike-air-max-97-grape/1.jpg" alt="featured shoe">
          <h1>NIKE AIR MAX 97</h1>
        </div>

        <div class="shoe-date-container">
          <h3>NOVEMBER 23</h3>
          <img src="img/shoes/nike-air-max-97-grape/1.jpg" alt="featured shoe">
          <h1>NIKE AIR MAX 97</h1>
        </div>
      </section>

      <section class="footer">
        <h1>ABOUT</h1>
        <p>Sneakr is a project made by @eivannisperos, a database of sneakers and their release dates for sneaker fanatics</p>
        <a>TOP</a>
      </section>
    </section>



  </body>
</html>
