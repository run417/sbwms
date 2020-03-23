const openProcessItemModalBtn = $('.open-process-item-modal');
const processItemModal = $('#process-item-modal');
const processItemForm = $('#process-item-form');
const processItemBtn = $('#process-item-btn');
const addItemsToStockBtn = $('#add-items-to-stock-btn');

openProcessItemModalBtn.on('click', processItemModalHandler);
processItemBtn.on('click', processItemsHandler);
addItemsToStockBtn.on('click', addItemsToStockHandler);

const itemCount = $('#items-table').data('item-count');
let receivedItems = {};

let rules = {
    quantity: {
        required: true,
        digits: true,
    },
    unitPrice: {
        required: true,
        number: true,
    },
    sellingPrice: {
        required: true,
        number: true,
    },
};

let validator = processItemForm.validate({
    debug: true,
    rules,
});

function addItemsToStockHandler() {
    let itemKeys = Object.keys(receivedItems);
    console.log(itemKeys);
    if (itemKeys.length === parseInt(itemCount, 10)) {
        let receivedItemsData = [
            {
                name: 'date',
                value: $('#date').val(),
            },
            {
                name: 'purchaseOrderId',
                value: $('#purchaseOrderId').val(),
            },
        ];

        itemKeys.forEach((id) => {
            let itemData = receivedItems[id];
            let dataObject = {
                itemId: itemData[0].value,
                name: itemData[1].value,
                quantity: itemData[2].value,
                unitPrice: itemData[3].value,
                sellingPrice: itemData[4].value,
            };
            receivedItemsData.push({
                name: 'items[]',
                value: JSON.stringify(dataObject),
            });
        });
        console.log(receivedItemsData);
        sendGrnDetails($('#purchaseOrderId').val(), receivedItemsData)
            .done((response) => {
                grnCreationFeedback(JSON.parse(response));
            });

    } else {
        receivedItemsNotProcessedFeedback();
    }
}

function sendGrnDetails(id, data) {
    return $.ajax({
        method: 'POST',
        datatype: 'json',
        data,
        url: urlFor(`/inventory/grn/receive?id=${id}`),
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function processItemsHandler() {
    if (processItemForm.valid()) {
        let itemId = $('#itemId').val();
        updateTableRow(itemId);
        receiveItem(itemId);
        $(`#${itemId}`).addClass('item-processed');
        processItemFeedback();
        processItemModal.modal('hide');
    }
}

function receiveItem(itemId) {
    receivedItems[itemId] = processItemForm.serializeArray();
}

function updateTableRow(id) {
    let row = $(`tr#${id}`);
    row.children()[2].innerHTML = $('#quantity').val();
    row.children()[3].innerHTML = $('#unitPrice').val();
    row.children()[4].innerHTML = $('#sellingPrice').val();
}

function processItemModalHandler() {
    processItemModal.modal('show');
    let itemId = $(this).data('entity-id');
    populateProcessItemForm(itemId);
}

function populateProcessItemForm(itemId) {
    // get the values from table row
    // and insert them into the modal form
    // reset the form and remove error css
    validator.resetForm();
    $('#process-item-form :input').removeClass('is-invalid is-valid');
    let row = $(`tr#${itemId}`);
    let name = row.children()[1].innerHTML;
    let quantity = row.children()[2].innerHTML;
    let unitPrice = row.children()[3].innerHTML;
    let sellingPrice = row.children()[4].innerHTML;
    $('#itemId').val(itemId);
    $('#name').val(name);
    $('#quantity').val(quantity);
    $('#unitPrice').val(unitPrice);
    $('#sellingPrice').val(sellingPrice);
}

function grnCreationFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Items Received!',
            text: `Stock updated by GRN '${id} - ${name}'`,
            onAfterClose: () => {
                window.location.replace(urlFor('/inventory/grn'));
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating stock',
        });
    }
}

function processItemFeedback() {
    swalB.fire({
        toast: true,
        type: 'success',
        title: 'Item Processed!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function receivedItemsNotProcessedFeedback() {
    swalB.fire({
        type: 'warning',
        title: 'Received Items are Not Processed',
        text: 'Please fill the details to process the items',
        showConfirmButton: true,
    });
}
