<?php
    function showProfile($conn,$profile_id) {

    $query = "SELECT * FROM users WHERE id=".$profile_id;
    $result = mysqli_query($conn,$query);
    $me = mysqli_fetch_assoc($result);

    //get posts
      $query = "SELECT * FROM posts WHERE user = '".$me['id']."' OR id IN (SELECT post FROM shares WHERE user='".$me['id']."') ORDER BY date DESC";
      $result = mysqli_query($conn,$query);
      $posts = '';
      while($row = mysqli_fetch_assoc($result)) {
          $content = $row['content'];
          $id = $row['id'];
          $user_query = 'SELECT * FROM users WHERE id='.$row['user'];
          $post_user = mysqli_query($conn,$user_query);
          $post_user = mysqli_fetch_assoc($post_user);
          $user_name = $post_user['name'];
          $username = $post_user['username'];
          $user_image = $post_user['image'];
          $likes_query = 'SELECT * FROM likes WHERE post='.$id;
          $likes_query = mysqli_query($conn,$likes_query);
          $likes_num = mysqli_num_rows($likes_query);
          //check if liked
          $likes_sql = 'SELECT * FROM likes WHERE post='.$id.' AND user='.$_SESSION['id'];
          $res = mysqli_query($conn,$likes_sql);
          if(mysqli_num_rows($res) == 0) {
              $like = "<div class=\"button-like\">
              <img id='icon-like' src=\"assets/icons/like.png\">
              <label for=\"icon-like\">Like</label>
          </div>"; }
           else {
              $like = "<div class=\"button-liked\">
              <img id='icon-like' src=\"assets/icons/liked.svg\">
              <label for=\"icon-like\">Liked</label>
          </div>";
          }
          //check if shared 
          $likes_sql = 'SELECT * FROM shares WHERE post='.$id.' AND user='.$_SESSION['id'];
          $res = mysqli_query($conn,$likes_sql);
          if(mysqli_num_rows($res) == 0) {
              $share = "<div class=\"button-share\">
              <img id='icon-like' src=\"assets/icons/share.png\"> 
              <label for=\"icon-like\">Share</label>
          </div>";
          }
           else {
               $share = "<div class=\"button-shared\">
               <img id='icon-like' src=\"assets/icons/share.png\"> 
               <label for=\"icon-like\">Shared</label>
              </div>";
          }
          //get comments 
          $comment_sql = "SELECT * FROM comments WHERE post='$id'";
          $comment_result = mysqli_query($conn,$comment_sql);
          $comments = '';       
          while($comment_row = mysqli_fetch_assoc($comment_result)) {
              $comment_user = "SELECT * FROM users WHERE id=".$comment_row['user'];
              $comment_user = mysqli_query($conn,$comment_user);
              $comment_user_info = mysqli_fetch_assoc($comment_user);
              $comments .= "<div class='comment'>
              <div class='comment-user-info'>
                  <p>".$comment_user_info['name']."<span> @".$comment_user_info['username']."</span></p>
              </div>
              <p>". $comment_row['comment'] ."</p>
          </div>"; 
          }
          //check if followed 
          $follow_sql = "SELECT * FROM isfollowing WHERE follower=".$_SESSION['id']." AND following = ".$row['user'];
          $follow_res = mysqli_query($conn,$follow_sql);
          if(mysqli_num_rows($follow_res) == 0) {
              $follow = "<span class='follow-button' data-post=".$row['user'].">Follow</span>";
          }
          else {
              $follow = "<span class='followed-button' data-post=".$row['user'].">Followed</span>";
          }
          $posts .=  
          "<div class=\"post-box\" data-post='$id'>
          <div class=\"name\">$user_name<span class='username'>@$username</span></div>
          <p class='post-content'> $content </p>
          <div class=\"post-box-bottom\">
          <div class=\"buttons\">
            $like
              <div class=\"button-comment\">
              <img id='icon-like' src=\"assets/icons/comment.png\" >
                  <label for=\"icon-like\">Comment</label>
              </div>
              $share
              </div>

              <div class=\"view\">
                  <span>$likes_num Likes</span>
                  $follow
          </div>
          </div>
          <div class='comments'>
          $comments
          <div class='comment-input'>
                <input type='text' placeholder='write comment..'>
                <button class='comment-submit' data-post='$id'>Send</button>
          </div>
              </div>
      </div>";
        }

?>

<div class="profile">
    <div class="top-header">
        <img src="<?php echo $me['image']?>">
        <div class='info'>
        <p class='name'>    <?php echo $me['name']?>
</p>
        <p class='username'>@<?php echo $me['username']?>
</p>
        </div>
        <span class='gender'><?php echo $me['gender']?></span>
    </div>
        
<div class='my-posts'>
<?php echo $posts; ?>

</div>
</div>
<script src='home.js'></script>
    <?php  } 
    /* WHERE user IN (SELECT following FROM isfollowing WHERE follower='".$_SESSION['id']."') */
function showPosts($conn,$closure) {
    $query = "SELECT * FROM posts $closure ORDER BY date DESC";
    $result = mysqli_query($conn,$query);
    $i = 1;
    $posts = '';
    while($row = mysqli_fetch_assoc($result)) {
        $content = $row['content'];
        $id = $row['id'];
        $user_query = 'SELECT * FROM users WHERE id='.$row['user'];
        $post_user = mysqli_query($conn,$user_query);
        $post_user = mysqli_fetch_assoc($post_user);
        $user_name = $post_user['name'];
        $username = $post_user['username'];
        $user_image = $post_user['image'];
        $likes_query = 'SELECT * FROM likes WHERE post='.$id;
        $likes_query = mysqli_query($conn,$likes_query);
        $likes_num = mysqli_num_rows($likes_query);
        //check if liked
        $likes_sql = 'SELECT * FROM likes WHERE post='.$id.' AND user='.$_SESSION['id'];
        $res = mysqli_query($conn,$likes_sql);
        if(mysqli_num_rows($res) == 0) {
            $like = "<div class=\"button-like\">
            <img id='icon-like' src=\"assets/icons/like.png\">
            <label for=\"icon-like\">Like</label>
        </div>"; }
         else {
            $like = "<div class=\"button-liked\">
            <img id='icon-like' src=\"assets/icons/liked.svg\">
            <label for=\"icon-like\">Liked</label>
        </div>";
        }
        //check if shared 
        $likes_sql = 'SELECT * FROM shares WHERE post='.$id.' AND user='.$_SESSION['id'];
        $res = mysqli_query($conn,$likes_sql);
        if(mysqli_num_rows($res) == 0) {
            $share = "<div class=\"button-share\">
            <img id='icon-like' src=\"assets/icons/share.png\"> 
            <label for=\"icon-like\">Share</label>
        </div>";
        }
         else {
             $share = "<div class=\"button-shared\">
             <img id='icon-like' src=\"assets/icons/share.png\"> 
             <label for=\"icon-like\">Shared</label>
            </div>";
        }
        //get comments 
        $comment_sql = "SELECT * FROM comments WHERE post='$id'";
        $comment_result = mysqli_query($conn,$comment_sql);
        $comments = '';       
        while($comment_row = mysqli_fetch_assoc($comment_result)) {
            $comment_user = "SELECT * FROM users WHERE id=".$comment_row['user'];
            $comment_user = mysqli_query($conn,$comment_user);
            $comment_user_info = mysqli_fetch_assoc($comment_user);
            $comments .= "<div class='comment'>
            <div class='comment-user-info'>
                <p>".$comment_user_info['name']."<span> @".$comment_user_info['username']."</span></p>
            </div>
            <p>". $comment_row['comment'] ."</p>
        </div>"; 
        }
        //check if followed 
        $follow_sql = "SELECT * FROM isfollowing WHERE follower=".$_SESSION['id']." AND following = ".$row['user'];
        $follow_res = mysqli_query($conn,$follow_sql);
        if(mysqli_num_rows($follow_res) == 0) {
            $follow = "<span class='follow-button' data-post=".$row['user'].">Follow</span>";
        }
        else {
            $follow = "<span class='followed-button' data-post=".$row['user'].">Followed</span>";
        }
        $posts .=  
        "<div class=\"post-box\" id='post-$i' data-post='$id'>
        <img src='$user_image' class='post-image'>
        <div onclick=\"viewProfile(".$row['user'].")\" class=\"name\">$user_name<span class='username'>@$username</span></div>
        <p class='post-content'> $content </p>
        <div class=\"post-box-bottom\">
        <div class=\"buttons\">
          $like
            <div class=\"button-comment\">
            <img id='icon-like' src=\"assets/icons/comment.png\" >
                <label for=\"icon-like\">Comment</label>
            </div>
            $share
            </div>

            <div class=\"view\">
                <span>$likes_num Likes</span>
                $follow
        </div>
        </div>
        <div class='comments'>
        $comments
        <div class='comment-input'>
              <input type='text' placeholder='write comment..'>
              <button class='comment-submit' data-post='$id'>Send</button>
        </div>
            </div>
    </div>";
    $i++;
    }
    return $posts;
}


    function getFollowing($conn) {
        $user = $_SESSION['id'];
        $sql = "SELECT * FROM users WHERE id IN (SELECT following FROM isfollowing WHERE follower=$user)";
        $result = mysqli_query($conn,$sql);
        $users = '';
        while($row = mysqli_fetch_assoc($result)) {
            $follower_image = $row['image'];
            $follower_name = $row['name'];
            $follower_username = $row['username'];
            $users.= "<div class='follower'>
            <img src='$follower_image'>
            <div class='follower-info'>
                <p class='name'>$follower_name</p>
                <p class='username'>@$follower_username</p>
            </div>
            <div class='gray'></div>
        </div>"; 
         }
        return $users;
    }
    function getFollowers($conn) {
        $user = $_SESSION['id'];
        $sql = "SELECT * FROM users WHERE id IN (SELECT follower FROM isfollowing WHERE following=$user)";
        $result = mysqli_query($conn,$sql);
        $users = '';
        while($row = mysqli_fetch_assoc($result)) {
            $follower_image = $row['image'];
            $follower_name = $row['name'];
            $follower_username = $row['username'];
            $users.= "<div class='follower'>
            <img src='$follower_image'>
            <div class='follower-info'>
                <p class='name'>$follower_name</p>
                <p class='username'>@$follower_username</p>
            </div>
            <div class='gray'></div>
        </div>"; 
         }
        return $users;
    }
    ?>
