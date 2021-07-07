<?php
    require 'dbconn.php';
    require 'header.php';

    $dataJson = file_get_contents('php://input');
    if(!empty($dataJson)){
        $data = json_decode($dataJson);
        $username = $data->username;
        $password = $data->password;

        $sql = "SELECT id, username, password, role FROM User";
        $status = array();
        if($res = $conn->query($sql)) {
            while($row = $res->fetch_row()){
            if($username === $row[1] && password_verify($password,$row[2])){
                  $status = array(
                      'id' => $row[0],
                      'role' => $row[3],
                      'uname' => $row[1]
                  );
                  break;
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