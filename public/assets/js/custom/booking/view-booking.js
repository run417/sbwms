const cancelBookingBtn = $('#cancel-booking-btn');
const realizeBookingBtn = $('#realize-booking-btn');
const serviceJobBtn = $('#service-job-btn');
const bookingId = $('#booking-info').data('booking-id');

// $('#cancel-booking-btn').hide();
// $('#realize-booking-btn').hide();
serviceJobBtn.on('click', serviceJobBtnHandler);
cancelBookingBtn.on('click', cancelBookingHandler);
realizeBookingBtn.on('click', realizeBookingHandler);

function serviceJobBtnHandler() {
    // alert('do you want to start service?');
    confirmJobStart();

}

function confirmJobStart() {
    return swalB.fire({
        type: 'warning',
        title: 'Start Service Job?',
        text: 'This action cannot be undone. This booking is will be realized',
        showCancelButton: true,
        focusCancel: true,
    });
}

function cancelBookingHandler() {
    confirmCancel()
        .then((result) => {
            if (result.value) {
                cancelBooking(bookingId)
                    .done((response) => {
                        response = JSON.parse(response);
                        if (response.status == 0) {
                            setModifiedId(response.data.id);
                            window.location.replace(urlFor('booking'));
                        }
                    });
            }
        });
}
function realizeBookingHandler() {
    confirmRealize()
        .then((result) => {
            if (result.value) {
                realizeBooking(bookingId)
                    .done((response) => {
                        response = JSON.parse(response);
                        if (response.status == 0) {
                            setModifiedId(response.data.id);
                            window.location.replace(urlFor('booking'));
                        }
                    });
            }
        });
}

function cancelBooking(id) {
    return $.ajax({
        method: 'POST',
        data: {
            id: bookingId,
        },
        url: urlFor('booking/cancel'),
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function realizeBooking(id) {
    return $.ajax({
        method: 'POST',
        data: {
            id: bookingId,
        },
        url: urlFor('booking/realize'),
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function confirmRealize() {
    return swalB.fire({
        type: 'warning',
        title: 'Realize Booking?',
        text: 'This action cannot be undone. You will be redirected to Booking',
        showCancelButton: true,
        focusCancel: true,
    });
}

function confirmCancel() {
    return swalB.fire({
        type: 'warning',
        title: 'Cancel Booking?',
        text: 'This action cannot be undone. You will be redirected to Booking',
        showCancelButton: true,
        focusCancel: true,
    });
}

function setModifiedId(id) {
    sessionStorage.setItem('lastModifiedId', id);
}
