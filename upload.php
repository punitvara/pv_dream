<?php
//include ('connect.php');

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'pv_data';

echo "database to connect";

// 1. Create a database connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

extract($_POST);
$uploadOk = 1;
$target_path = "uploads/";
$test = "hello";
$target_file= $target_path . basename( $_FILES['uploadedfile']['name']);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["uploadedfile"]["name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
$return_arr = array();
// Check file size
if ($_FILES["uploadedfile"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_file)) {
          echo "The file ". basename( $_FILES['uploadedfile']['name']).
                " has been uploaded";
          //  $QueryInsertFile = "INSERT INTO container ('id', 'ImageColumnName') values ('NULL', '$test')";
             $QueryInsertFile = "INSERT INTO container SET ImageColumnName= '$target_file'";

            $result_set = mysqli_query($connection, $QueryInsertFile);

            if ($result_set) {
              echo "REcord success";
            } else {
               echo "NOT SUCESS";
            }

            $fetch = mysqli_query($connection, "SELECT * FROM container");

            if ($result_set) {
                while ($row = mysqli_fetch_assoc($fetch)) {
                      $row_array['id'] = $row['id'];
                      $row_array['ImageColumnName'] = $row['ImageColumnName'];

                      array_push($return_arr,$row_array);
              }

              echo json_encode($return_arr);
            }

    } else{
          echo "There was an error uploading the file, please try again!";
    }
}
?>
