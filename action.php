<?php
require 'dbconn.php';
require 'header.php';

$dataJson = file_get_contents('php://input');

if (!empty($dataJson)) {
    $data = json_decode($dataJson);

    switch ($data->value) {

        case 'edit':
            $sql = "UPDATE User SET username = '$data->username', email = '$data->email', phone = '$data->phone', flag = '$data->flag' WHERE id = $data->id";
            if ($conn->query($sql)) {
                echo json_encode('User Updated');
            }
            break;

        case 'delete':
            $sql = "DELETE FROM User WHERE id = '$data->id'";
            if ($conn->query($sql)) {
                echo json_encode('User Deleted');
            }
            break;

        case 'getId':
            $sql = "SELECT nid from Nursery_Owner WHERE uid = '$data->uid'";
            if ($result = mysqli_query($conn, $sql)) {
                $row = mysqli_fetch_assoc($result);
                echo json_encode($row);
            }
            break;
        case 'editProduct':
            $sql = "UPDATE Product SET pname = '$data->pname', price = $data->price, p_description= '$data->description', quantity= $data->quantity, cid = $data->cid WHERE pid = $data->pid";
            if ($conn->query($sql)) {
                echo json_encode('Product Updated');
            }
            break;

            case 'deleteProduct':
                $sql = "DELETE FROM Product WHERE pid = '$data->pid'";
                if ($conn->query($sql)) {
                    echo json_encode('Product Deleted');
                }
                break;
    }
}

mysqli_close($conn);
