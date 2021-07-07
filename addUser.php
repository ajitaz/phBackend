<?php
    require 'dbconn.php';
    require 'header.php';

    $dataJson = file_get_contents('php://input');
    if(!empty($dataJson)){
        $data = json_decode($dataJson);
        $hash = password_hash($data->password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO User(username, password ,email, phone, role) VALUES('$data->username', '$hash', '$data->email', '$data->phone', '$data->role')";
    
        if($conn->query($sql)=== TRUE) {
            http_response_code(200);
            echo 'Success';
        } else{
            http_response_code(500);
            echo 'error';
        }
    }

    mysqli_close($conn);
