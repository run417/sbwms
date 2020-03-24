// item select
const addItemsBtn = $('#add-items-btn');
const addItemsModal = $('#add-items-modal');
const setItemQuantityModal = $('#set-item-quantity-modal');
const setItemQuantityForm = $('#set-quantity-form');
const addItemToListBtn = $('#add-item-btn');

addItemsBtn.on('click', showAddItemsModal);
addItemToListBtn.on('click', addItemToListHandler);

let serviceItems = {};

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
    if (isItemInServiceItemsList(id)) {
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

        if (!isItemInServiceItemsList(id)) {
            serviceItems[id] = data;
            let rowString = prepareHtmlTableRow(data);
            $('#service-items-table tbody').append(rowString);
            $(`#service-items-table #${id} .remove-item`).on('click', removeItem);
            setItemQuantityModal.modal('hide');
            addItemFeedback();
            $(`#item-list tr#${id}`).addClass('row-selected');
        } else {
            // item is in the purchase order item list
            // therefore update item quantity
            serviceItems[id] = data;
            $(`#service-items-table tr#${id}`).children()[3].innerHTML = quantity;
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
    return `<tr id="${data[0].value}">
            <td>${data[0].value}</td>
            <td>${data[1].value}</td>
            <td>${data[2].value}</td>
            <td>${data[3].value}</td>
            <td>${(data[3].value * data[2].value).toFixed(2)}</td>
            <td><a data-entity-id=${data[0].value} class="text-danger remove-item" href="#"><i class="fas fa-minus-square" data-toggle="tooltip" data-placement="top" title="Remove Item"></i></a></td>
        </tr>`;
}

function editItemQuantity() {
    let id = ($(this).data('entity-id'));
    let data = (serviceItems[id]);
    populateSetQuantityForm(id, data[1].value, data[2].value, data[3].value);
    setItemQuantityModal.modal('show');
}

function removeItem() {
    let id = ($(this).data('entity-id'));
    delete serviceItems[id];
    $(`#item-list-table tr#${id}`).removeClass('row-selected');
    $(`#service-items-table tr#${id}`).remove();
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

// service task
const serviceTasksModal = $('#service-tasks-modal');
const openServiceTaskBtn = $('#add-tasks-modal-btn');
const addTaskBtn = $('#add-task-btn');
const serviceTaskForm = $('#service-task-form');

serviceTaskForm.validate({
    debug: true,
    rules: {
        task: {
            required: true,
        },
    },
});

let serviceTasks = {};

openServiceTaskBtn.on('click', serviceTaskHandler);
addTaskBtn.on('click', addServiceTask);

function serviceTaskHandler() {
    serviceTasksModal.modal('show');
}

function addServiceTask() {
    let task = $('#task-description').val();
    let isDuplicate = false;
    serviceTasks.forEach((t) => {
        if (t === task.text) {
            console.log('duplicate task');
            isDuplicate = true;
        }
    });
    if (!isDuplicate) {
        serviceTasks.push(task);
        $('#service-tasks-table tbody').append(displayTaskTableRow(task));
        $('.remove-task')
    }
}

function removeTask() {
    console.dir(this);
}

function displayTaskTableRow(task) {
    return `<tr>
        <td>${task}</td>
        <td><a data-entity-id="" class="text-danger remove-task" href="#"><i class="fas fa-minus-square" data-toggle="tooltip" data-placement="top" title="Remove Item"></i></a></td>
    </tr>`;
}
