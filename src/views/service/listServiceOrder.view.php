<?php require_once(COMMON_VIEWS . 'header.php'); ?>
<body>
    <style>
 
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php 
            $breadcrumbMarkUp = breadcrumbs(['Service Orders' => '/service'], 'Service Orders');
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="service"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
        <div id="content">
        <div class="container">
            <div class="row">
                <!-- <div class="col-md-9 mx-auto">
                <nav class="nav nav-pills mb-5 justify-content-center">
                <a class="nav-link active" href="#">Service Order</a>
                <a class="nav-link" href="#">Service Types</a>
                <a class="nav-link" href="#">Link</a>
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </nav> -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Service Order</h4>
                            <a href="<?php echo url_for('#'); ?>" class="btn btn-primary btn-lg">New</a>
                        </div>
                        <div class="card-body">

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
            <h5 class="modal-title" id="exampleModalCenterTitle">Booking Details</h5>
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
        function showModal() {
            modal.modal({
                show: true,
            });
            modal.on('hide.bs.modal', function (e) {
                console.log('hiding modal');
            });
        }


        let modal = $('#exampleModalCenter');
        let editBooking = document.querySelectorAll('.edit_booking');
        editBooking.forEach(b => b.addEventListener('click', showModal));
    </script>
</body>
</html>
