<?php
    require 'dbconn.php';
    require 'header.php';

    $dataJson = file_get_contents('php://input');
    if(!empty($dataJson)){
        $data = json_decode($dataJson);
        $sql = "INSERT INTO User(username, password ,email, flag) VALUES('$data->username', '$data->password', '$data->email', '$data->flag')";
    
        if($conn->query($sql)=== TRUE) {
            http_response_code(200);
            echo 'Success';
        } else{
            http_response_code(500);
            echo 'error';
        }
    }

    mysqli_close($conn);
?>