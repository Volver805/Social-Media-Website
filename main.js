function login() {
    let username = $('#login-username').val();
    let password = $('#login-password').val();
    $('#login-username').val('');
    $('#login-password').val('');
    $.ajax({
        method:'POST',
        url:'actions.php?action=login',
        data:`username=${username}&password=${password}`,
        success : function(result) {
            $('#login-errors').html(result);
        }
    })
}
function register() {

    //get registeration info

    let name = $('#first-name').val() + ' '+ $('#last-name').val();
    let email = $("#register-email").val();
    let password = $("#register-password").val();
    let passwordConfirm = $("#register-password-confirm").val();
    let Gender = $('input[name=gender]:checked').val();

    //register AJAX 
   
    $.ajax({
        method:'POST',
        url:'actions.php?action=register',
        data:`name=${name}&email=${email}&password=${password}&passwordConfirm=${passwordConfirm}&gender=${Gender}`,
        success : function(result) {
            if(result != '') {
                if(result.includes("Email is already used")) {
                    $('#register-errors').html("Email is already used");
                }
               else {
                $("#register-errors").html('Please Check Your info')
                if(result.includes('email')) {
                    $("#register-email").addClass('register-incorrect');
                }
                if(result.includes('password')) {
                    $('#register-password').addClass('register-incorrect');
                }
                if(result.includes('name')) {
                    $('#first-name').addClass('register-incorrect');
                    $('#last-name').addClass('register-incorrect');
                }   
                if(result.includes('passwordConfirm')) {
                    $('#register-password-confirm').addClass('register-incorrect');
                }
            }

            }
            else {
                // $('.login-register').animate({
                //     'margin-right':'-100%'
                // },300);
            }
        }
    })

}
