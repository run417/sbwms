<?php
    $title = 'Service Type - SBWMS';
    require_once(COMMON_VIEWS . 'header.php');
?>
<body>
    <style>
        .updated {
            background-color: hsla(125, 68%, 90%, 1);
        }
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(
                [
                    'Service' => '#',
                    'Type' => '/service/types',
                ], 'Type');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="service"></span>
        <span id="sub_menu" data-submenu="service_type"></span>
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
                            <h4 class="card-title">Service Type</h4>
                            <a id="new-service-type-btn" href="#" class="btn btn-primary btn-lg">New Service Type</a>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="service-type-list-table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Service Type Id</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Duration</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($serviceTypes as $st): ?>
                                    <tr id="<?= $st->getServiceTypeId(); ?>">
                                        <td><?= $st->getServiceTypeId(); ?></td>
                                        <td><?= $st->getName(); ?></td>
                                        <td><?= $st->getStatus(); ?></td>
                                        <td><?= $st->getDuration()->format('%H hours and %I mins.'); ?></td>
                                        <td><a data-entity-id="<?= $st->getId(); ?>" class="edit-service-type" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Service Type"></i></a></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <div class="card-footer"></div>
                    </div> <!-- </card> -->

                </div> <!-- <col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->

    <!-- START CREATE SERVICE-TYPE MODAL -->
    <div class="modal fade" id="new-service-type-modal" role="dialog" aria-labelledby="newServiceTypeModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Service Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
        <!-- START FORM -->
        <form id="new-service-type-form">
            <div class="form-group">
                <label for="duration">Set Service Duration</label>
                <div id="duration" class="d-flex">
                    <select id="hours-duration" name="hours" class="custom-select mr-2">
                        <option value="">Select hours</option>
                        <?php for ($i = 0; $i <= 24; $i += 1): ?>
                        <option value="<?= $i . 'H'; ?>"><?= $i . ' hours'; ?></option>
                        <?php endfor; ?>
                    </select>
                    <select id="minutes-duration" name="minutes" class="custom-select">
                        <option value="">Select minutes</option>
                        <?php for ($i = 0; $i <= 60; $i += 15): ?>
                        <option value="<?= $i . 'M'; ?>"><?= $i . ' minutes'; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="name">Service Type Name</label>
                <input id="name" name="name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="service-status">Service Status</label>
                <select id="service-status" name="status" class="custom-select">
                    <option value="">--- Set Service Status ---</option>
                    <option value="operational">Operational</option>
                    <option value="discontinued">Discontinued</option>
                </select>
            </div>
        </div> <!-- </.modal-body> -->

            <div class="modal-footer">
                <button id="form-submit" type="submit" class="btn btn-primary">Create Service Type</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END CREATE SERVICE-TYPE MODAL -->

    <!-- START EDIT SERVICE-TYPE MODAL -->
    <div class="modal fade" id="edit-service-type-modal" role="dialog" aria-labelledby="editServiceTypeModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Service Type Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
        <!-- START FORM -->
        <form id="edit-service-type-form">
            <div class="form-group">
                <label for="service-type-id">Service Type Id</label>
                <input id="service-type-id" name="serviceTypeId" type="text" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="edit-name">Service Type Name</label>
                <input id="edit-name" name="name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="duration">Set Service Duration</label>
                <div id="duration" class="d-flex">
                    <select id="edit-hours-duration" name="hours" class="custom-select mr-2">
                        <option value="">Select hours</option>
                        <?php for ($i = 0; $i <= 24; $i += 1): ?>
                        <option value="<?= $i . 'H'; ?>"><?= $i . ' hours'; ?></option>
                        <?php endfor; ?>
                    </select>
                    <select id="edit-minutes-duration" name="minutes" class="custom-select">
                        <option value="">Select minutes</option>
                        <?php for ($i = 0; $i <= 60; $i += 15): ?>
                        <option value="<?= $i . 'M'; ?>"><?= $i . ' minutes'; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="edit-service-status">Service Status</label>
                <select id="edit-service-status" name="status" class="custom-select">
                    <option value="">--- Set Service Status ---</option>
                    <option value="operational">Operational</option>
                    <option value="discontinued">Discontinued</option>
                </select>
            </div>
        </div> <!-- </.modal-body> -->

            <div class="modal-footer">
                <button id="edit-form-submit" type="submit" class="btn btn-primary">Update Service Type</button>
            </form>
            <!-- END FORM -->
            </div> <!-- </.modal-footer> -->
            </div> <!-- </.modal-content> -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END CREATE SERVICE-TYPE MODAL -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/service-type/service-type.js') ?>"></script>
</body>
</html>
