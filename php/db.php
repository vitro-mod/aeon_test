<?php

$db_connect = mysqli_connect("localhost", "root", "password", "aeon_test");

if ($db_connect === false) {

  echo json_encode(['success' => false, 'error' => 'Could not connect to database!']);
  die();
}
