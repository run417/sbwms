const saveJobCardBtn = $('#save-job-card-btn');
const holdServiceBtn = $('#hold-service-btn');
const restartServiceBtn = $('#restart-service-btn');
const completeServiceBtn = $('#complete-service-btn');
const terminateServiceBtn = $('#terminate-service-btn');
const serviceOrderId = $('#service-info').data('service-order-id');
const serviceOrderStatus = $('#service-info').data('service-order-status');

if (serviceOrderStatus === 'ongoing') {
    restartServiceBtn.hide();
} else if (serviceOrderStatus === 'on-hold') {
    holdServiceBtn.hide();
} else {
    holdServiceBtn.hide();
    restartServiceBtn.hide();
}

if (serviceOrderStatus === 'completed' || serviceOrderStatus === 'terminated') {
    completeServiceBtn.hide();
    terminateServiceBtn.hide();
    saveJobCardBtn.hide();
}

saveJobCardBtn.on('click', saveJobCardHandler);
holdServiceBtn.on('click', holdServiceHandler);
restartServiceBtn.on('click', restartServiceHandler);
completeServiceBtn.on('click', completeServiceHandler);
terminateServiceBtn.on('click', terminateServiceHandler);

function completeServiceHandler() {
    confimCompletion().then((result) => {
        if (result.value) {
            completeService(serviceOrderId).done((response) => {
                if (response.status === 0) {
                    setModifiedId(response.data.id);
                    window.location.replace(urlFor('/service-order/history'));
                }
            });
        }
    });
}

function terminateServiceHandler() {
    confirmTermination().then((result) => {
        if (result.value) {
            terminateService(serviceOrderId).done((response) => {
                if (response.status === 0) {
                    setModifiedId(response.data.id);
                    window.location.replace(urlFor('/service-order/history'));
                }
            });
        }
    });
}

function completeService(id) {
    return $.ajax({
        method: 'POST',
        data: {
            id: id,
        },
        url: urlFor('/service-order/complete'),
        dataType: 'JSON',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function terminateService(id) {
    return $.ajax({
        method: 'POST',
        data: {
            id: id,
        },
        url: urlFor('/service-order/terminate'),
        dataType: 'JSON',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function confimCompletion() {
    return swalB.fire({
        type: 'warning',
        title: 'Complete service?',
        text: 'This action cannot be undone.',
        showCancelButton: true,
        focusCancel: true,
    });
}

function confirmTermination() {
    return swalB.fire({
        type: 'warning',
        title: 'Terminate service?',
        text: 'This action cannot be undone.',
        showCancelButton: true,
        focusCancel: true,
    });
}

function saveJobCardHandler() {
    let diagnosis = $('#diagnosis').val();
    let notes = $('#service-notes').val();
    let data = [];
    data.push(
        {
            name: 'diagnosis',
            value: diagnosis,
        },
        {
            name: 'notes',
            value: notes,
        },
        {
            name: 'id',
            value: jobCardId,
        }
    );
    sendJobCardDetails(data).done((response) => {
        if (response.status === 0) {
            saveJobCardFeedback();
        }
    });
}

function sendJobCardDetails(data) {
    return $.ajax({
        method: 'POST',
        data,
        url: urlFor('/job-card/save'),
        dataType: 'json',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function saveJobCardFeedback() {
    swalB.fire({
        toast: true,
        type: 'success',
        title: 'Job details saved!',
        position: 'top',
        showConfirmButton: false,
        timer: 2000,
    });
}

// hold service
function holdServiceHandler() {
    confirmOnHold().then((result) => {
        if (result.value) {
            holdService(serviceOrderId).done((response) => {
                if (response.status === 0) {
                    setModifiedId(response.data.id);
                    window.location.replace(urlFor('/service-order?status=on-hold'));
                }
            });
        }
    });
}

// hold service
function restartServiceHandler() {
    confirmServiceRestart().then((result) => {
        if (result.value) {
            restartService(serviceOrderId).done((response) => {
                if (response.status === 0) {
                    setModifiedId(response.data.id);
                    window.location.replace(urlFor('/service-order?status=ongoing'));
                }
            });
        }
    });
}

function holdService(id) {
    return $.ajax({
        method: 'POST',
        data: {
            id: id,
        },
        url: urlFor('/service-order/hold'),
        dataType: 'JSON',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function restartService(id) {
    return $.ajax({
        method: 'POST',
        data: {
            id: id,
        },
        url: urlFor('/service-order/restart'),
        dataType: 'JSON',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function confirmOnHold() {
    return swalB.fire({
        type: 'warning',
        title: 'Put service on hold?',
        text: 'You will be redirected to On-hold services list',
        showCancelButton: true,
        focusCancel: true,
    });
}

function confirmServiceRestart() {
    return swalB.fire({
        type: 'warning',
        title: 'Restart Service?',
        text: 'You will be redirected to ongoing services list',
        showCancelButton: true,
        focusCancel: true,
    });
}

function setModifiedId(id) {
    sessionStorage.setItem('lastModifiedId', id);
}
