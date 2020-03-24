<?php
    $title = 'View Purchase Order - SBWMS';
    require_once COMMON_VIEWS . 'header.php';
?>
<body>
    <style>
        .updated {
            background-color: hsla(125, 68%, 90%, 1);
        }
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
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'Purchase Order' => '/inventory/purchase-order', 'View' => '#', $p->getId() => '#'], $p->getId());
            require_once COMMON_VIEWS . 'sidebar.php';
        ?>
        <span id="active_menu" data-menu="inventory"></span>
        <span id="sub_menu" data-submenu="purchase-order"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once COMMON_VIEWS . 'navbar.php'; ?>
            <!-- navbar end -->
        <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Purchase Order - <?= $p->getId(); ?></h4>
                            <!-- <a href="<?= url_for('#'); ?>" class="btn btn-primary btn-lg">button</a> -->
                        </div>
                        <div class="card-body">

                            <div class="box">
                                <div class="box-header mb-2">
                                    <div class="box-title">Purchase Order Details</div>
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
                                        <span class="dd"><span class="dt">Id: </span><?= $p->getId(); ?></span>
                                        <span class="dd"><span class="dt">Date: </span><?= $p->getDate()->format('Y-m-d'); ?></span>
                                        <span class="dd"><span class="dt">Supplier: </span><?= $p->getSupplier()->getCompanyName(); ?></span>
                                        <span class="dd"><span class="dt">Status: </span><span class="<?= $p->getStatus(); ?>"><?= ucfirst($p->getStatus()); ?></span></span>
                                    </div>
                            </div>
                            <div class="box">
                            <div class="box-header mb-2 d-flex justify-content-between">
                                <div class="box-title">Purchase Order Items</div>
                            </div>
                            <div id="purchase-order-items" class="mb-1">
                                <div class="table-responsive">
                                    <table id="purchase-order-items-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Item Id</th>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($p->getItems() as $i): ?>
                                            <tr>
                                                <td><?= $i->getId(); ?></td>
                                                <td><?= $i->getName(); ?></td>
                                                <td><?= $i->getQuantity(); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        </div>
                        <div class="card-footer">
                            <button data-entity-id="<?= $p->getId(); ?>" id="receive-items" class="btn btn-primary">Receive Items</button>
                        </div>
                    </div> <!-- </card> -->

                </div> <!-- <col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/purchase-order/view-purchase-order.js'); ?>"></script>
</body>
</html>
