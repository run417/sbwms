// in main create purchase order page
const addItemsBtn = $('#add-items-btn');

// the modal opens when the add items button is clicked
const addItemsModal = $('#add-items-modal');

// this modal opens when select item button is clicked.
// select item button is in the items modal
const setItemQuantityModal = $('#set-item-quantity-modal');

// this form is in the set item quantity modal
const setItemQuantityForm = $('#set-quantity-form');

// this button is in the set item quantity form
// its purpose is to add the item to purchase order.
const addItemToListBtn = $('#add-item-btn');

const completePurchaseOrderBtn = $('#submit-purchase-order-btn');
const newPurchaseOrderForm = $('#new-purchase-order-form');


let purchaseOrderItems = {};
showHideTable();

addItemsBtn.on('click', showAddItemsModal);
addItemToListBtn.on('click', addItemToListHandler);
completePurchaseOrderBtn.on('click', submitPOHandler);

function submitPOHandler() {
    if ($.isEmptyObject(purchaseOrderItems)) {
        emptyPurchaseOrderFeedback();
    }
    if (newPurchaseOrderForm.valid() && !$.isEmptyObject(purchaseOrderItems)) {
        // get the all purchase order data except item data
        let pOData = newPurchaseOrderForm.serializeArray();
        console.log(pOData);

        // add item data to purchase order data
        Object.keys(purchaseOrderItems).forEach((id) => {
            let itemData = purchaseOrderItems[id];
            let dataObject = {
                itemId: itemData[0].value,
                name: itemData[1].value,
                quantity: itemData[2].value,
            };
            pOData.push({
                name: 'items[]',
                value: JSON.stringify(dataObject),
            });
        });

        console.log(pOData);
        sendPurchaseOrderData(pOData)
            .done((response) => {
                console.log(response);
                console.log(typeof response);
                purchaseOrderCreationFeedback(JSON.parse(response));
            });
    }
}

function showHideTable() {
    if ($.isEmptyObject(purchaseOrderItems)) {
        console.log('no po items');
        let message = '>Click \'Add Items\' button to add items to purchase order';
        // $('#purchase-order-items').append(message);
        $('#purchase-order-items-table').hide();
    } else {
        $('#purchase-order-items-table').show();
    }
}

// selected item modal form
let quantityRules = {
    quantity: {
        required: true,
        digits: true,
    },
};

let quantityMessages = {
    quantity: {
        digits: 'Please enter only positive numbers',
    },
};

let validator = setItemQuantityForm.validate({
    debug: true,
    rules: quantityRules,
    messages: quantityMessages,
});

let purchaseOrderRules = {
    date: {
        required: true,
    },
    shippingDate: {
        required: true,
    },
    supplier: {
        required: true,
    },
};

let newPurchaseOrderValidator = newPurchaseOrderForm.validate({
    rules: purchaseOrderRules,
});

// options for the item list modal
const itemTableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [7] },
    ],
};

const purchaseOrderItemTableOptions = {
    paging: true,
    searching: false,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [3, 4] },
    ],
};

// $('#purchase-order-items-table').DataTable(purchaseOrderItemTableOptions);

function showAddItemsModal() {
    // load state tells if the items are loaded
    // this ensures that items are not loaded every time
    // add items button is clicked
    let loadState = addItemsModal.data('load-state');
    addItemsModal.modal('show');
    if (loadState === 0) {
        loadItems()
            .done((partial) => {
                $('#item-list').empty().append(partial);
                $('#item-list-table').DataTable(itemTableOptions);
                addItemsModal.data('load-state', 1);
                $('.select-item').on('click', selectItemsHandler);
            });
    }
}


function selectItemsHandler() {
    // populate the form
    // get item id and name
    let id = $(this).data('entity-id');
    let name = $(`tr#${id}`).children()[1].innerHTML;

    // populate the selected item modal form
    populateSetQuantityForm(id, name);

    // show the set item quantity modal
    if (isItemInPurchaseOrder(id)) {
        duplicateItemFeedback();
    } else {
        setItemQuantityModal.modal('show');
    }
}

