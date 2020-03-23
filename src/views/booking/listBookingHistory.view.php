<?php
  $title = "Booking History - SBWMS";
  require_once(COMMON_VIEWS . 'header.php');

?>
<body>
    <style>
        .updated {
            background-color: hsla(125, 68%, 90%, 1);
        }
        .confirmed {
            width: 10px;
            background-color: #74c38a6e;
            border: #28a745 solid 2px;
            padding: 4px;
            border-radius: 9px;
        }
        .pending {
          width: 100%;
          background-color: hsla(45, 100%, 85%);
          border: hsl(45, 100%, 51%) solid 2px;
          padding: 4px;
          border-radius: 9px;
        }
        .late {

        }
        .cancelled {

        }
    </style>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php
            $breadcrumbMarkUp = breadcrumbs(['Booking' => '/booking', 'Booking History' => '#'], 'Booking History');
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
                    <div class="card animated fadeIn">
                      <div class="card-header">
                        <h4 class="card-title">Booking List</h4>
                        <a href="<?= url_for('/booking/new'); ?>" id="new_booking" class="btn btn-primary btn-lg">Book Service</a>
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
                              <th>View</th>
                            </thead>
                            <tbody>
                              <?php foreach ($bookings as $b): ?>
                                  <tr id="<?= $b->getBookingId(); ?>">
                                      <td><?= $b->getBookingId(); ?></td>
                                      <td><?= $b->getCustomer()->getFullName(); ?></td>
                                      <td><span class="<?= $b->getStatus(); ?>"><?= $b->getStatus(); ?></span></td>
                                      <td><?= $b->getStartDateTime()->format('Y-m-d'); ?></td>
                                      <td><?= $b->getStartDateTime()->format('H:i:s'); ?></td>
                                      <td><a class="edit-booking" href="<?= url_for('/booking/view?id=') . $b->getBookingId(); ?>"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="Details"></i></a></td>
                                  </tr>
                              <?php endforeach; ?>
                            </tbody>
                        </table>
                      </div>
                      </div> <!-- </.card-body> -->
                    </div> <!-- </.card> -->
                  </div> <!-- </.col> -->
                </div> <!-- </.row> -->
            </div> <!-- </.container-fluid> -->
            </div> <!-- </.content> -->
        </div> <!-- </.content-wrapper> -->
    </div> <!-- </.wrapper> -->

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
      function highLightLastModified() {
          if (sessionStorage.lastModifiedId) {
              let rowId = sessionStorage.getItem('lastModifiedId');
              console.log(rowId);
              $(`#${rowId}`).addClass('updated');
              sessionStorage.clear();
          }
      }
      highLightLastModified();
    </script>

</body>
</html>
