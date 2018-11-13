<?php
  session_start();
  //if the user is logged in and that the sneaker ID is properly sent
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

    //check first if the query already exists
    if ($countQueryResult > 0) {
      //if query returned is more than 0, means that the shoe is already favorited
      //if it is already favorited, delete the query
      $result = $connection->prepare($deleteQuery);
      $rowsAffected = runQuery($result, $connection, $user, $snkrId, "delete");
    } else {
      //if it does not, add it to favorites
      $result = $connection->prepare($addQuery);
      $rowsAffected = runQuery($result, $connection, $user, $snkrId, "insert");
    }

    //recieve feedback of affected rows
    echo $rowsAffected;

    //close the query
    $result->close();
    $connection->close();

  } else {
    echo "You are currently not logged in.";
  }

  function runQuery($resultConn, $conn, $var1, $var2, $type) {
    $resultConn->bind_param("ss", $var1, $var2);
    $resultConn->execute();

    //if the query type is count, bind the number of rows  to the $returnValue
    //so that we know if the query already exists, if it is greater than 0
    //this is evaluated above
    if ($type==="count") {
      $resultConn->bind_result($numRows);
      while($resultConn->fetch()) {
        $returnValue = $numRows;
      }
    } else if ($type==="insert" || $type==="delete") {
      //if it is insert or deletion, return the rows affected
      //we used affected_rows because our object is mysqli
      $returnValue = $resultConn->affected_rows;
    }

    //return the value
    return $returnValue;
  }


?>
