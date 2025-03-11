<?php

if ($_POST["time"]) {
  date_default_timezone_set("Europe/London");
  echo json_encode(array("time" => date("H:i", time())));
} else
  header("Location: index.php");