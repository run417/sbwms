const newSupplierBtn = $('#new-supplier-btn');
const newSupplierModal = $('#new-supplier-modal');
const newSupplierForm = $('#new-supplier-form');
newSupplierBtn.on('click', showNewSupplierModal);
newSupplierModal.on('hide.bs.modal', clearNewSupplierForm);

const editSupplierBtn = $('.edit-supplier');
const editSupplierModal = $('#edit-supplier-modal');
const editSupplierForm = $('#edit-supplier-form');
const editSupplier = $('.edit-supplier');
editSupplierBtn.on('click', showEditSupplierModal);
editSupplierModal.on('hide.bs.modal', clearEditSupplierForm);

const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [5] },
    ],
};

const table = $('#supplier-list-table').DataTable(tableOptions);

function showNewSupplierModal(e) {
    e.preventDefault();
    newSupplierModal.modal('show');
}

function showEditSupplierModal(e) {
    e.preventDefault();
    let id = $(e.currentTarget).data('entityId');
    getSupplierJsonData(id)
        .done((data) => {
            editSupplierModal.modal('show');
            if (isModelOpen()) {
                populateEditForm(editSupplierForm, data);
            }
        });
}

function isModelOpen() {
    return ($('body').hasClass('modal-open'));
}

function closeNewSupplierModal() {
    newSupplierModal.modal('hide');
}

function closeEditSupplierModal() {
    editSupplierModal.modal('hide');
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
    console.log(dataObject);
    // the response object is a customer json object
    // the form array consists of js objects with
    // name and value properties
    let formArray = formElement.serializeArray();
    console.log(formArray);
    formArray.forEach((elem) => {
        if (Object.prototype.hasOwnProperty.call(dataObject, elem.name)) {
            console.log(dataObject[elem.name]);
            $(`[name*=${elem.name}]`).val(dataObject[elem.name]);
        }
    });
}

let rules = {
    supplierName: {
        required: true,
        minlength: 2,
        maxlength: 100,
    },
    companyName: {
        required: true,
        minlength: 2,
        maxlength: 100,
    },
    telephone: {
        required: true,
    },
    email: {
        required: true,
        email: true,
    },
};

let newSupplierFormValidator = newSupplierForm.validate({
    submitHandler: createNewSupplier,
    rules,
    // messages: {},
});

let editSupplierFormValidator = editSupplierForm.validate({
    submitHandler: updateSupplier,
    rules,
    // messages: {},
});

function updateSupplier(form) {
    sendUpdatedSupplierData(form)
        .done((response) => {
            supplierUpdateFeedback(response);
            getSupplierRowPartial(response.data.id) // update the supplier list
                .done((partial) => {
                    // remove old row
                    table.row($(`tr#${response.data.id}`)).remove();
                    // add the updated row
                    table.row.add($(partial)).draw();
                    // attach event listener to the row's edit button
                    $(`#${response.data.id} .edit-supplier`).on('click', showEditSupplierModal);
                    // highlight the updated row
                    highLightRow(response.data.id);
                });
        });
}

function createNewSupplier(form) {
    sendNewSupplierData(form)
        .done((response) => {
            supplierCreationFeedback(response);
            getSupplierRowPartial(response.data.id) // update the supplier list
                .done((partial) => {
                    table.row.add($(partial)).draw();
                    $(`#${response.data.id} .edit-supplier`).on('click', showEditSupplierModal);
                    highLightRow(response.data.id);
                });
        });
}

function highLightRow(id) {
    $('tr').removeClass('updated');
    $(`tr#${id}`).addClass('updated');
}

function getSupplierRowPartial(id) {
    return $.ajax({
        method: 'GET',
        data: {
            type: 'rowpartial',
            id,
        },
        dataType: 'html',
        url: urlFor('/inventory/supplier/view'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function getSupplierJsonData(id) {
    return $.ajax({
        method: 'GET',
        data: { id },
        dataType: 'json',
        url: urlFor('/inventory/supplier/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendNewSupplierData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/inventory/supplier/new'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendUpdatedSupplierData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/inventory/supplier/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function supplierCreationFeedback(response) {
    let code = response.status;
    let name = response.data.name;
    let id = response.data.id;
    if (code === 0) {
        swalB.fire({
            type: 'success',
            title: 'Suceess!',
            text: `New Supplier '${id} - ${name}' Created Successfully`,
            onAfterClose() {
                closeNewSupplierModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error creating supplier',
        });
    }
}

function supplierUpdateFeedback(response) {
    let code = response.status;
    let name = response.data.name;
    let id = response.data.id;
    if (code === 0) {
        swalB.fire({
            type: 'success',
            title: 'Suceess!',
            text: `Supplier '${id} - ${name}' Updated Successfully`,
            onAfterClose() {
                closeEditSupplierModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating supplier',
        });
    }
}

function clearNewSupplierForm() {
    let data = newSupplierForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    newSupplierFormValidator.resetForm();
    $('#new-supplier-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = newSupplierForm.serializeArray();
    console.log(cdata);
}

function clearEditSupplierForm() {
    let data = editSupplierForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    editSupplierFormValidator.resetForm();
    $('#edit-supplier-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = editSupplierForm.serializeArray();
    console.log(cdata);
}
