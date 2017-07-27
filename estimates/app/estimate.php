<?php session_start();

//Initialize set-up of libraries and defaults
if (!include_once("load.php")) die("Initialization not complete!");

$app = new AladdinRoofingApp();

if (isset($app->recCode)) {
    $html = $app->doEmail();
} elseif (isset($app->recId)) {
    $html = $app->doEstimate();
} else {
    header("Location: http://aladdinroofing.com");    
}

if($html) {
    echo $html;
} else {
    header("Location: http://aladdinroofing.com");
}

