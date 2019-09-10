<?php
    $title = "New Employee - SBWMS";
    require_once(COMMON_VIEWS . 'header.php'); 
?>
<body>
    <style>
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
            $breadcrumbMarkUp = breadcrumbs(['Employee' => '/employee', 'New' => '/employee/new'], 'New');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="employee"></span>
        <!-- sidebar end -->

        <div id="content-wrapper">

            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->

            <div id="content">
            <div class="container">
                <div class="row">
                  <div class="col-md-6 mx-auto">
                    <div class="card">
                      <div class="card-header">
                        <div class="row no-gutters">
                            <div class="col-md-auto mr-auto">
                                <h4 class="card-title">New Employee Details</h4>
                            </div>
                            <div class="col-md-auto">

                            </div>
                        </div>

                      </div> <!-- </card-header> -->
                      <div class="card-body">
                        
                        <!-- START FORM -->
                        <form id="new_employee">
                            <div class="form-section-heading">
                                <h5>Personal</h5>
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

                            <div class="card-footer form-group">
                        
                                <button name="submit" type="submit" class="btn btn-block btn-primary">Add New Employee</button>
                        
                            </div> <!-- </card-footer> -->
                        </form>
                        <!-- END FORM -->
                    
                      </div> <!-- </card-body> -->

                    </div> <!-- </card> -->
                  </div> <!-- </col-md> -->
                </div> <!-- </row> -->
            </div> <!-- </container> -->
            </div> <!-- </content> -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>

        /* start validation */
        $.validator.addMethod('maxDate', (value, element) => (new Date(value)) <= (new Date()));
        const employeeForm = $('#new_employee');
        const formValidator = employeeForm.validate({
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

        function submitHandler() {
            let data = $(employeeForm).serializeArray();
            console.log(data);
            $.ajax({
                url: '<?= url_for("/employee/new"); ?>',
                method: 'POST',
                dataType: 'json',
                data,
                error: () => { console.log('Request Failed'); },
                success: (response) => {
                    console.log(typeof response);
                    console.log(response.success);
                    if (response.success === 0) {
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'New Employee Created',
                            background: '#ceebfd',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                            onAfterClose: () => {
                                // window.location.replace('/sbwms/public/customer');
                            },
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Failure!',
                            text: 'Employee Creation Failed',
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
    </script>
</body>
</html>
