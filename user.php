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
    <?php
      session_start();
    ?>

    <!-- go back one page -->
    <div class="">
      <a class="back">BACK</a>
    </div>
    <section class="user-entry-grid-container">


      <!-- log in form -->
      <form class="entry-form log-in" action="data-processing/sign-in.php" method="post">
        <h1>SIGN IN</h1>
        <input type="text" name="username-sign-in" placeholder="USERNAME">
        <input type="password" name="password-sign-in" placeholder="PASSWORD">
        <input type="submit" name="submit-sign-in" value="SIGN IN">
      </form>

      <!-- register form -->
      <form class="entry-form register" action="data-processing/register.php" method="post">
        <h1>REGISTER</h1>
        <input type="text" name="username-register" placeholder="USERNAME">
        <input type="email" name="email-register" placeholder="EMAIL">
        <input type="password" name="password-register" placeholder="PASSWORD">
        <input type="password" name="password-confirm-register" placeholder="CONFIRM PASSWORD">
        <input type="submit" name="submit-register" value="SIGN IN">
      </form>

      <!-- mode change (register / log-in) -->
      <div class="change-entry-mode register-redirect">
        <h4>Don't have an account?</h4>
        <a class="register-btn" href="#">REGISTER</a>
      </div>

      <div class="change-entry-mode log-in-redirect">
        <h4>Already have an account?</h4>
        <a class="log-in-btn" href="#">SIGN IN</a>
      </div>

    </section>
  </body>
</html>
