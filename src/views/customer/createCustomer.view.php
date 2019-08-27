<?php 
$title = "New Customer - SBWMS";
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
                    <form>
                        <div class="form-section-heading">
                            <h5>Personal</h5>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="customer_first_name">First Name</label> 
                                <input id="customer_first_name" name="customer_first_name" type="text" required="required" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="customer_last_name">Last Name</label> 
                                <input id="customer_last_name" name="customer_last_name" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="customer_telephone">Telephone</label> 
                                <input id="customer_telephone" name="customer_telephone" type="tel" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="customer_email">Email</label> 
                                <input id="customer_email" name="customer_email" type="email" class="form-control">
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
                                <input id="vehicle_year" name="vehicle_year" type="text" class="form-control">
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
                                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                <button name="reset" type="reset" class="btn">Reset</button>
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
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Booking Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
        <!-- /modal-content -->
    </div>
    </div>
    <!-- End Modal -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>
        function showModal() {
            modal.modal({
                show: true,
            });
            modal.on('hide.bs.modal', function (e) {
                console.log('hiding modal');
            });
        }

        let modal = $('#exampleModalCenter');
        let editBooking = document.querySelectorAll('.edit_booking');
        editBooking.forEach(b => b.addEventListener('click', showModal));
    </script>
</body>
</html>
