<?php
    $title = 'Bay List';
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
            $breadcrumbMarkUp = breadcrumbs(['Service' => '#', 'Bays' => '#'], 'Bays');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="service"></span>
        <span id="sub_menu" data-submenu="bay"></span>
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
                            <h4 class="card-title">Bay List</h4>
                            <a href="<?= url_for('/bay/new'); ?>" id="new-bay-btn" class="btn btn-primary btn-lg">New Bay</a>
                        </div>
                        <div class="card-body">
                            <div id="bay-list">
                                <div class="table-responsive">
                                    <table id="bay-list-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <?php if(empty($bays)): echo 'No Bay details in the system. Click \'New Bay\' to add a new bay'; ?>
                                                <?php else: ?>
                                                <th>Bay Id</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>&nbsp;</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bays as $b): ?>
                                            <tr id="<?= $b->getBayId(); ?>">
                                                <td><?= $b->getBayId(); ?></td>
                                                <td><?= $b->getBayType(); ?></td>
                                                <td><?= $b->getBayStatus(); ?></td>
                                                <td><a data-entity-id="<?= $b->getBayId(); ?>" class="edit-bay" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Bay Details"></i></a></td>
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

    <!-- START CREATE BAY MODAL -->
    <div class="modal fade" id="new-bay-modal" tabindex="-1" role="dialog" aria-labelledby="newBayModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Bay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <!-- START FORM -->
            <form id="new-bay-form">
                <div class="form-group">
                    <label for="bay-type">Bay Type</label>
                    <input id="bay-type" name="bayType" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="bay-status">Bay Status</label>
                    <select id="bay-status" name="bayStatus" class="custom-select">
                        <option value="">--- Select Bay Status ---</option>
                        <option value="free">Free</option>
                        <option value="occupied">Occupied</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="form-submit" type="submit" class="btn btn-primary">Add Bay</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END CREATE BAY MODAL -->

    <!-- START EDIT BAY MODAL -->
    <div class="modal fade" id="edit-bay-modal" tabindex="-1" role="dialog" aria-labelledby="editBayModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Bay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <!-- START FORM -->
            <form id="edit-bay-form">
                <div id="form-data">
                    <div class="form-group">
                        <label for="edit-bayId">Bay Id</label>
                        <input id="edit-bayId" name="bayId" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit-bay-type">Bay Type</label>
                        <input id="edit-bay-type" name="bayType" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-bay-status">Bay Status</label>
                        <select id="edit-bay-status" name="bayStatus" class="custom-select">
                            <option value="">--- Select Bay Status ---</option>
                            <option value="free">Free</option>
                            <option value="occupied">Occupied</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="edit-form-submit" type="submit" class="btn btn-primary">Update Bay</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END EDIT BAY MODAL -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/bay.js'); ?>"></script>
</body>
</html>
