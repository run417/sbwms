<?php
    $title = "New User - SBWMS";
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
            $breadcrumbMarkUp = breadcrumbs(
                [
                    'System' => '/system',
                    'User' => '/system/user',
                    'New' => '/system/user/new',
                ], 'New');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="System"></span>
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
                                <h4 class="card-title">Create New User</h4>
                            </div>
                            <div class="col-md-auto">

                            </div>
                        </div>

                      </div> <!-- </card-header> -->
                      <div class="card-body">
                        
                        <!-- START FORM -->
                        <form id="new_user">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label> 
                                    <input id="username" name="username" type="text" required="required" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="user_type">User Type</label> 
                                    <div>
                                        <select id="user_type" name="type" class="custom-select">
                                            <option value="">Select User Type</option>
                                            <option value="Employee">Employee</option>
                                            <option value="Customer">Customer</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label> 
                                    <input id="password" name="telephone" type="password" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm_password">Confirm Password</label> 
                                    <input id="confirm_password" name="confirmPassword" type="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="user_status">User Status</label> 
                                    <div>
                                        <select id="user_status" name="status" class="custom-select">
                                            <option value="">Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Suspended">Suspended</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>

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
        const userForm = $('#new_user');
        const formValidator = userForm.validate({
            submitHandler,
            rules: {},
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

        function submitHandler() {
            let data = $(userForm).serializeArray();
            console.log(data);
            $.ajax({
                url: '<?= url_for("/system/user/new"); ?>',
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
                            text: 'New User Created',
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
                            text: 'User Creation Failed',
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
