const newSubcategoryBtn = $('#new-subcategory-btn');
const newSubcategoryModal = $('#new-subcategory-modal');
const newSubcategoryForm = $('#new-subcategory-form');
newSubcategoryBtn.on('click', showNewSubcategoryModal);
newSubcategoryModal.on('hide.bs.modal', clearNewSubcategoryForm);

const editSubcategoryBtn = $('.edit-subcategory');
const editSubcategoryModal = $('#edit-subcategory-modal');
const editSubcategoryForm = $('#edit-subcategory-form');
const editSubcategory = $('.edit-subcategory');
editSubcategoryBtn.on('click', showEditSubcategoryModal);
editSubcategoryModal.on('hide.bs.modal', clearEditSubcategoryForm);

const deleteBtn = $('#delete');
deleteBtn.on('click', deleteListingEventHandler);

const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [3] },
    ],
};

const table = $('#subcategory-list-table').DataTable(tableOptions);

function showNewSubcategoryModal(e) {
    e.preventDefault();
    newSubcategoryModal.modal({
        backdrop: 'static',
    });
}

function showEditSubcategoryModal(e) {
    e.preventDefault();
    let id = $(e.currentTarget).data('entityId');
    editSubcategoryModal.data('modalEntityId', id);
    getSubcategoryJsonData(id)
        .done((data) => {
            editSubcategoryModal.modal({
                backdrop: 'static',
            });
            if (isModelOpen()) {
                populateEditForm(editSubcategoryForm, data);
            }
        });
}

function isModelOpen() {
    return ($('body').hasClass('modal-open'));
}

function closeNewSubcategoryModal() {
    newSubcategoryModal.modal('hide');
}

function closeEditSubcategoryModal() {
    editSubcategoryModal.modal('hide');
}

function closeEditModalAlias() {
    closeEditSubcategoryModal();
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
    subcategoryName: {
        required: true,
        minlength: 2,
        maxlength: 100,
    },
};

let newSubcategoryFormValidator = newSubcategoryForm.validate({
    submitHandler: createNewSubcategory,
    rules,
    // messages: {},
});

let editSubcategoryFormValidator = editSubcategoryForm.validate({
    submitHandler: updateSubcategory,
    rules,
    // messages: {},
});

function updateSubcategory(form) {
    confirmUpdate()
        .then((result) => {
            if (result.value) {
                sendUpdatedSubcategoryData(form)
                    .done((response) => {
                        subcategoryUpdateFeedback(response);
                        getSubcategoryRowPartial(response.data.id) // update the subcategory list
                            .done((partial) => {
                                // remove old row
                                table.row($(`tr#${response.data.id}`)).remove();
                                // add the updated row
                                table.row.add($(partial)).draw();
                                // attach event listener to the row's edit button
                                $(`#${response.data.id} .edit-subcategory`).on('click', showEditSubcategoryModal);
                                // highlight the updated row
                                highLightRow(response.data.id);
                            });
                    });
            } else if (result.dismiss) {
                cancelUpdateFeedBack();
            }
        });
}

function createNewSubcategory(form) {
    sendNewSubcategoryData(form)
        .done((response) => {
            subcategoryCreationFeedback(response);
            getSubcategoryRowPartial(response.data.id) // update the subcategory list
                .done((partial) => {
                    table.row.add($(partial)).draw();
                    $(`#${response.data.id} .edit-subcategory`).on('click', showEditSubcategoryModal);
                    highLightRow(response.data.id);
                });
        });
}

function deleteListingEventHandler(e) {
    e.preventDefault();
    let id = editSubcategoryModal.data('modalEntityId');
    confirmDelete()
        .then((result) => {
            if (result.value) {
                deleteSubcategory(id)
                    .done((response) => {
                        deleteSuccessFeedBack(response);
                    });
            } else if (result.dismiss) {
                cancelDeleteFeedBack();
            }
        });
}

function deleteSubcategory(id) {
    console.log(id);
    return $.ajax({
        method: 'POST',
        data: { id },
        dataType: 'json',
        url: urlFor('/inventory/subcategory/delete'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function highLightRow(id) {
    $('tr').removeClass('updated');
    $(`tr#${id}`).addClass('updated');
}

function getSubcategoryRowPartial(id) {
    return $.ajax({
        method: 'GET',
        data: {
            type: 'rowpartial',
            id,
        },
        dataType: 'html',
        url: urlFor('/inventory/subcategory/view'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function getSubcategoryJsonData(id) {
    return $.ajax({
        method: 'GET',
        data: { id },
        dataType: 'json',
        url: urlFor('/inventory/subcategory/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendNewSubcategoryData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/inventory/subcategory/new'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendUpdatedSubcategoryData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/inventory/subcategory/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function subcategoryCreationFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Success!',
            text: `New Subcategory '${id} - ${name}' Created Successfully`,
            onBeforeOpen: () => {
                closeNewSubcategoryModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error creating subcategory',
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

function subcategoryUpdateFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Success!',
            text: `Subcategory '${id} - ${name}' Updated Successfully`,
            onBeforeOpen: () => {
                closeEditSubcategoryModal();
            },
        }).then((result) => {
            console.log('then result', result);
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating subcategory',
        });
    }
}

function clearNewSubcategoryForm() {
    let data = newSubcategoryForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    newSubcategoryFormValidator.resetForm();
    $('#new-subcategory-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = newSubcategoryForm.serializeArray();
    console.log(cdata);
}

function clearEditSubcategoryForm() {
    let data = editSubcategoryForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    editSubcategoryFormValidator.resetForm();
    $('#edit-subcategory-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = editSubcategoryForm.serializeArray();
    console.log(cdata);
}
