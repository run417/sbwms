const findProfileBtn = $('#find-profile');
const clearProfileBtn = $('#clear-profile');
const findProfileModal = $('#findProfileModal');
const selectUserRole = $('#user-role');
findProfileBtn.on('click', showProfileModal);
clearProfileBtn.on('click', clearSelectedProfile);
selectUserRole.on('change', clearAndReloadProfiles);
findProfileModal.on('hidden.bs.modal', isProfileSelected);
$('#user-submit').on('click', isProfileSelected);

// function showHidePassword() {
//     (x.type === 'password') ? (x.type = 'text' ) : ( x.type = 'password');
// }

function isProfileSelected() {
    $('#profileId').valid();
    if ($('#profileId').val() === '') {
        profileInvalid();
    } else {
        profileValid();
    }
}
function profileInvalid() {
    let p = $('#selected-profile');
    p.removeClass('profile-valid').addClass('profile-invalid');
}
function profileValid() {
    let p = $('#selected-profile');
    p.removeClass('profile-invalid').addClass('profile-valid');
}
function removeProfileValidationCSS() {
    $('#selected-profile').removeClass('profile-invalid profile-valid');
}

function clearAndReloadProfiles(e) {
    $('#profileId').val('');
    $('#selected-profile')
        .empty()
        .append('Click \'Find\' to select a user profile');
    removeProfileValidationCSS();
    findProfile();
}

function clearSelectedProfile(e) {
    e.preventDefault();
    $('#profileId').val('');
    $('#selected-profile')
        .empty()
        .append('Click \'Find\' to select a user profile');
    isProfileSelected();
}

function showProfileModal(e) {
    e.preventDefault();
    if ($('#user-role').valid()) {
        findProfileModal.modal('show');
    }
}

function closeProfileModal() {
    findProfileModal.modal('hide');
}

function findProfile() {
    let role = $('#user-role').val();
    if (role !== '') {
        getProfileTable(role)
            .done((profileHtmlPartial) => {
                $('#profile-table-div').empty().append(profileHtmlPartial);
                $('.select-profile').on('click', selectProfile);
                let dt = $('#profile-list-table').DataTable({
                    paging: true,
                    searching: true,
                    order: [[0, 'desc']],
                });
            });
    }
}

function selectProfile() {
    let rowId = this.parentElement.parentElement.id;
    $('#profileId').val(rowId);
    console.log($('#profileId').val());
    // below translates to row = $('#E0001')
    let row = $(`#${rowId}`);
    let string = '';
    row.children().each((i, el) => {
        if ($(el).hasClass('_dash')) {
            string += '- ';
        }
        if ($(el).hasClass('_pdata')) {
            string += `${el.textContent} `;
        }
    });
    $('#selected-profile').empty().append(string.trim());
    closeProfileModal();
}

function getProfileTable(role) {
    return $.ajax({
        method: 'GET',
        dataType: 'html',
        data: { role },
        url: urlFor('/user/no-account-profiles'),
    }).fail((jqHr, err) => {
        console.log(jqHr);
        console.log(err);
    });
}

/* start validation */
$.validator.addMethod('whiteSpaceCheck', value => (!(/\s/.test(value))), 'Spaces are not allowed');
const userForm = $('#new_user');
const formValidator = userForm.validate({
    ignore: [],
    submitHandler,
    onfocusout: (element) => { $(element).valid(); },
    rules: {
        profileId: 'required',
        userRole: 'required',
        status: 'required',
        username: {
            required: true,
            whiteSpaceCheck: true,
            minlength: 2,
            maxlength: 255,
            remote: {
                url: urlFor('/user/is-unique'),
                data: {
                    username: () => $('#username').val(),
                },
                type: 'GET',
            },
        },
        password: {
            required: true,
            minlength: 2,
            maxlength: 255,
        },
        confirmPassword: {
            required: true,
            equalTo: '#password',
        },
    },
    messages: {
        userRole: 'Please select a user role',
        confirmPassword: {
            equalTo: 'Please confirm the password',
        },
        status: 'Please set the user status',
    },
});

/* end formValidator */

function submitHandler(form) {
    let data = $(form).serializeArray();
    console.log(data);
    sumbitFormData(data)
        .done((response) => {
            if (response.status === 0) {
                successAlert();
            } else {
                failureAlert();
            }
        });
}
/* end submitHandler */

function sumbitFormData(data) {
    return $.ajax({
        url: urlFor('/user/new'),
        method: 'POST',
        dataType: 'json',
        data,
    }).fail((er) => { console.log(er); });
}

function successAlert() {
    Swal.fire({
        type: 'success',
        title: 'Success!',
        text: 'New User Created',
        background: '#ceebfd',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-success',
        },
        onAfterClose: () => {
            window.location.replace(urlFor('/user'));
        },
    });
}
function failureAlert() {
    Swal.fire({
        type: 'error',
        title: 'Failure!',
        text: 'User Creation Failed',
        background: '#ceebfd',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-success',
        },
        onAfterClose: () => {
        },
    });
}
