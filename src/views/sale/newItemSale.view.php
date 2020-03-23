<?php
    $title = 'New Order';
    require_once COMMON_VIEWS . 'header.php';
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
        #item-sale-overview {
            border: 0px solid rgba(0, 0, 0, 0.125);
            box-shadow: 0px 0px 13px 0px #ced4da;
            border-radius: 15px;
            padding-right: 20px;
            padding-left: 20px;
            padding-top: 5px;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        #item-sale-overview #title {
            font-size: 1.12rem;
            margin-bottom: 1px;
        }
        .overview-info {
            /* text-transform: uppercase; */
        }
        #item-cost, #item-count {
            font-size: 2rem;
        }
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(['Sales' => '#', 'New Order' => '#'], 'New Order');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="sales"></span>
        <span id="sub_menu" data-submenu="new-order"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
        <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                <div id="item-sale-overview">
                    <!-- only item count NOT quantity * count -->
                    <div id="item-sale-info" data-item-count="" data-job-card-id="" data-service-order-id="" data-service-order-status=""></div>
                    <div class="" id="title">Sale Overview</div>
                    <div class="d-flex justify-content-end">
                        <span class="pr-4"><span class="overview-info">No. of Items: </span><span id="item-count">0</span></span>
                        <span><span class="overview-info">Grand Total:</span> Rs. <span id="item-cost">0.00</span></span>
                    </div>
                </div>
                    <div id="item-sale-card" class="card">
                        <div class="card-header">
                            <h4 class="card-title">New Order</h4>
                        </div>
                        <div class="card-body">
                            <div class="box">
                                <div class="box-header">
                                    <div class="box-title">Customer Details</div>
                                </div>
                                    <!-- START FORM -->
                                    <form id="select-customer-form">
                                    <div class="form-row">
                                        <div class="form-group col-md-7">
                                            <label for="customer">Customer</label>
                                                <style>
                                                    #selected-customer {
                                                        border: 1px solid blue;
                                                        border-radius: 5px;
                                                        padding: 5px;
                                                        width: 100%;
                                                        /* height: 10px; */
                                                    }
                                                </style>
                                                <div id="customer" class="d-flex">
                                                    <span id="selected-customer" class="mr-1">Click 'Find' to select a customer</span>
                                                    <button id="find-customer-btn" class="btn btn-outline-primary mr-1 .ignore">Find</button>
                                                </div>
                                                <input id="customerId" name="customerId" type="hidden">
                                        </div>
                                        <div class="form-group col-md-5">
                                            <div class="custom-control custom-checkbox pt-4">
                                                <input name="walk-in-customer" id="walk-in-customer" type="checkbox" class="custom-control-input">
                                                <label for="walk-in-customer" class="custom-control-label">Walk-in Customer</label>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <!-- END FORM -->

                            </div>
                            <div class="box">
                                <div class="box-header expanded-header d-flex justify-content-between">
                                    <div class="box-title">Order Cart</div>
                                    <button id="add-items-btn" class="btn btn-sm btn-primary">Add Items to Cart</button>
                                </div>
                                <div id="order-items" class="mb-1">
                                    <div class="table-responsive">
                                        <table id="order-items-table" class="table table-hover">
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
                        <div class="card-footer d-flex justify-content-between">
                            <button id="discard-btn" class="btn btn-sm btn-outline-danger">Discard</button>
                            <button id="payment-btn" class="btn btn-primary">Proceed to Payment</button>
                        </div>
                    </div> <!-- </card> -->

                    <style>
                        #payment-form .form-control {
                            font-size: 1.5rem;
                            text-align: right;
                        }
                    </style>
                    <!-- PAYMENT -->
                    <div id="row">
                        <div class="col-md-6 mx-auto">
                            <div id="payment-card" style="display: none;" class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Payment</h4>
                                </div>
                                <div class="card-body">
                                    <!-- START FORM -->
                                    <form id="payment-form">
                                    <div class="form-row ">
                                        <div class="form-group col-md">
                                            <label for="grand-total">Grand Total</label>
                                            <input id="grand-total" name="grandTotal" type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row ">
                                        <div class="form-group col-md-3">
                                            <label for="discount">Discount</label>
                                            <input id="discount" name="discount" type="text" class="form-control">
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="paid-amount">Paid Amount</label>
                                            <input id="paid-amount" name="paidAmount" type="number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row ">
                                        <div class="form-group col-md">
                                            <label for="net-total">Net Total</label>
                                            <input id="net-total" name="netTotal" type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row ">
                                        <div class="form-group col-md">
                                            <label for="balance">Balance</label>
                                            <input id="balance" name="balance" type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    </form>
                                    <!-- END FORM -->
                                </div> <!-- </.card-body> -->
                                <div class="card-footer d-flex justify-content-between">
                                    <button id="goto-order-btn" class="btn btn-sm btn-outline-primary">Go to Order</button>
                                    <button id="invoice-btn" class="btn btn-primary">Process Invoice</button>
                                </div>
                            </div> <!-- </card> -->
                        </div>
                    </div>
                    <!-- END PAYMENT -->

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
                <button id="add-item-btn" type="submit" class="btn btn-primary">Add to Purchase Order</button>
            </div> <!-- </.modal-footer> -->
        </form>
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END SELECTED ITEM MODAL -->

    <!-- START SELECT CUSTOMER MODAL -->
    <div class="modal fade" data-load-state="0" id="select-customer-modal" role="dialog" aria-labelledby="selectCustomerModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <div id="customer-list">

            </div>
        </div> <!-- </.modal-body> -->

            <div class="modal-footer">
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END SELECT CUSTOMER MODAL -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/sale/new-order.js'); ?>"></script>
</body>
</html>
