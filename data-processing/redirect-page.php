<?php
  session_start();
  if (isset($_SESSION["redirect"])) {
    echo json_encode($_SESSION["redirect"]);
  }
?>
