<?php
require_once("assets/Template.php");
session_start();

$page = new Template("Login");
$page->addHeadElement('<link rel="stylesheet" href="./assets/styles/normalize.css">');
$page->addHeadElement('<link rel="stylesheet" type="text/css" href="./assets/styles/styles.css">');
$page->addHeadElement('<link href="https://fonts.googleapis.com/css?family=Krub|PT+Sans|Ubuntu" rel="stylesheet">');
$page->addHeadElement('<script src="./assets/javascript/scripts.js"></script>');
$page->finalizeTopSection();
$page->finalizeBottomSection();
print $page->getTopSection();


if(isset($_POST["username"]) && isset($_POST["password"])){

    $dataJson = json_encode($_POST);
    $postString = "data=" . urlencode($dataJson);
    $contentLength = strlen($postString);

    $header = array(
    'Content-Type: application/x-www-form-urlencoded',
    'Content-Length: ' . $contentLength
    );

    $url = "cnmtsrv2.uwsp.edu/~nblon447/sprint3/backend/post-authentication.php";
    $ch = curl_init();

    curl_setopt($ch,
        CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch,
        CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch,
        CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $returnData = curl_exec($ch);
    $response = json_decode($returnData, true);
    
    if (!empty($response)) {        
        if ($response['status'] == 'success') {
            $_SESSION['user'] = $response['user'];
            $_SESSION['roles'] = $response['roles'];
        } else {
            $userMessage = $response['message'];
        }
    } else {
        $userMessage = 'An error has occured. Please try again.';
    }

    curl_close($ch);
}
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
            if (isset($_SESSION['user']))
            {
                echo $User = $_SESSION['user'];
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
            <div class="loginContent">';

    
if (isset($_SESSION['user'])) {
    print '<div class="homeContent">
    <h2 class="homeContent__statement">Welcome ' . $_SESSION['user'] . '</h2>
    <hr>
    </div>
    <div class="next">
        <form class="link" action="./index.php">
            <button class="btn btn__elevated forward">Home</button>
            <img alt="Next page arrow" class="next__icon" src="./assets/icons/baseline-navigate_next-24px.svg">
        </form>
    </div>';
} else {
        if(isset($userMessage)) {
            print '<span id="nullInputError" style="display: block;">' . $userMessage . '</span>';
        }
        print '<form name="loginForm"  onsubmit="return validateLogin()" action="./login.php" method="post"  class="question login_element">
            Username: <input type="text" name="username" id="username" autofocus >
			<div class="after"></div>
			
			<br />
			
			Password: <input type="password" name="password" autofocus >
			<div class="after"></div>
			
			<br />
			
			
			<input type="submit" value="LOGIN" id="login_btn_div" class="btn btn__elevated login_btn" >
			
            </form>	
            ';
}
'</div>
</div>
</div>
<script src="./assets/javascript/scripts.js"></script>
</div>';
print $page->getBottomSection();

?>