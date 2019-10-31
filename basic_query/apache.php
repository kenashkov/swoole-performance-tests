<?php
error_reporting(E_ALL);

require_once('../conn_settings.php');

// read 1 entry from DB
$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
if($mysqli->connect_error)
{
    die("$mysqli->connect_errno: $mysqli->connect_error");
}

$stmt = $mysqli->prepare("SELECT * FROM test1");
$stmt->execute();
$result = $stmt->get_result();
$data = [];
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}
print_r($data);


