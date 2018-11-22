<?php
  require("db-connect.php");
  //store brands in an array
  $brands = array();
  //retrieve available brands first
  $retrieveBrands = "SELECT brandName, dbRef FROM brands ORDER BY brandName ASC";
  $result = mysqli_query($connection, $retrieveBrands);

  while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {

    $brand_result = array(
      "brandName" => $row["brandName"],
      "dbRef" => $row["dbRef"]
    );

    array_push($brands, $brand_result);
  }

  echo json_encode($brands);
?>
