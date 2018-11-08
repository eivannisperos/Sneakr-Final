<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link rel="stylesheet" href="css/master.css">
    <script src="js/jquery.js"></script>
    <script src="js/button-scripts.js"></script>
  </head>
  <body>
    <?php
      session_start();
    ?>
    <div class="">
      <a class="back" href="index.php">BACK</a>
    </div>
    <ul>
      <li><?= $_SESSION['valid_user_id'] ?></li>
      <li><?= $_SESSION['valid_user'] ?></li>
    </ul>
    <a href="data-processing/exit.php">LOG OUT</a>
  </body>
</html>
