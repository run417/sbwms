<?php
    $title = "New User - SBWMS";
    require_once(COMMON_VIEWS . 'header.php');
?>
<body>
    <style>
        .custom-checkbox {
            padding-top: 3px;
            padding-bottom: 3px;
        }
        .form-section-heading {
            background-color: #529fff26;
            padding-bottom: 3px;
            padding-top: 3px;
            margin-left: -15px;
            margin-right: -15px;
            margin-bottom: 15px;
            box-shadow: 1px 2px 2px #eeeeee;
        }
        h5 {
            margin-left: 15px;
            margin-bottom: 0px;
        }
        .profile-invalid {
            border-color: hsl(354, 70%, 54%) !important;
            background-color: hsl(354, 70%, 97%);
        }
        .profile-valid {
            border-color: hsl(134, 61%, 41%) !important;
            background-color: hsl(134, 61%, 97%);
        }
    </style>
    <div class="wrapper">

        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(
                [
                    'System' => '#system',
                    'User' => '/user',
                    'New' => '/user/new',
                ], 'New');
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
                  <div class="col-md-6 mx-auto">
                    <div class="card">
                      <div class="card-header">
                        <div class="row no-gutters">
                            <div class="col-md-auto mr-auto">
                                <h4 class="card-title">Create New User</h4>
                            </div>
                            <div class="col-md-auto">

                            </div>
                        </div>

                      </div> <!-- </card-header> -->
                      <div class="card-body">

                        <!-- START FORM -->
                        <form id="new_user">
                            <div class="form-group">
                                <label for="user-role">User Role</label>
                                <select id="user-role" name="userRole" class="custom-select">
                                    <option value="">--- Select User Role ---</option>
                                    <option value="admin">Admin</option>
                                    <option value="supervisor">Service Supervisor</option>
                                    <option value="technician">Technician</option>
                                    <option value="sales">Sales Assistant</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="profileId">Profile</label>
                                    <style>
                                        #selected-profile {
                                            border: 1px solid blue;
                                            border-radius: 5px;
                                            padding: 5px;
                                            width: 100%;
                                            /* height: 10px; */
                                        }
                                    </style>
                                <div id="profile" class="d-flex">
                                    <span id="selected-profile" class="mr-1">Click 'Find' to select a user profile</span>
                                    <button id="find-profile" class="btn btn-outline-primary mr-1 .ignore">Find</button>
                                    <button id="clear-profile" class="btn btn-outline-danger .ignore">X</button>
                                </div>
                                <input id="profileId" name="profileId" type="hidden">
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" name="username" type="text" class="form-control">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input id="password" name="password" type="password" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input id="confirm-password" name="confirmPassword" type="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="user-status">User Status</label>
                                    <select id="user-status" name="status" class="custom-select">
                                        <option value="">--- Select Status ---</option>
                                        <option value="active">Active</option>
                                        <option value="suspended">Suspended</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer form-group">
                                <button id="user-submit"  class="btn btn-block btn-primary">Create New User</button>
                            </div> <!-- </.card-footer> -->
                        </form>
                        <!-- END FORM -->

                      </div> <!-- </card-body> -->

                    </div> <!-- </card> -->
                  </div> <!-- </col-md> -->
                </div> <!-- </row> -->
            </div> <!-- </container> -->
            </div> <!-- </content> -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->
    <!-- START USER PROFILE MODAL -->
    <div class="modal fade" id="findProfileModal" tabindex="-1" role="dialog" aria-labelledby="findProfileModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Find Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <!-- START TABLE -->
            <div id="profile-table-div">

            </div>
            <!-- END TABLE -->
            </div>
            </div>
            <!-- /modal-content -->
        </div> <!-- </modal-dialog> -->
    </div>
    <!-- END USER PROFILE MODAL -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/user.js'); ?>"></script>
</body>
</html>
