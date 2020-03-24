const newServiceTypeBtn = $('#new-service-type-btn');
const newServiceTypeModal = $('#new-service-type-modal');
const newServiceTypeForm = $('#new-service-type-form');
newServiceTypeBtn.on('click', showNewServiceTypeModal);
newServiceTypeModal.on('hide.bs.modal', clearNewServiceTypeForm);

const editServiceTypeBtn = $('.edit-service-type');
const editServiceTypeModal = $('#edit-service-type-modal');
const editServiceTypeForm = $('#edit-service-type-form');
const editServiceType = $('.edit-service-type');
editServiceTypeBtn.on('click', showEditServiceTypeModal);
editServiceTypeModal.on('hide.bs.modal', clearEditServiceTypeForm);

const deleteBtn = $('#delete');
deleteBtn.on('click', deleteListingEventHandler);

const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [4] },
    ],
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'print',
            title: 'Operational Service Types',
            exportOptions: {
                columns: [0, 1, 2, 3],
            },
        },
    ],
};

const table = $('#service-type-list-table').DataTable(tableOptions);

function showNewServiceTypeModal(e) {
    e.preventDefault();
    newServiceTypeModal.modal({
        backdrop: 'static',
    });
}

function showEditServiceTypeModal(e) {
    e.preventDefault();
    let id = $(e.currentTarget).data('entityId');
    editServiceTypeModal.data('modalEntityId', id);
    getServiceTypeJsonData(id)
        .done((data) => {
            editServiceTypeModal.modal({
                backdrop: 'static',
            });
            if (isModelOpen()) {
                populateEditForm(editServiceTypeForm, data);
            }
        });
}

function isModelOpen() {
    return ($('body').hasClass('modal-open'));
}

function closeNewServiceTypeModal() {
    newServiceTypeModal.modal('hide');
}

function closeEditServiceTypeModal() {
    editServiceTypeModal.modal('hide');
}

function closeEditModalAlias() {
    closeEditServiceTypeModal();
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
    hours: {
        required: true,
    },
    minutes: {
        required: true,
    },
    name: {
        required: true,
        minlength: 2,
        maxlength: 100,
        remote: {
            url: urlFor('/service/type/is-unique'),
            data: {
                name: () => $('.modal.show form [name=name]').val(),
                id: () => $('.modal.show form [name=serviceTypeId]').val(),
            },
            type: 'GET',
        },
    },
    status: {
        required: true,
    },
};

// let editNameUniqueRule = {
//     url: urlFor('/service/type/is-unique'),
//     data: {
//         name: () => $('.modal.show form [name=name]').val(),
//         id: () => $('.modal.show form [name=serviceTypeId]').val(),
//     },
//     type: 'GET',
// }

let newServiceTypeFormValidator = newServiceTypeForm.validate({
    submitHandler: createNewServiceType,
    rules,
    // messages: {},
});

let editServiceTypeFormValidator = editServiceTypeForm.validate({
    submitHandler: updateServiceType,
    rules,
    // messages: {},
});

function updateServiceType(form) {
    confirmUpdate()
        .then((result) => {
            if (result.value) {
                sendUpdatedServiceTypeData(form)
                    .done((response) => {
                        serviceTypeUpdateFeedback(response);
                        getServiceTypeRowPartial(response.data.id) // update the servicetype list
                            .done((partial) => {
                                // remove old row
                                table.row($(`tr#${response.data.id}`)).remove();
                                // add the updated row
                                table.row.add($(partial)).draw();
                                // attach event listener to the row's edit button
                                $(`#${response.data.id} .edit-service-type`).on('click', showEditServiceTypeModal);
                                // highlight the updated row
                                highLightRow(response.data.id);
                            });
                    });
            } else if (result.dismiss) {
                cancelUpdateFeedBack();
            }
        });
}

function createNewServiceType(form) {
    sendNewServiceTypeData(form)
        .done((response) => {
            serviceTypeCreationFeedback(response);
            getServiceTypeRowPartial(response.data.id) // update the servicetype list
                .done((partial) => {
                    table.row.add($(partial)).draw();
                    $(`#${response.data.id} .edit-service-type`).on('click', showEditServiceTypeModal);
                    highLightRow(response.data.id);
                });
        });
}

function deleteListingEventHandler(e) {
    e.preventDefault();
    let id = editServiceTypeModal.data('modalEntityId');
    confirmDelete()
        .then((result) => {
            if (result.value) {
                deleteServiceType(id)
                    .done((response) => {
                        deleteSuccessFeedBack(response);
                    });
            } else if (result.dismiss) {
                cancelDeleteFeedBack();
            }
        });
}

function deleteServiceType(id) {
    console.log(id);
    return $.ajax({
        method: 'POST',
        data: { id },
        dataType: 'json',
        url: urlFor('/service/type/delete'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function highLightRow(id) {
    $('tr').removeClass('updated');
    $(`tr#${id}`).addClass('updated');
}

function getServiceTypeRowPartial(id) {
    return $.ajax({
        method: 'GET',
        data: {
            type: 'rowpartial',
            id,
        },
        dataType: 'html',
        url: urlFor('/service/type/view'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function getServiceTypeJsonData(id) {
    return $.ajax({
        method: 'GET',
        data: { id },
        dataType: 'json',
        url: urlFor('/service/type/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendNewServiceTypeData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/service/type/new'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendUpdatedServiceTypeData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/service/type/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function serviceTypeCreationFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Success!',
            text: `New Service Type '${id} - ${name}' Created Successfully`,
            onBeforeOpen: () => {
                closeNewServiceTypeModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error creating Service Type',
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

function serviceTypeUpdateFeedback(response) {
    let code = response.status;
    if (code === 0) {
        let name = response.data.name;
        let id = response.data.id;
        swalB.fire({
            type: 'success',
            title: 'Success!',
            text: `Service Type '${id} - ${name}' Updated Successfully`,
            onBeforeOpen: () => {
                closeEditServiceTypeModal();
            },
        }).then((result) => {
            console.log('then result', result);
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating service type',
        });
    }
}

function clearNewServiceTypeForm() {
    let data = newServiceTypeForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    newServiceTypeFormValidator.resetForm();
    $('#new-service-type-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = newServiceTypeForm.serializeArray();
    console.log(cdata);
}

function clearEditServiceTypeForm() {
    let data = editServiceTypeForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    editServiceTypeFormValidator.resetForm();
    $('#edit-service-type-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = editServiceTypeForm.serializeArray();
    console.log(cdata);
}
