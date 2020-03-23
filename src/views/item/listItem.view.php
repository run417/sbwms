<?php
    $title = 'Item List';
    require_once COMMON_VIEWS . 'header.php';
?>
<body>
    <style>
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
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'Items' => '#'], 'Items');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="inventory"></span>
        <span id="sub_menu" data-submenu="item"></span>
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
                            <h4 class="card-title">Item List</h4>
                            <a href="#" id="new-item-btn" class="btn btn-primary btn-lg">New Item</a>
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
                                                <th>&nbsp;</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($items as $i): ?>
                                            <tr id="<?= $i->getItemId(); ?>">
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
                                                <td><a data-entity-id="<?= $i->getItemId(); ?>" class="edit-item" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Item Details"></i></a></td>
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

    <!-- START CREATE ITEM MODAL -->
    <div class="modal fade" id="new-item-modal" role="dialog" aria-labelledby="newItemModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
        <!-- START FORM -->
        <form id="new-item-form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="custom-select">
                        <option value="">Select a category</option>
                        <?php foreach($categories as $c): ?>
                        <option value="<?= $c->getId(); ?>"><?= $c->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="subcategory">Subcategory</label>
                    <div id="subcategory-list">
                        <select id="subcategory" name="subcategory" class="custom-select">
                            <option value="">Select a subcategory</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control">
                </div>
                <div class="form-group col-md-7">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-4">
                    <label for="brand">Brand</label>
                    <input id="brand" name="brand" type="text" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="model">Model</label>
                    <input id="model" name="model" type="text" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="make">Make</label>
                    <input id="make" name="make" type="text" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity</label>
                    <input id="quantity" name="quantity" type="text" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="reorderLevel">Reorder Level</label>
                    <input id="reorderLevel" name="reorderLevel" type="text" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="supplier">Select Supplier</label>
                    <select id="supplier" name="supplier" class="custom-select">
                        <option value="">Select a supplier</option>
                        <?php foreach($suppliers as $sup): ?>
                        <option value="<?= $sup->getId(); ?>"><?= $sup->getCompanyName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div> <!-- </.modal-body> -->

            <div class="modal-footer">
                <button id="form-submit" type="submit" class="btn btn-primary">Create Item</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END CREATE ITEM MODAL -->

    <!-- START EDIT ITEM MODAL -->
    <div class="modal fade" id="edit-item-modal" role="dialog" aria-labelledby="editItemModalCenterTitle" data-modal-entity-id="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <!-- START FORM -->
            <form id="edit-item-form">
                <div id="form-data">
                    <div class="form-group">
                        <label for="edit-itemId">Item Id</label>
                        <input id="edit-itemId" name="itemId" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edit-category">Category</label>
                            <select id="edit-category" name="category" class="custom-select">
                                <option value="">Select a category</option>
                                <?php foreach($categories as $c): ?>
                                <option value="<?= $c->getId(); ?>"><?= $c->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit-subcategory">Subcategory</label>
                            <div id="edit-subcategory-list">
                                <select id="edit-subcategory" name="subcategory" class="custom-select">
                                    <option value="">Select a subcategory</option>
                                    <?php foreach($subcategories as $s): ?>
                                    <option value="<?= $c->getId(); ?>"><?= $c->getName(); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="edit-name">Name</label>
                            <input id="edit-name" name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-7">
                            <label for="edit-description">Description</label>
                            <textarea id="edit-description" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-4">
                            <label for="edit-brand">Brand</label>
                            <input id="edit-brand" name="brand" type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit-model">Model</label>
                            <input id="edit-model" name="model" type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit-make">Make</label>
                            <input id="edit-make" name="make" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit-quantity">Quantity</label>
                            <input id="edit-quantity" name="quantity" type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit-reorderQuantity">Reorder Quantity</label>
                            <input id="edit-reorderQuantity" name="reorderQuantity" type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit-reorderLevel">Reorder Level</label>
                            <input id="edit-reorderLevel" name="reorderLevel" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit-supplier">Select Supplier</label>
                            <select id="edit-supplier" name="supplier" class="custom-select">
                                <option value="">Select a supplier</option>
                                <?php foreach($suppliers as $sup): ?>
                                <option value="<?= $sup->getId(); ?>"><?= $sup->getCompanyName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div> <!-- </#form-data> -->
            </div> <!-- </.modal-body> -->
            <div class="modal-footer d-flex justify-content-between flex-row-reverse">
                <button id="edit-form-submit" type="submit" class="btn btn-primary">Update Item</button>
                <button id="delete" class="btn btn-link">Delete Listing</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END EDIT ITEM MODAL -->

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


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/item.js'); ?>"></script>
</body>
</html>
