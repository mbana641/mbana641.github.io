<?php

require_once("assets/Template.php");
session_start();

$page = new Template("Survey Data");
$page->addHeadElement('<link rel="stylesheet" href="./assets/styles/normalize.css">');
$page->addHeadElement('<link rel="stylesheet" type="text/css" href="./assets/styles/styles.css">');
$page->addHeadElement('<link href="https://fonts.googleapis.com/css?family=Krub|PT+Sans|Ubuntu" rel="stylesheet">');
$page->finalizeTopSection();
$page->finalizeBottomSection();


if (isset($_SESSION['roles']) && (in_array('admin', $_SESSION['roles']))) {


    $url = "cnmtsrv2.uwsp.edu/~mbana641/sprint1/backend/surveydata-database.php";
    $ch = curl_init();
	
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $returnData = curl_exec($ch);
	
    $result = json_decode($returnData, true);
	
    curl_close($ch);
}


print $page->getTopSection();
print '<header id="header">
<div>
	<a class="link" href="./index.php">
		<h1 class="siteTitle">
			CNMT Survey
		</h1>
	</a>
</div>
<span class="flexSpace"></span>
<nav>
    <ul>';
        if (isset($_SESSION['user']))
        {
            echo  $_SESSION['user'];
            echo '<li><a class="link navLink" href="./logout.php"><div class="btn btn__text">LOGOUT</div></a></li>';
        }
        else
        {
            echo '<li><a class="link navLink" href="./login.php"><div class="btn btn__text">LOGIN</div></a></li>';
        }

print  '<li><a class="link navLink" href="./privacy.php"><div class="btn btn__text">PRIVACY</div></a></li>
        <li><a class="link navLink" href="./survey.php"><div class="btn btn__text">SURVEY</div></a></li>
		<li><a class="link navLink" href="./searchAlbums.php"><div class="btn btn__text">SEARCH</div></a></li>
    </ul>
</nav>
</header>
<div class="paneContainer">
<div class="pane">
<div class="SurveyDataContent">';
if (isset($_SESSION['roles']) && (in_array('admin', $_SESSION['roles']))) {
print '<br />';
print '<br />';
print '<br />';
print "<table>";
print "<tr>";
print "<th>ID</th>";
print "<th>Time</th>";
print "<th>Major</th>";
print "<th>Grade</th>";
print "<th>Topping</th>";
print "<th>IP Address</th>";
print "<th>Session ID</th>";
print "</tr>";
foreach($result as $resultArray) {
	print "<tr>";
	foreach($resultArray as $key => $value) {
		print "<td>".$value."</td>";
	}
	print "</tr>";
}
print "</table></div>
</div></div>";
} else if (isset($_SESSION['roles']) && (in_array('admin', $_SESSION['roles']) == false)) {
print '<br />
	<br />
	<h2 class="accessDenied">You do not have permission to view this page!</h2></div>
</div>';
} else if (!isset($_SESSION['roles'])) {
	print '<br />
	<br />
	<h2 class="accessDenied">Please log in to view this page!</h2></div>
</div>';
}
print $page->getBottomSection();
