<?php
require_once("./assets/Template.php");
require_once("./assets/DB.class.php");
$page = new Template("CMNT Survey");
$page->addHeadElement('<link rel="stylesheet" href="./assets/styles/normalize.css">');
$page->addHeadElement('<link rel="stylesheet" type="text/css" href="./assets/styles/styles.css">');
$page->addHeadElement('<link href="https://fonts.googleapis.com/css?family=Krub|PT+Sans|Ubuntu" rel="stylesheet">');
$page->finalizeTopSection();
$page->finalizeBottomSection();

if(isset($_POST)) {
$db = new DB();
if (!$db->getConnStatus()) {
  print "An error has occurred with connection\n";
  exit;
}
print $page->getTopSection();
$inputs = array('major','grade','pizza');
$error = false;
foreach($inputs as $field) {
	if(!isset($_POST[$field])) {
		$error = true;
	}
	if(empty($_POST[$field])) {
		$error = true;
	}
}
if($error) {
	print "<p>All form fields required. Please try again.</p>";
} else {
	$major = filter_var($_POST["major"], FILTER_SANITIZE_STRING);
	$major = $db->dbEsc($major);
	$grade = filter_var($_POST["grade"], FILTER_SANITIZE_STRING);
	$grade = $db->dbEsc($grade);
	$pizza = filter_var($_POST["pizza"], FILTER_SANITIZE_STRING);
	$pizza = $db->dbEsc($pizza);
}
if(isset($_SERVER['REMOTE_ADDR'])) {
	$userip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
}
	
$sql = "INSERT INTO survey (submittime, major, expectedgrade, favetopping, userip)
	VALUES (now(),'$major','$grade','$pizza','$userip')";
	
$db->dbCall($sql);
print '
<div class="paneContainer">
<div class="pane">
<div class="homeContent">
        <h2 class="homeContent__statement">Thank you for completing the survey!</h2>
    </div>
    <div class="next">
        <a class="link" href="./index.php">
            <button class="btn btn__elevated forward">RETURN HOME</button>
        </a>
    </div>
</div>
</div>';
print $page->getBottomSection();
} else {
	print "<p>All form fields required. Please try again.</p>";
}
?>