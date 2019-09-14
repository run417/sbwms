<?php
    $title = 'Service Type - SBWMS';
    require_once(COMMON_VIEWS . 'header.php');
?>
<body>
    <style>
 
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php 
            $breadcrumbMarkUp = breadcrumbs(
                [
                    'Service' => '#',
                    'Type' => '/service/types',
                ], 'Type');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="service"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
        <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                <!-- <nav class="nav mb-2 justify-content-center">
                <a class="nav-link active" href="#">Service</a>
                <a class="nav-link" href="#">Service Types</a>
                <a class="nav-link" href="#">Link</a>
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </nav> -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Service Type</h4>
                            <a href="<?= url_for('/service/type/new'); ?>" class="btn btn-primary btn-lg">New Service Type</a>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="customer_list_table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Service Type Id</th>
                                        <th>Name</th>
                                        <th>Duration</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($serviceTypes as $st): ?>
                                    <tr id="<?= $st->getServiceTypeId(); ?>">
                                        <td><?= $st->getServiceTypeId(); ?></td>
                                        <td><?= $st->getName(); ?></td>
                                        <td><?= $st->getDuration(); ?></td>
                                        <td><a class="edit_service_type" href=""><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Service Type"></i></a></td>
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
<div class="modal fade" id="edit_employee_modal" tabindex="-1" role="dialog" aria-labelledby="edit_employee_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="edit_employee_modal_title">Edit Employee Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <!-- START FORM -->

            <form id="edit_service_type_form">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="service_type">Service Name</label> 
                        <input id="service_type" name="name" type="text" required="required" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                    <label for="duration">Estimated Duration</label> 
                    <div>
                        <select id="duration" name="duration" class="custom-select">
                            <option value="">Please Select Service Duration</option>
                            <option value="01:00:00">1 hr</option>
                            <option value="02:00:00">2 hr</option>
                        </select>
                    </div>
                    </div>
                </div>
              <div class="modal-footer">
                <button id="form_submit" type="submit" class="btn btn-primary">Update Service Type</button>
                
            </form>
            <!-- END FORM -->
            </div>

        </div>

        </div> <!-- </model-content> -->
    </div> <!-- </model-dialog> -->
    </div>
    <!-- End Modal -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>

        const form = $('#edit_employee_form');
        const table = $('#employee_list');
        const editModal = $('#edit_employee_modal');
        const editLink = document.querySelectorAll('.edit_service_type');
        let editLinkHtml = ''; // outerHTML of .edit_employee element used in a datatable row.
        let showLinkHtml = '';
    
        function submitHandler() {
            let data = $(form).serializeArray();
            console.log(data);
            $.ajax({
                url: '<?= url_for("/service/type/edit"); ?>',
                method: 'POST',
                dataType: 'json',
                data,
                error: () => { console.log('Request Failed'); },
                success: (response) => {
                    /*
                        make datatable data array according to
                        the datatable column order
                    */
                    let columnOrder = ['serviceTypeId', 'name', 'duration'];
                    console.log(columnOrder);
                    let updatedRow = [];
                    data.forEach((d) => {
                        columnOrder.forEach((c) => {
                            if (d.name === c) {
                                updatedRow.push(d.value);
                            }
                        });
                    });
                    updatedRow.push(showLinkHtml);
                    updatedRow.push(editLinkHtml);
                    console.log(updatedRow);
                    console.log(data[0].value);
                    console.log(dataTable.row(`#${data[0].value}`).data());
                    dataTable.row(`#${data[0].value}`).data(updatedRow);
                    console.log(dataTable.row(`#${data[0].value}`).data());
                    console.log($(`tr#${data[0].value}>td>a.edit_employee`).one('click', showModal).addClass('updated'));
                    console.log($(`tr#${data[0].value}`).addClass('updated'));
                    console.log(response);
                    console.log(typeof response);
                    console.log(response.success);
                    if (response.success === 0) {
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'Employee Details Updated',
                            background: '#ceebfd',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                            onAfterClose: () => {
                                editModal.modal('hide');
                            },
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Failure!',
                            text: 'Employee Update Failed',
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
        } /* end submitHandler */
    
        /* start validation */
        const formValidator = form.validate({
            submitHandler,
            rules: {
                serviceName: {
                    required: true,
                    maxlength: 255,
                },
                duration: {
                    required: true,
                },
            },
            messages: {},
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
        
        /* end formValidator */
    
        function showModal(e) {
            e.preventDefault();
            const { id } = this.parentElement.parentElement; // this object destructured
            console.dir(this.outerHTML);
            console.dir(this.parentElement.previousElementSibling.innerHTML);
            editLinkHtml = this.outerHTML;
            showLinkHtml = this.parentElement.previousElementSibling.innerHTML;
            editModal.one('shown.bs.modal', getServiceTypeDetails);
    
            editModal.modal({
                show: true,
            });
    
            // depends on jquery form element, string id, this.outerHTML
            // 1. Get the data from backend (db) in the form of json object.
            // On success populate the edit form (if modal is open)
            function getServiceTypeDetails() {
                console.log('event fired modal');
                $.ajax({
                    method: 'GET',
                    data: { id },
                    url: '<?= url_for("/service/type/edit"); ?>',
                    dataType: 'json',
                    success: (response) => {
                        console.log(response);
                        let employee = response; // employee json object
                        let formArray = form.serializeArray();
                        console.log(formArray);
                        if ($('body').hasClass('modal-open')) {
                            console.log('modal is open');
                            formArray.forEach((elem) => {
                                if (Object.prototype.hasOwnProperty.call(employee, elem.name)) {
                                    console.log(employee[elem.name]);
                                    $(`[name*=${elem.name}]`).val(employee[elem.name]);
                                }
                            });
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
        }
    
        let dataTable = table.DataTable({
            paging: false,
            searching: false,
            columnDefs: [
                { orderable: false, targets: [3] },
            ],
        });
        
        function clearform() {
            let data = form.serializeArray().forEach((d) => {
                $(`[name*=${d.name}]`).val('');
            });
            formValidator.resetForm();
            console.log('clear form');
            let cdata = form.serializeArray();
            console.log(cdata);
        }
    
        editLink.forEach(b => b.addEventListener('click', showModal));
    </script>
</body>
</html>
