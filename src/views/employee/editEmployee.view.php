<?php
    $e = $employee;
    // exit(var_dump($e));
    $est = $employee->getServiceTypeIds();
    $title = "Edit Employee - SBWMS";
    require_once(COMMON_VIEWS . 'header.php');
?>
<body>
    <style>
        .card .card-body {
            padding-top: 0px;
        }
        .custom-checkbox {
            padding-top: 3px;
            padding-bottom: 3px;
        }

        .form-section-heading {
            /* background-color: #529fff26; */
            background-color:hsla(201, 33%, 90%, 0.65);
            padding-bottom: 9px;
            padding-top: 9px;
            margin-left: -15px;
            margin-right: -15px;
            margin-bottom: 15px;
            box-shadow: 1px 2px 2px #eeeeee;
        }

        .form-section-title {
            margin-left: 15px;
            margin-bottom: 0px;
            text-transform: uppercase;
            font-size: 0.86rem;
            color: #005999ba;
        }
        .form-info {
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 0.88rem;
            color: hsl(208, 7%, 46%);
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        #form-errors {
            color: hsl(354, 70%, 54%);
            border: 1px solid red;
            padding-top: 6px;
            padding-bottom: 6px;
            margin-top: 6px;
            margin-bottom: 6px;
        }
        #form-errors p {
            padding-left: 6px;
        }
    </style>
    <div class="wrapper">

        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(['Employee' => '/employee', $e->getId() => '#', 'Update Details' => '/employee/edit'], 'Update Details');
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
                                <h4 class="card-title">Edit Employee - <?= $e->getId(); ?> Details</h4>
                                <div id="employee-info" data-employee-id="<?= $e->getId(); ?>"></div>
                            </div>
                            <div class="col-md-auto">

                            </div>
                        </div>

                      </div> <!-- </card-header> -->
                      <div class="card-body">

                        <!-- START FORM -->
                        <form id="edit-employee">
                            <div class="form-info d-flex justify-content-end">All fields are required</div>
                            <div class="form-section-heading">
                                <span class="form-section-title">Personal Details</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee-first-name">First Name</label>
                                    <input id="employee-first-name" name="firstName" type="text" class="form-control" value="<?= $e->getFirstName(); ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="employee-last-name">Last Name</label> 
                                    <input id="employee-last-name" name="lastName" type="text" class="form-control" value="<?= $e->getLastName(); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee-nic">NIC</label>
                                    <input id="employee-nic" name="nic" type="text" class="form-control" value="<?= $e->getNic(); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee-telephone">Telephone</label>
                                    <input id="employee-telephone" name="telephone" type="tel" class="form-control" value="<?= $e->getTelephone(); ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="employee-email">Email</label>
                                    <input id="employee-email" name="email" type="email" class="form-control" value="<?= $e->getEmail(); ?>">
                                </div>
                            </div>
                            <div class="form-section-heading">
                                <span class="form-section-title">Role Details</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee-date-joined">Date Joined</label> 
                                    <input id="employee-date-joined" name="dateJoined" type="text" placeholder="yyyy-mm-dd" class="form-control" value="<?= $e->getDateJoined(); ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="employee-role">Employee Role</label>
                                    <div>
                                        <select id="employee-role" name="role" class="custom-select">
                                            <option value="">Select Role</option>
                                            <?php foreach($e->getAllRoles() as $key => $value): ?>
                                            <option <?php echo ($key == $e->getRoleId()) ? 'selected ' : '' ; ?>value="<?= $key ?>"> <?= $value ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="crew-options">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="employee-shift-start">Shift Start</label>
                                        <input id="employee-shift-start" name="shiftStart" type="text" class="form-control" value="<?= $e->getShiftStart(); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="employee-shift-end">Shift End</label>
                                        <input id="employee-shift-end" name="shiftEnd" type="text" class="form-control" value="<?= $e->getShiftEnd(); ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-auto">
                                        <div class="custom-control custom-checkbox">
                                            <input name="bookingAvailability" id="bookingAvailability" type="checkbox" class="custom-control-input" value="yes" <?= ($e->getBookingAvailability() == 'yes') ? ' checked' : '' ?>>
                                            <label for="bookingAvailability" class="custom-control-label">Booking Availability</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-auto">
                                        <input name="serviceTypes[]" id="serviceTypes" type="checkbox" class="custom-control-input" value="0000" style="{display: none;}">
                                        <label for="serviceTypes">Performing Service Types</label>
                                        <div>
                                        <?php foreach ($serviceTypes as $st): ?>
                                            <div class="custom-control custom-checkbox">
                                                <input name="serviceTypes[]" id="<?= $st->getServiceTypeId(); ?>" type="checkbox" class="custom-control-input" value="<?= $st->getServiceTypeId(); ?>" <?= (in_array($st->getId(), $est)) ? 'checked' : '' ?>>
                                                <label for="<?= $st->getServiceTypeId(); ?>" class="custom-control-label"><?= $st->getName(); ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- </#crew-options> -->

                            <div class="card-footer form-group">
                                <button class="btn btn-block btn-primary">Add New Employee</button>
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
    <script src="<?= url_for('/assets/js/custom/employee/edit-employee.js'); ?>"></script>
</body>
</html>
