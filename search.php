<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>
    <link rel="stylesheet" href="css/master.css">
    <script src="js/jquery.js"></script>
    <script src="js/button-scripts.js"></script>
    <script src="js/form-handler.js"></script>
  </head>
  <body>
    <div class="">
      <a class="back" href="index.php">BACK</a>
    </div>
    <section class="two-row-grid-container search-grid-container">
      <form class="search-entry-grid-container search" action="search.php" method="get">
        <input type="submit" name="search-submit" value="">
        <input type="text" name="search-input" placeholder="SEARCH">
      </form>
      <section class="search-recommendations search-space">
        <div class="flex-container search-by-brand-control">
          <a id="search-by-brand" href="#"><h3>SEARCH BY BRAND</h3></a>
          <img class="close-search-brands close img-button" src="assets/icons/cancel-music.png"></a>
        </div>
        <div class="flex-container search-brands">
          <!-- added div so that the underline does not extend all the way of the flex container -->
          <a href="#">NIKE</a>
          <a href="#">ADIDAS</a>
          <a href="#">COMME DES GARCON</a>
          <a href="#">ASICS</a>
          <a href="#">NEW BALANCE</a>
          <a href="#">REEBOK</a>
          <a href="#">SAUCONY</a>
          <a href="#">COMMON PROJECTS</a>
        </div>

        <!-- where the results show, currently it is flex container -->
        <!-- <div class="coming-up-flex search-results">
        </div> -->
        <div class="search-results-grid-container search-results">
        </div>
      </section>
    </section>
  </body>
</html>
