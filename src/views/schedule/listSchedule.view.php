<?php
  $title = "Scheduled Services";
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
            $breadcrumbMarkUp = breadcrumbs(['Schedule' => '#'], 'Schedule');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="schedule"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
            <div id="content">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-9 mx-auto">
                      <style>
                          #filter {
                            border: 0px solid rgba(0, 0, 0, 0.125);
                            box-shadow: 0px 0px 13px 0px #ced4da;
                            border-radius: 15px;
                            padding: 10px;
                            margin-bottom: 20px;
                          }
                          #filter label {
                              font-size: 0.9rem;
                              color: #165d99;
                              /* text-transform: uppercase; */
                          }
                          /* #filter button {
                              margin-right: auto;
                          } */
                      </style>
                    <div id="filter">
                        <div class="d-flex justify-content-around">
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <div class="pr-4">
                                        <label for="date-filter">Filter By Date</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input name="all-dates" id="all-dates" type="checkbox" checked class="custom-control-input" autocomplete="off">
                                        <label for="all-dates" class="custom-control-label">All Dates</label>
                                    </div>
                                </div>
                                <input id="date-filter" name="date" type="text" placeholder="yyyy-mm-dd" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="employee-role">Filter By Employee</label>
                                <div>
                                    <select id="employee" name="employee" class="custom-select">
                                        <option value="all">All</option>
                                        <?php foreach ($employees as $e): ?>
                                            <option value="<?= $e['employee_id']; ?>"><?= $e['first_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button id="filter-btn" class="btn btn-outline-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="card animated fadeIn">
                      <div class="card-header">
                        <h4 class="card-title">Scheduled Services</h4>
                        <!-- <a href="#" id="new_booking" class="btn btn-primary btn-lg">Book Service</a> -->
                      </div>
                      <div class="card-body">
                      <div class="table-responsive">
                        <div id="schedule-list">
                            <table id="schedule-table" class="table table-hover">
                                <thead>
                                  <th>Service Order Id</th>
                                  <th>Booking Id</th>
                                  <th>Employee</th>
                                  <th>Date</th>
                                  <th>Start Time</th>
                                  <th>Booking</th>
                                </thead>
                                <tbody>
                                  <?php foreach ($serviceOrders as $s): ?>
                                      <tr id="<?= $s->getId(); ?>">
                                          <td><?= $s->getId(); ?></td>
                                          <td><?= $s->getBooking()->getId(); ?></td>
                                          <td><?= $s->getBooking()->getEmployee()->getFirstName(); ?></td>
                                          <td><?= $s->getBooking()->getStartDateTime()->format('Y-m-d'); ?></td>
                                          <td><?= $s->getBooking()->getStartDateTime()->format('H:i:s'); ?></td>
                                          <td><a class="viewBooking" href="<?= url_for('/booking/view?id=') . $s->getBooking()->getBookingId(); ?>"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="View Booking"></i></a></td>
                                      </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
    <script src="<?= url_for('/assets/js/custom/schedule/list-schedule.js') ?>"></script>
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
