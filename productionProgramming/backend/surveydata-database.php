<?php
require_once("../assets/DB.class.php");

$db = new DB();

if (!$db->getConnStatus()) {
  print "An error has occurred with connection\n";
  exit;
}

$query = "SELECT * FROM survey";

$result = $db->dbCall($query);

print json_encode($result, true);