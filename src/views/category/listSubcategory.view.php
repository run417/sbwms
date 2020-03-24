<?php
    $title = 'Item Subcategory List';
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
            $breadcrumbMarkUp = breadcrumbs(['Inventory' => '#', 'Categories' => '#'], 'Categories');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="inventory"></span>
        <span id="sub_menu" data-submenu="subcategory"></span>
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
                            <h4 class="card-title">Subcategory List</h4>
                            <a href="#" id="new-subcategory-btn" class="btn btn-primary btn-lg">New Subcategory</a>
                        </div>
                        <div class="card-body">
                            <div id="subcategory-list">
                                <div class="table-responsive">
                                    <table id="subcategory-list-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <?php if(empty($subcategories)): echo 'No subcategories created in the inventory. Click \'Create Category\' to create a new subcategory'; ?>
                                                <?php else: ?>
                                                <th>Subcategory Id</th>
                                                <th>Subcategory Name</th>
                                                <th>Category</th>
                                                <th>&nbsp;</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($subcategories as $s): ?>
                                            <tr id="<?= $s->getSubcategoryId(); ?>">
                                                <td><?= $s->getSubcategoryId(); ?></td>
                                                <td><?= $s->getSubcategoryName(); ?></td>
                                                <td><?= $s->getCategory()->getName(); ?></td>
                                                <td><a data-entity-id="<?= $s->getSubcategoryId(); ?>" class="edit-subcategory" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Subcategory Details"></i></a></td>
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

    <!-- START CREATE SUBCATEGORY MODAL -->
    <div class="modal fade" id="new-subcategory-modal" role="dialog" aria-labelledby="newSubcategoryModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Subcategory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
        <!-- START FORM -->
        <form id="new-subcategory-form">
            <div class="form-group">
                <label for="category">Select Category</label>
                <select id="category" name="category" class="custom-select">
                    <option value="">Select a category</option>
                    <?php foreach($categories as $c): ?>
                    <option value="<?= $c->getCategoryId(); ?>"><?= $c->getName(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="subcategoryName">Subcategory Name</label>
                <input id="subcategoryName" name="subcategoryName" type="text" class="form-control">
            </div>
        </div> <!-- </.modal-body> -->

            <div class="modal-footer">
                <button id="form-submit" type="submit" class="btn btn-primary">Create Subcategory</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END CREATE SUBCATEGORY MODAL -->

    <!-- START EDIT SUBCATEGORY MODAL -->
    <div class="modal fade" id="edit-subcategory-modal" role="dialog" aria-labelledby="editSubcategoryModalCenterTitle" data-modal-entity-id="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subcategory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <!-- START FORM -->
            <form id="edit-subcategory-form">
                <div id="form-data">
                    <div class="form-group">
                        <label for="edit-subcategoryId">Subcategory Id</label>
                        <input id="edit-subcategoryId" name="subcategoryId" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit-category">Select Category</label>
                        <select id="edit-category" name="category" class="custom-select">
                            <option value="">Select a category</option>
                            <?php foreach($categories as $c): ?>
                            <option value="<?= $c->getCategoryId(); ?>"><?= $c->getName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-subcategoryName">Subcategory Name</label>
                        <input id="edit-subcategoryName" name="subcategoryName" type="text" class="form-control">
                    </div>

                </div> <!-- </#form-data> -->
            </div> <!-- </.modal-body> -->
            <div class="modal-footer d-flex justify-content-between flex-row-reverse">
                <button id="edit-form-submit" type="submit" class="btn btn-primary">Update Subcategory</button>
                <button id="delete" class="btn btn-link">Delete Listing</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END EDIT CATEGORY MODAL -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/subcategory.js'); ?>"></script>
</body>
</html>
