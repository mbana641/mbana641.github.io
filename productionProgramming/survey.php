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
print '<div class="content">
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
        <div class="surveyContent">
            <form id="surveyForm" action="./completed.php" 
            onreset="toggleError(false, \'nullInputError\');" 
            onsubmit="return isValid();" 
            method="POST">
                <h2>UWSP Computing and New Media Technologies Survey</h2>
                <span id="nullInputError">All fields are required.</span>
                <div class="question email">
                <p>Email:</p>                    
                    <input type="text" id="email" name="email" autofocus>
                    <label for="email">email@domain.com</label>
                    <div class="after"></div>
                </div>
                <div class="question">
                    <p>What is your major:</p>
                    <div class="options">
                        <div class="checkContainer">
                            <input type="checkbox" id="appDev" value="AppDev" name="major">
                            <label for="appDev">CIS-AppDev</label>
                        </div>
                        <div class="checkContainer">
                            <input type="checkbox" id="networking" value="Networking" name="major">
                            <label for="networking">CIS-Networking</label>
                        </div>
                        <div class="checkContainer">
                            <input type="checkbox" id="wdmd" value="WDMD" name="major">
                            <label for="wdmd">Web and Digital Media Development</label>
                        </div>
                        <div class="checkContainer">
                            <input type="checkbox" id="wd" value="WD" name="major">
                            <label for="wd">Web Development</label>
                        </div>
                        <div class="checkContainer">
                            <input type="checkbox" id="hti" value="HTI" name="major">
                            <label for="hti">Human Technology Interaction</label>
                        </div>
                        <div class="checkContainer">
                            <input type="checkbox" id="other" value="Other" name="major">
                            <label for="other">Other</label>
                        </div>
                    </div>
                </div>
                <div class="question">
                    <p>What grade do you expect to receive in CNMT 310:</p>
                    <div class="options">
                        <div class="radioContainer">
                            <input type="radio" id="a" name="grade" value="a">
                            <label for="a">A</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="b" name="grade" value="b">
                            <label for="b">B</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="c" name="grade" value="c">
                            <label for="c">C</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="d" name="grade" value="d">
                            <label for="d">D</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="f" name="grade" value="f">
                            <label for="f">F</label>
                        </div>
                    </div>
                </div>
                <div class="question">
                    <p>What is your favorite pizza topping:</p>
                    <div class="options">
                        <div class="radioContainer">
                            <input type="radio" id="pepperoni" name="pizza" value="pepperoni">
                            <label for="pepperoni">Pepperoni</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="anchovies" name="pizza" value="anchovies">
                            <label for="anchovies">Anchovies</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="sausage" name="pizza" value="sausage">
                            <label for="sausage">Sausage</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="peppers" name="pizza" value="peppers">
                            <label for="peppers">Peppers</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="onion" name="pizza" value="onion">
                            <label for="onion">Onion</label>
                        </div>
                        <div class="radioContainer">
                            <input type="radio" id="mushrooms" name="pizza" value="mushrooms">
                            <label for="mushrooms">Mushrooms</label>
                        </div>
                    </div>
                </div>
                <div class="next formActions">
                    <button class="btn btn__text" type="reset">CLEAR</button>
                    <button class="btn btn__elevated" type="submit">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="./assets/javascript/scripts.js"></script>
</div>';
print $page->getBottomSection();
?>
