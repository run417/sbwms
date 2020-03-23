const newItemBtn = $('#new-item-btn');
const newItemModal = $('#new-item-modal');
const newItemForm = $('#new-item-form');
newItemBtn.on('click', showNewItemModal);
newItemModal.on('hide.bs.modal', clearNewItemForm);

// new item category-subcategory
$('#category').on('change', newItemSubcategoryHandler);
$('#edit-category').on('change', editItemSubcategoryHandler);

const editItemBtn = $('.edit-item');
const editItemModal = $('#edit-item-modal');
const editItemForm = $('#edit-item-form');
const editItem = $('.edit-item');
editItemBtn.on('click', showEditItemModal);
editItemModal.on('hide.bs.modal', clearEditItemForm);

const deleteBtn = $('#delete');
deleteBtn.on('click', deleteListingEventHandler);

const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [10] },
    ],
};

const table = $('#item-list-table').DataTable(tableOptions);

function newItemSubcategoryHandler() {
    loadSubcategories(this.value)
        .done((subcatPartial) => {
            $('#subcategory-list').empty().append(subcatPartial);
        });
}

function editItemSubcategoryHandler() {
    loadSubcategories(this.value)
        .done((subcatPartial) => {
            $('#edit-subcategory-list').empty().append(subcatPartial);
        });
}

function loadSubcategories(id) {
    return $.ajax({
        method: 'GET',
        data: { id },
        url: urlFor('/inventory/subcategory/category'),
        dataType: 'html',
    }).fail((jQhr, err) => {
        console.log(err, jQhr);
    });
}

function showNewItemModal(e) {
    e.preventDefault();
    newItemModal.modal({
        backdrop: 'static',
    });
}

function showEditItemModal(e) {
    e.preventDefault();
    let id = $(e.currentTarget).data('entityId');
    editItemModal.data('modalEntityId', id);
    getItemJsonData(id)
        .done((data) => {
            editItemModal.modal({
                backdrop: 'static',
            });
            if (isModelOpen()) {
                // subcategory list for the selected category
                // then populate form
                loadSubcategories(data.category)
                    .done((subcatPartial) => {
                        $('#edit-subcategory-list').empty().append(subcatPartial);
                        populateEditForm(editItemForm, data);
                    });
            }
        });
}

function isModelOpen() {
    return ($('body').hasClass('modal-open'));
}

function closeNewItemModal() {
    newItemModal.modal('hide');
}

function closeEditItemModal() {
    editItemModal.modal('hide');
}

function closeEditModalAlias() {
    closeEditItemModal();
}

function populateEditForm(formElement, dataObject) {
    // now the form array is iterated. For each
    // form element 'name' if there is a matching
    // property in the json object got through ajax
    // then get the property value and populate in the
    // form element. This is done by selecting the
    // specific form element through the element name
    // attribute and populating the value attribute.
    console.log('inside populateForm');
    // the response object is a customer json object
    // the form array consists of js objects with
    // name and value properties
    let formArray = formElement.serializeArray();
    let formid = formElement[0].id;
    console.log(formArray);
    formArray.forEach((elem) => {
        // console.log(elem.name);
        if (Object.prototype.hasOwnProperty.call(dataObject, elem.name)) {
            console.log(`name attribute: ${elem.name}`);
            console.log('value: ', dataObject[elem.name]);
            $(`#${formid} [name=${elem.name}]`).val(dataObject[elem.name]);
        }
    });
}

let rules = {
    category: {
        required: true,
    },
    subcategory: {
        required: true,
    },
    name: {
        required: true,
        minlength: 2,
        maxlength: 100,
    },
    description: {
        required: true,
    },
    brand: {
        required: true,
    },
    supplier: {
        required: true,
    },
};

let newItemFormValidator = newItemForm.validate({
    submitHandler: createNewItem,
    rules,
    // messages: {},
});

let editItemFormValidator = editItemForm.validate({
    submitHandler: updateItem,
    rules,
    // messages: {},
});

