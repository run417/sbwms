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
                                <th>Last Name</th>
                                <th>B. Availability</th>
                                <th>Role</th>
                                <!-- <th>&nbsp;</th> -->
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($employees as $e): ?>
                              <tr id="<?= $e->getEmployeeId(); ?>">
                                <td><?= $e->getEmployeeId(); ?></td>
                                <td><?= $e->getFirstName(); ?></td>
                                <td><?= $e->getLastName(); ?></td>
                                <td><?= $e->getBookingAvailability(); ?></td>
                                <td><?= $e->getFormattedRole(); ?></td>
                                <!-- <td><a href="#"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="Details"></i></a></td> -->
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
    <!-- Modal -->
    <div class="modal fade" id="edit_employee_modal" tabindex="-1" role="dialog" aria-labelledby="edit_employee_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="edit_employee_modal_title">Edit Employee Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <!-- START FORM -->

            <form id="edit_employee_form">
              <div class="form-section-heading">
                  <h5>Personal</h5>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="employee_id">Employee Id</label> 
                    <input id="employee_id" name="employeeId" type="text" class="form-control" readonly>
                </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="employee_first_name">First Name</label> 
                      <input id="employee_first_name" name="firstName" type="text" required="required" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="employee_last_name">Last Name</label> 
                      <input id="employee_last_name" name="lastName" type="text" class="form-control">
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="employee_nic">NIC</label> 
                      <input id="employee_nic" name="nic" type="text" class="form-control">
                  </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="employee_telephone">Telephone</label> 
                      <input id="employee_telephone" name="telephone" type="tel" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="employee_email">Email</label> 
                      <input id="employee_email" name="email" type="email" class="form-control">
                  </div>
              </div>
              <div class="form-section-heading">
                  <h5>Role</h5>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-6">
                      <label for="employee_date_joined">Date Joined</label> 
                      <input id="employee_date_joined" name="dateJoined" type="date" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="employee_role">Employee Role</label> 
                      <div>
                          <select id="employee_role" name="role" class="custom-select">
                              <option value="">Select Role</option>
                              <option value="104">Service Crew</option>
                              <option value="105">Service Supervisor</option>
                              <option value="106">Sales Assistant</option>
                          </select>
                      </div>
                  </div> 
              </div>
              <!-- <div class="form-row">
                  <div class="form-group col-md-auto">
                      <label>Performing Service Types</label> 
                      
                      <div>
                          <div class="custom-control custom-checkbox">
                              <input name="employee_service_types" id="employee_service_types_0" type="checkbox" class="custom-control-input" value="st1"> 
                              <label for="employee_service_types_0" class="custom-control-label">Tyre Inspection and Replacement</label>
                          </div>
                          
                          <div class="custom-control custom-checkbox">
                              <input name="employee_service_types" id="employee_service_types_1" type="checkbox" class="custom-control-input" value="st2"> 
                              <label for="employee_service_types_1" class="custom-control-label">Wheel Alignment Inspection and Repair</label>
                          </div>
                          
                          <div class="custom-control custom-checkbox">
                              <input name="employee_service_types" id="employee_service_types_2" type="checkbox" class="custom-control-input" value="st3"> 
                              <label for="employee_service_types_2" class="custom-control-label">Battery Inspection and Replacement</label>
                          </div>
                      </div>
                  
                  </div> 
              </div> -->

              <div class="modal-footer">
                <button id="form_submit" type="submit" class="btn btn-primary">Update Employee Details</button>
                
              </form>
              <!-- END FORM -->
            </div>

        </div>

        </div> <!-- </model-content> -->
    </div> <!-- </model-dialog> -->
    </div>
    <!-- End Modal -->

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
