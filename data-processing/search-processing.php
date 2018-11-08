<?php
  require("db-connect.php");

  session_start();

  $data = array();

  if (isset($_GET['search-input'])) {
    $searchQuery = $_GET['search-input'];
    //$query = "SELECT * FROM shoes WHERE name LIKE '%$searchQuery%'";
    $query = "SELECT name, itemID, colors, releaseMonth, releaseDay, releaseYear, imgLink FROM shoes WHERE name LIKE '%$searchQuery%'";
    $result = mysqli_query($connection, $query);

    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      // $dataName = $dataIndex;
      // we type cast it because when json encodes it, any illegal characters will make json_encode($data) = false
      $search_result = array(
        "itemID" => (string)$row['itemID'],
        "name" => (string) $row['name'],
        "colors" => (string) $row['colors'],
        "releaseDay" => (int) $row['releaseDay'],
        "releaseMonth" => (string)$row['releaseMonth'],
        "releaseYear" => (int)$row['releaseYear'],
        "imgLink" => (string)$row['imgLink']
      );

      array_push($data, $search_result);
    }

    if (empty($data)) {
      $data["dataEmpty"] = true;
    }

    mysqli_close($connection);
  }
  echo json_encode($data);
?>
