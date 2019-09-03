<?php 
$title = "New Customer - SBWMS";
require_once(COMMON_VIEWS . 'header.php'); 
?>
<body>
    <style>
        .is-valid {
            background-image: none !important;
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
            $breadcrumbMarkUp = breadcrumbs(['Customer' => '/customer', 'New' => '/customer/new'], 'New');
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
                <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">New Customer Details</h4>
                    </div>
                    <div class="card-body">
                    
                    <!-- START FORM -->
                    <form id="new_customer">
                        <div class="form-section-heading">
                            <h5>Personal</h5>
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

                        
                        <div class="card-footer form-group">
                            <button id="form_submit" type="submit" class="btn btn-block btn-primary">Create New Customer</button>
                        </div>
                    
                    </form>
                    <!-- END FORM -->
                
                    </div>
                    <!-- card-body end -->
                </div> <!-- </card> -->
                </div> <!-- </col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->        
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->
    
    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/plugins/jquery.validate.js'); ?>"></script>
    <script src="<?= url_for('/assets/js/plugins/sweetalert2.all.min.js'); ?>"></script>
    <script>
        const form = $('#new_customer');
        const formValidator = form.validate({
            submitHandler,
            rules: {
                // customer_first_name: {
                //     required: true,
                //     maxlength: 255,
                // },
                // customer_last_name: {
                //     required: true,
                //     maxlength: 255,
                // },
                // customer_telephone: {
                //     required: true,
                // },
                // customer_email: {
                //     required: true,
                // },
                // vehicle_make: {
                //     required: true,
                //     minlength: 2,
                //     maxlength: 255,
                // },
                // vehicle_model: {
                //     required: true,
                //     minlength: 2,
                //     maxlength: 255,
                // },
                // vehicle_year: {
                //     required: true,
                //     digits: true,
                //     minlength: 4,
                //     maxlength: 4,
                // },
            },
            messages: {
                customer_first_name: {
                    required: 'Please enter customer\'s first name',
                    minlength: 'First name should be more than a character',
                },
                customer_last_name: {
                    required: 'Please enter customer\'s last name',
                    minlength: 'Last name should be more than a character',
                },
                customer_telephone: {
                    required: 'Please enter customer\'s telephone number',
                },
                customer_email: {
                    required: 'Please enter customer\'s email',
                },
                vehicle_year: {
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
        function submitHandler() {
            let data = $(form).serializeArray();
            $.ajax({
                url: '<?= url_for('/customer/new'); ?>',
                method: 'POST',
                data,
                error: () => { console.log('Request Failed'); },
                success: (response) => {
                    console.log(response);
                    if (response === '0') {
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'New Customer Created',
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
                            text: 'Customer Creation Failed',
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
</body>
</html>
