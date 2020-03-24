const saveJobCardBtn = $('#save-job-card-btn');
const holdServiceBtn = $('#hold-service-btn');
const startServiceBtn = $('#start-service-btn');
const completeServiceBtn = $('#complete-service-btn');
const serviceOrderId = $('#service-info').data('service-order-id');
const serviceOrderStatus = $('#service-info').data('service-order-status');

if (serviceOrderStatus === 'ongoing') {
    startServiceBtn.hide();
} else if (serviceOrderStatus === 'on-hold') {
    holdServiceBtn.hide();
} else {
    holdServiceBtn.hide();
    startServiceBtn.hide();
}

saveJobCardBtn.on('click', saveJobCardHandler);
holdServiceBtn.on('click', holdServiceHandler);
startServiceBtn.on('click', startServiceHandler);

function saveJobCardHandler() {
    let diagnosis = $('#diagnosis').val();
    let notes = $('#service-notes').val();
    let data = [];
    data.push({
        name: 'diagnosis',
        value: diagnosis,
    }, {
        name: 'notes',
        value: notes,
    }, {
        name: 'id',
        value: jobCardId,
    });
    sendJobCardDetails(data)
        .done((response) => {
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
    confirmOnHold()
        .then((result) => {
            if (result.value) {
                holdService(serviceOrderId)
                    .done((response) => {
                        if (response.status === 0) {
                            setModifiedId(response.data.id);
                            window.location.replace(urlFor('/service-order?status=on-hold'));
                        }
                    });
            }
        });
}

// hold service
function startServiceHandler() {
    confirmServiceStart()
        .then((result) => {
            if (result.value) {
                startService(serviceOrderId)
                    .done((response) => {
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

function startService(id) {
    return $.ajax({
        method: 'POST',
        data: {
            id: id,
        },
        url: urlFor('/service-order/start'),
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

function confirmServiceStart() {
    return swalB.fire({
        type: 'warning',
        title: 'Start Service?',
        text: 'You will be redirected to ongoing services list',
        showCancelButton: true,
        focusCancel: true,
    });
}

function setModifiedId(id) {
    sessionStorage.setItem('lastModifiedId', id);
}
