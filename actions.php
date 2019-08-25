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
                  $query = "INSERT INTO users(`name`,`email`,`password`,`gender`,`image`) VALUES('".$name."','".$email."','".$password."','".$gender."','profilepictures/default.png')";
                    $result = mysqli_query($conn,$query);
                    $query = "SELECT id FROM `users` WHERE email='".$email."'";
                $res = mysqli_query($conn,$query);
                $id = mysqli_fetch_assoc($res);
                $_SESSION['id'] = $id['id']; 
                echo 'success';
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
            $query = "SELECT * FROM users WHERE email='".$username."' OR username='".$username."'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) < 1) {
                echo "The info you entered is invalid";
            } else {
                $row = mysqli_fetch_assoc($result);
                if(password_verify($password,$row['password'])) {
                    $query = "SELECT id FROM `users` WHERE email='".$username."' OR username='".$username."'";
                    $res = mysqli_query($conn,$query);
                    $id = mysqli_fetch_assoc($res);
                    $_SESSION['id'] = $id['id']; 
                    echo 'success';
                }
                else {
                    echo "The info you entered is invalid";  
                }
            }


        }
    }
    

    //username check
    if($_GET['action'] == 'username') {
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        if(strlen($username) < 5) {
            echo "false";
        }
        else {
        $query = "SELECT * FROM `users` WHERE username='".$username."' COLLATE latin1_general_cs"; //COLLATE make the WHERE search case sensitive 
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($result);
        echo mysqli_error($conn);

        if(mysqli_num_rows($result) == 0) {   
            // $query = "UPDATE `users` SET username='".$username."' WHERE id=".$_SESSION['id'];
            // $result = mysqli_query($conn,$query);
            // echo mysqli_error($conn);
            echo 'true';
        } else {
            echo 'false';
        }
    }
    }

        //username check & submit
        if($_GET['action'] == 'usernameSubmit') {
            $username = mysqli_real_escape_string($conn,$_POST['username']);
            if(strlen($username) < 5) {
                echo "false";
            }
            else {
            $query = "SELECT * FROM `users` WHERE username='".$username."' COLLATE latin1_general_cs"; //COLLATE make the WHERE search case sensitive 
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            echo mysqli_error($conn);
    
            if(mysqli_num_rows($result) == 0) {   
                $query = "UPDATE `users` SET username='".$username."' WHERE id=".$_SESSION['id'];
                $result = mysqli_query($conn,$query);
                echo mysqli_error($conn);
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }


    // logout function
    if($_GET['action'] == 'logout') {
        session_destroy();
    }

    if($_GET['action'] == 'newPost') {
        $post_content = $_POST['content'];
        $post_user = $_SESSION['id'];
        $query = "INSERT INTO posts(content,user) VALUES('".$post_content."','".$post_user."')";
        $result = mysqli_query($conn,$query);
        echo mysqli_error();
    }
  
    if($_GET['action'] == 'likePost') {
        $post = $_POST['post'];
        $user = $_SESSION['id'];
        $sql = "INSERT INTO likes(post,user) VALUES('$post','$user')";
        $result = mysqli_query($conn,$sql);
        if(mysqli_error()){
            echo mysqli_error();
        }
        else {
            echo "Post shared";
        }    }
    if($_GET['action'] == 'unlikePost') {
        $post = $_POST['p'];
        $user = $_SESSION['id'];
        $sql = "DELETE FROM likes WHERE post = '$post' AND user = '$user'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_error()){
            echo mysqli_error();
        }
        else {
            echo "Post shared";
        }    }

    if($_GET['action'] == 'sharePost') {
        $post = $_POST['p'];
        $user = $_SESSION['id'];
        $sql = "INSERT INTO shares(post,user) VALUES('$post','$user')";
        $result = mysqli_query($conn,$sql);
        if(mysqli_error()){
            echo mysqli_error();
        }
        else {
            echo "Post shared";
        }    }

     if($_GET['action'] == 'unsharePost') {
            $post = $_POST['p'];
            $user = $_SESSION['id'];
            $sql = "DELETE FROM shares WHERE post = '$post' AND user = '$user'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_error()){
                echo mysqli_error();
            }
            else {
                echo "Share Removed";
            }
     }
     if($_GET['action'] == 'insertComment') {
         $content =  $_POST['content'];
         $postID = $_POST['postID'];
         $userID = $_SESSION['id'];
         $sql = "INSERT INTO comments(comment,post,user) VALUES('$content','$postID','$userID')";
         mysqli_query($conn,$sql);
         echo "error: ".mysqli_error();
    }   

    if($_GET['action'] == 'page-home') {
        $_SESSION['page'] = 'home';
        unset($_GET['profile']);
    }

    if($_GET['action'] == 'page-explore') {
        $_SESSION['page'] = 'explore';
        unset($_GET['profile']);

    }

    if($_GET['action'] == 'followUser') {
        $follower = $_SESSION['id'];
        $following = $_POST['post'];
        $sql = "INSERT INTO isfollowing(follower,following) VALUES('$follower','$following')";
        mysqli_query($conn,$sql);
        echo mysqli_error();
    }

    if($_GET['action'] == 'unfollowUser') {
        $follower = $_SESSION['id'];
        $following = $_POST['post'];  
        $sql = "DELETE FROM isfollowing WHERE follower='$follower' AND following='$following'";
        mysqli_query($conn,$sql);
    
    }

    if($_GET['action'] == 'profile') {
        $_SESSION['page'] = 'myprofile';
    }

    if($_GET['action'] == 'viewProfile') {
        $_SESSION['page'] = 'profile';
        $_SESSION['profile'] = $_POST['profile'];
    }

    
    if($_GET['action'] == 'search') {
        $_SESSION['search'] = $_POST['search'];
        $_SESSION['page'] = 'search';
    }

 ?>