<?php
  require("db-connect.php");
  //store brands in an array
  $brands = array();

  //retrieve available brands first
  $retrieveBrands = "SELECT brandName FROM brands ORDER BY brandName ASC";
  $result = mysqli_query($connection, $retrieveBrands);

  while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    array_push($brands, $row["brandName"]);
  }

  echo json_encode($brands);
?>
