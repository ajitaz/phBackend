<?php
     require 'dbconn.php';
     require 'header.php';

     $dataJson = file_get_contents('php://input');

    if(!empty($dataJson)){
        $data = json_decode($dataJson);

       switch($data->value){

        case 'edit' :
           $sql = "UPDATE User SET username = '$data->username', email = '$data->email', phone = '$data->phone', flag = '$data->flag' WHERE id = $data->id";
           if($conn->query($sql)){
               echo json_encode('Edited');
           }
            break; 

        case 'delete' :
            $sql = "DELETE FROM User WHERE id = '$data->id'";
            if($conn->query($sql)){
                echo json_encode('Deleted');
            }
            break;

        case 'getId':
            # sql = get nid from nurseryowner table...
            break;
            
            
       }
       
        
    }

    mysqli_close($conn);
