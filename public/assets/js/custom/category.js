const newCategoryBtn = $('#new-category-btn');
const newCategoryModal = $('#new-category-modal');
const newCategoryForm = $('#new-category-form');
newCategoryBtn.on('click', showNewCategoryModal);
newCategoryModal.on('hide.bs.modal', clearNewCategoryForm);

const editCategoryBtn = $('.edit-category');
const editCategoryModal = $('#edit-category-modal');
const editCategoryForm = $('#edit-category-form');
const editCategory = $('.edit-category');
editCategoryBtn.on('click', showEditCategoryModal);
editCategoryModal.on('hide.bs.modal', clearEditCategoryForm);

const tableOptions = {
    paging: true,
    searching: true,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [2] },
    ],
};

const table = $('#category-list-table').DataTable(tableOptions);

function showNewCategoryModal(e) {
    e.preventDefault();
    newCategoryModal.modal('show');
}

function showEditCategoryModal(e) {
    e.preventDefault();
    let id = $(e.currentTarget).data('entityId');
    getCategoryJsonData(id)
        .done((data) => {
            editCategoryModal.modal('show');
            if (isModelOpen()) {
                populateEditForm(editCategoryForm, data);
            }
        });
}

function isModelOpen() {
    return ($('body').hasClass('modal-open'));
}

function closeNewCategoryModal() {
    newCategoryModal.modal('hide');
}

function closeEditCategoryModal() {
    editCategoryModal.modal('hide');
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
    name: {
        required: true,
        minlength: 2,
        maxlength: 100,
    },
};

let newCategoryFormValidator = newCategoryForm.validate({
    submitHandler: createNewCategory,
    rules,
    // messages: {},
});

let editCategoryFormValidator = editCategoryForm.validate({
    submitHandler: updateCategory,
    rules,
    // messages: {},
});

function updateCategory(form) {
    sendUpdatedCategoryData(form)
        .done((response) => {
            categoryUpdateFeedback(response);
            getCategoryRowPartial(response.data.id) // update the category list
                .done((partial) => {
                    // remove old row
                    table.row($(`tr#${response.data.id}`)).remove();
                    // add the updated row
                    table.row.add($(partial)).draw();
                    // attach event listener to the row's edit button
                    $(`#${response.data.id} .edit-category`).on('click', showEditCategoryModal);
                    // highlight the updated row
                    highLightRow(response.data.id);
                });
        });
}

function createNewCategory(form) {
    sendNewCategoryData(form)
        .done((response) => {
            categoryCreationFeedback(response);
            getCategoryRowPartial(response.data.id) // update the category list
                .done((partial) => {
                    table.row.add($(partial)).draw();
                    $(`#${response.data.id} .edit-category`).on('click', showEditCategoryModal);
                    highLightRow(response.data.id);
                });
        });
}

function highLightRow(id) {
    $('tr').removeClass('updated');
    $(`tr#${id}`).addClass('updated');
}

function getCategoryRowPartial(id) {
    return $.ajax({
        method: 'GET',
        data: {
            type: 'rowpartial',
            id,
        },
        dataType: 'html',
        url: urlFor('/inventory/category/view'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function getCategoryJsonData(id) {
    return $.ajax({
        method: 'GET',
        data: { id },
        dataType: 'json',
        url: urlFor('/inventory/category/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendNewCategoryData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/inventory/category/new'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function sendUpdatedCategoryData(form) {
    let data = $(form).serializeArray();
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        data,
        url: urlFor('/inventory/category/edit'),
    }).fail((jqHr, err) => {
        console.log(err, jqHr);
    });
}

function categoryCreationFeedback(response) {
    let code = response.status;
    let name = response.data.name;
    let id = response.data.id;
    if (code === 0) {
        swalB.fire({
            type: 'success',
            title: 'Suceess!',
            text: `New Category '${id} - ${name}' Created Successfully`,
            onAfterClose() {
                closeNewCategoryModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error creating category',
        });
    }
}

function categoryUpdateFeedback(response) {
    let code = response.status;
    let name = response.data.name;
    let id = response.data.id;
    if (code === 0) {
        swalB.fire({
            type: 'success',
            title: 'Suceess!',
            text: `Category '${id} - ${name}' Updated Successfully`,
            onAfterClose() {
                closeEditCategoryModal();
            },
        });
    } else {
        swalB.fire({
            type: 'error',
            title: 'Error!',
            text: 'Error updating category',
        });
    }
}

function clearNewCategoryForm() {
    let data = newCategoryForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    newCategoryFormValidator.resetForm();
    $('#new-category-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = newCategoryForm.serializeArray();
    console.log(cdata);
}

function clearEditCategoryForm() {
    let data = editCategoryForm.serializeArray().forEach((d) => {
        $(`[name*=${d.name}]`).val('');
    });
    editCategoryFormValidator.resetForm();
    $('#edit-category-form :input').removeClass('is-valid');
    console.log('clearing form');
    let cdata = editCategoryForm.serializeArray();
    console.log(cdata);
}
