<?php 
require_once(COMMON_VIEWS . 'header.php');

?>
<body>
    <style>
        .box {
            border: 1px solid black;
            min-height: 240px;
            padding: 10px;
        }
        .vehicle {
            border: 1px solid black;
            min-height: 240px;
            padding: 10px;
        }
        .online-profile {
            border: 1px solid black;
            min-height: 240px;
            padding: 10px;
        }
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php 
            $e = $employee;
            $breadcrumbMarkUp = breadcrumbs(['Employee' => '/employee', 'View' => '#', $e->getEmployeeId() => '#'], '$e->getEmployeeId()');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="employee"></span>
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
                            <h4 class="card-title">Employee Details</h4>
                            <!-- <a href="<?= url_for('#'); ?>" class="btn btn-primary btn-lg">button</a> -->
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-1">
                                <div id="personal" class="mr-1 box">
                                    <h5>Personal</h4>
                                    <p>
                                        <?= $e->getEmployeeId(); ?>
                                    </p>
                                    <p>
                                        <?= $e->getFullName(); ?>
                                    </p>
                                    <p>
                                        <?= $e->getFormattedRole(); ?>
                                    </p>
                                    <p>
                                        <?= $e->getDateJoined(); ?>
                                    </p>
                                </div>
                                <div class="flex-grow-1 box">
                                    <h5>Vehicle</h5>
                                </div>
                            </div>
                            <div class="box">
                                <h5>Online Profile</h5>
                            </div>
                        </div>
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
    <script>

    </script>
</body>
</html>
