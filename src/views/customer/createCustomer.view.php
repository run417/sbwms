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
                            <div class="form-group col-md-6">
                                <label for="customer_first_name">First Name</label> 
                                <input id="customer_first_name" name="customer_first_name" type="text" required="required" class="form-control" minlength="2" maxlength="255" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="customer_last_name">Last Name</label> 
                                <input id="customer_last_name" name="customer_last_name" type="text" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="customer_telephone">Telephone</label> 
                                <input id="customer_telephone" name="customer_telephone" type="tel" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="customer_email">Email</label> 
                                <input id="customer_email" name="customer_email" type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-section-heading">
                            <h5>Vehicle</h5>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="vehicle_make">Make</label> 
                                <input id="vehicle_make" name="vehicle_make" type="text" required="required" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="vehicle_model">Model</label> 
                                <input id="vehicle_model" name="vehicle_model" type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="vehicle_year">Year</label> 
                                <input id="vehicle_year" name="vehicle_year" type="text" class="form-control" pattern="\d{4}" data-bouncer-message="Please use the following format YYYY">
                            </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="vehicle_reg_no">Registration No.</label> 
                                    <input id="vehicle_reg_no" name="vehicle_reg_no" type="text" required="required" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="vehicle_vin_no">VIN No</label> 
                                    <input id="vehicle_vin_no" name="vehicle_vin_no" type="text" class="form-control">
                                </div>
                                </div>

                        
                        <div class="card-footer">
                            <div class="form-group d-flex justify-content-between">
                                <button id="form_submit" type="submit" class="btn btn-primary">Submit</button>
                                <button id="form_reset" type="reset" class="btn">Reset</button>
                            </div>
                        </div>
                    
                    </form>
                    <!-- END FORM -->
                
                    </div>
                    <!-- card-body end -->
                </div>
                </div> <!-- </col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->        
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->
    
    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="/sbwms/public/assets/js/plugins/bouncer.js"></script>
    <script>
        const year = document.querySelector('#vehicle_year');
        console.log((new Date()).getFullYear());
        
        const bouncer = new Bouncer('form', {
            customValidations: {
                isYear: function (year) {
                    return !(year.value < (new Date()).getFullYear()+1);
                },
            },
            messages: {
                isYear: 'Year should be less than ' + ((new Date()).getFullYear()+1),
            },

            fieldClass: 'is-invalid', // Applied to fields with errors
            errorClass: 'invalid-feedback', // Applied to the error message for invalid fields
            disableSubmit: true,
        });

        function textInputValidation(e) {
            let field = e.target;
            console.dir(field.checkValidity());
            if (field.checkValidity()) {
                if (!field.classList.contains('is-valid')) {
                    field.classList.add('is-valid');
                    console.log('contains is-valid');
                }
            }
            if (!field.checkValidity()) {
                if (field.classList.contains('is-valid')) {
                    field.classList.remove('is-valid');
                    console.log('contains is-valid');
                }
            }
        }

        function submitForm(e) {
            console.log(e);
            console.log('Bouncer says form valid');
            let cusdata = form.serializeArray();
            console.log(cusdata);
        }
        
        const form = $('#new_customer');
        const textinputs = document.querySelectorAll('input[type="text"]');
        const inputs = document.querySelectorAll('input');
        
        inputs.forEach(input => input.addEventListener('keyup', textInputValidation));
        document.addEventListener('bouncerFormValid', submitForm);
    </script>
</body>
</html>