function updateItem(form) {
    confirmUpdate()
        .then((result) => {
            if (result.value) {
                sendUpdatedItemData(form)
                    .done((response) => {
                        itemUpdateFeedback(response);
                        getItemRowPartial(response.data.id) // update the item list
                            .done((partial) => {
                                // remove old row
                                table.row($(`tr#${response.data.id}`)).remove();
                                // add the updated row
                                table.row.add($(partial)).draw();
                                // attach event listener to the row's edit button
                                $(`#${response.data.id} .edit-item`).on('click', showEditItemModal);
                                // highlight the updated row
                                highLightRow(response.data.id);
                            });
                    });
            } else if (result.dismiss) {
                cancelUpdateFeedBack();
            }
        });
}

function createNewItem(form) {
    sendNewItemData(form)
        .done((response) => {
            itemCreationFeedback(response);
            getItemRowPartial(response.data.id) // update the item list
                .done((partial) => {
                    table.row.add($(partial)).draw();
                    $(`#${response.data.id} .edit-item`).on('click', showEditItemModal);
                    highLightRow(response.data.id);
                });
        });
}

function deleteListingEventHandler(e) {
    e.preventDefault();
    let id = editItemModal.data('modalEntityId');
    confirmDelete()
        .then((result) => {
            if (result.value) {
                deleteItem(id)
                    .done((response) => {
                        deleteSuccessFeedBack(response);
                    });
            } else if (result.dismiss) {
                cancelDeleteFeedBack();
            }
        });
}

function deleteItem(id) {
    console.log(id);
    return $.ajax({
        method: 'POST',
        data: { id },
        dataType: 'json',
        url: urlFor('/inventory/item/delete'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function highLightRow(id) {
    $('tr').removeClass('updated');
    $(`tr#${id}`).addClass('updated');
}

function getItemRowPartial(id) {
    return $.ajax({
        method: 'GET',
        data: {
            type: 'rowpartial',
            id,
        },
        dataType: 'html',
        url: urlFor('/inventory/item/view'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function getItemJsonData(id) {
    return $.ajax({
        method: 'GET',
        data: { id },
        dataType: 'json',
        url: urlFor('/inventory/item/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendNewItemData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/inventory/item/new'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendUpdatedItemData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/inventory/item/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function itemCreationFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Success!',
            text: `New Item '${id} - ${name}' Created Successfully`,
            onBeforeOpen: () => {
                closeNewItemModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error creating item',
        });
    }
}

function confirmUpdate() {
    return swalB.fire({
        type: 'warning',
        title: 'Update Details?',
        text: 'This action cannot be undone',
        showCancelButton: true,
    });
}

function confirmDelete() {
    return swalB.fire({
        type: 'warning',
        title: 'Delete Listing?',
        text: 'This action cannot be undone',
        showCancelButton: true,
        focusCancel: true,
    });
}

function cancelUpdateFeedBack() {
    return swalB.fire({
        type: 'error',
        title: 'Cancelled',
        text: 'Update Cancelled',
    });
}

function cancelDeleteFeedBack() {
    return swalB.fire({
        type: 'error',
        title: 'Cancelled',
        text: 'Delete Action Cancelled. The listing data is safe!',
    });
}

function deleteSuccessFeedBack(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Delete Success',
            text: `The listing ${id} - ${name} is successfully deleted`,
            onBeforeOpen: () => {
                closeEditModalAlias();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error deleting listing',
        });
    }
}

function itemUpdateFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Success!',
            text: `Item '${id} - ${name}' Updated Successfully`,
            onBeforeOpen: () => {
                closeEditItemModal();
            },
        }).then((result) => {
            console.log('then result', result);
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating item',
        });
    }
}

function clearNewItemForm() {
    let data = newItemForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    newItemFormValidator.resetForm();
    $('#new-item-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = newItemForm.serializeArray();
    console.log(cdata);
}

function clearEditItemForm() {
    let data = editItemForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    editItemFormValidator.resetForm();
    $('#edit-item-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = editItemForm.serializeArray();
    console.log(cdata);
}
