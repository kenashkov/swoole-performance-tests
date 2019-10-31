<?php
error_reporting(E_ALL);
// read 1 entry from DB

//please note the "p:" in front of the host
$mysqli = new mysqli("p:".MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
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


