<?php session_start();

//Initialize set-up of libraries and defaults
if (!include_once("load.php")) die("Initialization not complete!");

$app = new AladdinRoofingApp();



if (isset($app->recCode)) {
    echo "Doing Email with id " . $app->recId . " and vaildation code " . $app->recCode;
    exit();
}
if (isset($app->recId)) {
    echo "Doing report with id " . $app->recId;
    exit();
}

header("Location: /estimates/index.php");