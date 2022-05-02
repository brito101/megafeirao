$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('form[name="login"]').submit(function (event) {
        event.preventDefault();

        const form = $(this);
        const action = form.attr('action');
        const email = form.find('input[name="email"]').val();
        const password = form.find('input[name="password_check"]').val();

        $.post(action, {email: email, password: password}, function (response) {

            if (response.message) {
                ajaxMessage(response.message, 3);
            }

            if (response.redirect) {
                window.location.href = response.redirect;
            }
        }, 'json');

    });

    $('form[name="newAccount"]').submit(function (event) {
        event.preventDefault();

        const form = $(this);
        const action = form.attr('action');
        const name = form.find('input[name="name"]').val();
        const email = form.find('input[name="email"]').val();
        const password = form.find('input[name="password_check"]').val();

        $.post(action, {name: name, email: email, password: password}, function (response) {

            if (response.message) {
                ajaxMessage(response.message, 3);
            }

            if (response.redirect) {
                window.location.href = response.redirect;
            }
        }, 'json');

    });

    $('form[name="forgotternAccount"]').submit(function (event) {
        event.preventDefault();

        const form = $(this);
        const action = form.attr('action');
        const email = form.find('input[name="email"]').val();

        $.post(action, {email: email}, function (response) {

            if (response.message) {
                ajaxMessage(response.message, 3);
            }

            if (response.redirect) {
                window.location.href = response.redirect;
            }
        }, 'json');

    });

    $('form[name="resetAccount"]').submit(function (event) {
        event.preventDefault();

        const form = $(this);
        const action = form.attr('action');
        const password = form.find('input[name="password_check"]').val();

        $.post(action, {password: password}, function (response) {

            if (response.message) {
                ajaxMessage(response.message, 3);
            }

            if (response.redirect) {
                window.location.href = response.redirect;
            }
        }, 'json');

    });

    // AJAX RESPONSE
    var ajaxResponseBaseTime = 3;

    function ajaxMessage(message, time) {
        var ajaxMessage = $(message);

        ajaxMessage.append("<div class='message_time'></div>");
        ajaxMessage.find(".message_time").animate({"width": "100%"}, time * 1000, function () {
            $(this).parents(".message").fadeOut(200);
        });

        $(".ajax_response").append(ajaxMessage);
    }

    // AJAX RESPONSE MONITOR
    $(".ajax_response .message").each(function (e, m) {
        ajaxMessage(m, ajaxResponseBaseTime += 1);
    });

    // AJAX MESSAGE CLOSE ON CLICK
    $(".ajax_response").on("click", ".message", function (e) {
        $(this).effect("bounce").fadeOut(1);
    });
});

//Login Validate
var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");

if (password && confirm_password) {
    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Senhas não conferem!");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
}