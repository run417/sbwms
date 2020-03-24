<?php

    require_once COMMON_VIEWS . 'header.php';
?>
<body>
    <style>

    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(
                [
                    'System' => '#system',
                    'User' => '/user'
                ], 'User');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="system"></span>
        <span id="sub_menu" data-submenu="user"></span>
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
                            <h4 class="card-title">Users</h4>
                            <a href="<?php echo url_for('/user/new'); ?>" class="btn btn-primary btn-lg">Create User</a>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                <table id="user-list-table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <?php if(empty($users)): echo 'No users registered in the system. Click \'Create User\' to register a new user'; ?>
                                            <?php else: ?>
                                            <th>User Id</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Account Type</th>
                                            <th>User Role</th>
                                            <th>Status</th>
                                            <th>&nbsp;</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $u): ?>
                                        <tr id="<?= $u->getUserId(); ?>">
                                            <td><?= $u->getUserId(); ?></td>
                                            <td><?= $u->getUsername(); ?></td>
                                            <td><?= $u->getProfile()->getEmail(); ?></td>
                                            <td><?= $u->getAccountType(); ?></td>
                                            <td><?= $u->getUserRole(); ?></td>
                                            <td><?= $u->getStatus(); ?></td>
                                            <td><a href="<?= url_for('/user/view?id=') . $u->getUserId(); ?>"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="View User Details"></i></a></td>
                                            <!-- <td></td> -->
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">User Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
        <!-- /modal-content -->
    </div>
    </div>
    <!-- End Modal -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>
        const userListTable = $('#user-list-table');
        userListTable.DataTable({
            paging: true,
            searching: true,
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: [6] },
            ],
        });

    </script>
</body>
</html>
