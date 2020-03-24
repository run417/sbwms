const receiveItems = $('#receive-items');

receiveItems.on('click', receiveItemsHandler);

const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
};

$('#purchase-order-items-table').DataTable(tableOptions);

function receiveItemsHandler() {
    console.log($(this).data('entity-id'));
    let id = $(this).data('entity-id');
    confirmItemReceive()
        .then((result) => {
            if (result.value) {
                window.location.replace(`${urlFor('/inventory/grn/receive')}?id=${id}`);
            } else if (result.dismiss) {
                // cancelItemReceiveFeedback();
            }
        });
}

function confirmItemReceive() {
    return swalB.fire({
        type: 'warning',
        title: 'Receive Items?',
        text: 'You will be redirected to process the received items',
        showCancelButton: true,
        focusCancel: true,
    });
}

// function cancelItemReceiveFeedback() {

// }