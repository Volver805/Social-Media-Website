<?php
    include 'connect.php';

    //regsteration handling 


    if($_GET['action'] == 'register') {
      // Email Validation      
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $err .= ('email');
        }
    //Name lenght 

        if (strlen($_POST['name']) > 40 || strlen($_POST['name']) < 6) {
            $err .=('name');
        }

    //Password length 
        if (strlen($_POST['password']) > 30 || strlen($_POST['password']) < 5) {
            $err .= ('password');
        }
    
    //Password confirm Check 
        if ($_POST['password'] !== $_POST['passwordConfirm']) {
            $err .= ('passwordConfirm');
        }
    
        if($err) {
            echo $err;
        } else {
                $name = mysqli_real_escape_string($conn,$_POST['name']);
                $email = mysqli_real_escape_string($conn,$_POST['email']);
                $password = mysqli_real_escape_string($conn,$_POST['password']);
                $password = password_hash($password,PASSWORD_DEFAULT);
                $gender = mysqli_real_escape_string($conn,$_POST['gender']);
              

                //Check if email exists already 
                $query = "SELECT * FROM users WHERE email='".$email."'";
                $result = mysqli_query($conn,$query);
                $row = mysqli_fetch_assoc($result);
                if(mysqli_num_rows($result) != 0) {
                    echo "Email is already used";
                } 

                //if correct insert info into the database 
                else {
                $query = "INSERT INTO users(`name`,`email`,`password`,`gender`) VALUES('".$name."','".$email."','".$password."','".$gender."')";
                $result = mysqli_query($conn,$query);
           }
        }

    }


    //Login handling
    if($_GET['action'] == 'login') {
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        if(strlen($username) < 1) {
            echo "Please enter a username or email";
        } else if (strlen($password) < 1 ) {
            echo "Please enter a password";
        }
        else {
            $query = "SELECT * FROM users WHERE email='".$username."'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) < 1) {
                echo "The info you entered is invalid";
            } else {
                $row = mysqli_fetch_assoc($result);
                if(password_verify($password,$row['password'])) {
                    echo "success";
                }
                else {
                    echo "The info you entered is invalid"; 
                }
            }


        }
    }
 
?>