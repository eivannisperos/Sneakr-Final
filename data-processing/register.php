<?php
  /* this php file will clean the incoming data from user.php
  1. clean incoming data
  2. validate data
  3. keep track of errors in data()
  4. send this data to server and picked up by JavaScript
  5. display errors on browser using AJAX */
  session_start();

  require('db-connect.php');
  $data = array();
  $errors = array();

  //username validation
  if (empty($_POST['username-register'])) {
    $errors['username'] = 'USERNAME REQUIRED';
  } else if(strlen($_POST['username-register']) > 20) {
    $errors['username'] = 'USERNAME CANNOT EXCEEED 20 CHARACTERS';
  } else {
    if (hasDuplicate($_POST['username-register'], 'users', 'username', $connection)) {
      $errors['username'] = 'USERNAME ALREADY TAKEN';
    }
  }

  //email validation
  if (empty($_POST['email-register'])) {
    $errors['email'] = 'EMAIL REQUIRED';
  } else if (!filter_var($_POST['email-register'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'INVALID EMAIL FORMAT';
  } else {
    if (hasDuplicate($_POST['email-register'], 'users', 'email', $connection)) {
      $errors['email'] = 'EMAIL ALREADY IN USE';
    }
  }

  if (empty($_POST['password-register'])) {
    $errors['password'] = 'PASSWORD REQUIRED';
  }

  if (empty($_POST['password-confirm-register'])) {
    $errors['confirmPassword'] = 'PLEASE CONFIRM YOUR PASSWORD';
  } else if ($_POST['password-register'] !== $_POST['password-confirm-register']) {
    $errors['password'] = "PASSWORDS MUST MATCH";
  }

  //checks for errors from validation above
  if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
  } else {

    //store post global variables to make it easier for access, also clean them
    $username = cleanInput($_POST['username-register']);
    $email = cleanInput($_POST['email-register']);
    $password = cleanInput($_POST['password-register']);
    $confirmPassword = cleanInput($_POST['password-confirm-register']);

    $query = "INSERT INTO users (username, email, pass) VALUES('$username', '$email', '$password')";
    $result = mysqli_query($connection, $query);

    if (mysqli_errno($connection)) {
      $errors['general'] = mysqli_errno($connection);
      //check for duplicate entires
      if (mysqli_errno($connection) == 1062) {
        $errors['username'] = "Duplicate ID deteced. Please contact service.";
      }

      //transmit erro messages to AJAX request
      $data['success'] = false;
      $data['errors'] = $errors;

    } else {
      //send success after everything else checks out
      $data['success'] = true;
      $data['message'] = 'Success! Session in order.';

      $_SESSION['valid_user']=$username;
      $_SESSION['first_time_entry']=true;
      $data['session']=$_SESSION['valid_user'];
    }

    mysqli_close($connection);
  }

  echo json_encode($data);


  function hasDuplicate($data, $db, $col, $con) {
    $query = "SELECT ".$col." FROM ".$db." WHERE ".$col."='$data'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);

    if ($count > 0) return true;
  }

  function cleanInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
?>
