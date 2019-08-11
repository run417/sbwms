<?php require_once(COMMON_VIEWS . 'header.php'); ?>
<body>
    <style>
        #booking > .card:not(:first-of-type){
            display: none;
        }
        .card {
            max-width: 500px;
            margin-right: auto;
            margin-left: auto;
        }
        .card-body {
            min-height: 220px
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
    </style>
    <div class="wrapper">

    <!-- sidebar start -->
    <?php 
        $moduleName = 'Booking';
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

            <div class="wizard">
                <div class="step" id="step-1">1. Service and Time</div>
                <div class="step" id="step-2">2. Customer Details</div>
                <div class="step" id="step-3">3. Confirm Booking</div>
            </div>
            <div id="booking">
                
                <!-- Select Service -->
                <div class="card" id="card-1">
                    <div class="card-header">
                        <h4 class="card-title">Select Service and Time</h4>
                    </div>
                
                    <div class="card-body">
                        <div class="form-group w-75 mx-auto">
                            <label for="select" class="">Service Type</label> 
                            <select id="select" name="select" class="custom-select">
                                <option value="1">Regular Service</option>
                                <option value="2">Minor Repair(s) / Service</option>
                            </select>
                        </div>
                        <div class="my-4"></div>
                        <div class="form-group w-75 mx-auto">
                            <label for="select" class="">Service Time Slot</label> 
                            <select id="select" name="select" class="custom-select">
                                <option value="1">Monday</option>
                            </select>
                        </div>
                    </div> <!-- </card-body> -->
    
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-primary next">Next</button>
                    </div> <!-- </card-footer> -->
                </div>
                <!-- End Select Service -->
                
                <!-- Customer Details -->
                <div class="card" id="card-2">
                    <div class="card-header">
                        <h4 class="card-title">Customer Details</h4>
                    </div> <!-- </card-header> -->
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <input type="text" name="find" id="find_customer" class="form-control w-75 mr-1" placeholder="Search Customer">
                            <button class="btn btn-primary">New</button>
                        </div>
                    </div> <!-- </card-body> -->
                    
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-primary prev">Prev</button>
                        <button class="btn btn-primary next">Next</button>
                    </div>
                </div> <!-- </card> -->
                <!-- End Customer Details -->
    
                <!-- Confirm Booking Details -->
                <div class="card" id="card-3">
                    <div class="card-header">
                        <h4 class="card-title">Confirm Booking</h4>
                    </div> <!-- </card-header> -->
                    
                    <div class="card-body">
                        <div style="background-color: rgb(192, 192, 248);">
                            <h5 class="d-flex justify-content-center ">Customer Details</h5>
                        </div>
                    </div> <!-- </card-body> -->
    
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-primary prev">Prev</button>
                        <button class="btn btn-primary">Finish</button>
                    </div> <!-- card-footer -->
                    
                </div> <!-- </card> -->
                <!-- End Confirm Booking Details -->
                
            </div>
        </div> <!-- </container-fluid -->
        </div> <!-- </content> -->
    </div> <!-- </content-wrapper> -->
    </div> <!-- wrapper -->
    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="wizard.js"></script>
</body>
</html>