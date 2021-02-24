<?php
    require 'dbconn.php';
    require 'header.php';

    $dataJson = file_get_contents('php://input');
    if(!empty($dataJson)){
        $data = json_decode($dataJson);
        $username = $data->username;
        $password = $data->password;

        $sql = "SELECT username, password, flag FROM User";
        $status = '';
        if($res = $conn->query($sql)) {
            while($row = $res->fetch_row()){
            if($username === $row[0] && $password === $row[1]){
                  $status = $row[2];
            } 
        }
        $res->free_result();
        echo json_encode($status);
        } else {
            http_response_code(404);
        }
        }
        
        
    mysqli_close($conn);
?>