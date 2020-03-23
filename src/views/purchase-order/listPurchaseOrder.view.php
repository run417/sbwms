<?php
    $title = 'Purchase Order List';
    require_once COMMON_VIEWS . 'header.php';
?>
<body>
    <style>
        .received {
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

        .updated {
            background-color: hsla(125, 68%, 90%, 1);
        }
        .box {
            border: 1px solid hsl(0, 0%, 83%);
            min-height: 200px;
            padding: 6px;
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
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'Purchase Orders' => '#'], 'Purchase Orders');
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
                            <h4 class="card-title">Purchase Order List</h4>
                            <a href="<?= url_for('/inventory/purchase-order/new'); ?>" id="new-purchase-order-btn" class="btn btn-primary btn-lg">New Purchase Order</a>
                        </div>
                        <div class="card-body">
                            <div id="purchase-order-list">
                                <div class="table-responsive">
                                    <table id="purchase-order-list-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <?php if(empty($purchaseOrders)): echo 'No Purchase Orders created in the inventory. Click \'Create Purchase Order\' to create a new purchase order'; ?>
                                                <?php else: ?>
                                                <th>Purchase Order Id</th>
                                                <th>Date</th>
                                                <th>Shipping Date</th>
                                                <th>Status</th>
                                                <th>Supplier Company</th>
                                                <th>View</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($purchaseOrders as $p): ?>
                                            <tr id="<?= $p->getId(); ?>">
                                                <td><?= $p->getId(); ?></td>
                                                <td><?= $p->getDate()->format('Y-m-d'); ?></td>
                                                <td><?= $p->getShippingDate()->format('Y-m-d'); ?></td>
                                                <td><span class="<?= $p->getStatus(); ?>"><?= $p->getStatus(); ?></span></td>
                                                <td><?= $p->getSupplier()->getCompanyName(); ?></td>
                                                <td><a data-entity-id="<?= $p->getId(); ?>" class="view-purchase-order" href="<?= url_for('/inventory/purchase-order/view?id=') . $p->getId(); ?>"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="View Purchase Order Details"></i></a></td>
                                                <!-- <td></td> -->
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div> <!-- </.card-body> -->
                        <div class="card-footer">
                            <!-- Deactivate Online Account -->
                        </div>
                    </div> <!-- </card> -->

                </div> <!-- <col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->



    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/purchase-order/list-purchase-order.js'); ?>"></script>
</body>
</html>
