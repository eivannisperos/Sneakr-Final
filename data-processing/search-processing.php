<?php
  require("db-connect.php");

  session_start();

  $data = array();

  // if (isset($_GET["search-input"])) {
  //   echo "search input detected";
  // }

  if (isset($_SESSION["search-input"])) {
      $searchQuery = $_SESSION["search-input"];
      //$query = "SELECT * FROM shoes WHERE name LIKE '%$searchQuery%'";
      $query = "SELECT name, itemID, colors, releaseMonth, releaseDay, releaseYear, imgLink FROM shoes WHERE name LIKE '%$searchQuery%'";
      $result = mysqli_query($connection, $query);

      while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $dateValue = assignMonthValue($row['releaseMonth']);
        // $dataName = $dataIndex;
        // we type cast it because when json encodes it, any illegal characters will make json_encode($data) = false
        $search_result = array(
          "itemID" => (string)$row['itemID'],
          "name" => (string) $row['name'],
          "colors" => (string) $row['colors'],
          "releaseDay" => (int) $row['releaseDay'],
          "releaseMonth" => (string)$row['releaseMonth'],
          "releaseYear" => (int)$row['releaseYear'],
          "imgLink" => (string)$row['imgLink'],
          "dateValue" => $dateValue
        );

        array_push($data, $search_result);
      }

      $monthSort = array_column($search_result, 'dateValue');
      $daySort = array_column($search_result, 'releaseDay');
      //array_multisort($monthSort, SORT_ASC, $daySort, SORT_DESC, $search_result);

      if (empty($data)) {
        $data["dataEmpty"] = true;
      }

      mysqli_close($connection);
      //unset global variable to make room for next one
  }
  unset($_SESSION["search-input"]);
  echo json_encode($data);

  function assignMonthValue($month) {
    switch($month) {
      case "January":
        return 1;
      case "Febuary":
        return 2;
      case "March":
        return 3;
      case "April":
        return 4;
      case "May":
        return 5;
      case "June":
        return 6;
      case "July":
        return 7;
      case "August":
        return 8;
      case "September":
        return 9;
      case "October":
        return 10;
      case "November":
        return 11;
      case "December":
        return 12;
    }
  }
?>
