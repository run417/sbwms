<?php
    $title = "New Service Type - SBWMS";
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
    </style>
    <div class="wrapper">

        <!-- sidebar start -->
        <?php 
            $breadcrumbMarkUp = breadcrumbs(
                [
                    'Service' => '#',
                    'Type' => '/service/type',
                    'New' => '/service/type/new',
                ], 'New');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="System"></span>
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
                                <h4 class="card-title">Create New Service Type</h4>
                            </div>
                            <div class="col-md-auto">

                            </div>
                        </div>

                      </div> <!-- </card-header> -->
                      <div class="card-body">
                        <div class="text-muted mb-2" >All fields are required</div>
                        <!-- START FORM -->
                        <form id="new_service_type">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="service_type">Service Name</label> 
                                    <input id="service_type" name="name" type="text" required="required" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                <label for="duration">Estimated Duration</label> 
                                <div>
                                    <select id="duration" name="duration" class="custom-select">
                                        <option value="">Please Select Service Duration</option>
                                        <option value="1H0M">1 hr</option>
                                        <option value="2H0M">2 hr</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="card-footer form-group">
                        
                                <button name="submit" type="submit" class="btn btn-block btn-primary">Create Service Type</button>

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
