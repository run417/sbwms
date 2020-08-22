<?php
$title = 'View Booking - SBWMS';
require_once COMMON_VIEWS . 'header.php';
$booking = $booking;
?>

<body>
    <style>
        .box {
            border: 1px solid hsl(0, 0%, 90%);
            min-height: 90px;
            padding: 6px;
            margin-bottom: 3px;
        }

        .box-title {
            text-transform: uppercase;
            font-size: 0.82rem;
            color: hsl(0, 0%, 50%)
        }

        .box-header {
            /* border: 1px solid red; */
            /* padding: 2px; */
            padding-bottom: 5px;
        }

        .box-title {

            /* border: 3px solid blue; */
        }
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
        $b = $booking;
        $breadcrumbMarkUp = breadcrumbs(['Booking' => '/booking', 'View' => '#', $b->getBookingId() => '#'], '$b->getBookingId()');
        require_once COMMON_VIEWS . 'sidebar.php';
        ?>
        <span id="active_menu" data-menu="booking"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once COMMON_VIEWS . 'navbar.php'; ?>
            <!-- navbar end -->
            <div id="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 mx-auto">
                            <div id="booking-info" data-booking-id="<?= $b->getId(); ?>"></div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Booking - <?= $b->getBookingId(); ?></h4>
                                    <?php if ($booking->getStatus() === 'confirmed') : ?>
                                        <a id="service-job-btn" href="#" class="btn btn-primary btn-lg">Start Job</a>
                                    <?php endif; ?>
                                    <?php if ($booking->getStatus() === 'realized') : ?>
                                        <a id="view-service-job-btn" href="<?= url_for('service-order/view?id=') . $b->getBookingId(); ?>" class="btn btn-outline-primary btn-lg">View Service Order</a>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">

                                    <div id="booking-box" class="box">
                                        <div class="box-header">
                                            <div class="box-title">Booking Details</div>
                                        </div>
                                        <style>
                                            .dt {
                                                text-transform: uppercase;
                                                font-size: 0.8rem;
                                                color: hsl(231, 51%, 56%);
                                                padding-right: 5px;
                                            }

                                            #employee-box {
                                                width: 100%;
                                            }

                                            #service-type-box {
                                                width: 100%;
                                                margin-right: 3px;
                                            }

                                            .c-details .dd {
                                                /* column details */
                                                padding-bottom: 4px;
                                            }

                                            #service-employee-box {
                                                min-height: 125px;
                                            }
                                        </style>
                                        <div class="box-body d-flex justify-content-around">
                                            <span class="dd"><span class="dt">Booking Id: </span><?= $b->getBookingId(); ?></span>
                                            <span class="dd"><span class="dt">Date: </span><?= $b->getStartDateTime()->format('Y-m-d'); ?></span>
                                            <span class="dd"><span class="dt">Start Time: </span><?= $b->getStartDateTime()->format('H:i:s'); ?></span>
                                            <span class="dd"><span class="dt">Status: </span><span class="<?= $b->getStatus(); ?>"><?= ucfirst($b->getStatus()); ?></span></span>
                                        </div>
                                    </div>

                                    <div class="box" id="customer-box">
                                        <div class="box-header">
                                            <div class="box-title">Customer Details</div>
                                        </div>
                                        <div class="box-body">
                                            <div class="customer-details d-flex justify-content-around">
                                                <span class="dd"><span class="dt">Customer Id: </span><?= $b->getCustomer()->getCustomerId(); ?></span>
                                                <span class="dd"><span class="dt">Name: </span><?= $b->getCustomer()->getFullName(); ?></span>
                                                <span class="dd"><span class="dt">Telephone: </span><?= $b->getCustomer()->getTelephone(); ?></span>
                                                <span class="dd"><span class="dt">Email: </span><?= $b->getCustomer()->getEmail(); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box" id="vehicle-box">
                                        <div class="box-header">
                                            <div class="box-title">Vehicle Details</div>
                                        </div>
                                        <div class="box-body">
                                            <div class="customer-details d-flex justify-content-around">
                                                <span class="dd"><span class="dt">Vehicle Id: </span><?= $b->getVehicle()->getVehicleId(); ?></span>
                                                <span class="dd"><span class="dt">Make: </span><?= $b->getVehicle()->getMake(); ?></span>
                                                <span class="dd"><span class="dt">Model: </span><?= $b->getVehicle()->getModel(); ?></span>
                                                <span class="dd"><span class="dt">Year: </span><?= $b->getVehicle()->getYear(); ?></span>
                                                <span class="dd"><span class="dt">Reg No: </span><?= $b->getVehicle()->getRegNo() ?? 'N/A'; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="service-employee-box" class="d-flex">
                                        <div class="box" id="service-type-box">
                                            <div class="box-header">
                                                <div class="box-title">Service type Details</div>
                                            </div>
                                            <div class="box-body">
                                                <div id="service-type-details" class="c-details d-flex flex-column">
                                                    <span class="dd"><span class="dt">Service Id: </span><?= $b->getServiceType()->getServiceTypeId(); ?></span>
                                                    <span class="dd"><span class="dt">Name: </span><?= $b->getServiceType()->getName(); ?></span>
                                                    <span class="dd"><span class="dt">Duration: </span><?= $b->getServiceType()->getDuration()->format('Approx. %H hours and %i minutes'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box align-items-stretch" id="employee-box">
                                            <div class="box-header">
                                                <div class="box-title">Employee Details</div>
                                            </div>
                                            <div class="box-body">
                                                <div id="employee-details" class="c-details d-flex flex-column">
                                                    <span class="dd"><span class="dt">Employee Id: </span><?= $b->getEmployee()->getEmployeeId(); ?></span>
                                                    <span class="dd"><span class="dt">Name: </span><?= $b->getEmployee()->getFirstName(); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <?php if ($booking->getStatus() !== 'realized' && $booking->getStatus() !== 'cancelled') : ?>
                                        <button id="cancel-booking-btn" class="btn btn-outline-danger">Cancel</button>
                                    <?php endif; ?>
                                    <!-- don't show if late or cancelled -->
                                    <!-- show reschedule instead -->
                                    <!-- <?php if (
                                                !($booking->getStatus() === 'cancelled' ||
                                                    $booking->getStatus() === 'late' ||
                                                    $booking->getStatus() === 'realized')
                                            ) : ?>
                                        <button id="realize-booking-btn" class="btn btn-outline-success">Realize</button>
                                    <?php endif; ?> -->
                                </div>
                            </div> <!-- </card> -->

                        </div> <!-- <col> -->
                    </div> <!-- </row> -->
                </div> <!-- </container> -->
            </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/booking/view-booking.js'); ?>"></script>

    <script>

    </script>
</body>

</html>