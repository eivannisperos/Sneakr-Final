<?php
  session_start();

  $errors = array();
  $data = array();

  //checks to see if user input fields are empty
  //if there is, report it to error array
  if (empty($_POST['username-sign-in'])) {
    $errors['username'] = 'Username is required.';
  }

  if (empty($_POST['password-sign-in'])) {
    $errors['password'] = 'Password is required.';
  }

  //if the error array is NOT empty, return a false statement to data stream
  //else if not, proceed with query to database
  if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
  } else {
    $data['success'] = true;
    $data['message'] = 'Success!';

    $username = $_POST['username-sign-in'];
    $password = $_POST['password-sign-in'];

    require('db-connect.php');

    $query = "SELECT userId, username FROM users WHERE username='$username' and pass='$password'";
    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);

    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $userid = $row['userId'];
      $validUser = $row['username'];
    }

    if ($count > 0) {
      $_SESSION['valid_user']=$validUser;
      $_SESSION['valid_user_id']=$userid;
      $_SESSION['first_time_entry']=true;
      $data['username']=$_SESSION['valid_user'];
    } else {
      $username_error = "Incorrect username!";

      $errors['username'] = "Incorrect username or password";
      $data['success'] = false;
      $data['errors'] = $errors;
    }


    mysqli_close($connection);
  }
  echo json_encode($data);
?>
