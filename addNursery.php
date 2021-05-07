<?php
require 'dbconn.php';
require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? mysqli_escape_string($conn, $_POST['name']) : "";
    $description = isset($_POST['description']) ? mysqli_escape_string($conn, $_POST['description']) : "";
    $address = isset($_POST['address']) ? mysqli_escape_string($conn, $_POST['address']) : "";
    $phone = isset($_POST['phone']) ? mysqli_escape_string($conn, $_POST['phone']) : "";
    $email = isset($_POST['email']) ? mysqli_escape_string($conn, $_POST['email']) : "";
    $image = isset($_FILES['image']) ? basename($_FILES['image']['name']) : "";

    $imgsql = "INSERT INTO Image(iname) Values('$image')";
    if (mysqli_query($conn, $imgsql)) {
        http_response_code(200);
        echo "Successfully Image UPLOADED";

        $response = array();
        $upload_dir = '/home/ajit/Documents/ProjectReact/plant_hugger/public/images/';
        // $upload_dir = '/Users/crpoudyal/PlantHuggers/public/images/';
        $server_url = 'http://localhost:3000';

        if ($_FILES['image']) {
            $img_tmp_name = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];

            if ($error > 0) {
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "messege" => "Error uploading the file!"
                );
            } else {
                $upload_name = $upload_dir . $image;
                $upload_name = preg_replace('/\s+/', '-', $upload_name);

                if (move_uploaded_file($img_tmp_name, $upload_name)) {
                    $response = array(
                        "status" => "success",
                        "error" => false,
                        "message" => "File Moved successfully",
                        "url" => $server_url . "/" . $upload_name
                    );


                    $sql_id = "SELECT img_id FROM Image WHERE iname = '$image'";
                    if ($result = mysqli_query($conn, $sql_id)) {
                        http_response_code(200);
                        echo "Successfully retrive image ID";

                        $row = mysqli_fetch_assoc($result);
                        $image_id = $row['img_id'];
                        $sql = "INSERT INTO Nursery(name, address, description, phone, nur_email, img_id) VALUES('$name', '$address', '$description', '$phone','$email', $image_id)";
                        if (mysqli_query($conn, $sql)) {
                            http_response_code(200);
                            echo "Successfully Nursery Added";
                        } else {
                            http_response_code(200);
                            echo "Could NOT Add Nursery";
                        }
                    }
                } else {
                    $response = array(
                        "status" => "error",
                        "error" => true,
                        "message" => "Error Moving the file!"
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
