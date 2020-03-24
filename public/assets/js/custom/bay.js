const newBayBtn = $('#new-bay-btn');
const newBayModal = $('#new-bay-modal');
const newBayForm = $('#new-bay-form');
newBayBtn.on('click', showNewBayModal);
newBayModal.on('hide.bs.modal', clearNewBayForm);

const editBayBtn = $('.edit-bay');
const editBayModal = $('#edit-bay-modal');
const editBayForm = $('#edit-bay-form');
const editBay = $('.edit-bay');
editBayBtn.on('click', showEditBayModal);
editBayModal.on('hide.bs.modal', clearEditBayForm);

const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [3] },
    ],
};

const table = $('#bay-list-table').DataTable(tableOptions);

function showNewBayModal(e) {
    e.preventDefault();
    newBayModal.modal('show');
}

function showEditBayModal(e) {
    e.preventDefault();
    let id = $(e.currentTarget).data('entityId');
    getBayJsonData(id)
        .done((data) => {
            editBayModal.modal('show');
            if (isModelOpen()) {
                populateEditForm(editBayForm, data);
            }
        });
}

function isModelOpen() {
    return ($('body').hasClass('modal-open'));
}

function closeNewBayModal() {
    newBayModal.modal('hide');
}

function closeEditBayModal() {
    editBayModal.modal('hide');
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
    bayType: {
        required: true,
    },
    bayStatus: {
        required: true,
    },
};

let newBayFormValidator = newBayForm.validate({
    submitHandler: createNewBay,
    rules,
    // messages: {},
});

let editBayFormValidator = editBayForm.validate({
    submitHandler: updateBay,
    rules,
    // messages: {},
});

function updateBay(form) {
    sendUpdatedBayData(form)
        .done((response) => {
            bayUpdateFeedback(response);
            getBayRowPartial(response.data.id) // update the bay list
                .done((partial) => {
                    // remove old row
                    table.row($(`tr#${response.data.id}`)).remove();
                    // add the updated row
                    table.row.add($(partial)).draw();
                    // attach event listener to the row's edit button
                    $(`#${response.data.id} .edit-bay`).on('click', showEditBayModal);
                    // highlight the updated row
                    highLightRow(response.data.id);
                });
        });
}

function createNewBay(form) {
    sendNewBayData(form)
        .done((response) => {
            bayCreationFeedback(response);
            getBayRowPartial(response.data.id) // update the bay list
                .done((partial) => {
                    table.row.add($(partial)).draw();
                    $(`#${response.data.id} .edit-bay`).on('click', showEditBayModal);
                    highLightRow(response.data.id);
                });
        });
}

function highLightRow(id) {
    $('tr').removeClass('updated');
    $(`tr#${id}`).addClass('updated');
}

function getBayRowPartial(id) {
    return $.ajax({
        method: 'GET',
        data: {
            type: 'rowpartial',
            id,
        },
        dataType: 'html',
        url: urlFor('/service/bay/view'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function getBayJsonData(id) {
    return $.ajax({
        method: 'GET',
        data: { id },
        dataType: 'json',
        url: urlFor('/service/bay/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendNewBayData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/service/bay/new'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendUpdatedBayData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/service/bay/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function bayCreationFeedback(response) {
    let code = response.status;
    let name = response.data.name;
    let id = response.data.id;
    if (code === 0) {
        swalB.fire({
            type: 'success',
            title: 'Suceess!',
            text: `New Bay '${id} - ${name}' Created Successfully`,
            onAfterClose() {
                closeNewBayModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error creating bay',
        });
    }
}

function bayUpdateFeedback(response) {
    let code = response.status;
    let name = response.data.name;
    let id = response.data.id;
    if (code === 0) {
        swalB.fire({
            type: 'success',
            title: 'Suceess!',
            text: `Bay '${id} - ${name}' Updated Successfully`,
            onAfterClose() {
                closeEditBayModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating bay',
        });
    }
}

function clearNewBayForm() {
    let data = newBayForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    newBayFormValidator.resetForm();
    $('#new-bay-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = newBayForm.serializeArray();
    console.log(cdata);
}

function clearEditBayForm() {
    let data = editBayForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    editBayFormValidator.resetForm();
    $('#edit-bay-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = editBayForm.serializeArray();
    console.log(cdata);
}
