
<?php
    $title = "V2 New Booking - SBWMS";
    require_once(COMMON_VIEWS . 'header.php');
?>
<body>
    <style>

        /* #booking > .card:not(:first-of-type) {
            display: none;
        } */
        .form-info {
            padding-top: 0px;
            padding-bottom: 0px;
            font-size: 0.88rem;
            color: hsl(208, 7%, 46%);
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        #new-booking, #confirm-booking {
            max-width: 500px;
            margin-right: auto;
            margin-left: auto;
        }
        #new-booking {
            min-height: 220px
        }

        #new-booking .form-group {
            padding-bottom: 20px;
        }
        .wizard {
            display: flex;
            max-width: 600px;
            min-height: 50px;
            margin-right: auto;
            margin-left: auto;
            margin-bottom: 15px;
        }
        .step {
            border: 1px solid hsla(221, 100%, 90%, 1);
            padding: 10px;
            flex-basis: 100%;
            border-radius: 20px;
            text-align: center;
            background-color: hsla(221, 100%, 95%, 1);
            box-shadow: 0px 0px 6px 0px hsla(221, 100%, 80%, 1);
        }
        .step:nth-child(2) {
            margin-left: 9px;
            margin-right: 9px;
        }
        .active-step {
            background-color: #c7e2ff !important;
        }
        .complete {
            border: 1px solid hsla(115, 100%, 90%, 1);
            background-color: hsla(115, 100%, 95%, 1);
            box-shadow: 0px 0px 6px 0px hsla(115, 100%, 80%, 1);
        }

        .chosen-container {
            font-size: inherit;
            margin-right: 5px;
        }

        .chosen-container-single .chosen-single {
            padding: 5px 10px 5px 10px;
            height: 37px;

        }

    </style>
    <div class="wrapper">

    <!-- sidebar start -->
    <?php
        $breadcrumbMarkUp = breadcrumbs(['Booking' => '/booking', 'New' => '/booking/new'], 'New');
        require_once(COMMON_VIEWS . 'sidebar.php');
    ?>
    <span id="active_menu" data-menu="booking"></span>
    <!-- sidebar end -->

    <div id="content-wrapper">
        <!-- navbar start -->
        <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
        <!-- navbar end -->

        <div id="content">
        <div class="container-fluid">

            <div id="booking">
                <div class="card" id="new-booking">
                    <div class="card-header">
                        <h4 class="card-title">Book Service</h4>
                    </div>
                    <div class="card-body">
                    <div class="form-info d-flex justify-content-end">All fields are required</div>
                        <!-- select service -->
                        <div class="form-group">
                            <label for="serviceType" class="">Service Type</label>
                            <select id="serviceType" name="serviceType" class="custom-select">
                                <option value="">Select a service type</option>
                                <?php foreach ($serviceTypes as $st): ?>
                                <option value="<?= $st->getServiceTypeId() ?>"><?= $st->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="timeSlot" class="">Service Time Slot</label>
                            <select id="timeSlot" name="timeSlot" class="custom-select" readonly>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="vehicle" class="">Select Customer</label>
                            <div class="d-flex justify-content-center">
                                <!-- <input type="text" name="vehicle" id="vehicle" class="form-control mr-1" placeholder="Search Customer"> -->
                                <select name="vehicle" id="vehicle" class="custom-select mr-1">
                                    <option value="">Select Customer Name | Email | Telephone | Vehicle Make | Model | Year | Reg No</option>
                                    <?php foreach($vehicles as $v): ?>
                                    <option value="<?= $v->getVehicleId(); ?>"><?= $v->getOwner()->getFullName(); ?> | <?= $v->getOwner()->getEmail(); ?> | <?= $v->getOwner()->getTelephone(); ?> | <?= $v->getMake(); ?> | <?= $v->getModel(); ?> | <?= $v->getYear(); ?> | <?= $v->getRegNo(); ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- <button class="btn btn-primary">New</button> -->
                            </div>
                        </div>

                    </div> <!-- </card-body> -->

                    <div class="card-footer d-flex justify-content-end">
                        <button id="createBooking" class="btn btn-block btn-primary next">Create Booking</button>
                    </div> <!-- </card-footer> -->
                </div> <!-- </card> -->
            </div>

            <!-- CONFIRM BOOKING -->

            <div class="card" id="confirm-booking" style="display: none;">
                <div class="card-header">
                    <h4 class="card-title">Please Your Verify Booking</h4>
                </div>

                <div class="card-body">
                    <style>
                        .ht {
                            text-transform: uppercase;
                            font-size: 0.8rem;
                            color: hsl(0, 0%, 50%);
                            width: 90px;
                            align-self: center;
                            display: flex;
                            justify-content: flex-end;
                        }
                        .bt {
                            margin-left: 10px;
                            width: 280px;
                        }
                        .dt {

                            padding-bottom: 5px;
                            display: flex;
                        }
                    </style>
                    <div id="booking-data">
                        <div class="dt"><span class="ht">Booking ID:</span> <span class="bt">B0001</span></div>
                        <div class="dt"><span class="ht">Service Type:</span> <span class="bt">Tire Service</span></div>
                        <div class="dt"><span class="ht">Start Time:</span> <span class="bt">0900</span></div>
                        <div class="dt"><span class="ht">Technician:</span> <span class="bt">Mr. Buddhi Prabashwara</span></div>
                        <div class="dt"><span class="ht">Duration:</span> <span class="bt">2 hours</span></div>
                        <div class="dt"><span class="ht">Customer:</span> <span class="bt">Mr. Chathuranga Gunasekara</span></div>
                        <div class="dt"><span class="ht">Telephone:</span> <span class="bt">0771234567</span></div>
                        <div class="dt"><span class="ht">Vehicle:</span> <span class="bt">Toyota Corolla 2018 Sedan GAW 1923</span></div>
                    </div> <!-- </#booking-data> -->
                </div> <!-- </.card-body> -->

                <div class="card-footer d-flex justify-content-between">
                    <div class="w-50">
                        <button id="cancelBooking" style="display: none;" class="btn btn-sm btn-outline-danger mr-1">Discard</button>
                        <!-- <button id="holdBooking" class="btn btn-sm btn-outline-warning">Hold</button> -->
                    </div>
                    <button id="confirmBooking" class="btn btn-primary w-25">Go To Booking List</button>
                </div> <!-- </card-footer> -->
            </div> <!-- </card> -->

            <!-- END CONFIRM BOOKING -->

                <!-- <div class="card-body">
                    <div style="background-color: rgb(192, 192, 248);">
                        <h5 class="d-flex justify-content-center ">Customer Details</h5>
                    </div> -->
                <!-- </div> --> <!-- </card-body> -->

        </div> <!-- </container-fluid -->
        </div> <!-- </content> -->
    </div> <!-- </content-wrapper> -->
    </div> <!-- wrapper -->
    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <!-- <script src="<?php echo url_for('assets/js/custom/wizard.js') ?>"></script> -->
    <script src="<?= url_for('assets/js/plugins/typeahead.bundle.js') ?>"></script>
    <!-- <script src="<?= url_for('assets/js/plugins/bootstrap-combobox.js') ?>"></script> -->
    <!-- <script src="<?= url_for('assets/js/plugins/select2.js') ?>"></script> -->
    <script src="<?= url_for('assets/js/plugins/chosen.jquery.js') ?>"></script>
    <script src="<?= url_for('assets/js/custom/booking/new-booking.js') ?>"></script>
</body>
</html>