<?php
  $title = "Report - Employee List - SBWMS";
  require_once(COMMON_VIEWS . 'header.php');
?>
<body>
  <style>
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
            $breadcrumbMarkUp = breadcrumbs(['Report' => '#', 'Employee' => '#'], 'Employee');
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
                        <h4 class="card-title">Employee List</h4>
                      </div>
                      <div class="card-body">
                      <div class="table-resposive">
                        <table id="employee-list" class="table table-hover">
                            <thead>
                              <tr>
                                <th>Employee Id</th>
                                <th>First Name</th>
                                <th>Job Count</th>
                                <!-- <th>&nbsp;</th> -->
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($employees as $e): ?>
                              <tr id="<?= $e->getId(); ?>">
                                <td><?= $e->getId(); ?></td>
                                <td><?= $e->getFullName(); ?></td>
                                <td><?= $e->getJobCount(); ?></td>
                              </tr>
                              <?php endforeach; ?>
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

<?php require_once(COMMON_VIEWS . 'footer.php'); ?>
<script>
    const tableOptions = {
    paging: false,
    searching: false,
    order: [[0, 'desc']],
    dom: 'Bfrtip',
    buttons: [
            'print', 'pdf'
        ],
    // columnDefs: [
    //     { orderable: false, targets: [3] },
    // ],
};

const table = $('#employee-list').DataTable(tableOptions);
</script>
</body>
</html>
