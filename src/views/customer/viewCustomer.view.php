<?php 
require_once(COMMON_VIEWS . 'header.php');

?>
<body>
    <style>
        .updated {
            background-color: hsla(125, 68%, 90%, 1);
        }
        .box {
            border: 1px solid hsl(0, 0%, 83%);
            min-height: 200px;
            padding: 6px;
        }
        .box-header {
            /* border: 1px solid red; */
            /* padding: 2px; */
            padding-bottom: 5px;
        }
        .box-title {

            /* border: 3px solid blue; */
        }
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $c = $customer;
            $breadcrumbMarkUp = breadcrumbs(['Customer' => '/customer', 'View' => '#', $c->getCustomerId() => '#'], '$c->getCustomerId()');
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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Customer Details</h4>
                            <!-- <a href="<?= url_for('#'); ?>" class="btn btn-primary btn-lg">button</a> -->
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-1">
                                <div id="personal" class="mr-1 box">
                                    <div class="box-header">
                                        <div class="box-title">Personal</div>
                                    </div>
                                    <p>
                                        <?= $c->getCustomerId(); ?>
                                    </p>
                                    <p>
                                        <?= $c->getFullName(); ?>
                                    </p>
                                    <p>
                                        <?= $c->getRegDate(); ?>
                                    </p>
                                </div>
                                <div class="flex-grow-1 box">
                                    <div class="box-header">
                                        <div class="box-title">Online Profile</div>
                                    </div>
                                </div>
                            </div>

                            <div class="box" id="vehicle">
                                <div class="box-header d-flex justify-content-between">
                                    <div class="box-title">Customer's Vehicles</div>
                                    <a href="#"  class="btn btn-primary btn-sm" id="add_vehicle_btn">Add Vehicle</a>
                                </div>

                                <div id="vehicle-list">
                                    <div class="table-responsive">
                                        <table id="customer_list_table" class="table table-hover">
                                        <?php if (!empty($c->getVehicles())): ?>
                                            <thead>
                                                <tr>
                                                    <th>Vehicle Id</th>
                                                    <th>Make</th>
                                                    <th>Model</th>
                                                    <th>Year</th>
                                                    <th>Reg No</th>
                                                    <th>Edit</th>
                                                    <!-- <th>&nbsp;</th> -->
                                                </tr>
                                            </thead>
                                        <?php else: echo 'This customer has no vehicles'; ?>
                                        <?php endif; ?>
                                            <tbody>
                                                <?php foreach ($c->getVehicles() as $v): ?>
                                                <tr id="<?= $v->getVehicleId(); ?>">
                                                    <td><?= $v->getVehicleId(); ?></td>
                                                    <td><?= $v->getMake(); ?></td>
                                                    <td><?= $v->getModel(); ?></td>
                                                    <td><?= $v->getYear(); ?></td>
                                                    <td><?= $v->getRegNo(); ?></td>
                                                    <td><a class="edit_vehicle" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Vehicle Details"></i></a></td>
                                                    <!-- <td></td> -->
                                                </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Deactivate Online Account -->
                        </div>
                    </div> <!-- </card> -->

                </div> <!-- <col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->

    <!-- Add Vehicle Modal -->
    <div class="modal" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- START FORM -->
                <form id="add_vehicle_form">
                    <input style="display: none;" type="text" id="_customerId" name="customerId" value="<?= $c->getCustomerId() ?>">
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
                <button id="form_submit" type="submit" class="btn btn-primary">Save</button>
            </form>
            <!-- END FORM -->
            </div>
            </div>
            <!-- /modal-content -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- End Add Vehicle Modal -->


    <!-- Edit Vehicle Modal -->
    <div data-entityId="" class="modal" id="editVehicleModal" tabindex="-1" role="dialog" aria-labelledby="editVehicleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Vehicle Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- START FORM -->
                <form id="edit_vehicle_form">
                    <input style="display: none;" type="text" id="_customerId" name="customerId" value="<?= $c->getCustomerId() ?>">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="vehicle_id">Vehicle Id</label>
                            <input id="vehicle_id" name="vehicleId" type="text" class="form-control" readonly>
                        </div>
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
                <button id="form_submit" type="submit" class="btn btn-primary">Save</button>
            </form>
            <!-- END FORM -->
            </div>
            </div>
            <!-- /modal-content -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- End Edit Vehicle Modal -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>
        // Add vehicle
        const addVehicleForm = $('#add_vehicle_form');
        const addVehicleModal = $('#addVehicleModal');
        const addVehicleBtn = document.querySelector('#add_vehicle_btn');
        addVehicleBtn.addEventListener('click', showAddVehicleModal);


        function showAddVehicleModal() {
            addVehicleModal.modal({
                show: true,
            });
        }

        function highlightVehicle(id) {
            console.log($(`tr#${id}`));
            $(`tr#${id}`).addClass('updated');
        }

        function getUpdatedVehicleList(id) {
            // get the customer vehicle list (html partial)
            let url = '<?= url_for("/customer/vehicle"); ?>';
            return $.ajax({
                method: 'GET',
                url,
                dataType: 'html',
                data: { customerId: id },
            }).fail((response, err) => {
                console.log(response);
                console.log(err);
            });
        }

        // clear the form when the modal is closed
        // clear values, validations, and modal entityId
        function clearform() {
            let data = addVehicleForm.serializeArray().forEach((d) => {
                if (d.name !== 'customerId') { // don't clear the customer id
                    $(`[name*=${d.name}]`).val('');
                }
            });
            formValidator.resetForm();
            $('#add_vehicle_form :input').removeClass('is-valid');
            console.log('clear form');
            let cdata = addVehicleForm.serializeArray();
            console.log(cdata);
        }

        /* START VALIDATION */

        const formValidator = addVehicleForm.validate({
            submitHandler,
            onfocusout: (element) => {
                $(element).valid();
            },
            rules: {
                make: {
                    required: true,
                    minlength: 2,
                    maxlength: 255,
                },
                model: {
                    required: true,
                    minlength: 2,
                    maxlength: 255,
                },
                year: {
                    required: true,
                    digits: true,
                    minlength: 4,
                    maxlength: 4,
                },
            },
            messages: {
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
        function submitHandler() {
            let data = addVehicleForm.serializeArray();
            $.ajax({
                url: '<?= url_for("/customer/vehicle/new"); ?>',
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
                    if (response.status === 0) {
                        // update the dataTable row
                        getUpdatedVehicleList($('#_customerId').val())
                            .done((vehicleListHtml) => {
                                // on getting vehicle list append it and hightlight that record
                                $('#vehicle-list').empty().append(vehicleListHtml);
                                $('.edit_vehicle').on('click', showEditModal);
                                highlightVehicle(response.vehicleId);
                            });

                        // the success response by the server
                        console.log(response);
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'New Vehicle Added',
                            background: '#ceebfd',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                            onAfterClose: () => {
                                addVehicleModal.modal('hide');
                                clearform();
                            },
                        });
                    } else { // response.success is not 0
                        Swal.fire({
                            type: 'error',
                            title: response.message,
                            text: `Customer Update Failed ${response.status}`,
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
    </script>

    <script>
        // Edit Vehicle
        const editVehicleForm = $('#edit_vehicle_form');
        const editVehicleModal = $('#editVehicleModal');
        const editVehicleBtn = $('.edit_vehicle');
        editVehicleBtn.on('click', showEditVehicleModal);
        editVehicleModal.on('hide.bs.modal', clearEditVehicleForm);


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

        function isModelOpen() {
            return ($('body').hasClass('modal-open'));
        }

        function getVehicleDetails() {
            let id = $(this).data('entityId');
            console.log('event fired modal');
            $.ajax({
                method: 'GET',
                data: { vehicleId: id },
                url: '<?= url_for("/customer/vehicle/edit"); ?>',
                dataType: 'json',
                success: (response) => {
                    if (isModelOpen()) {
                        console.log('modal is open');
                        populateEditForm(editVehicleForm, response);
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

        function showEditVehicleModal(e) {
            e.preventDefault();
            // set the data attribute for getCustomerDetails()
            editVehicleModal.data('entityId', this.parentElement.parentElement.id);

            console.dir(this.outerHTML);
            console.dir(this.parentElement.previousElementSibling.innerHTML);

            // editLinkHtml = this.outerHTML;
            // showLinkHtml = this.parentElement.previousElementSibling.innerHTML;

            // when the modal is shown get the customer details
            // the eventlistener is removed after it is attached
            // (once only listener) so everytime this modal is opened
            // the event is attached and detached.
            editVehicleModal.one('shown.bs.modal', getVehicleDetails);

            // show the modal
            editVehicleModal.modal({
                show: true,
            });
        }

        function clearEditVehicleForm() {
            editVehicleModal.data('entityId', '');
            let data = editVehicleForm.serializeArray().forEach((d) => {
                if (d.name !== 'customerId') { // don't clear the customer id
                    $(`[name*=${d.name}]`).val('');
                }
            });
            // formValidator.resetForm();
            console.log('clear form');
            let cdata = editVehicleForm.serializeArray();
            console.log(cdata);
        }

        function highlightVehicle(id) {
            console.log($(`tr#${id}`));
            $(`tr#${id}`).addClass('updated');
        }

        function getUpdatedVehicleList(id) {
            // get the customer vehicle list (html partial)
            let url = '<?= url_for("/customer/vehicle"); ?>';
            return $.ajax({
                method: 'GET',
                url,
                dataType: 'html',
                data: { customerId: id },
            }).fail((response, err) => {
                console.log(response);
                console.log(err);
            });
        }

        function updateVehicle() {
            let data = editVehicleForm.serializeArray();
            $.ajax({
                url: '<?= url_for("/customer/vehicle/edit"); ?>',
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
                    if (response.status === 0) {
                        // update the dataTable row
                        getUpdatedVehicleList($('#_customerId').val())
                            .done((vehicleListHtml) => {
                                // on getting vehicle list append it and hightlight that record
                                $('#vehicle-list').empty().append(vehicleListHtml);
                                // on above list load the existing event listeners are destroyed
                                $('.edit_vehicle').on('click', showEditVehicleModal); // reattach listeners
                                highlightVehicle(response.vehicleId);
                            });


                        // the success response by the server
                        console.log(response);
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'Vehicle Details Updated',
                            background: '#ceebfd',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                            onAfterClose: () => {
                                editVehicleModal.modal('hide');
                                clearEditVehicleForm();
                            },
                        });
                    } else { // response.success is not 0
                        Swal.fire({
                            type: 'error',
                            title: response.message,
                            text: `Customer Update Failed ${response.status}`,
                            background: '#ceebfd',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                            onAfterClose: () => {
                                editVehicleModal.modal('hide');
                                clearEditVehicleForm();
                            },
                        });
                    }
                },
            });
        }

        /* START VALIDATION */

        const editFormValidator = editVehicleForm.validate({
            submitHandler: updateVehicle,
            // onfocusout: (element) => {
            //     $(element).valid();
            // },
            rules: {
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
    </script>
</body>
</html>
