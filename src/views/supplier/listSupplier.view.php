<?php
    $title = 'Supplier List';
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
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'Suppliers' => '#'], 'Suppliers');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="inventory"></span>
        <span id="sub_menu" data-submenu="supplier"></span>
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
                            <h4 class="card-title">Supplier List</h4>
                            <a href="<?= url_for('/supplier/new'); ?>" id="new-supplier-btn" class="btn btn-primary btn-lg">New Supplier</a>
                        </div>
                        <div class="card-body">
                            <div id="supplier-list">
                                <div class="table-responsive">
                                    <table id="supplier-list-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <?php if(empty($suppliers)): echo 'No suppliers details in the system. Click \'New Supplier\' to add a new supplier'; ?>
                                                <?php else: ?>
                                                <th>Supplier Id</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Telephone</th>
                                                <th>Email</th>
                                                <th>&nbsp;</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($suppliers as $s): ?>
                                            <tr id="<?= $s->getSupplierId(); ?>">
                                                <td><?= $s->getSupplierId(); ?></td>
                                                <td><?= $s->getSupplierName(); ?></td>
                                                <td><?= $s->getCompanyName(); ?></td>
                                                <td><?= $s->getTelephone(); ?></td>
                                                <td><?= $s->getEmail(); ?></td>
                                                <td><a data-entity-id="<?= $s->getSupplierId(); ?>" class="edit-supplier" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Supplier Details"></i></a></td>
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

    <!-- START CREATE SUPPLIER MODAL -->
    <div class="modal fade" id="new-supplier-modal" tabindex="-1" role="dialog" aria-labelledby="newSupplierModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <!-- START FORM -->
            <form id="new-supplier-form">
                <div class="form-group">
                    <label for="supplier-name">Supplier Name</label>
                    <input id="supplier-name" name="supplierName" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="company-name">Company Name</label>
                    <input id="company-name" name="companyName" type="text" class="form-control">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="supplier-telephone">Telephone</label>
                        <input id="supplier-telephone" name="telephone" type="tel" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="supplier-email">Email</label>
                        <input id="supplier-email" name="email" type="email" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="form-submit" type="submit" class="btn btn-primary">Add Supplier</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END CREATE SUPPLIER MODAL -->

    <!-- START EDIT SUPPLIER MODAL -->
    <div class="modal fade" id="edit-supplier-modal" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <!-- START FORM -->
            <form id="edit-supplier-form">
                <div id="form-data">
                    <div class="form-group">
                        <label for="edit-supplierId">Supplier Id</label>
                        <input id="edit-supplierId" name="supplierId" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit-supplier-name">Supplier Name</label>
                        <input id="edit-supplier-name" name="supplierName" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-company-name">Company Name</label>
                        <input id="edit-company-name" name="companyName" type="text" class="form-control">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edit-supplier-telephone">Telephone</label>
                            <input id="edit-supplier-telephone" name="telephone" type="tel" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit-supplier-email">Email</label>
                            <input id="edit-supplier-email" name="email" type="email" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="edit-form-submit" type="submit" class="btn btn-primary">Update Supplier</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END EDIT SUPPLIER MODAL -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/supplier.js'); ?>"></script>
</body>
</html>
