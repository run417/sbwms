// find customer
const findCustomerBtn = $('#find-customer-btn');
const selectCustomerModal = $('#select-customer-modal');
const walkinCustomerCheckbox = $('#walk-in-customer');

findCustomerBtn.on('click', showSelectCustomerModal);
walkinCustomerCheckbox.on('change', walkinCustomerHandler);

const customerTableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [5] },
    ],
};


function walkinCustomerHandler() {
    if (this.checked) {
        $('#selected-customer')
            .empty()
            .append('Walk-in Customer (unregistered)')
            .addClass('row-selected');
        $('#customerId').val(0);
        customerSelectedFeedback();
    } else {
        $('#selected-customer')
            .empty()
            .append('Click \'Find\' to select a customer')
            .removeClass('row-selected');
        $('#customerId').val('');
    }
}

function showSelectCustomerModal(e) {
    e.preventDefault();
    selectCustomerModal.modal('show');
    loadCustomers()
        .done((partial) => {
            $('#customer-list').empty().append(partial);
            $('.select-customer').on('click', selectCustomerHandler);
            if ($('#customerId').val() !== '') {
                $(`tr#${$('#customerId').val()}`).addClass('row-selected');
            }
            $('#customer-list-table').DataTable(customerTableOptions);
        });
}

function loadCustomers() {
    return $.ajax({
        method: 'GET',
        url: urlFor('/sale/customers'),
        dataType: 'html',
    }).fail((jqhr, err) => {
        console.log(err, jqhr);
    });
}

function selectCustomerHandler() {
    // populate the form
    // get item id and name
    let id = $(this).data('entity-id');
    let fname = $(`tr#${id}`).children()[1].innerHTML;
    let lname = $(`tr#${id}`).children()[2].innerHTML;

    let customerStr = `${id} - ${fname} ${lname}`;
    $('#selected-customer').empty().append(customerStr).addClass('row-selected');
    $('#customerId').val(id);
    $('#customer-list-table tr').removeClass('row-selected');
    $(`#customer-list tr#${id}`).addClass('row-selected');
    customerSelectedFeedback();
    $('#walk-in-customer').prop('checked', false);
}

function customerSelectedFeedback() {
    swalB.fire({
        toast: true,
        type: 'success',
        title: 'Customer Selected!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

// item select
const addItemsBtn = $('#add-items-btn');
const addItemsModal = $('#add-items-modal');
const setItemQuantityModal = $('#set-item-quantity-modal');
const setItemQuantityForm = $('#set-quantity-form');
const addItemToListBtn = $('#add-item-btn');

addItemsBtn.on('click', showAddItemsModal);
addItemToListBtn.on('click', addItemToListHandler);

let orderCart = {};

const itemTableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [7] },
    ],
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
                $('.select-item').on('click', selectItemsHandler);
                $('#item-list-table').DataTable(itemTableOptions);
                addItemsModal.data('load-state', 1);
            });
    }
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

function selectItemsHandler() {
    // populate the form
    // get item id and name
    let id = $(this).data('entity-id');
    let name = $(`tr#${id}`).children()[1].innerHTML;
    let price = $(`tr#${id}`).children()[2].innerHTML;

    // populate the selected item modal form
    populateSetQuantityForm(id, name, price);

    // show the set item quantity modal
    if (isItemInOrderCart(id)) {
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
        let quantity = data[3].value;

        if (!isItemInOrderCart(id)) {
            orderCart[id] = data;
            let rowString = prepareHtmlTableRow(data);
            $('#order-items-table tbody').append(rowString);
            $(`#order-items-table #${id} .remove-item`).on('click', removeItem);
            setItemQuantityModal.modal('hide');
            addItemFeedback();
            calculateGrandTotal();
            $(`#item-list tr#${id}`).addClass('row-selected');
        } else {
            // item is in the purchase order item list
            // therefore update item quantity
            orderCart[id] = data;
            $(`#order-items-table tr#${id}`).children()[3].innerHTML = quantity;
            setItemQuantityModal.modal('hide');
            editItemQuantityFeedback();
        }
    }
}

function populateSetQuantityForm(id, name, price, q = '') {
    $('#selectedItemId').val(id);
    $('#selectedItemName').val(name);
    $('#selectedItemSellingPrice').val(price);
    $('#selectedItemQuantity').removeClass('is-valid').val(q);
}

function prepareHtmlTableRow(data) {
    console.log(data);
    return `
        <tr id="${data[0].value}">
            <td>${data[0].value}</td>
            <td>${data[1].value}</td>
            <td>${data[2].value}</td>
            <td>${data[3].value}</td>
            <td>${(data[3].value * data[2].value).toFixed(2)}</td>
            <td><a data-entity-id=${data[0].value} class="text-danger remove-item" href="#"><i class="fas fa-minus-square" data-toggle="tooltip" data-placement="top" title="Remove Item"></i></a></td>
        </tr>
    `;
}

function editItemQuantity() {
    let id = ($(this).data('entity-id'));
    let data = (orderCart[id]);
    populateSetQuantityForm(id, data[1].value, data[2].value, data[3].value);
    setItemQuantityModal.modal('show');
}

