<?php
  session_start();
  if (isset($_SESSION['valid_user_id']) && isset($_POST['sneakerId'])) {
    //paramteres incoming AJAX
    $snkrId = $_POST['sneakerId'];
    $user = $_SESSION['valid_user_id'];

    //require will stop the entire script if something goes wrong
    require('db-connect.php');

    $countQuery = "SELECT COUNT(itemID) FROM follows WHERE userid=? AND itemID=?";
    $addQuery = "INSERT INTO follows (userid, itemID) VALUES(?,?)";
    $deleteQuery = "DELETE FROM follows WHERE userid=? AND itemID=?";

    $result = $connection->prepare($countQuery);
    $countQueryResult = runQuery($result, $connection, $user, $snkrId, "count");

    if ($countQueryResult > 0) {
      //if query returned is more than 0, means that the shoe is already favorited
      //if it is already favorited, delete the query
      $resultDelete = $connection->prepare($deleteQuery);
      var_dump($resultDelete);
      //$deletedRows = runQuery($resultDelete, $connection, $user, $snkrId, "delete");
    } else {
      //the shoe is not favorited, thus we must favorite it
      echo "Favorite me!";
    }

    // echo runQuery($result, $connection, $user, $snkrId, "count");
    //PDO connection to database using prepared statements
    // $result = $connection->prepare($countQuery);
    // $result->bind_param("ss", $user, $snkrId); //bind paramters to ?
    // $result->execute();  //execute query
    // $result->bind_result($numRows); //bind the result to variable $numRows
    //
    // while($result->fetch()) {
    //   if ($numRows > 0) { //return variable $numRows here
    //     //delete
    //     $result = $connection->prepare($deleteQuery);
    //     $result = bind_param("ss", $)
    //   } else {
    //     echo "Favorite shoe!";
    //   }
    // }
    //
    // $result->close();
    // $connection->close();
    // if ($sql = $connection->prepare($selectQuery)) {
    //   $sql->bind_param("ss", $user, $snkrID);
    //   $sql->execute();
    //   $sql->bind_result($u, $id);
    //
    //   while($sql->fetch()) {
    //     echo $u;
    //     echo $id;
    //   }
    // }

    // $countQuery = "SELECT COUNT(itemID) FROM follows WHERE userid=? AND itemID=?";
    // $countQuery->bind_param("ss", $user, $snkrId);
    // // $countQuery->execute();
    // if ($result = $connection->query($initialSql)) {
    //   echo "connected";
    // }
    //check connection
    // if ($connection->connect_error){
    //   die("Connection failed: ".$connection->connect_error);
    // }
    //
    // $initialQuery = $connection->prepare("SELECT userid, itemID FROM follows WHERE userid=? AND itemID=?");
    // $initialQuery->bind_param("ss", $user, $snkrId);
    // $initialQuery->execute();
    // $initialQuery->bind_result($retrievedUser, $retrievedId);

    //query as a PDO

    // while($initialQuery->fetch()) {
    //   echo $retrievedUser;
    //   echo $retrievedId;
    // }
    //
    // $initialQuery->close();
    //
    // $stmt = $connection->prepare("INSERT INTO follows (userid, itemID) VALUES(?,?)");
    // $stmt->bind_param("ss", $user, $snkrId);
    // $stmt->execute();
    //
    // echo "New records created successfully!";
    // $stmt->close();
    // $connection->close();
  } else {
    echo "You are currently not logged in.";
  }
  // $result = $connection->prepare($countQuery);
  // $result->bind_param("ss", $user, $snkrId); //bind paramters to ?
  // $result->execute();  //execute query
  // $result->bind_result($numRows); //bind the result to variable $numRows
  //
  // while($result->fetch()) {
  //   if ($numRows > 0) { //return variable $numRows here
  //     //delete
  //     $result = $connection->prepare($deleteQuery);
  //     $result = bind_param("ss", $)
  //   } else {
  //     echo "Favorite shoe!";
  //   }
  // }
  //
  // $result->close();
  // $connection->close();

  function runQuery($resultConn, $conn, $var1, $var2, $type) {
    $returnValue;

    $resultConn->bind_param("ss", $var1, $var2);
    $resultConn->execute();

    if ($type==="count") {
      $resultConn->bind_result($numRows);
      while($resultConn->fetch()) {
        $returnValue = $numRows;
      }
    } else if ($type==="select") {
      //$result->bind_result($u, $id);
      echo "Select!";
    } else if ($type==="delete") {
      $returnValue=$resultConn->rowCount();
    }


    $resultConn->close();
    $conn->close();

    return $returnValue;
  }


?>
