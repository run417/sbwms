const form = $('#operating-day-time');
$('input[name^=\'open\']').timepicker({
    disableTextInput: true,
    timeFormat: 'H:i',
    scrollDefault: '08:00',
});

$('input[name^=\'close\']').timepicker({
    disableTextInput: true,
    timeFormat: 'H:i',
    scrollDefault: '17:00',
});


const rules = {
    'open[monday]': {
        required: {
            required: true,
            depends: elem => ($('#monday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'close[monday]': {
        required: {
            required: true,
            depends: elem => ($('#monday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'open[tuesday]': {
        required: {
            required: true,
            depends: elem => ($('#tuesday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'close[tuesday]': {
        required: {
            required: true,
            depends: elem => ($('#tuesday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'open[wednesday]': {
        required: {
            required: true,
            depends: elem => ($('#wednesday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'close[wednesday]': {
        required: {
            required: true,
            depends: elem => ($('#wednesday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'open[thursday]': {
        required: {
            required: true,
            depends: elem => ($('#thursday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'close[thursday]': {
        required: {
            required: true,
            depends: elem => ($('#thursday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'open[friday]': {
        required: {
            required: true,
            depends: elem => ($('#friday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'close[friday]': {
        required: {
            required: true,
            depends: elem => ($('#friday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'open[saturday]': {
        required: {
            required: true,
            depends: elem => ($('#saturday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'close[saturday]': {
        required: {
            required: true,
            depends: elem => ($('#saturday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'open[sunday]': {
        required: {
            required: true,
            depends: elem => ($('#sunday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'close[sunday]': {
        required: {
            required: true,
            depends: elem => ($('#sunday').prop('checked') === true) && ($('#default').prop('checked') === false),
        },
    },
    'open[default]': {
        required: {
            required: true,
            depends: elem => $('#default').prop('checked') === true,
        },
    },
    'close[default]': {
        required: {
            required: true,
            depends: elem => $('#default').prop('checked') === true,
        },
    },
};

const validator = form.validate({
    rules,
    submitHandler,
});

function submitHandler() {
    let data = form.serializeArray();
    console.log(data);
    sendData(data)
        .done((response) => {
            updateFeedback(response);
        });
}

function sendData(data) {
    return $.ajax({
        method: 'POST',
        data,
        dataType: 'json',
        url: urlFor('centre/working/update'),
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function updateFeedback(response) {
    let code = response.status;
    if (code === 0) {
        swalB.fire({
            type: 'success',
            title: 'Suceess!',
            text: 'Business Hours Updated Successfully',
            onAfterClose: () => { window.location.reload(); },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating business times',
        });
    }
}
