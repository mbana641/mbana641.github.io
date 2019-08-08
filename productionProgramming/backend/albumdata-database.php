<?php 
require_once("../assets/DB.class.php");

$postData = json_decode($_POST['data'], true);

    $db = new DB();
    if (!$db->getConnStatus()) {
        print "An error has occurred with connection\n";
        exit;
    }

    $albumName = filter_var($postData['search'], FILTER_SANITIZE_STRING);
    $albumName = $db->dbEsc($albumName);

    $query  = "SELECT * FROM album WHERE albumtitle = '$albumName' OR albumartist = '$albumName'";

    $albumResults = $db->dbCall($query);
	print json_encode($albumResults, true);
?>