function removeItem() {
    let id = ($(this).data('entity-id'));
    delete orderCart[id];
    calculateGrandTotal();
    $(`#item-list-table tr#${id}`).removeClass('row-selected');
    $(`#order-items-table tr#${id}`).remove();
    console.log(`removed item ${id} from order`);
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
        title: 'Item Removed Service!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function isItemInOrderCart(itemId) {
    // global orderCart
    return Object.prototype.hasOwnProperty.call(orderCart, itemId);
}

function emptyOrderCartFeedback() {
    swalB.fire({
        type: 'warning',
        title: 'Order Cart is Empty!',
        text: 'Please add items to the order',
        showConfirmButton: true,
    });
}

function addItemFeedback() {
    swalB.fire({
        toast: true,
        type: 'success',
        title: 'Item added to Order Cart!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}

function duplicateItemFeedback() {
    swalB.fire({
        toast: true,
        type: 'error',
        title: 'Item exists in Order Cart!',
        position: 'top',
        showConfirmButton: false,
        timer: 1500,
    });
}



function noCustomerFeedback() {
    swalB.fire({
        // toast: true,
        type: 'warning',
        title: 'Please select a customer!',
        // position: 'top',
        showConfirmButton: true,
        // timer: 1500,
    });
}

function noItemsFeedback() {
    swalB.fire({
        // toast: true,
        type: 'warning',
        title: 'Please add items to order!',
        // position: 'top',
        showConfirmButton: true,
        // timer: 1500,
    });
}
function calculateGrandTotal() {
    let ids = Object.keys(orderCart);
    let total = 0;
    let itemCount = ids.length;
    console.log(orderCart);
    ids.forEach((i) => {
        let dataArray = orderCart[i];
        let sellingPrice = 0;
        let quantity = 0;
        dataArray.forEach((i) => {
            if (i.name === 'sellingPrice') {
                sellingPrice = i.value;
                console.log(i.value);
            }
            if (i.name === 'quantity') {
                console.log(i.value);
                quantity = i.value;
            }
        });
        total += (sellingPrice * quantity);
    });
    $('#item-cost').empty().text(total.toFixed(2));
    $('#item-count').empty().text(itemCount);
    $('#grand-total').val(total.toFixed(2));
    // return total;
}

// Payment

const paymentBtn = $('#payment-btn');
// const invoiceBtn = $('#invoice-btn');
const discardBtn = $('#discard-btn');
const customerId = $('#customerId');

const grandTotal = $('#grand-total');
const discount = $('#discount');
const paidAmount = $('#paid-amount');
const netTotal = $('#net-total');
const balance = $('#balance');
$('#goto-order-btn').on('click', () => {
    $('#payment-card').hide(250);
    $('#item-sale-card').show(250);
});

paymentBtn.on('click', paymentBtnHandler);
discardBtn.on('click', discardBtnHandler);
paidAmount.on('input', calculateInvoice);
paidAmount.on('blur', calculateInvoice);
discount.on('input', calculateInvoice);
discount.on('blur', calculateInvoice);

function discardBtnHandler() {
    confirmDiscard()
        .then((result) => {
            if (result.value) {
                window.location.reload();
            }
        });

}

function confirmDiscard() {
    return swalB.fire({
        type: 'warning',
        title: 'Discard Item Order?',
        text: 'Current items and details will be lost!',
        showCancelButton: true,
        focusCancel: true,
    });
}

function paymentBtnHandler() {
    if ($.isEmptyObject(orderCart)) {
        noItemsFeedback();
    }
    if (customerId.val() === '') {
        noCustomerFeedback();
    }

    if (!($.isEmptyObject(orderCart)) && !(customerId.val() === '')) {
        calculateGrandTotal();
        $('#item-sale-card').hide(250);
        $('#payment-card').show(250);
        $('#paid-amount').focus();
    }
}

function calculateInvoice() {
    let ntotal = 0;
    let d = discount.val();
    let gtotal = parseFloat(grandTotal.val());
    let pay = paidAmount.val();
    let b = 0;

    if (d !== '') {
        d = parseFloat(d);
        ntotal = gtotal - ((d / 100) * gtotal);
    } else {
        ntotal = gtotal;
    }

    if (pay !== '') {
        pay = parseFloat(pay);
        b = pay - ntotal;
        if (b < 0) { b = 0; }
    } 
    // else {
    //     return;
    // }

    netTotal.val(ntotal.toFixed(2));
    balance.val(b.toFixed(2));
    // if (isNaN(g));
}

const invoiceBtn = $('#invoice-btn');

function itemOrderHandler() {
    // gather details
    let data = [];

    Object.keys(orderCart).forEach((i) => {
        let item = {};
        orderCart[i].forEach((el) => {
            item[el.name] = el.value;
        });
        data.push({
            name: 'items[]',
            value: JSON.stringify(item),
        });
    });
    data.push({
        name: 'customerId',
        value: customerId.val(),
    });
    let paymentData = $('#payment-form').serializeArray();
    data = data.concat(paymentData);
    console.log(data);
}

function sendOrderData(data) {

}
// send details to controller
// insert / update database
// get invoice record
// show invoice
// print invoice

// order reports
