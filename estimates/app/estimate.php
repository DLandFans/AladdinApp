<?php session_start();

//Initialize set-up of libraries and defaults
if (!include_once("load.php")) die("Initialization not complete!");

$app = new AladdinRoofingApp();

if (isset($app->recCode)) {
    $html = $app->displayEmail();
} elseif (isset($app->recId)) {
    $html = $app->displayEstimate();
} else {
//    header("Location: /estimates/index.php");    
}

if($html) {
    echo $html;
} else {
    header("Location: /estimates/index.php");    
}

