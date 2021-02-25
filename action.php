<?php
     require 'dbconn.php';
     require 'header.php';

     $dataJson = file_get_contents('php://input');

    if(!empty($dataJson)){
        $data = json_decode($dataJson);

       switch($data->value){

        case 'edit' :
            echo  json_encode('why man');
            break; 

        case 'delete' :
            $sql = "DELETE FROM User WHERE id = '$data->id'";
            if($conn->query($sql)){
                echo 'true';
            }
            break;
            
            
       }
       
        
    }

    mysqli_close($conn);
