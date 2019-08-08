<?php
session_start();

require_once("./assets/Template.php");
$page = new Template("CMNT Survey");
$page->addHeadElement('<link rel="stylesheet" href="./assets/styles/normalize.css">');
$page->addHeadElement('<link rel="stylesheet" type="text/css" href="./assets/styles/styles.css">');
$page->addHeadElement('<link href="https://fonts.googleapis.com/css?family=Krub|PT+Sans|Ubuntu" rel="stylesheet">');
$page->finalizeTopSection();
$page->finalizeBottomSection();
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
    
        if (isset($_SESSION['roles']))
        {
            echo $User =  $_SESSION['user'];
            echo '<li><a class="link navLink" href="./logout.php"><div class="btn btn__text">LOGOUT</div></a></li>';
        }
        else
        {
            echo '<li><a class="link navLink" href="./login.php"><div class="btn btn__text">LOGIN</div></a></li>';
        }
		if (isset($_SESSION['roles']) && (in_array('admin', $_SESSION['roles']))) {
                print '<li><a class="link navLink" href="./SurveyData.php"><div class="btn btn__text">DATA</div></a></li>';
            }
print  '<li><a class="link navLink" href="./privacy.php"><div class="btn btn__text">PRIVACY</div></a></li>
        <li><a class="link navLink" href="./survey.php"><div class="btn btn__text">SURVEY</div></a></li>
		<li><a class="link navLink" href="./searchAlbums.php"><div class="btn btn__text">SEARCH</div></a></li>
    </ul>
</nav>
</header>
<div class="paneContainer">
<div class="pane">
<div class="searchContent">
    <form id="surveyForm" action="./searchResults.php"
	onsubmit="return isValidSearch();"
    method="POST">
		<h2>Search Your Favorite Album!</h2>
            <span id="nullInputError">Please enter a search keyword.</span>
            <div class="question email">                 
                <input type="text" id="search" name="search" autofocus>
                <div class="after"></div>
            </div>
	    <div class="next formActions">
                <button class="btn btn__elevated" type="submit">SEARCH</button>
            </div>
        </form>
</div>
</div>
<script src="./assets/javascript/scripts.js"></script>
</div>';
print $page->getBottomSection();
?>
