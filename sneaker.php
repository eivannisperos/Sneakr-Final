<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shoe name here</title>
    <link rel="stylesheet" href="css/master.css">
    <script src="js/jquery.js"></script>
    <script src="js/button-scripts.js"></script>
    <script src="js/form-handler.js"></script>
  </head>
  <body>
    <?php
      session_start();
      include("data-processing/db-connect.php");
      //$_GET name comes from url query: name
      //$_GET id comes from url query: id
      if (isset($_GET['name']) && isset($_GET['id'])) {
        $snkrName = $_GET['name'];
        $snkrId = $_GET['id'];

        $query = "SELECT imgLink, colors, description from shoes WHERE itemID = '$snkrId'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //store retrieved data from MySQL to be passed down to DOM below
        //sanitize user input
        $snkrDescription = cleanInput($row['description']);
        $snkrImageLink = $row['imgLink'];
        $snkrColor = $row['colors'];
      }

      //favorite systsem:
      /*
      what we have thus far:
      1. A way for the system to add "favorites" to mysql based on user logged in

      What we need:
      1. The system should keep track of the user's favorited items
      2. When the user clicks the favorite button when it is already favorited, it should remove that from the database

      A1:
      1. session checks for the shoe to be favorited, if it is then set button class to "favorited"
      2. button's appearance should rely on the shoe being favorited

      */

      // function to concatenate root directory for image
      function buildImageLink($link, $imgIndex) {
        echo $link."/".$imgIndex.".jpg";
      }

      function cleanInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
      }
    ?>

    <div class="back">
      <a>BACK</a>
    </div>

    <section class="two-row-grid-container sneaker-grid-container">
      <!-- the buildImageLink function returns the image path -->
      <img class="sneaker-main-img" src=<?= buildImageLink($snkrImageLink, 1); ?> alt="featured shoe">

      <div class="img-carousel"></div>

      <!-- shoe description using passed down data from MySQL -->
      <div class="sneaker-title-colorway">
        <div class="shoe-name-favorite-btn flex-display">
          <h1 class="snkr-name"><?= $snkrName ?></h1>
          <a class="btn-set-favorite">
            <img class="img-button" src="assets/icons/bookmark-white.png" alt="set to favorites">
          </a>
        </div>

        <h3><?= $snkrColor ?></h3>
        <h4 class="snkr-id"><?= $snkrId ?></h4>
      </div>
      <p class="snkr-desc"><?php echo $snkrDescription; ?></p>
    </section>
  </body>

  <script>
    $(document).ready(function() {
      //capitalize the paragrpahs
      var snkrDesc = "<?= $snkrDescription ?>";
      $(".snkr-desc").html(snkrDesc.toUpperCase());

      //iterate through images
      //then build image sections
      for (i = 1; i < 6; i++) {
        $(".img-carousel").append(
          addCarouselImg(
            buildImageLink('<?= $snkrImageLink; ?>', i)
          )
        );
      }

      //by default, first element of img-carousel should be focused
      //because sneaker-main-img focuses on this img initially
      $(".img-carousel-element:first-child").removeClass("img-carousel-unfocused");

      //add click listeners for each img carousel element
      $(".img-carousel-element").click(function() {
        //when clicked, make that image the main image
        $(".sneaker-main-img").attr("src",
          $(this).attr("src")
        );

        //add and remove img-carousel-unfocused class
        //add the class to all elements
        //then remove it to the one selected
        $(".img-carousel-element").addClass("img-carousel-unfocused");
        $(this).removeClass("img-carousel-unfocused");
      })

      //retrieve link of where images are
      function buildImageLink(imgLink, imgIndex) {
        return imgLink + "/" + imgIndex + ".jpg";
      }

      //build img container for image
      function addCarouselImg(imgLink) {
        var carouselImg = $('<img/>', {
          class: "img-carousel-element img-carousel-unfocused",
          src: imgLink
        });

        return carouselImg;
      }
  })
  </script>
</html>
