<?php
    include 'connect.php';
   if($_FILES['image']) {
    
    $img = $_FILES["image"]["name"];
    $tmp = $_FILES["image"]["tmp_name"];
    $error_img = $_FILES["image"][“error”];
    $valid_extensions = array('jpeg', 'jpg', 'png');
    $path = 'profilepictures/';
    $ext =  strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $final_img = rand(1000,100000).$img;
    if(in_array($ext, $valid_extensions)) { 
        $path = $path.strtolower($final_img);
        if(move_uploaded_file($tmp,$path)) {
            $query = "UPDATE users SET image='".$path."' WHERE id=".$_SESSION['id'];
            $result = $conn ->query($query);
            echo "image has been uploaded";
        }
        else {
            echo'failed to Move image';
        }

    }
        else {
            echo'extention not valid';
        }
} else {
    echo 'please upload an image';
}
?>