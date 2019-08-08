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

print '
<div class="content">
<header id="header">
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
        <div class="privacyContent">
            <h1 class="privacyContent__title">Privacy Policy</h1>
            <p class="privacyContent__mission">
                The University of Wisconsin System Administration (UWSA) recognizes the importance of
                protecting the privacy of
                information provided to us.
            </p>
            <hr>
            <h2>Personal information</h2>
            <p>
                We will use personal information that you provide via e-mail or through other online means only
                for purposes necessary to serve your needs, such as responding to an inquiry
                or other request for information. This may involve redirecting your inquiry
                or comment to another person or department better suited to meeting your needs.
            </p>
            <p>
                Some webpages at UWSA may collect personal information about visitors and use that information
                for purposes other than those stated above. Each webpage that collects
                information will have a separate privacy statement that will tell you how
                that information is used.
            </p>
            <h2>Collected Information</h2>
            <p>
                UWSA monitors network traffic for the purposes of site management and security.
                We use this information to help diagnose problems and carry out other
                administrative tasks. We also use statistic information to determine
                which information is of most interest to users, to identify
                system problem areas, or to help determine technical requirements.
                The server log information does not include personal information.
            </p>
            <h2>External websites</h2>
            <p>
                This site contains links to other sites outside of UWSA. UWSA is not
                responsible for the privacy practices or the content of such websites.
            </p>
            <h2>Questions</h2>
            <p>
                If you have any questions about this privacy statement, the practices of
                this site, or your use of this website, please contact
            </p>

        </div>
        <div class="next">
			<form class="link" action="./survey.php">
				<button class="btn btn__elevated forward">TAKE SURVEY</button>
				<img alt="Next page arrow" class="next__icon" src="./assets/icons/baseline-navigate_next-24px.svg">
			</form>
        </div>
    </div>
</div>
</div>';

print $page->getBottomSection();
?>
