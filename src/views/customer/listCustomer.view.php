<?php 
$title = "Customer - SBWMS";
require_once(COMMON_VIEWS . 'header.php'); 
?>
<body>
    <style>
        .updated {
            background-color: hsla(125, 68%, 90%, 1);
        }
        .modal-header {
            background-color: hsl(203, 92%, 88%);
            border-bottom: none;
            /* border-radius: 15px 15px 0px 0px; */
            min-height: 63px;
        }
        .modal-content {
            border-radius: 1.2rem;
            /* border: 2px solid hsl(0, 0%, 0%); */
        }

        .custom-checkbox {
            padding-top: 3px;
            padding-bottom: 3px;
        }
        .form-section-heading {
            background-color: #529fff26;
            padding-bottom: 3px;
            padding-top: 3px;
            margin-left: -15px;
            margin-right: -15px;
            margin-bottom: 15px;
            box-shadow: 1px 2px 2px #eeeeee;
        }
        h5 {
            margin-left: 15px;
            margin-bottom: 0px;
        }
    </style>

    <div class="wrapper">
        <!-- sidebar start -->
        <?php 
            $breadcrumbMarkUp = breadcrumbs(['Customer' => '/customer'], 'Customer');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="customer"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
        <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                    <div class="card" id="customer_list_card">
                        <div class="card-header">
                            <h4 class="card-title">Customers</h4>
                            <a href="<?= url_for('/customer/new'); ?>"  class="btn btn-primary btn-lg" id="new_customer_btn">New Customer</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="customer_list_table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Customer Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Telephone</th>
                                            <th>Email</th>
                                            <th>View</th>
                                            <th>Edit</th>
                                            <!-- <th>&nbsp;</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($customers as $c): ?>
                                        <tr id="<?= $c->getCustomerId(); ?>">
                                            <td><?= $c->getCustomerId(); ?></td>
                                            <td><?= $c->getFirstName(); ?></td>
                                            <td><?= $c->getLastName(); ?></td>
                                            <td><?= $c->getTelephone(); ?></td>
                                            <td><?= $c->getEmail(); ?></td>
                                            <td><a href="<?= url_for('/customer/view?id=') . $c->getCustomerId(); ?>"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="View Customer Details"></i></a></td>
                                            <td><a class="edit_customer" href=""><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Customer"></i></a></td>
                                            <!-- <td></td> -->
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer"></div>
                    </div> <!-- </card> -->
    
                </div> <!-- <col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->        
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->
    
    <!-- Modal -->
    <div data-entityId="" class="modal" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustomerModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Customer Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <!-- START FORM -->
            <form id="edit_customer_form">
                <div class="form-section-heading">
                    <h5>Personal</h5>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="customer_id">Customer Id</label> 
                        <input id="customer_id" name="customerId" type="text" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="customer_title">Title</label> 
                        <select id="customer_title" name="title" class="custom-select">
                            <option value="">Select Title</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Dr.">Dr.</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="customer_first_name">First Name</label> 
                        <input id="customer_first_name" name="firstName" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customer_last_name">Last Name</label> 
                        <input id="customer_last_name" name="lastName" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="customer_telephone">Telephone</label> 
                        <input id="customer_telephone" name="telephone" type="tel" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customer_email">Email</label> 
                        <input id="customer_email" name="email" type="email" class="form-control">
                    </div>
                </div>
                <div class="form-section-heading">
                    <h5>Vehicle</h5>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="vehicle_make">Make</label> 
                        <input id="vehicle_make" name="make" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="vehicle_model">Model</label> 
                        <input id="vehicle_model" name="model" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="vehicle_year">Year</label> 
                        <input id="vehicle_year" name="year" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="vehicle_reg_no">Registration No.</label> 
                        <input id="vehicle_reg_no" name="regNo" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="vehicle_vin">VIN No</label> 
                        <input id="vehicle_vin" name="vin" type="text" class="form-control">
                    </div>
                </div>
            </div>
        <div class="modal-footer">
            <button id="form_submit" type="submit" class="btn btn-primary">Update Customer Details</button>
        </form>
        <!-- END FORM -->
        </div>
        </div>
        <!-- /modal-content -->
    </div> <!-- </modal-dialog> -->
    </div>
    <!-- End Modal -->
    
    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>
        /*
            What is done here is not that big
            list dependencies of each function. The variables

            This script does four functions
            1. Get the customer details when the edit modal button is clicked
            2. Populate the edit modal form with the above customer details
            3. validate the fields of the edit modal if the populated fields are altered
            4. Submit the form to be saved in the database
            5. On successful submit of the data update the table row of the list
            by altering the html. The updated data is not retrieved from the
            database but collected from the valid user data.
        */
        const editCustomerForm = $('#edit_customer_form');
        const table = $('#customer_list_table');
        const editModal = $('#editCustomerModal');
        const editCustomer = document.querySelectorAll('.edit_customer');
        const dtColumnOrder = ['customerId', 'firstName', 'lastName', 'telephone', 'email'];

        // the following is needed for the reconstruction of the table row
        let editLinkHtml = ''; // outerHTML of .edit_customer element used in a datatable row.
        let showLinkHtml = '';

        function isModelOpen() {
            return ($('body').hasClass('modal-open'));
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
            let formArray = editCustomerForm.serializeArray();
            console.log(formArray);
            formArray.forEach((elem) => {
                if (Object.prototype.hasOwnProperty.call(dataObject, elem.name)) {
                    console.log(dataObject[elem.name]);
                    $(`[name*=${elem.name}]`).val(dataObject[elem.name]);
                }
            });
        }

        function getCustomerDetails() {
            let id = $(this).data('entityId');
            console.log('event fired modal');
            $.ajax({
                method: 'GET',
                data: { id },
                url: '<?= url_for("/customer/edit"); ?>',
                dataType: 'json',
                success: (response) => {
                    if (isModelOpen()) {
                        console.log('modal is open');
                        populateEditForm(editCustomerForm, response);
                    } else {
                        console.log('modal not open');
                    }
                },
                error: (jqXHR, textStatus) => {
                    console.log(textStatus);
                    console.log(jqXHR.responseText);
                },
            });
        }

        // depends on form data, column order, showLink, editLink
        function updateRow(formData) {
            let data = formData;
            /*
                make datatable data array according to
                the datatable column order
            */

            console.log(dtColumnOrder);

            let updatedRow = [];

            // compares each form field with each column in
            // the table. If the form field name matches the
            // a column name then it (form field value) is pushed to
            // the updated row.
            data.forEach((d) => {
                dtColumnOrder.forEach((c) => {
                    if (d.name === c) {
                        updatedRow.push(d.value);
                    }
                });
            });

            // puts the edit and show html in the updated row
            updatedRow.push(showLinkHtml);
            updatedRow.push(editLinkHtml);

            console.log(updatedRow);

            console.log(data[0].value);
            // show the original row data (DT row selector)
            console.log(dataTable.row(`#${data[0].value}`).data());

            // update the row
            dataTable.row(`#${data[0].value}`).data(updatedRow);

            // show the updated row
            console.log(dataTable.row(`#${data[0].value}`).data());

            // attach the function showModal to click event of the edit link
            console.log($(`tr#${data[0].value}>td>a.edit_customer`).on('click', showModal));

            // add css class to the row to show it was updated
            console.log($(`tr#${data[0].value}`).addClass('updated'));
        }

        // clear the form when the modal is closed
        // clear values, validations, and modal entityId
        function clearform() {
            editModal.data('entityId', '');
            let data = editCustomerForm.serializeArray().forEach((d) => {
                $(`[name*=${d.name}]`).val('');
            });
            formValidator.resetForm();
            console.log('clear form');
            let cdata = editCustomerForm.serializeArray();
            console.log(cdata);
        }

        /* START VALIDATION */

        const formValidator = editCustomerForm.validate({
            submitHandler,
            // onfocusout: (element) => {
            //     $(element).valid();
            // },
            rules: {
                title: {
                    required: true,
                },
                firstName: {
                    required: true,
                    maxlength: 255,
                },
                lastName: {
                    required: true,
                    maxlength: 255,
                },
                telephone: {
                    required: true,
                },
                email: {
                    required: true,
                },
                // make: {
                //     required: true,
                //     minlength: 2,
                //     maxlength: 255,
                // },
                // model: {
                //     required: true,
                //     minlength: 2,
                //     maxlength: 255,
                // },
                // year: {
                //     required: true,
                //     digits: true,
                //     minlength: 4,
                //     maxlength: 4,
                // },
            },
            messages: {
                firstName: {
                    required: 'Please enter customer\'s first name',
                    minlength: 'First name should be more than a character',
                },
                lastName: {
                    required: 'Please enter customer\'s last name',
                    minlength: 'Last name should be more than a character',
                },
                telephone: {
                    required: 'Please enter customer\'s telephone number',
                },
                email: {
                    required: 'Please enter customer\'s email',
                },
                year: {
                    required: 'Please provide the vehicle\'s manufacture year',
                    digits: 'Please enter a valid in the form YYYY',
                    minlength: 'Please enter a valid in the form YYYY',
                    maxlength: 'Please enter a valid in the form YYYY',
                },
            },
            errorClass: 'is-invalid',
            errorElement: 'label',
            validClass: 'is-valid',
            errorPlacement: (error, element) => {
                error.addClass('invalid-feedback');
                if (element.prop('type') === 'checkbox') {
                    error.insertAfter(element.next('label'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: (element, errorClass, validClass) => {
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: (element, errorClass, validClass) => {
                $(element).addClass(validClass).removeClass(errorClass);
            },
        });

        /* END VALIDATION */

        /*
            on clicking the edit button this function fires
            right now: it gets the id of a customer which is also
            the id of the edit link.
            then it registers an event (once only) 'shown.bs.modal' and an
            handler function called getCustomerDetails which is nested
            in this showModal function
            Then the modal is fired and getCustomerDetails is fired too.

            getCustomerDetails function is nested in showModal function
            it sends an ajax request to get the customer details. It gets
            the id of a customer from showModal function.
            Then on success a json customer object is received. Inside the
            success function the editForm is serialized into an array.
            We loop through this array and for each if the returned
            customer json object also has that property then that
            element is selected and populated with the customer property.
        */

        /*
            showModal function
                get the id from the row html
                get the edit link html
                get the show link html

                attach event listener to fire function 'getCustomerDetails'
                    once the modal is shown

                show the modal

            getCustomerDetails function
                get customer details using the id of the row in showModal()
                populate the edit modal form using the above details
                    but only if the modal is open

         */
        function showModal(e) {
            e.preventDefault();
            // set the data attribute for getCustomerDetails()
            editModal.data('entityId', this.parentElement.parentElement.id);

            console.dir(this.outerHTML);
            console.dir(this.parentElement.previousElementSibling.innerHTML);

            editLinkHtml = this.outerHTML;
            showLinkHtml = this.parentElement.previousElementSibling.innerHTML;

            // when the modal is shown get the customer details
            // the eventlistener is removed after it is attached
            // (once only listener) so everytime this modal is opened
            // the event is attached and detached.
            editModal.one('shown.bs.modal', getCustomerDetails);

            // show the modal
            editModal.modal({
                show: true,
            });
        }

        // this function is part of the validation plugin
        // fires only if the form is valid
        function submitHandler() {
            // get the data from the edit form
            let data = editCustomerForm.serializeArray();

            // submit the data
            $.ajax({
                url: '<?= url_for("/customer/edit"); ?>',
                method: 'POST',
                dataType: 'json',
                data,
                error: (response, err) => {
                    console.log(response);
                    console.log(err);
                },
                success: (response) => {
                    // in the case of success error response then too the row
                    // will be updated which is not what we want.
                    if (response.success === 0) {
                        // update the dataTable row
                        updateRow(data);

                        // the success response by the server
                        console.log(response);
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'Customer Updated',
                            background: '#ceebfd',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                            onAfterClose: () => {
                                editModal.modal('hide');
                            },
                        });
                    } else { // response.success is not 0
                        Swal.fire({
                            type: 'error',
                            title: 'Failure!',
                            text: 'Customer Update Failed',
                            background: '#ceebfd',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                            onAfterClose: () => {
                            },
                        });
                    }
                },
            });
        }

        let dataTable = table.DataTable({
            paging: true,
            searching: true,
            order: [[0, 'desc']],
            columnDefs: [
                { orderable: false, targets: [5, 6] },
            ],
        });

        editModal.on('hide.bs.modal', clearform);
        editCustomer.forEach(b => b.addEventListener('click', showModal));
    </script>
</body>
</html>
