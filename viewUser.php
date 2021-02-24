<?php
    require 'dbconn.php';
    require 'header.php';

    $sql = 'SELECT * FROM User';
    
    $result = mysqli_query($conn, $sql);
    $row = array();

    while($res = mysqli_fetch_assoc($result)) {
        $row[] = $res;
    }

    $result->free_result();

    echo json_encode($row);

    mysqli_close($conn);

    