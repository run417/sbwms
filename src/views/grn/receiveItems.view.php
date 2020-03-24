<?php
    $title = 'GRN Receive Items';
    require_once COMMON_VIEWS . 'header.php';
?>
<body>
    <style>
        .item-processed {
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
            $p = $purchaseOrder;
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'GRN' => '/inventory/grn', 'Receive Items' => '#'], 'Receive Items');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="inventory"></span>
        <span id="sub_menu" data-submenu="grn"></span>
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
                            <h4 class="card-title">GRN - Receive Items</h4>
                        </div>
                        <div class="card-body">
                            <div class="box">
                                <!-- <div class="box-header">
                                    <div class="box-title">Details</div>
                                </div> -->
                                    <!-- START FORM -->
                                    <form id="receive-items-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="date">Date</label>
                                                <input id="date" name="date" type="date" class="form-control" value="<?= ((new DateTime())->format('Y-m-d')); ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="date">Purchase Order Id</label>
                                                <input id="purchaseOrderId" name="purchaseOrderId" type="text" class="form-control" readonly value="<?= $p->getId(); ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="purchaseOrderDate">Purchase Order Date</label>
                                                <input id="purchaseOrderDate" name="purchaseOrderDate" type="date" class="form-control" readonly value="<?= $p->getDate()->format('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="date">Remarks</label>
                                                <textarea id="remarks" name="remarks" class="form-control" readonly><?= $p->getRemarks(); ?></textarea>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="supplier">Supplier</label>
                                                <input type="text" id="supplier" name="supplier" class="form-control" readonly value="<?= $p->getSupplier()->getCompanyName(); ?>">
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM -->

                            </div>
                            <div class="box">
                                <div class="box-header expanded-header d-flex justify-content-between">
                                    <div class="box-title">Items Received</div>
                                    <button id="add-items-btn" class="btn btn-sm btn-primary">Process Items</button>
                                </div>
                                <div id="items" class="mb-1">
                                    <div class="table-responsive">
                                        <table id="items-table" data-item-count="<?= count($p->getItems()); ?>" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Item Id</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Selling Price</th>
                                                    <th>Process Item</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($p->getItems() as $i): ?>
                                                <tr id="<?= $i->getId(); ?>">
                                                    <td><?= $i->getId(); ?></td>
                                                    <td><?= $i->getName(); ?></td>
                                                    <td><?= $i->getQuantity(); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><a data-entity-id="<?= $i->getId(); ?>" class="open-process-item-modal" href="#"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Process Item Details"></i></a></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- </.card-body> -->
                        <div class="card-footer d-flex justify-content-end">
                            <button id="add-items-to-stock-btn" class="btn btn-primary">Add to Stock</button>
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

    <!-- START PROCESS ITEM MODAL -->
    <div class="modal fade" id="process-item-modal" role="dialog" aria-labelledby="processItemModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Received Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <form id="process-item-form">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="itemId">Item Id</label>
                        <input id="itemId" name="itemId" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="quantity">Quantity</label>
                        <input id="quantity" name="quantity" type="number" class="form-control">
                    </div>
                    <div class="form-group col-md">
                        <label for="unitPrice">Unit Price</label>
                        <input id="unitPrice" name="unitPrice" type="number" step="50" class="form-control">
                    </div>
                    <div class="form-group col-md">
                        <label for="sellingPrice">Selling Price</label>
                        <input id="sellingPrice" name="sellingPrice" type="number" step="50" class="form-control">
                    </div>
                </div>

        </div> <!-- </.modal-body> -->

            <div class="modal-footer">
                <button id="process-item-btn" type="submit" class="btn btn-primary">Process Item</button>
            </div> <!-- </.modal-footer> -->
        </form>
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END PROCESS ITEM MODAL -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/grn/receive-items.js'); ?>"></script>
</body>
</html>
