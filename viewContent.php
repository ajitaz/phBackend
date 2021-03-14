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

    case 'viewNursery':
        $sql = 'SELECT * FROM Nursery NATURAL JOIN Image';
        break;

    case 'viewProduct':
        $sql = 'SELECT pid, pname, p_description, price, quantity, iname, cname FROM Product NATURAL JOIN Image NATURAL JOIN Category';
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