function addItemToListHandler() {
    // validate quantity here or above
    // add to list - solve adding items to purchase order.
    // if quantity is valid add
    // on click complete order how to submit item data to server along
    // with other purchase order details?
    // use session storage? php session?

    // edit quantity
    // remove item
    // hide table if no items
    // remove row html spaces

    if (validator.element('#selectedItemQuantity')) {
        let data = setItemQuantityForm.serializeArray();
        let id = data[0].value;
        let quantity = data[2].value;

        if (!isItemInPurchaseOrder(id)) {
            purchaseOrderItems[id] = data;
            let rowString = prepareHtmlTableRow(data);
            showHideTable();
            $('#purchase-order-items-table tbody').append(rowString);
            $(`#purchase-order-items-table #${id} .edit-item-quantity`).on('click', editItemQuantity);
            $(`#purchase-order-items-table #${id} .remove-item`).on('click', removeItem);
            setItemQuantityModal.modal('hide');
            addItemFeedback();
            $(`#item-list tr#${id}`).addClass('row-selected');
        } else {
            // item is in the purchase order item list
            // therefore update item quantity
            purchaseOrderItems[id] = data;
            $(`#purchase-order-items-table tr#${id}`).children()[2].innerHTML = quantity;
            showHideTable();
            setItemQuantityModal.modal('hide');
            editItemQuantityFeedback();
        }
    }
}

function populateSetQuantityForm(id, name, q = '') {
    $('#selectedItemId').val(id);
    $('#selectedItemName').val(name);
    $('#selectedItemQuantity').removeClass('is-valid').val(q);
}

function prepareHtmlTableRow(data) {
    return `
        <tr id="${data[0].value}">
            <td>${data[0].value}</td>
            <td>${data[1].value}</td>
            <td>${data[2].value}</td>
            <td><a data-entity-id=${data[0].value} class="edit-item-quantity" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Quantity"></i></a></td>
            <td><a data-entity-id=${data[0].value} class="text-danger remove-item" href="#"><i class="fas fa-minus-square" data-toggle="tooltip" data-placement="top" title="Remove Item"></i></a></td>
        </tr>
    `;
}

function editItemQuantity() {
    let id = ($(this).data('entity-id'));
    let data = (purchaseOrderItems[id]);
    populateSetQuantityForm(id, data[1].value, data[2].value);
    setItemQuantityModal.modal('show');
}

function removeItem() {
    let id = ($(this).data('entity-id'));
    delete purchaseOrderItems[id];
    $(`#item-list tr#${id}`).removeClass('row-selected');
    $(`#purchase-order-items-table tr#${id}`).remove();
    showHideTable();
    console.log(`removed item ${id} from purchase order`);
    removeItemFeedback();
}

function editItemQuantityFeedback() {
    swalB.fire({
        toast: true,
        type: 'success',
        title: 'Item Quantity Updated!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function removeItemFeedback() {
    swalB.fire({
        toast: true,
        type: 'error',
        title: 'Item Removed From Purchase Order!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function isItemInPurchaseOrder(itemId) {
    // global purchaseOrderItems
    return Object.prototype.hasOwnProperty.call(purchaseOrderItems, itemId);
}

function emptyPurchaseOrderFeedback() {
    swalB.fire({
        type: 'warning',
        title: 'Purchase Order is Empty!',
        text: 'Please add items to the purchase order',
        showConfirmButton: true,
    });
}

function addItemFeedback() {
    swalB.fire({
        toast: true,
        type: 'success',
        title: 'Item added to purchase order!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function duplicateItemFeedback() {
    swalB.fire({
        toast: true,
        type: 'error',
        title: 'Item exists in purchase order!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function purchaseOrderCreationFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Success!',
            text: `New Purchase Order '${id} - ${name}' Created Successfully`,
            onAfterClose: () => {
                window.location.replace(urlFor(`/inventory/purchase-order/view?id=${id}`));
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error creating purchase order',
        });
    }
}

function sendPurchaseOrderData(data) {
    return $.ajax({
        method: 'POST',
        datatype: 'json',
        data,
        url: urlFor('/inventory/purchase-order/new'),
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function addToList(form) {
    console.log(form);
}

function loadItems() {
    return $.ajax({
        method: 'GET',
        url: urlFor('/inventory/item/partial'),
        dataType: 'html',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}
