<?php
error_reporting(E_ALL);
// read 1 entry from DB

if (!file_exists('./files')) {
    mkdir('./files');
}

for ($aa = 0; $aa < 10000; $aa++) {
    $data = apcu_fetch('test1_data', $success);
    if (!$success) {

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

        apcu_add('test1_data', $data);
    }
}

//write some files
$file_content = 'some content here';
for( $aa = 0; $aa < 10; $aa++) {
    $file_name = './files/apache'.$aa.'.txt';
    file_put_contents($file_name, $file_content);
}

//read some files
for( $aa = 0; $aa < 10; $aa++) {
    $file_name = './files/apache'.$aa.'.txt';
    $file_content = file_get_contents($file_name);
}

print_r($data);

