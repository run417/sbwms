<?php
    $title = 'New Purchase Order';
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
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'Purchase Orders' => '/inventory/purchase-order', 'New' => '#'], 'New');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="inventory"></span>
        <span id="sub_menu" data-submenu="purchase-order"></span>
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
                            <h4 class="card-title">New Purchase Order</h4>
                        </div>
                        <div class="card-body">
                            <div class="box">
                                <!-- <div class="box-header">
                                    <div class="box-title">Details</div>
                                </div> -->
                                    <!-- START FORM -->
                                    <form id="new-purchase-order-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="date">Date</label>
                                                <input id="date" name="date" type="date" class="form-control" value="<?= ((new DateTime())->format('Y-m-d')); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="shippingDate">Shipping Date</label>
                                                <input id="shippingDate" name="shippingDate" type="date" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="supplier">Supplier</label>
                                                <select id="supplier" name="supplier" class="custom-select">
                                                    <option value="">Select a supplier</option>
                                                    <?php foreach($suppliers as $s): ?>
                                                    <option value="<?= $s->getId(); ?>"><?= $s->getCompanyName(); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="date">Remarks</label>
                                                <textarea id="remarks" name="remarks" class="form-control" placeholder="Optional Remarks"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM -->

                            </div>
                            <div class="box">
                                <div class="box-header expanded-header d-flex justify-content-between">
                                    <div class="box-title">Purchase Order Items</div>
                                    <button id="add-items-btn" class="btn btn-sm btn-primary">Add Items</button>
                                </div>
                                <div id="purchase-order-items" class="mb-1">
                                    <div class="table-responsive">
                                        <table id="purchase-order-items-table" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Item Id</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
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
                        <div class="card-footer d-flex justify-content-end">
                            <button id="submit-purchase-order-btn" class="btn btn-primary">Create Purchase Order</button>
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


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/purchase-order/new-purchase-order.js'); ?>"></script>
</body>
</html>
