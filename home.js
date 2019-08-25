$(window).bind("load", function() {


function firstAnimation() {
    $('.post').animate({
        top:'15%',
        opacity:'1'
    },500);
}

function secondAnimation() {
$('.right-component').animate({
    top:'50%',
    opacity:'1'
},500);
}

setTimeout(firstAnimation,400)
setTimeout(secondAnimation,800);
setTimeout(firstPost,900);
setTimeout(secondPost,1200);
setTimeout(thirdPost,1500);
setTimeout(remainingPosts,1800);
setTimeout(showImages,2300);
});


function firstPost() {
    $('#post-1').animate({
        top:'0px',
        opacity:'1'
    },'slow');
}
function secondPost() {
    $('#post-2').animate({
        top:'0px',
        opacity:'1'
    },'slow');
}
function thirdPost() {
$('#post-3').animate({
    top:'0px',
        opacity:'1'
},'slow');
}
function remainingPosts() {
    $('.post-box').animate({
        opacity:'1'
    },'slow');
}
function showImages() {
    $('.post-image').css('display','block');
    $('.post-image').animate({
        left:'-200px'
    },'slow');
}
$('#post-submit').click(function() {
    let content = $('#post-value').val();
    $.ajax({
        method:'post',
        url:'actions.php?action=newPost',
        data:`content=${content}`,
        success : function(result) {
            alert(result);
        }

    })
})

$('body').on('click','.button-like',function(){
    const DOMname = $(this).parent().parent().parent().attr('data-post');
    const DOMimg = $(this).children('#icon-like');
    const DOMtext = $(this).children('label');
    const DOMthis = $(this);
        $.ajax({
        method:'post',
        url:'actions.php?action=likePost',
        data:`post=${DOMname}`,
        success:function() {
            DOMimg.attr('src','assets/icons/liked.svg')
            DOMtext.text('Liked');
            DOMthis.removeClass('button-like');
            DOMthis.addClass('button-liked')
        }
    })
})


$('body').on('click','.button-liked',function(){
    const DOMname = $(this).parent().parent().parent().attr('data-post');
    const DOMimg = $(this).children('#icon-like');
    const DOMtext = $(this).children('label');
    const DOMthis = $(this);
    $.ajax({
        method:'post',
        url:'actions.php?action=unlikePost',
        data:`p=${DOMname}`,
        success:function() {
            DOMimg.attr('src','assets/icons/like.png')
            DOMtext.text('Like');
            DOMthis.removeClass('button-liked');
            DOMthis.addClass('button-like');
    }})
})
function customAlert(text) {
    const alert = $('.custom-alert');
    alert.text(text);
    alert.fadeIn();
    setTimeout(function(){ alert.fadeOut() },2000);
}

$('body').on('click','.button-share',function(){
    const DOMname = $(this).parent().parent().parent().attr('data-post');
    const DOMtext = $(this).children('label');
    const DOMthis = $(this);
    $.ajax({
        method:'post',
        url:'actions.php?action=sharePost',
        data:`p=${DOMname}`,
        success:function(result) {
            customAlert(result);
            DOMtext.text('Shared');
            DOMthis.removeClass('button-share');
            DOMthis.addClass('button-shared');
        }
    })
})
  $('body').on('click','.button-shared',function(){
    const DOMname = $(this).parent().parent().parent().attr('data-post');
    const DOMtext = $(this).children('label');
    const DOMthis = $(this);

    $.ajax({
        method:'post',
        url:'actions.php?action=unsharePost',
        data:`p=${DOMname}`,
        success:function(result) {
            customAlert(result);
            DOMtext.text('Share');
            DOMthis.removeClass('button-shared');
            DOMthis.addClass('button-share');
        }
    })
})
let x = 0;
$('.button-comment').click(function(){
    let DOMcomment = $(this).parent().parent().siblings('.comments');
    if (x == 0 ) {
    DOMcomment.css('height','auto');
    x = 1;
    }
    else {
    DOMcomment.css('height','0');
    x = 0;
}
})

$('.comment-submit').click(function(){
    let postID = $(this).attr('data-post');
    let comment = $(this).siblings('input').val()
    $.ajax({
        method:'post',
        url:'actions.php?action=insertComment',
        data:`content=${comment}&postID=${postID}`,
        success:function(){
            location.reload();
        }
    })
})


$('body').on('click','.follow-button',function(){
    let DOMpost = $(this).attr('data-post');
    let button = $(this);
    $.ajax({
        method:'post',
        url:'actions.php?action=followUser',
        data:`post=${DOMpost}`,
        success: function() {
            button.removeClass('follow-button');
            button.addClass('followed-button');
            button.text('Followed');
        }
        
    })
})

$('body').on('click','.followed-button',function(){
    let DOMpost = $(this).attr('data-post');
    let button = $(this);

    $.ajax({
        method:'post',
        url:'actions.php?action=unfollowUser',
        data:`post=${DOMpost}`,
        success: function() {
            button.removeClass('followed-button');
            button.addClass('follow-button');
            button.text('Follow')
        }
        
    })

})

function profile() {
    $.ajax({
        method:'post',
        url:'actions.php?action=profile',
        success:function(res){
            location.reload();
        }
    })
}
function viewProfile(profile) {
    $.ajax({
        method:'post',
        url:'actions.php?action=viewProfile',
        data:`profile=${profile}`,
        success:function(result){
            location.reload();
        }
    })
}

function followerHide() {
    $('#follower').fadeOut();
    $('.wrapper').fadeIn();
}
function followingHide() {
    $('#following').fadeOut();
    $('.wrapper').fadeIn();

}
function following() {
    $('.wrapper').fadeOut();
    $('#following').fadeIn();
}
function follower() {
    $('.wrapper').fadeOut();
    $('#follower').fadeIn();
}