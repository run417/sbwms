console.log('hi login');

const form = $('#login-form');
const rules = {
    username: {
        required: true,
    },
    password: {
        required: true,
    }

};

const messages = {
    username: {
        required: 'Please enter a username',
    },
    password: {
        required: 'Please enter a password',
    },
};

const formValidator = form.validate({
    submitHandler,
    rules,
    messages,
});

function submitHandler() {
    let data = form.serializeArray();
    $('#login-form :input').removeClass('is-valid');
    $('#error-message').hide(200);
    sendLoginData(data)
        .done((response) => {
            if (response.status === 2) {
                $('#error-message').empty().append(response.message);
                $('#error-message').show(200);
            } else if (response.status === 0) {
                window.location.replace(urlFor('/'));
            }
        });
    console.log(data);

}

function sendLoginData(data) {
    return $.ajax({
        url: urlFor('/login'),
        method: 'POST',
        dataType: 'json',
        data,
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}