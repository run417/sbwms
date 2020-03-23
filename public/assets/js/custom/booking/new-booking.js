// requires jQuery

// const service = $('#serviceType');
const service = document.querySelector('#serviceType');
const timeSlot = document.querySelector('#timeSlot');
const vehicle = document.querySelector('#vehicle');
const createBookingBtn = document.querySelector('#createBooking');
const confirmBookingBtn = document.querySelector('#confirmBooking');
// const cancelBookingBtn = document.querySelector('#cancelBooking');
// const holdBookingBtn = document.querySelector('#holdBooking');
$('#vehicle').chosen();
// $('#timeSlot').on('click', emptyTimeSlotFeeback);


service.addEventListener('change', onServiceSelect);
timeSlot.addEventListener('click', emptyTimeSlotFeeback);
createBookingBtn.addEventListener('click', createBooking);
confirmBookingBtn.addEventListener('click', confirmBooking);
// cancelBookingBtn.addEventListener('click', cancelBooking);
// holdBookingBtn.addEventListener('click', holdBooking);


function confirmBooking() {
    let bookingId = ($('#booking-id').data('booking-id'));
    $.ajax({
        method: 'POST',
        dataType: 'json',
        data: { bookingId },
        url: urlFor('/booking/confirm'),
    }).fail((jqHr, err) => {
        console.log(jqHr, err);
    }).done((response) => {
        console.log(response);
        confirmBookingFeedback(response);
    });
    // console.log('confirming booking...');
}

function cancelBooking() {
    alert('cancelling booking...');
}

function holdBooking() {
    alert('holding booking...');

}

function onServiceSelect(e) {
    timeSlot.value = '';
    timeSlot.readonly = true;
    let selectedService = this.value;

    if (selectedService !== '') {
        timeSlot.readonly = false;
    }
    console.log('is timeslot readonly? ', timeSlot.readonly);

    getTimeSlots(selectedService)
        .done((response) => {
            console.log(response);
            if (response === '') {
                noEmployeeFeedBack();
            }
            $('#timeSlot').empty().append(response); // append html partial to select element
        });
}

function getTimeSlots(serviceType) {
    console.log('service type selected: ', serviceType);

    return $.ajax({
        method: 'GET',
        dataType: 'html',
        data: { serviceType },
        url: urlFor('/booking/new/timeslots'),
    }).fail((jqHr, err) => {
        console.log(jqHr);
        console.log(err);
    });
}

function t() {
    console.log('selected time slot: ', this.value);
}

function createBooking() {
    let data = collectBookingData(); // collect the data in name value pairs
    let errors = validateBookingData(data); // validate the above data

    if (errors === 0) {
        console.log('sending data...');
        sendBookingData(data)
            .done((response) => {
                console.log('new response', response)
                bookingCreationFeedBack(response);
                displayConfirmBooking(response.data.id);
            });
    }
}

function displayConfirmBooking(id) {
    // hide create booking card
    $('#new-booking').hide();
    $('#confirm-booking').fadeIn(500);
    getBookingDetailsPartial(id)
        .done((bookingDataHtmlPartial) => {
            $('#booking-data').empty().append(bookingDataHtmlPartial);
        });
}

function getBookingDetailsPartial(id) {
    let bookingId = id;
    return $.ajax({
        method: 'GET',
        dataType: 'html',
        data: { bookingId },
        url: urlFor('/booking/confirm'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
        console.log(err);
    });
}

function sendBookingData(data) {
    return $.ajax({
        method: 'POST',
        data,
        dataType: 'json',
        url: urlFor('/booking/new'),
    }).fail((response, err) => {
        console.log(response, err);
    });
}

function setModifiedId(id) {
    sessionStorage.setItem('lastModifiedId', id);
}
function confirmBookingFeedback(response) {
    console.log('response status: ', response.status);
    if (response.status === 0) {
        swalB.fire({
            position: 'top-end',
            type: 'success',
            title: 'Booking Confirmed!',
            showConfirmButton: false,
            timer: 1500,
            onAfterClose: () => {
                setModifiedId(response.data.id);
                window.location.replace(urlFor('/booking'));
            },
        });
    } else if (response.status === 1) {
        swalB.fire({
            type: 'error',
            title: 'Invalid Data',
            text: 'Record not created',
            showConfirmButton: true,
            onAfterClose: () => {
                alert(response.message);
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error',
            text: 'Unable to confirm booking',
            showConfirmButton: true,
            onAfterClose: () => {
                alert(response.message);
            },
        });
    }
}
function bookingCreationFeedBack(response) {
    console.log('response status: ', response.status);
    if (response.status === 0) {
        swalB.fire({
            position: 'top-end',
            type: 'success',
            title: 'New Booking has been created',
            showConfirmButton: false,
            timer: 1500,
            onAfterClose: () => {},
        });
    } else if (response.status === 1) {
        swalB.fire({
            type: 'error',
            title: 'Invalid Data',
            text: 'Record not created',
            showConfirmButton: true,
            onAfterClose: () => {
                alert(response.message);
            },
        });
    }
}

function collectBookingData() {
    let data = [
        { name: service.name, value: service.value },
        { name: timeSlot.name, value: timeSlot.value },
        { name: vehicle.name, value: vehicle.value },
    ];
    return data;
}

function emptyTimeSlotFeeback() {
    if (service.value === '') {
        swalB.fire({
            type: 'warning',
            title: 'Please select Service Type first',
            showConfirmButton: true,
        });
    }
}

function noEmployeeFeedBack() {
    swalB.fire({
        type: 'warning',
        title: 'No Employees Available!',
        showConfirmButton: true,
    });

}

function displayValidationFeeback(code) {
    if (code === 1) {
        swalB.fire({
            type: 'warning',
            title: 'All Fields are Required!',
            text: 'Please select service type, time slot and a customer',
            showConfirmButton: true,
        });
    }
}


function validateBookingData(data) {
    let errorCount = 0;
    let serviceType = service.value;
    let dateTime = timeSlot.value;
    let vehicleDetails = vehicle.value;
    let errorCode;

    let serviceName = service.name;

    // temp validity check. Checking isnt enough. Script is going to continue after check.
    if (serviceType === '' || dateTime === '' || vehicleDetails === '') {
        errorCount += 1;
        errorCode = 1;
        displayValidationFeeback(1);
    }
    console.log(serviceType, dateTime, vehicleDetails);

    return errorCount;
}
