<?php
    $title = "New Service Centre Time - SBWMS";
    require_once(COMMON_VIEWS . 'header.php'); 
?>
<body>
    <style>
        .form-info {
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 0.88rem;
            color: hsl(208, 7%, 46%);
            text-transform: uppercase;
            font-size: 0.8rem;
        }
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
    </style>
    <div class="wrapper">

        <!-- sidebar start -->
        <?php 
            $breadcrumbMarkUp = breadcrumbs(
                [
                    'Service Options' => '#',
                    'Centre Time' => '#',
                    'Set' => '#',
                ], 'Set');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="service"></span>
        <span id="active_submenu" data-submenu="centretime"></span>
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
                                <h4 class="card-title">Centre Operating Hours</h4>
                            </div>
                        </div>
                      </div> <!-- </card-header> -->
                      <div class="card-body">
                      <div class="form-info d-flex justify-content-end">All fields are required</div>
                        <!-- START FORM -->
                        <form id="centre-operating-hours">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="opening">Opening Time</label> 
                                    <input id="opening" name="openingTime" type="text" required="required" class="form-control">
                                </div>
                                <div class="form-group col-md">
                                <label for="closing">Closing Time</label>
                                <input id="closing" name="closingTime" type="text" required="required" class="form-control">
                                <div>
                                </div>
                            </div>
                            </div>
                            <div class="card-footer form-group">
                                <button name="submit" type="submit" class="btn btn-block btn-primary">Set Operating Hours</button>
                            </div> <!-- </card-footer> -->
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

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>
    </script>
</body>
</html>