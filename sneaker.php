<!DOCTYPE html>
<?php
  session_start();
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_GET["name"] ?></title>
    <link rel="stylesheet" href="css/master.css">
    <script src="js/jquery.js"></script>
    <script src="js/button-scripts.js"></script>
    <script src="js/form-handler.js"></script>
  </head>
  <body>
    <?php
      include("data-processing/db-connect.php");

      $favoriteShoe = false;
      $userLoggedIn = false;
      $redirectPossible = false;
      $redirectLink = $_SERVER["REQUEST_URI"];
      $_SESSION["redirect"] = $redirectLink;
      //$_GET name comes from url query: name
      //$_GET id comes from url query: id
      if (isset($_GET['name']) && isset($_GET['id'])) {
        $snkrName = $_GET['name'];
        $snkrId = $_GET['id'];

        //run query
        //queries
        $retrieveShoeQuery = "SELECT imgLink, colors, description from shoes WHERE itemID = ?";
        $result = $connection->prepare($retrieveShoeQuery);
        $result->bind_param("s", $snkrId);
        $result->execute();
        $result->bind_result($imgLink, $colors, $description);

        //store retrieved data from MySQL to be passed down to DOM below
        //sanitize user input
        while($result->fetch()) {
          $snkrDescription = cleanInput($description);
          $snkrImageLink = $imgLink;
          $snkrColor = $colors;
        }
      }

      //if the user is logged in
      //check if the shoe has been favorited
      if (isset($_SESSION['valid_user_id'])) {
        //a user is logged in
        $userLoggedIn = true;
        //store valid user into this variable
        $validUser = $_SESSION['valid_user_id'];

        //[re[are query]]
        $checkFavorite = "SELECT COUNT(itemID) FROM follows WHERE userid=? AND itemID=?";
        $result = $connection->prepare($checkFavorite);
        $result->bind_param("ss", $validUser, $snkrId);
        $result->execute();
        $result->bind_result($numRows);
        while($result->fetch()) {
          //if the count returns that the query exists...
          //set variable $favoriteShoe to true
          if ($numRows>0) {
            $favoriteShoe = true;
          }
        }
      } else {
        $redirectPossible = true;
      }

      //close database
      $result->close();
      $connection->close();

      // function to concatenate root directory for image
      function buildImageLink($link, $imgIndex) {
        echo $link."/".$imgIndex.".jpg";
      }

      //clean input
      function cleanInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
      }
    ?>

    <nav class="main-nav">
      <ul class="nav-grid-container">
        <li class="nav-item-a"><a href="search.php">HOME</a></li>
        <li class="nav-item-b back"><a href="index.php">BACK</a></li>
        <li class="nav-item-c"><a href="user.php">USERS</a></li>
      </ul>
    </nav>
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
      var isFavoriteShoe = <?= json_encode($favoriteShoe); ?>;
      var userLoggedIn = <?= json_encode($userLoggedIn) ?>;
      //capitalize the paragrpahs
      var snkrDesc = "<?= $snkrDescription ?>";
      $(".snkr-desc").html(snkrDesc.toUpperCase());

      //if the favorite button is clicked
      $('.btn-set-favorite').click(function() {
        if (userLoggedIn) {
          if ($(this).hasClass("favorited")) {
            $(this).removeClass("favorited");
            $(this).find("img").attr("src", "assets/icons/bookmark-white.png");
          } else {
            $(this).addClass("favorited");
            $(this).find("img").attr("src", "assets/icons/bookmark-black-shape.png");
          }
        } else {
          $(".shoe-name-favorite-btn").append(warningMsg("YOU MUST BE LOGGED IN TO BOOKMARK.", "logged-in"));
        }
      })

      //change based on data incoming from data
      if (isFavoriteShoe) {
        //if the shoe is favorited
        //add favorited classes, change icon
        $(".btn-set-favorite").addClass("favorited");
        $(".btn-set-favorite").find("img").attr("src", "assets/icons/bookmark-black-shape.png");
      } else {
        //if the shoe is not
        $(".btn-set-favorite").removeClass("favorited");
        $(".btn-set-favorite").find("img").attr("src", "assets/icons/bookmark-white.png");
      }

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

      function warningMsg(msg, type) {
        var src = "";
        if (type==="logged-in") {
          src = "user.php";
        }

        var srcRedirect = $("<a/>", {
          href: src
        })

        var warningContainer = $("<span/>", {
          class: "warning-msg"
        });

        warningContainer.html(msg);
        srcRedirect.append(warningContainer);
        return srcRedirect;
      }
  })
  </script>
</html>
