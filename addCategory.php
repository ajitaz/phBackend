<?php
require 'dbconn.php';
require 'header.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $cname = isset($_POST['cname']) ? (mysqli_real_escape_string($conn, $_POST['cname'])) : "";
    $description = isset($_POST['description']) ? (mysqli_real_escape_string($conn, $_POST['description'])) : "";
    $image = isset($_FILES['image']) ? basename($_FILES["image"]["name"]) : "";


    $isql = "INSERT INTO Image(iname) VALUES('$image')";
    if (mysqli_query($conn, $isql)) {
        http_response_code(200);
        echo 'Successfuly uploaded image in database';
        $response = array();
        $upload_dir = '/home/ajit/Documents/ProjectReact/plant_hugger/public/images/';
        // $upload_dir = '/Users/crpoudyal/PlantHuggers/public/images/';
        $server_url = 'http://localhost:3000';

        if ($_FILES['image']) {
            $image_name = $_FILES["image"]["name"];
            $image_tmp_name = $_FILES["image"]["tmp_name"];
            $error = $_FILES["image"]["error"];

            if ($error > 0) {
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "Error uploading the file!"
                );
            } else {
                $upload_name = $upload_dir . $image_name;
                $upload_name = preg_replace('/\s+/', '-', $upload_name);

                if (move_uploaded_file($image_tmp_name, $upload_name)) {
                    $response = array(
                        "status" => "success",
                        "error" => false,
                        "message" => "File uploaded successfully",
                        "url" => $server_url . "/" . $upload_name
                    );

                    $sql_id = "SELECT img_id FROM Image WHERE iname = '$image'";
                    if ($result = mysqli_query($conn, $sql_id)) {
                        http_response_code(200);
                        echo 'Successfully retrive image ID';
                        $row = mysqli_fetch_assoc($result);
                        $image_id = $row['img_id'];
                        $sql = "INSERT INTO Category(cname, description, c_img_id) VALUES('$cname', '$description', $image_id)";
                        if (mysqli_query($conn, $sql)) {
                            http_response_code(200);
                            echo 'Successfully inserted Category in database';
                        }
                        else{
                            http_response_code(400);
                        }
                    }
                } else {
                    $response = array(
                        "status" => "error",
                        "error" => true,
                        "message" => "Error uploading the file!"
                    );
                }
            }
        } else {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "No file was sent!"
            );
        }

        echo json_encode($response);
    } else {
        http_response_code(500);
        echo 'error in database';
    }
}
mysqli_close($conn);