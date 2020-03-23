<?php
    $title = 'GRN List';
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
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'GRN' => '#'], 'GRN');
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
                            <h4 class="card-title">GRN List</h4>
                            <!-- <a href="#" id="new-purchase-order-btn" class="btn btn-primary btn-lg">New Purchase Order</a> -->
                        </div>
                        <div class="card-body">
                            <div id="grn-list">
                                <div class="table-responsive">
                                    <table id="grn-list-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <?php if(empty($grns)): echo 'No Items Received.Go to purchase orders Click \'Receive Items\' to update the stock'; ?>
                                                <?php else: ?>
                                                <th>GRN Id</th>
                                                <th>Date</th>
                                                <th>Purchase Order Id</th>
                                                <th>Supplier Company</th>
                                                <th>View</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($grns as $g): ?>
                                            <tr id="<?= $g->getId(); ?>">
                                                <td><?= $g->getId(); ?></td>
                                                <td><?= $g->getDate()->format('Y-m-d'); ?></td>
                                                <td><?= $g->getPurchaseOrder()->getId(); ?></td>
                                                <td><?= $g->getPurchaseOrder()->getSupplier()->getCompanyName(); ?></td>
                                                <td><a data-entity-id="<?= $g->getId(); ?>" class="view-grn" href="<?= url_for('/inventory/grn/view?id=') . $g->getId(); ?>"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="View GRN Details"></i></a></td>
                                                <!-- <td></td> -->
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
    <script src="<?= url_for('/assets/js/custom/grn/list-grn.js'); ?>"></script>
</body>
</html>