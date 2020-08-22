<?php
$s = $serviceOrder;
$v = $s->getBooking()->getVehicle();
$e = $s->getBooking()->getEmployee();
$c = $s->getBooking()->getCustomer();
$st = $s->getBooking()->getServiceType();
$j = $s->getJobCard();
$title = "Service Order - " . $s->getId();
require_once(COMMON_VIEWS . 'header.php');

?>

<body>
    <style>
        .updated {
            background-color: hsla(125, 68%, 90%, 1);
        }

        .row-selected {
            background-color: hsla(209, 68%, 90%, 1)
        }

        .confirmed {
            width: 10px;
            background-color: #74c38a6e;
            border: #28a745 solid 2px;
            padding: 4px;
            border-radius: 9px;
        }

        .pending {
            width: 100%;
            background-color: hsla(45, 100%, 85%);
            border: hsl(45, 100%, 51%) solid 2px;
            padding: 4px;
            border-radius: 9px;
        }

        /* .late {}

        .cancelled {} */

        .dt {
            text-transform: uppercase;
            font-size: 0.8rem;
            color: hsl(231, 51%, 56%);
            padding-right: 5px;
        }

        .expanded-header {
            margin: 0px;
            margin-top: 6px;
            margin-bottom: 8px;
            /* margin-left: -22px; */
            /* margin-right: -22px; */
            padding-left: 22px;
            padding-right: 22px;
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 12px;
            background-color: hsl(201, 33%, 90%)
        }

        .service-items-header {
            align-items: flex-end;
            margin: 0px;
            margin-top: 2px;
            margin-bottom: 8px;
            /* margin-left: -22px; */
            /* margin-right: -22px; */
            padding-left: 22px;
            padding-right: 22px;
            padding-top: 3px;
            padding-bottom: 10px;
            border-bottom: 1px solid hsl(201, 33%, 80%);
        }

        .box-title {
            text-transform: uppercase;
            font-size: 0.86rem;
            color: hsl(207, 75%, 44%)
        }

        .box-body {
            padding-bottom: 9px;
            padding-top: 9px;
            border-bottom: 1px solid hsl(0, 0%, 85%);
        }

        .card-body {
            padding-top: 3px !important;
        }

        #service-overview {
            border: 0px solid rgba(0, 0, 0, 0.125);
            box-shadow: 0px 0px 13px 0px #ced4da;
            border-radius: 15px;
            padding: 10px;
            padding-top: 5px;
            margin-bottom: 20px;
        }

        #service-overview #title {
            font-size: 1.12rem;
            margin-bottom: 15px;
        }

        /* .overview-info {
            text-transform: uppercase;
        } */

        #item-cost {
            font-size: 1.2rem;
        }
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
        $breadcrumbMarkUp = breadcrumbs(['Service Order' => '#', 'View' => '#', $s->getId() => '#'], $s->getId());
        require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="service-order"></span>
        <span id="sub_menu" data-submenu="<?= $s->getStatus(); ?>"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
            <div id="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-9 mx-auto">
                            <div id="service-overview">
                                <!-- only item count NOT quantity * count -->
                                <div id="service-info" data-job-card-item-count="<?= count($j->getItems()); ?>" data-job-card-id="<?= $j->getId(); ?>" data-service-order-id="<?= $s->getId(); ?>" data-service-order-status="<?= $s->getStatus(); ?>"></div>
                                <div class="" id="title">Service Overview</div>
                                <div class="d-flex justify-content-around">
                                    <span><span class="overview-info">Item Cost:</span> Rs. <span id="item-cost"><?= $j->getTotalItemCost(); ?></span></span>
                                    <span>Service Time
                                        <?php
                                        $sert = $s->getServiceTime();
                                        // $sert = new DateInterval('PT1H59M32S');
                                        ?>

                                        <span id="service-time" data-hours="<?= $sert->format('%h'); ?>" data-minutes="<?= $sert->format('%i'); ?>" data-seconds="<?= $sert->format('%s'); ?>" class="pt-2 pr-4 nav-item">
                                            <i class="far fa-clock"></i>
                                            <span id="display-service-time">
                                                <?php if ($s->getStatus() !== 'ongoing') {
                                                    echo $sert->format('%h:%I:%S');
                                                } ?>
                                            </span>
                                        </span>

                                    </span>
                                    <span>Service Status: <span id="<?= $s->getStatus(); ?>"><?= ucfirst($s->getStatus()); ?></span></span>
                                </div>
                            </div>
                            <div class="card animated fadeIn">
                                <div class="card-header">
                                    <h4 class="card-title">Service Order - <?= $s->getId(); ?></h4>
                                    <a href="#" id="hold-service-btn" class="btn btn-outline-info">Hold Service</a>
                                    <a href="#" id="restart-service-btn" class="btn btn-outline-success">Restart Service</a>
                                </div>
                                <div class="card-body">

                                    <!-- box -->

                                    <div class="box">
                                        <div class="box-header">
                                            <!-- <div class="box-title">Booking Details</div> -->
                                        </div>
                                        <div class="box-body d-flex justify-content-around">
                                            <span class="dd"><span class="dt">Booking Id: </span><?= $s->getBooking()->getBookingId(); ?><a href="<?= url_for('/booking/view?id=') . $s->getBooking()->getId(); ?>" id="view-booking-btn" class="btn ml-2 btn-outline-primary btn-sm">View Booking</a></span>
                                            <span class="dd"><span class="dt">Start Time: </span><?= $s->getBooking()->getStartDateTime()->format('H:i:s'); ?></span>
                                        </div>
                                        <div class="box-body d-flex justify-content-around">
                                            <span class="dd"><span class="dt">Vehicle: </span><?php echo $v->getVehicleId();
                                                                                                echo ' - ' . $v->getMakeModelYear(); ?><button class="ml-2 btn btn-outline-primary btn-sm">View Service History</button></span>
                                            <span class="dd"><span class="dt">Customer: </span><?php echo $c->getCustomerId();
                                                                                                echo ' - ' . $c->getFullName(); ?></span>
                                        </div>
                                        <div class="box-body d-flex justify-content-around">
                                            <span class="dd"><span class="dt">Vehicle Reg No: </span><?= $v->getRegNo() ?? 'N/A'; ?></span>
                                            <span class="dd"><span class="dt">Mileage: </span>32567</span>
                                            <span class="dd"><span class="dt">Last Service Date: </span>N/A</span>
                                        </div>
                                        <div class="box-body d-flex justify-content-around">
                                            <span class="dd"><span class="dt">Employee</span><?php echo $e->getEmployeeId();
                                                                                                echo ' - ' . $e->getFirstName(); ?></span>
                                            <span class="dd"><span class="dt">Service </span><?php echo $st->getId();
                                                                                                echo ' - ' . $st->getName(); ?></span>
                                        </div>
                                    </div>

                                    <!-- /box -->

                                    <!-- jobcard box -->
                                    <div class="box">
                                        <div class="box-header expanded-header d-flex justify-content-between">
                                            <div class="box-title">Job Card</div>
                                            <button id="save-job-card-btn" class="btn btn-sm btn-primary">Save Job Card</button>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="diagnosis">Diagnosis</label>
                                                <textarea id="diagnosis" name="diagnosis" class="form-control" placeholder="Problems of the vehicle"><?= $j->getDiagnosis(); ?></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="notes">Service Notes</label>
                                                <textarea id="service-notes" name="notes" class="form-control" placeholder="Notes on the service"><?= $j->getNotes(); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /end jobcard box -->

                                    <!-- items used box -->

                                    <div class="box">
                                        <div class="box-header service-items-header d-flex justify-content-between">
                                            <div class="box-title">Spare Parts Used</div>
                                            <button id="add-items-btn" class="btn btn-sm btn-primary">Add Items</button>
                                        </div>
                                        <div id="service-items" class="mb-1">
                                            <div class="table-responsive">
                                                <table id="service-items-table" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Id</th>
                                                            <th>Item Name</th>
                                                            <th>Selling Price</th>
                                                            <th>Quantity</th>
                                                            <th>Sub. Total</th>
                                                            <th>&nbsp;</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- /end items used box -->

                                </div> <!-- </.card-body> -->

                                <div class="card-footer d-flex justify-content-between">
                                    <button id="terminate-service-btn" class="btn btn-danger">Terminate Service</button>
                                    <button id="complete-service-btn" class="btn btn-success">Complete Service</button>
                                </div> <!-- </.card-footer> -->
                            </div> <!-- </.card> -->
                        </div> <!-- </.col> -->
                    </div> <!-- </.row> -->
                </div> <!-- </.container-fluid> -->
            </div> <!-- </.content> -->
        </div> <!-- </.content-wrapper> -->
    </div> <!-- </.wrapper> -->

    <!-- START ADD ITEM MODAL -->
    <div class="modal fade" data-load-state="0" id="add-items-modal" role="dialog" aria-labelledby="addItemsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Items to Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="item-list">

                    </div>
                </div> <!-- </.modal-body> -->

                <div class="modal-footer">
                </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END ADD ITEM MODAL -->

    <!-- START SELECTED ITEM MODAL -->
    <div class="modal fade" id="set-item-quantity-modal" role="dialog" aria-labelledby="setItemQuantityModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set Item Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="set-quantity-form">
                        <div class="form-group">
                            <label for="selectedItemId">Item Id</label>
                            <input id="selectedItemId" name="itemId" type="text" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="selectedItemName">Name</label>
                            <input id="selectedItemName" name="name" type="text" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="selectedItemSellingPrice">Selling Price</label>
                            <input id="selectedItemSellingPrice" name="sellingPrice" type="text" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="selectedItemQuantity">Quantity</label>
                            <input id="selectedItemQuantity" name="quantity" type="number" class="form-control">
                        </div>

                </div> <!-- </.modal-body> -->

                <div class="modal-footer">
                    <button id="add-item-btn" type="submit" class="btn btn-primary">Add to Service</button>
                </div> <!-- </.modal-footer> -->
                </form>
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END SELECTED ITEM MODAL -->



    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/service-order/add-item.js'); ?>"></script>
    <script src="<?= url_for('/assets/js/custom/service-order/view-service-order.js'); ?>"></script>
    <script src="<?= url_for('/assets/js/plugins/easytimer.min.js'); ?>"></script>

    <script>
        const timer = new easytimer.Timer();
        const service_h = $('#service-time').data('hours');
        const service_m = $('#service-time').data('minutes');
        const service_s = $('#service-time').data('seconds');

        if (serviceOrderStatus === 'ongoing') {
            timer.start({
                startValues: [0, service_s, service_m, service_h, 0]
            });
        }

        timer.addEventListener('secondsUpdated', () => {
            $('#display-service-time').text(timer.getTimeValues().toString());
        });
        // $('#display-service-time').text(timeStr)

        function highLightLastModified() {
            if (sessionStorage.lastModifiedId) {
                let rowId = sessionStorage.getItem('lastModifiedId');
                console.log(rowId);
                $(`#${rowId}`).addClass('updated');
                sessionStorage.clear();
            }
        }
        highLightLastModified();
    </script>

</body>

</html>