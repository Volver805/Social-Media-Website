<?php   
      include 'header.php' ;
      if($_SESSION['id']) {
      include 'home-header.html';
      $query = "SELECT * FROM `users` WHERE id=".$_SESSION['id'];
      $result = mysqli_query($conn,$query);
      $user = mysqli_fetch_assoc($result);
            if($user['username'] == NULL) {
                //if first time sign in make him enter a unique username
                include 'username.php';
            
            }

            
            else {

                
               if ($_SESSION['page'] == 'explore') {
                  include 'explore.php';
                }
                else if($_SESSION['page'] == 'myprofile') {
                  include 'myprofile.php';

                } else if($_SESSION['page'] == 'profile') {
                  include 'functions.php';
                  showProfile($conn,$_SESSION['profile']);
                }
                else if($_SESSION['page'] == 'search') {
                    include 'search.php';
                    $_SESSION['page'] = 'home'; 
                }
                else {
                  include 'home.php';
                }
              }
         
              

      }

      else {
        include 'loginPage.html';
      }
      
      include 'footer.php'; 
?>