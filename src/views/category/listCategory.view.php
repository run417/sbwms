<?php
    $title = 'Item Category List';
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
        <span id="sub_menu" data-submenu="category"></span>
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
                            <h4 class="card-title">Category List</h4>
                            <a href="#" id="new-category-btn" class="btn btn-primary btn-lg">New Category</a>
                        </div>
                        <div class="card-body">
                            <div id="category-list">
                                <div class="table-responsive">
                                    <table id="category-list-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <?php if(empty($categories)): echo 'No categories created in the inventory. Click \'Create Category\' to create a new category'; ?>
                                                <?php else: ?>
                                                <th>Category Id</th>
                                                <th>Name</th>
                                                <th>&nbsp;</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categories as $c): ?>
                                            <tr id="<?= $c->getCategoryId(); ?>">
                                                <td><?= $c->getCategoryId(); ?></td>
                                                <td><?= $c->getName(); ?></td>
                                                <td><a data-entity-id="<?= $c->getCategoryId(); ?>" class="edit-category" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Category Details"></i></a></td>
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

    <!-- START CREATE CATEGORY MODAL -->
    <div class="modal fade" id="new-category-modal" role="dialog" aria-labelledby="newCategoryModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <!-- START FORM -->
            <form id="new-category-form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button id="form-submit" type="submit" class="btn btn-primary">Create Category</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END CREATE CATEGORY MODAL -->

    <!-- START EDIT CATEGORY MODAL -->
    <div class="modal fade" id="edit-category-modal" role="dialog" aria-labelledby="editCategoryModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <!-- START FORM -->
            <form id="edit-category-form">
                <div id="form-data">
                    <div class="form-group">
                        <label for="edit-categoryId">Category Id</label>
                        <input id="edit-categoryId" name="categoryId" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit-name">Name</label>
                        <input id="edit-name" name="name" type="text" class="form-control">
                    </div>
                </div> <!-- </#form-data> -->
            </div>
            <div class="modal-footer">
                <button id="edit-form-submit" type="submit" class="btn btn-primary">Update Category</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END EDIT CATEGORY MODAL -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/category.js'); ?>"></script>
</body>
</html>
