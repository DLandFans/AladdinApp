<?php


if (!isset($_GET['id'])) {
    header("Location: /estimates/index.php");
    exit();
}

$record_id = $_GET['id'];
$record_code = $_GET['code'];


echo "RecID - " . $record_id . "<br>";
echo "RecCode - " . $record_code . "<br>";

