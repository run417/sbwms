<?php 
  $title = "Employee - SBWMS";
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
            $breadcrumbMarkUp = breadcrumbs(['Employee' => '/employee'], 'Employee');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="employee"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
            <div id="content">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-9 mx-auto">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Employee List</h4>
                        <a href="<?php echo url_for('/employee/new'); ?>" class="btn btn-primary btn-lg">Create Employee</a>
                      </div>
                      <div class="card-body">
                      <div class="table-resposive">
                        <table id="employee_list" class="table table-hover">
                            <thead>
                              <tr>
                                <th>Employee Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Role</th>
                                <th>Details</th>
                                <th>Edit</th>
                                <!-- <th>&nbsp;</th> -->
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($employees as $e): ?>
                              <tr id="<?= $e->getEmployeeId(); ?>">
                                <td><?= $e->getEmployeeId(); ?></td>
                                <td><?= $e->getFirstName(); ?></td>
                                <td><?= $e->getLastName(); ?></td>
                                <td><?= $e->getFormattedRole(); ?></td>
                                <td><a href="<?= url_for('/employee/view?id=') . $e->getEmployeeId(); ?>"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="Details"></i></a></td>
                                <td><a class="edit_employee" href=""><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit"></i></a></td>
                              </tr>
                              <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                      </div>
                      <!-- card-body end -->
                    </div>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
            </div>
            <!-- end content -->
        </div>
        <!-- end content-wrapper -->
    </div>
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

            <form id="edit_employee_form">
              <div class="form-section-heading">
                  <h5>Personal</h5>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="employee_id">Employee Id</label> 
                    <input id="employee_id" name="employeeId" type="text" class="form-control" readonly>
                </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="employee_first_name">First Name</label> 
                      <input id="employee_first_name" name="firstName" type="text" required="required" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="employee_last_name">Last Name</label> 
                      <input id="employee_last_name" name="lastName" type="text" class="form-control">
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="employee_nic">NIC</label> 
                      <input id="employee_nic" name="nic" type="text" class="form-control">
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="employee_telephone">Telephone</label> 
                      <input id="employee_telephone" name="telephone" type="tel" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="employee_email">Email</label> 
                      <input id="employee_email" name="email" type="email" class="form-control">
                  </div>
              </div>
              <div class="form-section-heading">
                  <h5>Role</h5>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="employee_date_joined">Date Joined</label> 
                      <input id="employee_date_joined" name="dateJoined" type="date" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="employee_role">Employee Role</label> 
                      <div>
                          <select id="employee_role" name="role" class="custom-select">
                              <option value="">Select Role</option>
                              <option value="104">Service Crew</option>
                              <option value="105">Service Supervisor</option>
                              <option value="106">Sales Assistant</option>
                          </select>
                      </div>
                  </div> 
              </div>
              <!-- <div class="form-row">
                  <div class="form-group col-md-auto">
                      <label>Performing Service Types</label> 
                      
                      <div>
                          <div class="custom-control custom-checkbox">
                              <input name="employee_service_types" id="employee_service_types_0" type="checkbox" class="custom-control-input" value="st1"> 
                              <label for="employee_service_types_0" class="custom-control-label">Tyre Inspection and Replacement</label>
                          </div>
                          
                          <div class="custom-control custom-checkbox">
                              <input name="employee_service_types" id="employee_service_types_1" type="checkbox" class="custom-control-input" value="st2"> 
                              <label for="employee_service_types_1" class="custom-control-label">Wheel Alignment Inspection and Repair</label>
                          </div>
                          
                          <div class="custom-control custom-checkbox">
                              <input name="employee_service_types" id="employee_service_types_2" type="checkbox" class="custom-control-input" value="st3"> 
                              <label for="employee_service_types_2" class="custom-control-label">Battery Inspection and Replacement</label>
                          </div>
                      </div>
                  
                  </div> 
              </div> -->

              <div class="modal-footer">
                <button id="form_submit" type="submit" class="btn btn-primary">Update Employee Details</button>
                
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

    const editEmployeeForm = $('#edit_employee_form');
    const table = $('#employee_list');
    const editModal = $('#edit_employee_modal');
    const editEmployee = document.querySelectorAll('.edit_employee');
    let editLinkHtml = ''; // outerHTML of .edit_employee element used in a datatable row.
    let showLinkHtml = '';

    function submitHandler() {
        let data = $(editEmployeeForm).serializeArray();
        console.log(data);
        $.ajax({
            url: '<?= url_for("/employee/edit"); ?>',
            method: 'POST',
            dataType: 'json',
            data,
            error: () => { console.log('Request Failed'); },
            success: (response) => {
                /*
                    make datatable data array according to
                    the datatable column order
                */
                let columnOrder = ['employeeId', 'firstName', 'lastName', 'role'];
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

    $.validator.addMethod('maxDate', (value, element) => (new Date(value)) <= (new Date()));
    const formValidator = editEmployeeForm.validate({
        submitHandler,
        rules: {
            // firstName: {
            //     required: true,
            //     maxlength: 255,
            // },
            // lastName: {
            //     required: true,
            //     maxlength: 255,
            // },
            // telephone: {
            //     required: true,
            // },
            // email: {
            //     required: true,
            // },
            dateJoined: {
                required: true,
                dateISO: true,
                maxDate: true,
            },
        },
        messages: {
            firstName: {
                required: 'Please enter employee\'s first name',
                minlength: 'First name should be more than a character',
            },
            lastName: {
                required: 'Please enter employee\'s last name',
                minlength: 'Last name should be more than a character',
            },
            telephone: {
                required: 'Please enter employee\'s telephone number',
            },
            email: {
                required: 'Please enter employee\'s email',
            },
            dateJoined: {
                required: 'Please enter the date this employee joined the centre',
                maxDate: 'Date joined should be a past or the current date',
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
    
    /* end formValidator */

    function showModal(e) {
        e.preventDefault();
        const { id } = this.parentElement.parentElement; // this object destructured
        console.dir(this.outerHTML);
        console.dir(this.parentElement.previousElementSibling.innerHTML);
        editLinkHtml = this.outerHTML;
        showLinkHtml = this.parentElement.previousElementSibling.innerHTML;
        editModal.one('shown.bs.modal', getemployeeDetails);

        editModal.modal({
            show: true,
        });

        // depends on jquery form element, string id, this.outerHTML
        function getemployeeDetails() {
            console.log('event fired modal');
            $.ajax({
                method: 'GET',
                data: { id },
                url: '<?= url_for("/employee/edit"); ?>',
                dataType: 'json',
                success: (response) => {
                    console.log(response);
                    let employee = response; // employee json object
                    let formArray = editEmployeeForm.serializeArray();
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
            { orderable: false, targets: [4, 5] },
        ],
    });
    
    function clearform() {
        let data = editEmployeeForm.serializeArray().forEach((d) => {
            $(`[name*=${d.name}]`).val('');
        });
        formValidator.resetForm();
        console.log('clear form');
        let cdata = editEmployeeForm.serializeArray();
        console.log(cdata);
    }

    editEmployee.forEach(b => b.addEventListener('click', showModal));
</script>
</body>
</html>
