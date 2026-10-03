<?php

if ($_POST["time"]) {
  date_default_timezone_set(getenv("APP_TIMEZONE") ?: "America/Detroit");
  echo json_encode(array("time" => date("H:i", time())));
} else
  header("Location: index.php");