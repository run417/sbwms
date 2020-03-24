$('#employee-shift-start').timepicker({
    disableTextInput: true,
    timeFormat: 'H:i',
    scrollDefault: '08:00',
});
$('#employee-shift-end').timepicker({
    disableTextInput: true,
    timeFormat: 'H:i',
    scrollDefault: '17:00',
});
$('#employee-date-joined').datepicker({
    format: 'yyyy-mm-dd',
});

$('#employee-telephone').inputmask('+\\94-99-999-9999');

const employeeForm = $('#edit-employee');
const employeeRole = $('#employee-role');
const employeeId = $('#employee-info').data('employee-id');
employeeRole.on('change', toggleCrewOptions);
// hideCrewOptions();
$(window).on('load', toggleCrewOptions);


function toggleCrewOptions() {
    // let employeeRole = $('#employee-role');
    if (employeeRole.val() === '104') {
        $('#crew-options').show(500);
    } else {
        $('#crew-options').hide(500);
    }
}

function hideCrewOptions() {
    $('#crew-options').hide();
}

let serviceTypes = [];

/* start validation */
$.validator.addMethod('maxDate', (value, element) => (new Date(value)) <= (new Date()));
const rules = {
    // firstName: {
    //     required: true,
    //     maxlength: 255,
    // },
    // lastName: {
    //     required: true,
    //     maxlength: 255,
    // },
    nic: {
        required: true,
        // remote: {
        //     url: urlFor('/employee/is-nic-unique'),
        //     data: {
        //         username: () => $('#username').val(),
        //     },
        //     type: 'GET',
        // },
    },
    // telephone: {
    //     required: true,
    // },
    // email: {
    //     required: true,
    // },
    role: {
        required: true,
    },
    dateJoined: {
        required: true,
        dateISO: true,
        maxDate: true,
    },
    shiftStart: {
        required: {
            required: true,
            depends: elem => $('#employee-role').val() === '104',
        },
    },
    shiftEnd: {
        required: {
            required: true,
            depends: elem => $('#employee-role').val() === '104',
        },
    },
    'serviceTypes[]': {
        required: {
            required: true,
            depends: elem => $('#employee-role').val() === '104',
        },
    },
};

const messages = {
    firstName: {
        required: 'Please enter employee\'s first name',
        minlength: 'First name should be more than a character',
    },
    lastName: {
        required: 'Please enter employee\'s last name',
        minlength: 'Last name should be more than a character',
    },
    telephone: {
        required: 'Please enter employee\'s telephone number',
    },
    email: {
        required: 'Please enter employee\'s email',
    },
    dateJoined: {
        required: 'Please enter the date this employee joined the centre',
        maxDate: 'Date joined should be a past or the current date',
    },
    'serviceTypes[]': {
        required: 'Please select this employee\'s perfoming service types',
    },
};

const formValidator = employeeForm.validate({
    submitHandler,
    rules,
    messages,
});

/* end formValidator */

function sendEmployeeData(data) {
    return $.ajax({
        url: urlFor('/employee/edit'),
        method: 'POST',
        dataType: 'json',
        data,
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function employeeUpdateFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Success!',
            text: ` Employee '${id} - ${name}' Updated Successfully`,
            onAfterClose: () => {
                window.location.replace(urlFor('employee'));
            },
        });
    } else if (code === 1) {
        let errors = response.errors;
        swalB.fire({
            type: 'error',
            title: 'Validation Error!',
            text: 'Data not Valid. Please enable javascript',
            onAfterClose: () => {
                window.scrollTo(0, 0);
            },
        });
        $('#form-errors').remove();
        let errorContainer = '<div id=\'form-errors\'></div>';
        $('.form-info').after(errorContainer);
        $('#form-errors').append('<p>Frontend Validation Failure</p><ul></ul>');
        $.each(errors, (i) => {
            $('#form-errors ul').append(`<li>${errors[i]}</li>`);
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating employee',
        });
    }
}

function submitHandler() {
    let data = $(employeeForm).serializeArray();
    data.push({
        name: 'employeeId',
        value: employeeId,
    });
    console.log(data);
    sendEmployeeData(data)
        .done((response) => {
            employeeUpdateFeedback(response);
        });
}
/* end submitHandler */
