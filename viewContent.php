<?php
require 'dbconn.php';
require 'header.php';

$option = $_GET['option'];
switch ($option) {

    case 'category':
        $sql = 'SELECT cid, cname FROM Category';
        break;

    case 'viewUser':
        $sql = 'SELECT * FROM User';
        break;
}

$result = mysqli_query($conn, $sql);
$row = array();

while ($res = mysqli_fetch_assoc($result)) {
    $row[] = $res;
}

$result->free_result();

echo json_encode($row);

mysqli_close($conn);
