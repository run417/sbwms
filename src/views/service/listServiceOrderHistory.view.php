<?php
  $title = "Service Order History";
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
            $breadcrumbMarkUp = breadcrumbs(['Service Order' => '#', 'Service Order History' => '#'], 'Service Order History');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="service-order"></span>
        <span id="sub_menu" data-submenu="servicehistory"></span>
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
                        <h4 class="card-title">Service Order History List</h4>
                        <!-- <a href="#" id="new_booking" class="btn btn-primary btn-lg">Book Service</a> -->
                      </div>
                      <div class="card-body">
                      <div class="table-responsive">
                        <table id="service-order-history-table" class="table table-hover">
                            <thead>
                              <th>Service Order Id</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th>View</th>
                            </thead>
                            <tbody>
                              <?php foreach ($serviceOrders as $s): ?>
                                  <tr id="<?= $s->getId(); ?>">
                                      <td><?= $s->getId(); ?></td>
                                      <td><?= $s->getBooking()->getStartDateTime()->format('Y-m-d'); ?></td>
                                      <td><?= $s->getStatus(); ?></td>
                                      <td><a class="view-service-order" href="#"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="view-service-order"></i></a></td>
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

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/service-order/service-order-history.js') ?>"></script>
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
