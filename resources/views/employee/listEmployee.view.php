<?php require_once(COMMON_VIEWS . 'header.php'); ?>
<body>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php 
            $moduleName = 'Employees';
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="employee"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
            <div id="content">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md mx-auto">
                    <div class="card">
                      <div class="card-header">
                        <div class="row no-gutters">
                            <div class="col-sm-auto mr-auto">
                                <h4 class="card-title">Employee List</h4>
                            </div>
                            <div class="col-sm-auto">
                                <a href="<?php echo url_for('/employee/new.php'); ?>" class="btn btn-primary btn-lg">Create Employee</a>
                            </div>
                        </div>

                      </div>
                      <div class="card-body">
                      <div class="table-resposive">
                        <table class="table table-hover">
                            <thead>
                              <th>Employee Id</th>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><a class="edit_employee" href="#"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="Details"></i></a></td>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Employee Details</h5>
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
    let editEmployee = document.querySelectorAll('.edit_employee');
    editEmployee.forEach(b => b.addEventListener('click', showModal));
    </script>
</body>
</html>
