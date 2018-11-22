<?php
  require("db-connect.php");
  require("common.php");

  $data = array();

  //access database of brand
  //need to reitreve shoes, maybe usiong two prepared statements?
  if (isset($_POST['dbRef'])) {
    $dbRef = $_POST['dbRef'];

    $searchByBrand = "SELECT name, itemID, releaseDay, releaseMonth, releaseYear, imgLink FROM $dbRef";
    $result = mysqli_query($connection, $searchByBrand);


    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $search_results = array(
        "name" => $row["name"],
        "itemID" => $row["itemID"],
        "releaseDay" => $row["releaseDay"],
        "releaseMonth" => $row["releaseMonth"],
        "releaseYear" => $row["releaseYear"],
        "imgLink" => $row["imgLink"]
      );

      array_push($data, $search_results);
    }

    mysqli_close($connection);
    echo json_encode($data);
  }

?>
