// item select
const addItemsBtn = $('#add-items-btn');
const addItemsModal = $('#add-items-modal');
const setItemQuantityModal = $('#set-item-quantity-modal');
const setItemQuantityForm = $('#set-quantity-form');
const addItemToListBtn = $('#add-item-btn');
const jobCardId = $('#service-info').data('job-card-id');
const serviceStatus = $('#service-info').data('service-order-status');

$(window).on('load', loadJobCardItemsHandler);
addItemsBtn.on('click', showAddItemsModal);
addItemToListBtn.on('click', addItemToListHandler);

if (serviceStatus === 'completed' || serviceStatus === 'terminated') {
    addItemsBtn.hide();
}

let serviceItems = {}; // keep track of items

const itemTableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [{ orderable: false, targets: [7] }],
};

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

function loadJobCardItemsHandler() {
    let count = $('#service-info').data('job-card-item-count');
    if (count > 0) {
        loadJobCardItems(jobCardId).done((response) => {
            $('#service-items').empty().append(response);
            $('#service-items-table .remove-item').on('click', removeItemHandler);
            // populate service items
            let rows = $('#service-items-table tbody').children();
            $.each(rows, (i, el) => {
                let id = $(el).attr('id');
                serviceItems[id] = '';
            });
        });
    }
}

function loadJobCardItems(id) {
    return $.ajax({
        method: 'GET',
        data: {
            id: id,
        },
        url: urlFor('/job-card/item/list-partial'),
        dataType: 'html',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function showAddItemsModal() {
    // load state tells if the items are loaded
    // this ensures that items are not loaded every time
    // add items button is clicked
    let loadState = addItemsModal.data('load-state');
    addItemsModal.modal('show');
    // if (loadState === 0) {
    loadItems().done((partial) => {
        $('#item-list').empty().append(partial);
        $('.select-item').on('click', selectItemsHandler);
        $('#item-list-table').DataTable(itemTableOptions);
        addItemsModal.data('load-state', 1);
        Object.keys(serviceItems).forEach((id) => {
            $(`#item-list tr#${id}`).addClass('row-selected');
        });
    });
    // }
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

/**
 * Attached to 'Select' button of each item in the item list modal.
 */
function selectItemsHandler(e) {
    e.preventDefault();
    // populate the form
    // get item id and name
    let id = $(this).data('entity-id');
    let name = $(`tr#${id}`).children()[1].innerHTML;
    let price = $(`tr#${id}`).children()[2].innerHTML;

    // populate the selected item modal form
    populateSetQuantityForm(id, name, price);

    // show the set item quantity modal
    if (isItemInServiceItemsList(id)) {
        duplicateItemFeedback();
    } else {
        setItemQuantityModal.modal('show');
    }
}

/**
 * Adds item to the 'spare parts used in service' table
 * The button is in 'set item quantity modal'
 */
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
        let id = data[0].value; // item id
        let quantity = data[3].value;

        if (!isItemInServiceItemsList(id)) {
            sendItemData(data, jobCardId).done((response) => {
                $('#service-items').empty().append(response.data.html);
                // $(`#service-items-table #${id} .remove-item`).on('click', removeItemHandler);
                $('#service-items-table .remove-item').on('click', removeItemHandler);
                $('#item-cost').empty().append(response.data.total);
                addItemFeedback();
                serviceItems[id] = data; // add to internal array
            });

            // let rowString = prepareHtmlTableRow(data);
            // $('#service-items-table tbody').append(rowString);
            // $(`#service-items-table #${id} .remove-item`).on('click', removeItem);
            $(`#item-list tr#${id}`).addClass('row-selected');
            setItemQuantityModal.modal('hide');
            // addItemFeedback();
        } else {
            // item is in the purchase order item list
            // therefore update item quantity
            // serviceItems[id] = data;
            // $(`#service-items-table tr#${id}`).children()[3].innerHTML = quantity;
            // setItemQuantityModal.modal('hide');
            // editItemQuantityFeedback();
        }
    }
}

function sendItemData(data, jId) {
    data.push({
        name: 'id',
        value: jId,
    });
    return $.ajax({
        method: 'POST',
        data: data,
        dataType: 'json',
        url: urlFor('/job-card/item/new'),
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function removeItem(itemId, jId, q) {
    return $.ajax({
        method: 'POST',
        data: {
            id: jId,
            itemId: itemId,
            quantity: q,
        },
        dataType: 'json',
        url: urlFor('/job-card/item/delete'),
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function populateSetQuantityForm(id, name, price, q = '') {
    $('#selectedItemId').val(id);
    $('#selectedItemName').val(name);
    $('#selectedItemSellingPrice').val(price);
    $('#selectedItemQuantity').removeClass('is-valid').val(q);
}

function prepareHtmlTableRow(data) {
    console.log(data);
    return `<tr id="${data[0].value}">
            <td>${data[0].value}</td>
            <td>${data[1].value}</td>
            <td>${data[2].value}</td>
            <td>${data[3].value}</td>
            <td>${(data[3].value * data[2].value).toFixed(2)}</td>
            <td><a data-entity-id=${
                data[0].value
            } class="text-danger remove-item" href="#"><i class="fas fa-minus-square" data-toggle="tooltip" data-placement="top" title="Remove Item"></i></a></td>
        </tr>`;
}

function editItemQuantity() {
    let id = $(this).data('entity-id');
    let data = serviceItems[id];
    populateSetQuantityForm(id, data[1].value, data[2].value, data[3].value);
    setItemQuantityModal.modal('show');
}

function removeItemHandler(e) {
    e.preventDefault();
    confirmDelete().then((result) => {
        if (result.value) {
            let id = $(this).data('entity-id');
            let quantity = $(`#service-items-table tr#${id}`).children()[3].innerHTML;
            let subtotal = $(`#service-items-table tr#${id}`).children()[4].innerHTML;
            let total = $('#item-cost').text();
            removeItem(id, jobCardId, quantity).done((response) => {
                delete serviceItems[id];
                $(`#item-list-table tr#${id}`).removeClass('row-selected');
                console.log(`removed item ${response.data.id} from order`);
                loadJobCardItems(jobCardId).done((responsepartial) => {
                    $('#item-cost').text((total - subtotal).toFixed(2));
                    $('#service-items').empty().append(responsepartial);
                    $('#service-items-table .remove-item').on('click', removeItemHandler);
                    // populate service items
                    let rows = $('#service-items-table tbody').children();
                    $.each(rows, (i, el) => {
                        serviceItems[$(el).attr('id')] = '';
                    });
                });
                removeItemFeedback();
            });
        }
    });
    // $(`#service-items-table tr#${id}`).remove();
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
        title: 'Item Removed From Item List!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function isItemInServiceItemsList(itemId) {
    // global serviceItems
    return Object.prototype.hasOwnProperty.call(serviceItems, itemId);
}

function emptyServiceItemsListFeedback() {
    swalB.fire({
        type: 'warning',
        title: 'Item List is Empty!',
        text: 'Please add items to the order',
        showConfirmButton: true,
    });
}

function addItemFeedback() {
    swalB.fire({
        toast: true,
        type: 'success',
        title: 'Item added to Item List!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function duplicateItemFeedback() {
    swalB.fire({
        toast: true,
        type: 'error',
        title: 'Item exists in Item List!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function confirmDelete() {
    return swalB.fire({
        type: 'warning',
        title: 'Remove Spare Part?',
        text: 'This action cannot be undone',
        showCancelButton: true,
        focusCancel: true,
    });
}
