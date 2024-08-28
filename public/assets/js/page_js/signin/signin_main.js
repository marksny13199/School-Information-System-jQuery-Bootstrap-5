$('.toggle-password-visibility').on('click', togglePassword);

function togglePassword(){
    let passwordSelector = $('#password');
    let passwordIconSelector = $('.toggle-password-visibility');
    if(passwordIconSelector.hasClass('password-hide')){
        passwordSelector.attr('type', 'text');
        passwordIconSelector.removeClass('password-hide').addClass('password-show');
        passwordIconSelector.empty().append('<span class="far fa-eye text-900 fs--1"></span>');
    } else {
        passwordSelector.attr('type', 'password');
        passwordIconSelector.removeClass('password-show').addClass('password-hide');
        passwordIconSelector.empty().append('<span class="far fa-eye-slash text-900 fs--1"></span>');
    }
}

$('#sign-in').on('click', checkCredetials);

$('#email-password-form').on('keyup, keypress', function(e){
    if (e.key === 'Enter') { 
        e.preventDefault();
        checkCredetials();
    }
});

function checkCredetials(){
    const siginButtonsSelector = $('#sign-in');
    const formSelector = $('#email-password-form');
    $('.err-msg-div').addClass('invisible');
    $('.err-msg').removeClass('text-success').addClass('text-danger').text('');

    formSelector.removeClass('was-validated');

    if(formSelector[0].checkValidity()){
        siginButtonsSelector.attr('disabled', true).prepend('<span class="spinner-border spinner-border-sm loading-spinner" role="status" aria-hidden="true">');
        $.ajax({
            url: 'api/checkCredentials',
            type: 'POST',
            data: formSelector.serialize(), 
            dataType: 'JSON',
            success: function(response){
                $('.loading-spinner').remove();
                siginButtonsSelector.removeAttr('disabled');
                if(!response.is_success){
                    $('.err-msg').text('Incorrect email or password.');
                    $('.err-msg-div').removeClass('invisible');
                    return;
                }
                $('.err-msg').removeClass('text-danger').addClass('text-success').text('Login success.');
                $('.err-msg-div').removeClass('invisible');
            },
            error: function(error){
                $('.loading-spinner').remove();
                siginButtonsSelector.removeAttr('disabled');
                console.log(error);
                switch(error.status){
                    case 422:
                        $('.err-msg').text('*' + error.responseJSON.message);
                        $('.err-msg-div').removeClass('invisible');
                    break;
                    case 404:
                        $('.err-msg').text('*Incorrect username/password.');
                        $('.err-msg-div').removeClass('invisible');
                    break;
                    case 500:
                        $('.err-msg').text('*Internal server error.');
                        $('.err-msg-div').removeClass('invisible');
                    break;
                    default:
                        $('.err-msg').text('*Internal server error.');
                        $('.err-msg-div').removeClass('invisible');
                    break;
                }
                
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            }
        });
    } else {
        $('.err-msg').text('*Please fill up empty field/s.');
        $('.err-msg-div').removeClass('invisible');
        formSelector.addClass('was-validated');
    }
}