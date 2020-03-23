<?php
    $title = 'Centre Options - SBWMS';
    require_once COMMON_VIEWS . 'header.php';
    $days = sbwms\Model\Centre\BusinessHours\BusinessHours::DAYS_OF_WEEK;
    $bh = $businessHours;
    // $booking = $serviceOrder->getBooking();
?>
<body>
    <style>
        .box {
            border: 1px solid hsl(0, 0%, 90%);
            min-height: 90px;
            padding: 6px;
            margin-bottom: 3px;
        }
        .card-section {
            padding-top: 6px;
        }
        .card-section-title {
            /* text-transform: uppercase; */
            font-size: 1.34rem;
            color: hsl(207, 75%, 40%);
            padding-bottom: 6px;
            border-bottom: 1px solid red;
        }
        .card-section:first-of-type {
            padding-top: 0px;
        }
        .card-section-body {
            padding-top: 6px;
        }
        .day-time-header {
            padding: 4px;
            text-align: center;
            padding-bottom: 8px;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        .dth-cell:nth-of-type(2) {
            /* background-color: tomato;
            margin-left: 2px;
            margin-right: 2px; */
        }
        .dth-cell {
            background-color: aquamarine;
            border: 2px solid black;
        }
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(['Centre Options' => '#'], '#');
            require_once COMMON_VIEWS . 'sidebar.php';
        ?>
        <span id="active_menu" data-menu="service"></span>
        <span id="sub_menu" data-submenu="centre"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once COMMON_VIEWS . 'navbar.php'; ?>
            <!-- navbar end -->
        <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Centre Options</h4>
                        </div>
                        <div class="card-body">

                            <div class="card-section">
                                <div class="card-section-header">
                                    <div class="card-section-title">Operating Days and Time</div>
                                </div>
                                <div class="card-section-body">
                                    <div class="form-row day-time-header">
                                        <div class="col-md-2 dth-cell">Day</div>
                                        <div class="col-md-5 ml-1 dth-cell">Opening Time</div>
                                        <div class="col-md ml-1 dth-cell">Closing Time</div>
                                    </div>
                                    <form id="operating-day-time">
                                        <?php foreach($days as $d): ?>
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <div class="custom-control custom-switch">
                                                    <input name="day[<?= $d; ?>]" type="checkbox" class="custom-control-input" id="<?= $d; ?>" <?= ($bh->isWorkingDay($d) ? 'checked' : '') ?>>
                                                    <label class="custom-control-label" for="<?= $d; ?>"><?= ucfirst($d); ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <input name="open[<?= $d; ?>]" type="text" class="form-control" value="<?= ($bh->isWorkingDay($d)) ? $bh->getOpen($d) : '' ?>" <?= ($bh->isWorkingDay($d)) ? '' : ' disabled' ?>>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <input name="close[<?= $d; ?>]" type="text" class="form-control" value="<?= ($bh->isWorkingDay($d)) ? $bh->getClose($d) : '' ?>" <?= ($bh->isWorkingDay($d)) ? '' : ' disabled' ?>>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <div class="custom-control custom-switch">
                                                    <input name="day[default]" type="checkbox" class="custom-control-input" id="default">
                                                    <label class="custom-control-label" for="default">Set Default Time</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input name="open[default]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input name="close[default]" type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-success">Save Changes</button>
                                        </div>
                                    </form>
                                </div>

                            </div> <!-- /card-section -->

                            <div class="card-section">
                                <div class="card-section-header">
                                    <div class="card-section-title">Holidays</div>
                                </div>
                                <div class="card-section-body">

                                </div>
                                
                            </div> <!-- /card-section -->

                        </div>
                        <div class="card-footer d-flex justify-content-between">

                        </div>
                    </div> <!-- </card> -->

                </div> <!-- <col> -->
            </div> <!-- </row> -->
        </div> <!-- </container> -->
        </div> <!-- </content -->
        </div> <!-- </content-wrapper> -->
    </div> <!-- </wrapper> -->


    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/centre-day-time.js'); ?>"></script>
    <script src="<?= url_for('/assets/js/custom/centre-day-time-form.js'); ?>"></script>

    <script>

    </script>
</body>
</html>