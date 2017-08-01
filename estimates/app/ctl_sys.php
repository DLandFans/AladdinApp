<?php
header('Content-Type: application/json');
if(!require_once(__DIR__ . '/config/defaults.php')) die ("System defaults couldn't be loaded.");
if(!require_once(__DIR__ . '/lib/knack.php')) die("Database system couldn't be loaded.");

$id = preg_replace('/[^A-Za-z0-9 ]/','',filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING, array(FILTER_FLAG_STRIP_LOW,FILTER_FLAG_STRIP_HIGH,FILTER_FLAG_NO_ENCODE_QUOTES)));
$name = preg_replace('/[^A-Za-z0-9 ]/','',filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING,array(FILTER_FLAG_STRIP_LOW,FILTER_FLAG_STRIP_HIGH,FILTER_FLAG_NO_ENCODE_QUOTES)));

$ref = $_SERVER['HTTP_REFERER'];
$type = $_SERVER['HTTP_X_REQUESTED_WITH'];
unset($error);

if (isset($ref)) {
    $ref = split('//', $ref);
    $ref = split('/', $ref[1]);
    $ref = $ref[0];
    
    if(!in_array($ref, Defaults::$ALLOWED_SERVERS)) {
        $error[] = array( 'FATAL_ERROR' => 'Can\'t run front this server.' );
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
    unset($error);
}

//Ok, do your thing

//$data = array( $id, $name );
//
//echo json_encode($data);

echo Knack::updateApproval($id, $name);
