<?php
    $title = 'Available Stock';
    require_once COMMON_VIEWS . 'header.php';
?>
<body>
    <style>
        .low {
            background-color: hsla(354, 68%, 90%, 1);
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
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'Stock' => '#'], 'Stock');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="inventory"></span>
        <span id="sub_menu" data-submenu="stock"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
        <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Available Stock</h4>
                            <!-- <a href="#" id="new-item-btn" class="btn btn-primary btn-lg">New Item</a> -->
                        </div>
                        <div class="card-body">
                            <div id="item-list">
                                <div class="table-responsive">
                                    <table id="item-list-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <?php if(empty($items)): echo 'No items created in the inventory. Click \'Create Item\' to create a new item'; ?>
                                                <?php else: ?>
                                                <th>Item Id</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Subategory</th>
                                                <th>Make</th>
                                                <th>Model</th>
                                                <th>Brand</th>
                                                <th>Quantity</th>
                                                <th>Reorder Level</th>
                                                <th>Supplier</th>
                                                <!-- <th>&nbsp;</th> -->
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($items as $i): ?>
                                            <tr <?= ($i->getReorderLevel() >= $i->getQuantity()) ? 'class="low"' : '' ?> id="<?= $i->getItemId(); ?>">
                                                <td><?= $i->getItemId(); ?></td>
                                                <td><?= $i->getName(); ?></td>
                                                <td><?= $i->getCategory()->getName(); ?></td>
                                                <td><?= $i->getSubcategory()->getSubcategoryName(); ?></td>
                                                <td><?= $i->getMake(); ?></td>
                                                <td><?= $i->getModel(); ?></td>
                                                <td><?= $i->getBrand(); ?></td>
                                                <td><?= $i->getQuantity(); ?></td>
                                                <td><?= $i->getReorderLevel(); ?></td>
                                                <td><?= $i->getSupplier()->getCompanyName(); ?></td>
                                                <!-- <td><a data-entity-id="#" class="edit-item" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Item Details"></i></a></td> -->
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
    <script src="<?= url_for('/assets/js/custom/list-stock.js'); ?>"></script>
</body>
</html>
