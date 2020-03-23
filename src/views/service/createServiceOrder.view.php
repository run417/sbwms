<?php
    $title = 'Create Service Order';
    require_once COMMON_VIEWS . 'header.php';
    // $b = $booking;
?>
<body>
    <style>
        .row-selected {
            background-color: hsla(209, 68%, 90%, 1)
        }
        .updated {
            background-color: hsla(125, 68%, 90%, 1);
        }
        .box {
            border: 1px solid hsl(0, 0%, 90%);
            min-height: 90px;
            padding: 6px;
            margin-bottom: 3px;
        }
        .box-title {
            text-transform: uppercase;
            font-size: 0.82rem;
            color: hsl(207, 75%, 34%)
        }
        .box-header {
            /* border: 1px solid red; */
            /* padding: 2px; */
            padding-bottom: 5px;
        }
        .expanded-header {
            margin: 0px;
            margin-left: -22px;
            margin-right: -22px;
            padding-left: 22px;
            padding-right: 22px;
            padding-top: 10px;
            padding-bottom: 10px;
            background-color: hsl(201, 33%, 90%)
        }
        .box-title {
            /* border: 3px solid blue; */
        }
    </style>

    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(['Service' => '#', 'Service Order' => '#'], 'Service Order');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="service"></span>
        <span id="sub_menu" data-submenu="service_order"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
        <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Service Order</h4>
                            <!-- <a href="<?= url_for('/service-order/new'); ?>"  class="btn btn-primary btn-lg" id="new_customer_btn">New Service Order</a> -->
                        </div>
                        <div class="card-body">
                                <div class="box">
                                    <div class="box-header">
                                        <div class="box-title">Service Details</div>
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
                                        .c-details .dd { /* column details */
                                            padding-bottom: 4px;
                                        }
                                        #service-employee-box {
                                            min-height: 125px;
                                        }
                                    </style>
                                    <div class="box-body d-flex justify-content-around">
                                        <span class="dd"><span class="dt">Service Type: </span></span>
                                        <span class="dd"><span class="dt">Date: </span></span>
                                        <span class="dd"><span class="dt">Start Time: </span></span>
                                        <span class="dd"><span class="dt">Status: </span><span></span></span>
                                    </div>
                                </div>
                                <div id="box" class="box">
                                    <div class="box-header">
                                        <div class="box-title"> Details</div>
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
                                        .c-details .dd { /* column details */
                                            padding-bottom: 4px;
                                        }
                                        #service-employee-box {
                                            min-height: 125px;
                                        }
                                    </style>
                                    <div class="box-body d-flex justify-content-around">
                                        <span class="dd"><span class="dt">Booking Id: </span></span>
                                        <span class="dd"><span class="dt">Date: </span></span>
                                        <span class="dd"><span class="dt">Start Time: </span></span>
                                        <span class="dd"><span class="dt">Status: </span><span></span></span>
                                    </div>
                                </div>
                            <div class="box">
                                <div class="box-header expanded-header d-flex justify-content-between">
                                    <div class="box-title">Service Tasks</div>
                                    <button id="add-tasks-modal-btn" class="btn btn-sm btn-primary">Add Tasks</button>
                                </div>
                                <div id="order-items" class="mb-1">
                                    <div class="table-responsive">
                                        <table id="service-tasks-table" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Task Description</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-header expanded-header d-flex justify-content-between">
                                    <div class="box-title">Service Items Used</div>
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
                        </div> <!-- </.card-body> -->
                        <div class="card-footer">
                            <button class="btn btn-primary">Payment</button>
                        </div>
                    </div> <!-- </card> -->

                </div> <!-- <col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->

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

       <!-- START SERVICE TASKS MODAL -->
       <div class="modal fade" id="service-tasks-modal" role="dialog" aria-labelledby="serviceTasksModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <form id="service-task-form">
                <div class="form-group">
                    <label for="task-description">Task Description</label>
                    <input id="task-description" name="task" type="text" class="form-control">
                </div>
        </div> <!-- </.modal-body> -->
            <div class="modal-footer">
                <button id="add-task-btn" type="submit" class="btn btn-primary">Add Task to Service</button>
            </div> <!-- </.modal-footer> -->
        </form>
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END SERVICE TASKS MODAL -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/service-order/service-order.js'); ?>"></script>
</body>
</html>
