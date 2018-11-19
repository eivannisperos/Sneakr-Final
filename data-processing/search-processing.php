<?php
  require("db-connect.php");

  session_start();

  $data = array();

  if (isset($_SESSION["search-input"])) {
    $searchQuery = $_SESSION["search-input"];
    $query = "SELECT name, itemID, colors, releaseMonth, releaseDay, releaseYear, imgLink FROM shoes WHERE name LIKE '%$searchQuery%'";
    $result = mysqli_query($connection, $query);

    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $dateValue = assignMonthValue($row['releaseMonth']);
      // $dataName = $dataIndex;
      // we type cast it because when json encodes it, any illegal characters will make json_encode($data) = false
      // take result data and assemble it into a an array
      // this array is then pushed to data array below
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

      //for each result retrieved, push the it into the data array
      array_push($data, $search_result);
    }

    //assign columns to the value that is being sorted
    $monthSort = array_column($data, 'dateValue');
    $daySort = array_column($data, 'releaseDay');

    //sort month by ascending order (value given by assignMonthValue)
    //sort day by ascending order
    //variables refer to columns assigned above
    array_multisort($monthSort, SORT_ASC, $daySort, SORT_ASC, $data);

    if (empty($data)) {
      $data["dataEmpty"] = true;
    }

    mysqli_close($connection);
    //unset global variable to make room for next one

  } else {
    $data["searchIdle"] = true;
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
