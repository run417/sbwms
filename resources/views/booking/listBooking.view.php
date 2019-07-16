<?php require_once(COMMON_VIEWS . 'header.php'); ?>
<body>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $moduleName = 'Booking';
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="booking"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
            <div id="content">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-9 mx-auto">
                    <div class="card">
                      <div class="card-header">
                        <div class="row no-gutters">
                            <div class="col-sm-auto mr-auto">
                                <h4 class="card-title">Booking List</h4>
                            </div>
                            <div class="col-sm-auto">
                                <a href="<?php echo url_for('/booking/new.php'); ?>" class="btn btn-primary btn-lg">New Booking</a>
                            </div>
                        </div>

                      </div>
                      <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                              <th>Booking Id</th>
                              <th>Customer</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Start Time
                              <th>&nbsp;</th>
                              <th>&nbsp;</th>
                              <th>&nbsp;</th>
                            </thead>
                            <tbody>
                              <tr>
                                <td>B0001</td>
                                <td>Mr. Chathuranga</td>
                                <td><span style="background-color: #74c38a6e; border: #28a745 solid 2px; padding: 3px; border-radius: 9px;">Confirmed</span></td>
                                <td>02-07-2019</td>
                                <td>11:00 AM</td>
                                <td><a class="edit_booking" href="#"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="Details"></i></a></td>
                                <td><a href="#"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a></td>
                              </tr>
                              <tr>
                                <td>B0002</td>
                                <td>Ms. Weerasinghe</td>
                                <td>Late</td>
                                <td>02-07-2019</td>
                                <td>03:00 PM</td>
                                <td><a class="edit_booking" href="#"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="Details"></i></a></td>
                                <td><a href="#"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a></td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                      </div>
                      <!-- card-body end -->
                    </div>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
            </div>
            <!-- end content -->
        </div>
        <!-- end content-wrapper -->
    </div>
    <!-- end wrapper -->

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
                console.log("hiding modal");
            })
        }

        let modal = $('#exampleModalCenter');
        let editBooking = document.querySelectorAll('.edit_booking');
        editBooking.forEach(b => b.addEventListener('click', showModal));
    </script>
</body>
</html>
