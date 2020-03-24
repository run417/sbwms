<?php
  $title = "Report - Customer List - SBWMS";
  require_once(COMMON_VIEWS . 'header.php');
?>
<body>
  <style>
    img {
        border-bottom: 1px solid black;
    }
    table {
        table-layout: fixed;
        width: 80%;
        border-collapse: collapse;
        /* border: 3px solid purple; */
    }

    thead th {
        border-bottom: 1px solid hsl(204, 100%, 80%);
        text-transform: uppercase;
        font-size: 0.88rem;
        color: hsl(0, 0%, 25%);
    }

    tfoot td, tfoot th {
        border-top: 1px solid hsl(204, 100%, 80%) !important;
    }

    thead {
        padding-top: 10px;
        margin-bottom: 3px;
    }

    thead th:nth-child(1) {
        width: 10%;
    }

    thead th:nth-child(2) {
        width: 20%;
    }

    thead th:nth-child(3) {
        width: 15%;
    }

    thead th:nth-child(4) {
        width: 10%;
    }
    /* tbody td:nth-child(4) {
        text-align: center;
    } */

    th, td {
        padding: 9px;
    }
    tbody td {
        border-bottom: 1px solid hsl(204, 50%, 90%);
        border-left: 1px solid hsl(204, 50%, 90%);
    }
    tbody td:nth-child(1) {
        border-left: unset;
    }
    tbody > tr:last-child td {
        border-bottom: unset;
    }
    .updated {
      background-color: hsla(125, 68%, 90%, 1);
    }
    .modal-header {
        background-color: hsl(203, 92%, 88%);
        border-bottom: none;
        /* border-radius: 15px 15px 0px 0px; */
        min-height: 63px;
    }
    .modal-content {
        border-radius: 1.2rem;
        /* border: 2px solid hsl(0, 0%, 0%); */
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
            $breadcrumbMarkUp = breadcrumbs(['Report' => '#', 'Customer' => '#'], 'Customer');
            require_once(COMMON_VIEWS . 'sidebar.php');
        ?>
        <span id="active_menu" data-menu="report"></span>
        <span id="active_submenu" data-submenu="empreport"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
            <div id="content">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12 mx-auto">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Top Customer List</h4>
                      </div>
                      <div class="card-body">
                      <div class="">
                        <table id="top-customer-list" class="mx-auto">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Telephone</th>
                                <th>Service Count</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($customers as $c): ?>
                              <tr id="<?= $c['customer_id']; ?>">
                                <td><?= $c['customer_id']; ?></td>
                                <td><?= $c['name']; ?></td>
                                <td><?= $c['telephone']; ?></td>
                                <td><?= $c['services']; ?></td>
                              </tr>
                              <?php endforeach; ?>
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <th scope="row">Total albums</th>
                                    <td>77</td>
                                </tr>
                            </tfoot> -->
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


<?php require_once(COMMON_VIEWS . 'footer.php'); ?>
<script>
    const tableOptions = {
    paging: false,
    searching: false,
    order: [[0, 'desc']],
    dom: 'Bfrtip',
    buttons: [
            {
                extend: 'print',
                footer: true,
                messageTop: '<img src="<?= url_for("assets/img/v2sriyani-motors-header.png"); ?>"><br><h1 class="text-center mt-2 mb-4">Top Customers 2019</h1>',
                title: 'Top Customers 2019',
            }
        ],
    // columnDefs: [
    //     { orderable: false, targets: [3] },
    // ],
};

const table = $('#top-customer-list').DataTable(tableOptions);
</script>
</body>
</html>
