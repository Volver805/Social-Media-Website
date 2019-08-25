<?php
    $query = "SELECT * FROM `users` WHERE id=".$_SESSION['id'];
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    $name = strtok($row['name'],' ');
?>
<div class='username-modal'>
            <h1>Hey <?php echo $name  ?></h1>
            <p>Only one more step to access your favorite social media website</p>
    <div class='username-input'>
            <p>Enter a unique username  @</p><input id='username-field' type='text'> 
    </div>
        <span>You may also want to set a profile picture (optional)</span>
        <div class='change-image'>
      
            <img id='default-image' src='<?php if($row['image']) {echo $row['image'];} else {echo'profilepictures/default.png';} ?>'>
            <div class='upload-container'>
                <form id="form" action="ajaxupload.php" method="post" enctype="multipart/form-data">
                    <input name='image' type='file' accept="image/*" id='upload-input'> 
                    <img id='upload-button' src='assets/icons/pencil.svg'>
                </form>
            </div>
       </div>
       <p id='username-alerts'></p>
        <button id='username-submit' onclick='usernameSubmit()'>Submit</button>
        </div>

        <script>
            $('#username-field').blur(function(){
                let username = $(this).val();
                $.ajax({
                    method:'POST',
                    url:'actions.php?action=username',
                    data:`username=${username}`,
                    success: function(result) {
                        if(result == 'true') {
                            $('#username-field').css('border','1px solid #4caf50');
                            
                        }
                        else {
                            $('#username-field').css('border','1px solid #d7423c');
                       }
                    }
                });
           });
           function usernameSubmit() {
            let username = $('#username-field').val();
                $.ajax({
                    method:'POST',
                    url:'actions.php?action=usernameSubmit',
                    data:`username=${username}`,
                    success: function(result) {
                        if(result == 'true') {
                            location.reload();

                        }
                        else {
                            $('#username-field').effect("bounce",'slow',function(){$('#username-field').css('border','1px solid #d7423c');});
                       }
                    }
                });
           }

           $('#upload-button').click(() => {
                $('#upload-input').click();
        })
            $("#upload-input").change(function(){
                $.ajax({
                    method:'POST',
                    url:'Fileupload.php',
                    data:  new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,      
                    success : function(result) {
                            $('#username-alerts').html(result); 
                    }
                })
            })
        </script>      