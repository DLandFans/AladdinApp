<?php
header('Content-Type: application/json');

//Initialize set-up of libraries and defaults
if (!include_once("load.php")) die("Initialization not complete!");

$id = preg_replace('/[^A-Za-z0-9 ]/','',filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING, array(FILTER_FLAG_STRIP_LOW,FILTER_FLAG_STRIP_HIGH,FILTER_FLAG_NO_ENCODE_QUOTES)));
$name = preg_replace('/[^A-Za-z0-9 ]/','',filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING,array(FILTER_FLAG_STRIP_LOW,FILTER_FLAG_STRIP_HIGH,FILTER_FLAG_NO_ENCODE_QUOTES)));

//$ref = $_SERVER['HTTP_REFERER'];
//$type = $_SERVER['HTTP_X_REQUESTED_WITH'];

$ref = filter_var($_SERVER['HTTP_REFERER'], FILTER_SANITIZE_URL);
$type = filter_var($_SERVER['HTTP_X_REQUESTED_WITH'], FILTER_SANITIZE_STRING);
unset($error);

if (isset($ref)) {

    $ref = explode('/',explode('//', $ref)[1])[0];
    
    if(!in_array($ref, Defaults::$ALLOWED_SERVERS)) {
        $error[] = array( 'FATAL_ERROR' => 'Can\'t run from this server.' );
    }
} else {
    $error[] = array( 'FATAL_ERROR' => 'Can\'t be called remote.');
}

if (isset($type)) {
    if ($type != "XMLHttpRequest") {
        $error[] = array( 'FATAL_ERROR' => 'Improper call type.' );
    }
} else {
    $error[] = array( 'FATAL_ERROR' => 'Improper call type.');
}

if (isset($error)) {
    exit(json_encode($error));
}

//Ok, do your thing
$result = Knack::updateApproval($id, $name);

//$mailto = array(array(
//        'email' => 'approvals@aladdinroofing.com',
//        'name' => 'Aladdin Approvals'
//    ));

//Send notification email
//Email::sendApprovalNotification($mailto, json_decode($result));


echo $result;