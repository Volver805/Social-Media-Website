<?php
      $query = "SELECT * FROM `users` WHERE id=".$_SESSION['id'];
      $result = mysqli_query($conn,$query);
      $user = mysqli_fetch_assoc($result);
      $user_name = $user['name'];
      $user_image = $user['image'];
      $user_username = $user['username'];
      //Show Posts 
      include 'functions.php';
      $posts = showPosts($conn,' ');
?>
<div class="animation-wrapper">
    <div class='right-component'>
        <div class="wrapper">
        <div id='user-info'>
            <img src='<?php echo $user['image'] ?>'>
            <div id='contact-info'>
                <p><?php echo $user['name'] ?></p>
                <div id="username">@<?php echo $user_username ?></div>
            </div>
        </div>
        <div class='button'>
            <span><img src='assets/icons/profile.svg'> Profile</span>
        </div>
        <div class='button'>
            <span><img src='assets/icons/person.svg'>Following</span>
        </div>
        <div class='button'>
            <span><img src='assets/icons/friends.svg'>Followers</span>
        </div>
        <div class='button' onclick='logout()'>
            <span style='color: #FF8181;'><img style='width:20px;' src='assets/icons/logout.svg'>Logout</span>
        </div>
    </div>
    <div class="post">
        <div class="header">
            <span>Post</span>
        </div>
        <textarea id="post-value"></textarea>
        <img id='post-submit' src='assets/icons/vector.svg'>
    </div>
    </div>
    </div>

    <div class="posts">
        <div class="header">
            <h1>Explore</h1>
        </div>
      <?php echo $posts ?>
    </div>
    <div class='custom-alert'>
      Post Shared
    </div>
<script src='home.js'></script>